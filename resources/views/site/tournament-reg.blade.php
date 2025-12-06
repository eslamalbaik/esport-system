@extends('layouts.app')

@section('title', $tournament->titleFor(app()->getLocale()) ?: __('Tournament'))

@push('styles')
    @vite([
        'resources/css/style.css',
        'resources/css/tours-reg.css',
    ])
@endpush

@section('content')
  <section class="tr-cards" aria-labelledby="tr-title">
    <!-- header pills -->
    <h2 style="display:flex;justify-content:center">
      <button class="tab-btn active" style="font-size:25px;padding:10px 40px;border-radius:5px!important;">
        {{ content('tours-reg.header.title', __('E-Sports')) }}
      </button>
    </h2>

    <section class="our-news-section">


      {{-- 2-column detail layout --}}
      <div class="tr-two-col">
        {{-- LEFT: image --}}
        <figure class="tr-media">
          <img
            src="{{ $tournament->imageUrl() ?? content_media('tournaments.card.image','img/tournaments-inner.png') }}"
            alt="{{ $tournament->titleFor(app()->getLocale()) ?: __('Tournament') }}"
            loading="eager" fetchpriority="high"
          />
        </figure>

        {{-- RIGHT: text + CTAs --}}
        <aside class="tr-aside">
          <header class="tr-aside__head">
            <h1 class="tr-title">{{ $tournament->titleFor(app()->getLocale()) }}</h1>
            <ul class="tr-meta">
              <li><span class="meta-k">{{ __('Date') }}</span> <span class="meta-v">{{ optional($tournament->date)->format('d/m/Y') ?? '--' }}</span></li>
              <li><span class="meta-k">{{ __('Time') }}</span> <span class="meta-v">{{ $tournament->time ?: '--' }}</span></li>
              @if(!empty($tournament->prize))
              <li><span class="meta-k">{{ __('Prize') }}</span> <span class="meta-v">{{ $tournament->prize }}</span></li>
              @endif
            </ul>
          </header>

          <div class="tr-cta">
            @if($tournament->status === 'open')
              <button class="btn-register" style="margin-bottom: 30px;" type="button" aria-label="{{ __('Register now') }}">
                {{ content('tours-reg.card.register_button', __('Register now')) }}
              </button>
              <div class="segmented">
                <a href="{{ route('register.single') }}?t={{ $tournament->id }}" class="tab-btn" aria-label="{{ __('Register as single') }}">
                  {{ content('tours-reg.links.single', __('Single')) }}
                </a>
                <a href="{{ route('register.team') }}?t={{ $tournament->id }}" class="tab-btn" aria-label="{{ __('Register as team') }}">
                  {{ content('tours-reg.links.team', __('Team')) }}
                </a>
              </div>
            @elseif($tournament->status === 'finished')
              <a class="mini" href="{{ route('winners.show', $tournament->slug) }}">
                {{ content('tournaments.card.winner', __('Winner')) }}
              </a>
            @else
              <span class="mini" style="pointer-events:none;opacity:.6">
                {{ content('tournaments.card.closed', __('Closed')) }}
              </span>
            @endif
          </div>

          {{-- Optional: a short blurb (CMS-driven) --}}
          <p class="tr-note">
            {{ content('tournaments.register.note', __('Make sure you meet the requirements before registering.')) }}
          </p>
        </aside>
      </div>
    </section>
  </section>
@endsection

@push('scripts')
@vite('resources/js/script.js')
@endpush
