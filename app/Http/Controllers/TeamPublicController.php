<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Support\HighlightParser;

class TeamPublicController extends Controller
{
    public function index()
    {
        $teams = Team::query()
            ->published()
            ->ordered()
            ->get();

        return view('site.team', compact('teams'));
    }

    public function show(Team $team)
    {
        abort_unless($team->is_published, 404);

        $valueCards = $this->buildValueCards($team);
        $legacyValuesText = $this->legacyValuesText($team);

        return view('site.team_show', [
            'team' => $team,
            'valueCards' => $valueCards,
            'legacyValuesText' => $legacyValuesText,
        ]);
    }

    private function buildValueCards(Team $team): array
    {
        $locale = app()->getLocale();
        $values = $team->values ?? [];

        $cards = HighlightParser::normalize(data_get($values, $locale));

        if (empty($cards) && $locale !== 'en') {
            $cards = HighlightParser::normalize(data_get($values, 'en'));
        }

        return collect($cards)
            ->take(3)
            ->map(fn ($card) => [
                'title' => $card['title'] ?? '',
                'body' => $card['body'] ?? '',
            ])
            ->all();
    }

    private function legacyValuesText(Team $team): string
    {
        $locale = app()->getLocale();
        $values = $team->values ?? [];
        $raw = data_get($values, $locale);

        if (is_string($raw) && trim($raw) !== '') {
            return trim($raw);
        }

        $fallback = data_get($values, 'en');

        return is_string($fallback) ? trim($fallback) : '';
    }
}
