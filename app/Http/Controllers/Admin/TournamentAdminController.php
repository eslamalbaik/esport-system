<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use App\Models\TournamentCard;
use App\Models\SingleRegistration;
use App\Models\TeamRegistration;
use App\Models\Winner;
use App\Models\TournamentGameWinner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TournamentAdminController extends Controller
{
    public function index()
    {
        $tournaments = TournamentCard::query()
            ->withCount(['singleRegistrations', 'teamRegistrations'])
            ->orderByRaw($this->statusOrderingExpression())
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.tournaments.index', compact('tournaments'));
    }

    public function bulkDestroy(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:tournament_cards,id'],
        ]);

        $cards = TournamentCard::whereIn('id', $data['ids'])->get();

        foreach ($cards as $card) {
            $this->removeCardImage($card->image_path);
            $card->delete();
        }

        return redirect()
            ->route('admin.tournaments.index')
            ->with('ok', __('Selected tournaments deleted.'));
    }

    public function open()
    {
        $tournaments = TournamentCard::where('status', 'open')
            ->ordered()
            ->withCount(['singleRegistrations', 'teamRegistrations'])
            ->paginate(20);

        return view('admin.tournaments.open', compact('tournaments'));
    }

    public function show(TournamentCard $tournament)
    {
        $tournament->load([
            'singleRegistrations' => fn ($query) => $query->latest(),
            'teamRegistrations' => fn ($query) => $query->with('members')->latest(),
            'winner',
            'games.winnerEntry',
        ]);

        $singleRegistrations = $tournament->singleRegistrations;
        $teamRegistrations = $tournament->teamRegistrations;
        $winner = $tournament->winner;
        $winnerSnapshot = null;

        if ($winner) {
            $snapshot = $winner->snapshot ?? [];
            $singleEntries = collect($snapshot['singles'] ?? []);
            if ($singleEntries->isEmpty() && !empty($snapshot['single'])) {
                $singleEntries = collect([$snapshot['single']]);
            }
            $teamEntries = collect($snapshot['teams'] ?? []);
            if ($teamEntries->isEmpty() && !empty($snapshot['team'])) {
                $teamEntries = collect([$snapshot['team']]);
            }

            $winnerSnapshot = [
                'kind' => $winner->kind,
                'singles' => $singleEntries->values(),
                'teams' => $teamEntries->values(),
            ];
        }

        return view('admin.tournaments.show', compact(
            'tournament',
            'singleRegistrations',
            'teamRegistrations',
            'winner',
            'winnerSnapshot'
        ));
    }

    public function export(TournamentCard $tournament)
    {
        $tournament->load([
            'singleRegistrations' => fn ($query) => $query->with('game')->orderBy('player_name'),
            'teamRegistrations' => fn ($query) => $query->with(['members', 'game'])->orderBy('team_name'),
        ]);

        $locale = app()->getLocale();
        $tournamentTitle = $tournament->titleFor($locale) ?: $tournament->slug;

        $singleRows = $tournament->singleRegistrations->map(function (SingleRegistration $registration) use ($tournamentTitle, $locale) {
            $gameName = $registration->game ? $registration->game->titleFor($locale) : null;

            return [
                'tournament' => $tournamentTitle,
                'game_name' => $gameName,
                'team_name' => null,
                'player_name' => $registration->player_name,
                'role' => 'Single',
                'ingame_id' => $registration->ingame_id,
                'email' => $registration->email,
                'phone' => $registration->phone,
                'age' => $registration->age,
            ];
        });

        $teamRows = $tournament->teamRegistrations->flatMap(function (TeamRegistration $team) use ($tournamentTitle, $locale) {
            $gameName = $team->game ? $team->game->titleFor($locale) : null;

            $rows = [[
                'tournament' => $tournamentTitle,
                'game_name' => $gameName,
                'team_name' => $team->team_name,
                'player_name' => $team->captain_name,
                'role' => 'Captain',
                'ingame_id' => $team->game_id,
                'email' => $team->captain_email,
                'phone' => $team->captain_phone,
                'age' => null,
            ]];

            foreach ($team->members as $member) {
                $rows[] = [
                    'tournament' => $tournamentTitle,
                    'game_name' => $gameName,
                    'team_name' => $team->team_name,
                    'player_name' => $member->member_name,
                    'role' => 'Member',
                    'ingame_id' => $member->member_ingame_id,
                    'email' => null,
                    'phone' => null,
                    'age' => null,
                ];
            }

            return $rows;
        });

        $allRegistrations = $singleRows->concat($teamRows)->values();

        $content = view('admin.tournaments.export', [
            'tournament' => $tournament,
            'singleRegistrations' => $tournament->singleRegistrations,
            'teamRegistrations' => $tournament->teamRegistrations,
            'allRegistrations' => $allRegistrations,
        ])->render();

        $baseName = $tournament->titleFor(app()->getLocale()) ?: $tournament->slug;
        $filename = 'tournament-' . Str::slug($baseName ?: 'tournament') . '-registrations-' . now()->format('Ymd_His') . '.xls';

        return response($content, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function finish(TournamentCard $tournament, Request $request)
    {
        if ($tournament->status === 'finished') {
            return back()->withErrors(['status' => __('This tournament has already been marked as finished.')]);
        }

        $games = $tournament->games()->get()->keyBy('id');

        if ($games->isEmpty()) {
            return back()->withErrors(['games' => __('Please create at least one game before finishing this tournament.')]);
        }

        $data = $request->validate([
            'game_winners' => ['nullable', 'array'],
            'game_winners.*' => ['array'],
            'game_winners.*.*' => ['nullable', 'string', 'max:255'],
            'finished_games' => ['nullable', 'array'],
            'finished_games.*' => ['integer', Rule::exists('tournament_games', 'id')->where('tournament_card_id', $tournament->id)],
        ]);

        $cleanWinners = collect($data['game_winners'] ?? [])
            ->mapWithKeys(function ($names, $gameId) use ($games) {
                $gameId = (int) $gameId;
                if (! $games->has($gameId)) {
                    return [];
                }

                $list = collect($names ?? [])
                    ->map(fn ($name) => trim((string) $name))
                    ->filter()
                    ->values()
                    ->all();

                return [$gameId => $list];
            });

        $finishedIds = collect($data['finished_games'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => $games->has($id))
            ->values();

        $hasAnyWinners = $cleanWinners->filter(fn ($names) => !empty($names))->isNotEmpty();
        if (! $hasAnyWinners && $finishedIds->isEmpty()) {
            return back()->withErrors(['game_winners' => __('Add at least one winner or mark a game as finished.')]);
        }

        DB::transaction(function () use ($games, $cleanWinners, $finishedIds, $tournament) {
            foreach ($games as $gameId => $game) {
                $names = $cleanWinners->get($gameId, []);

                if (! empty($names)) {
                    TournamentGameWinner::updateOrCreate(
                        ['tournament_game_id' => $gameId],
                        ['winners' => $names]
                    );
                } else {
                    $game->winnerEntry()->delete();
                }

                $shouldFinish = $finishedIds->contains($gameId) || ! empty($names);

                if ($shouldFinish && $game->status !== 'finished') {
                    $game->update(['status' => 'finished']);
                }
            }

            $tournament->update(['status' => 'finished']);
        });

        return redirect()
            ->route('admin.tournaments.show', $tournament)
            ->with('ok', __('Tournament marked as finished.'));
    }

    private function statusOrderingExpression(): string
    {
        $expression = "CASE status WHEN 'open' THEN 0 WHEN 'finished' THEN 1 WHEN 'closed' THEN 2 ELSE 3 END";

        if (in_array(DB::connection()->getDriverName(), ['mysql', 'mariadb'], true)) {
            $expression = "FIELD(status, 'open','finished','closed')";
        }

        return $expression . ' ASC';
    }

    private function removeCardImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        $fullPath = public_path($path);
        if (File::isFile($fullPath)) {
            File::delete($fullPath);
        }
    }
}
