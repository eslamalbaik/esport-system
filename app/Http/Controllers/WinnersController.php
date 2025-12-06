<?php

namespace App\Http\Controllers;

use App\Models\TournamentCard;

class WinnersController extends Controller
{
    public function show(TournamentCard $tournament)
    {
        if ($tournament->status !== 'finished') {
            abort(404);
        }

        $tournament->load([
            'winner',
            'games' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('id')
                ->with('winnerEntry'),
        ]);

        $gameWinners = $tournament->games
            ->filter(fn ($game) => $game->winnerEntry && !empty($game->winnerEntry->winners))
            ->values();

        return view('site.winner', [
            'tournament' => $tournament,
            'winner' => $tournament->winner,
            'gameWinners' => $gameWinners,
        ]);
    }
}
