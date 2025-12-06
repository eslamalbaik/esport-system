<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TournamentCard;
use App\Models\TournamentGame;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class TournamentGameAdminController extends Controller
{
    public function index(TournamentCard $tournament): View
    {
        $tournament->load('games');

        return view('admin.tournaments.games.index', [
            'tournament' => $tournament,
            'games' => $tournament->games,
        ]);
    }

    public function create(TournamentCard $tournament): View
    {
        return view('admin.tournaments.games.create', [
            'tournament' => $tournament,
            'game' => new TournamentGame(['status' => 'open', 'allow_single' => true, 'allow_team' => true]),
        ]);
    }

    public function store(TournamentCard $tournament, Request $request): RedirectResponse
    {
        $data = $this->validateGame($request);

        if (! isset($data['sort_order'])) {
            $data['sort_order'] = (int) ($tournament->games()->max('sort_order') ?? 0) + 1;
        }

        $data['tournament_card_id'] = $tournament->id;
        $data['title'] = $this->buildLocalizedPayload($data, 'title');
        $data['description'] = $this->buildLocalizedPayload($data, 'description');

        unset($data['title_en'], $data['title_ar'], $data['description_en'], $data['description_ar']);
        $this->handleImageUpload($request, $data);

        $tournament->games()->create($data);

        return redirect()
            ->route('admin.tournaments.games.index', $tournament)
            ->with('ok', __('Game created.'));
    }

    public function edit(TournamentCard $tournament, TournamentGame $game): View
    {
        $this->assertGameBelongsToTournament($tournament, $game);

        return view('admin.tournaments.games.edit', [
            'tournament' => $tournament,
            'game' => $game,
        ]);
    }

    public function update(TournamentCard $tournament, TournamentGame $game, Request $request): RedirectResponse
    {
        $this->assertGameBelongsToTournament($tournament, $game);

        $data = $this->validateGame($request, $game);
        $data['title'] = $this->buildLocalizedPayload($data, 'title', $game->title ?? []);
        $data['description'] = $this->buildLocalizedPayload($data, 'description', $game->description ?? []);

        unset($data['title_en'], $data['title_ar'], $data['description_en'], $data['description_ar']);
        $this->handleImageUpload($request, $data, $game);

        $game->update($data);

        return redirect()
            ->route('admin.tournaments.games.index', $tournament)
            ->with('ok', __('Game updated.'));
    }

    public function destroy(TournamentCard $tournament, TournamentGame $game): RedirectResponse
    {
        $this->assertGameBelongsToTournament($tournament, $game);

        $this->removeImage($game);
        $game->delete();

        return redirect()
            ->route('admin.tournaments.games.index', $tournament)
            ->with('ok', __('Game deleted.'));
    }

    public function reorder(TournamentCard $tournament, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'orders' => ['required', 'array'],
            'orders.*' => ['nullable', 'integer', 'min:0'],
        ]);

        $games = $tournament->games()->get()->keyBy('id');
        foreach ($data['orders'] as $id => $order) {
            $id = (int) $id;
            if ($games->has($id) && $order !== null) {
                $games[$id]->update(['sort_order' => (int) $order]);
            }
        }

        return redirect()
            ->route('admin.tournaments.games.index', $tournament)
            ->with('ok', __('Sort order updated.'));
    }

    private function validateGame(Request $request, ?TournamentGame $game = null): array
    {
        $statuses = ['open', 'closed', 'finished'];

        $imageRules = array_merge(
            [$game && $game->image_path ? 'sometimes' : 'required'],
            ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096']
        );

        $payload = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('tournament_games', 'slug')->ignore($game)],
            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'status' => ['required', Rule::in($statuses)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => $imageRules,
        ]);

        $payload['allow_single'] = $request->boolean('allow_single');
        $payload['allow_team'] = $request->boolean('allow_team');

        return $payload;
    }

    private function buildLocalizedPayload(array $data, string $key, array $existing = []): array
    {
        $payload = array_filter([
            'en' => $data[$key . '_en'] ?? ($existing['en'] ?? null),
            'ar' => $data[$key . '_ar'] ?? ($existing['ar'] ?? null),
        ], fn ($value) => $value !== null && $value !== '');

        return empty($payload) ? null : $payload;
    }

    private function assertGameBelongsToTournament(TournamentCard $tournament, TournamentGame $game): void
    {
        if ($game->tournament_card_id !== $tournament->id) {
            abort(404);
        }
    }

    private function handleImageUpload(Request $request, array &$data, ?TournamentGame $game = null): void
    {
        if (! $request->hasFile('image')) {
            return;
        }

        if ($game && $game->image_path) {
            Storage::disk('public')->delete($game->image_path);
        }

        $data['image_path'] = $request->file('image')->store('content-images/tournament-games', 'public');
    }

    private function removeImage(TournamentGame $game): void
    {
        if ($game->image_path) {
            Storage::disk('public')->delete($game->image_path);
        }
    }
}
