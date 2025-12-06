<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRegistrationRequest;
use App\Models\TeamRegistration;
use App\Models\TournamentCard;
use App\Models\TournamentGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeamRegistrationController extends Controller
{
    public function create(Request $request)
    {
        $tournaments = TournamentCard::published()
            ->open()
            ->ordered()
            ->get(['id', 'title', 'slug']);

        $selectedTournamentId = $request->query('t');
        if ($selectedTournamentId !== null) {
            $selectedTournamentId = (int) $selectedTournamentId;
            if (! $tournaments->firstWhere('id', $selectedTournamentId)) {
                $selectedTournamentId = null;
            }
        }

        $selectedGameId = null;
        $selectedGame = null;
        $gameId = $request->query('g');

        if ($gameId && $selectedTournamentId) {
            $selectedGame = TournamentGame::where('id', (int) $gameId)
                ->where('tournament_card_id', $selectedTournamentId)
                ->where('allow_team', true)
                ->where('status', 'open')
                ->first();

            if ($selectedGame) {
                $selectedGameId = $selectedGame->id;
            }
        }

        return view('site.reg-team', [
            'tournaments' => $tournaments,
            'selectedTournamentId' => $selectedTournamentId,
            'selectedGame' => $selectedGame,
            'selectedGameId' => $selectedGameId,
        ]);
    }

    public function store(TeamRegistrationRequest $request)
    {
        $data = $request->validated();
        $members = $data['members'];
        unset($data['members']);
        unset($data['team_logo'], $data['captain_logo']);

        DB::transaction(function () use ($request, &$data, $members) {
            if ($request->hasFile('teamLogo')) {
                $data['team_logo_path'] = $this->storeLogo($request->file('teamLogo'));
            }

            if ($request->hasFile('captainLogo')) {
                $data['captain_logo_path'] = $this->storeLogo($request->file('captainLogo'));
            }

            $data['meta'] = [
                'locale' => app()->getLocale(),
                'ip' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
            ];

            $team = TeamRegistration::create($data);

            foreach ($members as $member) {
                $team->members()->create($member);
            }
        });

        $message = __('Thank you! Your team registration has been received.');

        return redirect()
            ->route('register.team')
            ->with([
                'status' => $message,
                'registration_success' => $message,
            ]);
    }

    private function storeLogo($file): string
    {
        return $file->store('content-images/teams', 'public');
    }
}
