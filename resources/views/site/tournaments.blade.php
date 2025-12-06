@extends('layouts.app')

@section('title', __('Tournaments'))

@push('styles')
    @vite([
        'resources/css/style.css',
        'resources/css/tournaments.css',
    ])
@endpush

@section('content')
  <section class="our-tournaments" aria-labelledby="esports-title">
    <!-- top labels -->
    <div class="right-panel">
      <div class="form-header">
        <button class="tab-btn active" style="font-size: 20px; border-radius: 10px">
          {{ content('tournaments.header.title', __('E-Sports')) }}
        </button>
      </div>
    </div>

    <span class="ot-pill ot-pill--gray">{{ content('tournaments.our_tournament', __('Our Tournament')) }}</span>

    <!-- grid -->
    @php
      $cards = \App\Models\TournamentCard::published()->ordered()->get();
    @endphp
    <ul class="ot-grid">
      @forelse($cards as $card)
        <li class="ot-card">
          <article class="ot-card__wrap">
            <figure class="ot-media">
              <img
                src="{{ $card->imageUrl() ?? content_media('tournaments.card.image', 'img/tournaments-inner.png') }}"
                alt="{{ $card->titleFor(app()->getLocale()) ?: __('Tournament card') }}"
              />
            </figure>
            <div class="ot-body">
              <h3 class="ot-title">{{ $card->titleFor(app()->getLocale()) ?: __('Untitled Tournament') }}</h3>

              @php
                $startDate = $card->date?->format('d/m/Y') ?? '--';
                $endDate = $card->end_date?->format('d/m/Y') ?? '--';
              @endphp
              <ul class="ot-meta">
                <li class="meta meta--stacked">
                  <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M7 2v3M17 2v3M3 9h18M5 6h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z" />
                  </svg>
                  <div class="meta-lines">
                    <span>{{ __('Start:') }} {{ $startDate }}</span>
                    <span>{{ __('End:') }} {{ $endDate }}</span>
                  </div>
                </li>
                <li class="meta">
                  <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 8v5l3 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                  </svg>
                  <span>{{ $card->time ?: '--' }}</span>
                </li>
              </ul>

              <div class="ot-prize">
                <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M8 21h8M12 17v4M5 3h14v2a4 4 0 0 1-4 4h-1a4 4 0 0 1-3 4v0H9v0a4 4 0 0 1-3-4H7A4 4 0 0 1 3 5V3h2z" />
                </svg>
                <span class="amount">{{ $card->prize ?: '--' }}</span>
              </div>

              @if($card->status === 'open')
                <a href="{{ route('tournaments.register', $card->slug) }}" class="ot-btn ot-btn--register" style="width: 50%;">
                  {{ content('tournaments.card.register', __('REGISTER')) }}
                </a>
              @elseif($card->status === 'finished')
                <a href="{{ route('winners.show', $card->slug) }}" class="ot-btn" style="background: #059669; width: 50%;">
                  {{ content('tournaments.card.winner', __('Winner')) }}
                </a>
              @else
                <span class="ot-btn" style="background:#4b5563; pointer-events:none;">
                  {{ content('tournaments.card.closed', __('Closed')) }}
                </span>
              @endif
            </div>
          </article>
        </li>
      @empty
        <li class="ot-card">
          <article class="ot-card__wrap text-center">
            <div class="ot-body">
              <h3 class="ot-title">{{ __('No tournaments available right now.') }}</h3>
              <p class="ot-description">
                {{ __('Please check back later for upcoming events.') }}
              </p>
            </div>
          </article>
        </li>
      @endforelse
    </ul>
  </section>
@endsection
