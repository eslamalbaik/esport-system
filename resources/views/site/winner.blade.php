@extends('layouts.app')

@section('title', $tournament->titleFor(app()->getLocale()) ?: __('Winners'))

@push('styles')
    @vite('resources/css/style.css')
<style>
  .winners-stage {
    padding: 40px 0 60px;
    background: #050506;
  }
  .winners-banner {
    display: flex;
    justify-content: center;
    gap: 16px;
    margin-bottom: 32px;
    flex-wrap: wrap;
  }
  .badge-pill {
    border: none;
    border-radius: 999px;
    padding: 12px 32px;
    font-size: 0.95rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
  }
  .badge-pill--muted {
    background: #5e5e63;
    color: #fff;
    box-shadow: inset 0 0 0 2px rgba(255,255,255,0.08);
  }
  .badge-pill--primary {
    background: #f23b33;
    color: #fff;
    box-shadow: 0 8px 20px rgba(242,59,51,0.35);
  }
  .winner-shell {
    display: grid;
    grid-template-columns: minmax(260px, 330px) 1fr;
    gap: 24px;
  }
  .winner-card {
    background: #111217;
    border-radius: 18px;
    padding: 20px;
    color: #f9fafb;
    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
  }
  .winner-card figure {
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 16px;
  }
  .winner-card figure img {
    width: 100%;
    height: auto;
    display: block;
  }
  .winner-card h3 {
    font-size: 1.3rem;
    margin-bottom: 6px;
  }
  .winner-card__meta {
    display: grid;
    gap: 10px;
    margin-top: 12px;
  }
  .winner-card__meta p {
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.95rem;
    color: #d9dcea;
  }
  .winner-card__cta {
    margin-top: 18px;
    display: block;
    text-align: center;
    background: #f23b33;
    color: #fff;
    padding: 12px;
    border-radius: 10px;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
  }
  .winner-track {
    background: #090a0f;
    border-radius: 18px;
    padding: 24px;
    border: 1px solid rgba(255,255,255,0.04);
  }
  .game-scroll {
    display: flex;
    gap: 16px;
    overflow-x: auto;
    padding-bottom: 12px;
    scrollbar-width: thin;
  }
  .game-scroll::-webkit-scrollbar {
    height: 8px;
  }
  .game-scroll::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.25);
    border-radius: 999px;
  }
  .game-tile {
    background: linear-gradient(180deg, rgba(5,5,6,0.85), rgba(5,5,6,0.95));
    border-radius: 22px;
    border: 2px solid #f23b33;
    position: relative;
    overflow: hidden;
    min-width: 230px;
    max-width: 260px;
    display: flex;
    flex-direction: column;
    color: #fff;
  }
  .game-tile__body {
    padding: 18px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    background: #050506;
  }
  .game-tile figure {
    height: 160px;
    overflow: hidden;
    border-bottom: 1px solid rgba(255,255,255,0.1);
  }
  .game-tile figure img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }
  .winner-pill-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }
  .winner-pill {
    flex: 1 1 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f23b33;
    color: #fff;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
  }
  .winner-pill span:last-child {
    font-weight: 400;
    text-transform: none;
  }
  @media (max-width: 1024px) {
    .winner-shell {
      grid-template-columns: 1fr;
    }
    .game-scroll {
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    }
  }
</style>
@endpush

@section('content')
  @php
    $fallbackImage = content_media('tournaments.card.image','img/tournaments-inner.png');
    $tournamentImage = $tournament->imageUrl() ?? $fallbackImage;
    $gameWinners = ($gameWinners ?? collect())->filter();
    $hasGameWinners = $gameWinners->isNotEmpty();
    $hasLegacyWinner = ! $hasGameWinners && $winner;

    $displayCards = collect();

    foreach ($gameWinners as $game) {
        $winners = collect($game->winnerEntry->winners ?? [])->filter()->values();
        $displayCards->push([
            'title' => $game->titleFor(app()->getLocale()) ?: __('Game'),
            'image' => $game->imageUrl() ?? $tournamentImage,
            'status' => ucfirst($game->status),
            'allow_single' => $game->allow_single,
            'allow_team' => $game->allow_team,
            'winners' => $winners,
        ]);
    }

    if ($hasLegacyWinner) {
        $snapshot = $winner->snapshot ?? [];
        $singleEntries = collect($snapshot['singles'] ?? []);
        if ($singleEntries->isEmpty() && !empty($snapshot['single'])) {
            $singleEntries = collect([$snapshot['single']]);
        }
        $teamEntries = collect($snapshot['teams'] ?? []);
        if ($teamEntries->isEmpty() && !empty($snapshot['team'])) {
            $teamEntries = collect([$snapshot['team']]);
        }

        if ($singleEntries->isNotEmpty()) {
            $displayCards->push([
                'title' => content('winners.single.label', __('Winner (Single)')),
                'image' => $tournamentImage,
                'status' => __('Singles'),
                'allow_single' => true,
                'allow_team' => false,
                'winners' => $singleEntries->map(fn ($entry) => $entry['player_name'] ?? ''),
            ]);
        }

        if ($teamEntries->isNotEmpty()) {
            $displayCards->push([
                'title' => content('winners.team.label', __('Winner (Team)')),
                'image' => $tournamentImage,
                'status' => __('Teams'),
                'allow_single' => false,
                'allow_team' => true,
                'winners' => $teamEntries->map(fn ($entry) => $entry['team_name'] ?? ''),
            ]);
        }
    }
  @endphp

  <section class="winners-stage">
    <div class="container" style="max-width:1200px;">
      <div class="winners-banner">
        <button class="badge-pill badge-pill--muted">{{ __('Winners') }}</button>
        <button class="badge-pill badge-pill--primary">{{ content('winners.header.main_title', __('E-Sports')) }}</button>
      </div>

      <div class="winner-shell">
        <aside class="winner-card">
          <figure>
            <img src="{{ $tournamentImage }}" alt="{{ $tournament->titleFor(app()->getLocale()) }}">
          </figure>
          <h3>{{ $tournament->titleFor(app()->getLocale()) ?: __('Tournament') }}</h3>
          <p style="color:#f23b33; font-weight:600; text-transform:uppercase; letter-spacing:0.2em;">
            {{ __('Prize') }}: {{ $tournament->prize ?: __('TBD') }}
          </p>
          <div class="winner-card__meta">
            <p><span>{{ __('Date') }}</span><strong>{{ $tournament->date?->format('d/m/Y') ?? __('TBD') }}</strong></p>
            <p><span>{{ __('Time') }}</span><strong>{{ $tournament->time ?: __('TBD') }}</strong></p>
            <p><span>{{ __('Status') }}</span><strong>{{ ucfirst($tournament->status) }}</strong></p>
          </div>
        </aside>

        <div class="winner-track">
          @if($displayCards->isNotEmpty())
            <div class="game-scroll">
              @foreach($displayCards as $card)
                @php($cardImage = $card['image'] ?: $tournamentImage)
                <article class="game-tile">
                  <figure>
                    <img src="{{ $cardImage }}" alt="{{ $card['title'] }}">
                  </figure>
                  <div class="game-tile__body">
                    <h5 style="font-weight:700;margin-bottom:8px;">
                      {{ strtoupper($card['title']) }}
                    </h5>
                    <div class="winner-pill-list">
                      @forelse($card['winners'] as $winnerName)
                        <div class="winner-pill">
                          <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                          <span>{{ $winnerName ?: __('TBD') }}</span>
                        </div>
                      @empty
                        <div class="winner-pill">
                          <span>--</span>
                          <span>{{ __('Coming soon') }}</span>
                        </div>
                      @endforelse
                    </div>
                  </div>
                </article>
              @endforeach
            </div>
          @else
            <p style="color:#f23b33; font-size:1.2rem; text-align:center;">
              {{ content('winners.empty', __('Winner will be announced soon.')) }}
            </p>
          @endif
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
@vite('resources/js/script.js')
@endpush
