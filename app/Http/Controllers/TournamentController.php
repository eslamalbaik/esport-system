<?php

namespace App\Http\Controllers;

use App\Models\TournamentCard;

class TournamentController extends Controller
{
    public function register(TournamentCard $tournament)
    {
        if ($tournament->status === 'finished') {
            return redirect()->route('winners.show', $tournament->slug);
        }

        $tournament->load(['games' => fn ($query) => $query->orderBy('sort_order')->orderBy('id')]);

        $games = $tournament->games;

        return view('site.tours-reg', compact('tournament', 'games'));
    }
}
