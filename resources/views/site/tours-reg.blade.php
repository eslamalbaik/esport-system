@extends('layouts.app')

@section('title', __('Registration'))

@push('styles')
    @vite([
        'resources/css/style.css',
        'resources/css/tours-reg.css',
    ])
@endpush

@section('content')

@php
    $isTournamentContext = isset($tournament);
@endphp

@if($isTournamentContext)
  @php
      $gamesList = ($games ?? collect())->sortBy('sort_order')->values();
      $themeCycle = ['theme-dark', 'theme-slate', 'theme-coal'];
      $tournamentTitle = $tournament->titleFor(app()->getLocale()) ?: content('tours-reg.header.title', __('E-Sports'));
  @endphp
  <section class="tr-cards" aria-labelledby="tr-title">
    <h2 style="display: flex; justify-content: center">
      <button class="tab-btn active" style="font-size: 25px; padding: 10px 40px; border-radius: 5px !important;">
        {{ $tournamentTitle }}
      </button>
    </h2>

    <section class="our-news-section">
      <h2 style="display: flex; justify-content: start">
        <button class="secondary-btn" style="font-size: 25px; padding: 10px 40px; border-radius: 5px !important;">
          {{ content('tours-reg.section.title', __('Current games')) }}
        </button>
      </h2>

      <span class="tri t1" aria-hidden="true"></span>
      <span class="tri t2" aria-hidden="true"></span>
      <span class="tri t3" aria-hidden="true"></span>
      <span class="tri t4" aria-hidden="true"></span>

      <ul class="char-grid">
        @forelse($gamesList as $game)
          @php
            $theme = $themeCycle[$loop->index % count($themeCycle)];
            $description = $game->description[app()->getLocale()] ?? ($game->description['en'] ?? '');
            $gameTitle = $game->titleFor(app()->getLocale()) ?: $tournamentTitle;
            $gameImage = $game->imageUrl() ?: content_media('tours-reg.card1.image', 'img/Art(3).png');
            $singleAllowed = (bool) $game->allow_single;
            $teamAllowed = (bool) $game->allow_team;
            $singleUrl = ($singleAllowed && $game->status === 'open')
              ? route('privacy', ['mode' => 'single', 't' => $tournament->id, 'g' => $game->id])
              : null;
            $teamUrl = ($teamAllowed && $game->status === 'open')
              ? route('privacy', ['mode' => 'team', 't' => $tournament->id, 'g' => $game->id])
              : null;
          @endphp
          <li class="char-card {{ $theme }}">
            <div class="char-wrap">
              <figure class="art" data-art-source="{{ $gameImage }}">
                <img
                  src="{{ $gameImage }}"
                  alt="{{ $gameTitle }}"
                  loading="lazy"
                  decoding="async"
                />
              </figure>

              {{-- Game Title Label --}}
              <div class="vlabel" style="position: absolute; left: -36px; top: 84px; transform: rotate(-90deg); transform-origin: left top; letter-spacing: 0.18em; text-transform: uppercase; pointer-events: none;">
                <strong style="display: block; margin-top: 8px; font-weight: 900; color: #000000; letter-spacing: 0.36em; font-size: 26px;">{{ $gameTitle }}</strong>
              </div>

              <i class="accent" aria-hidden="true"></i>
              <div class="abilities">
                <img class="ab" src="{{ asset('./img/vectors/Vector.png') }} " alt="" />
                <img class="ab" src="{{ asset('./img/vectors/Vector(1).png') }} " alt="" />
                <img class="ab" src="{{ asset('./img/vectors/Vector(2).png') }} " alt="" />
                <img class="ab" src="{{ asset('./img/vectors/Vector(3).png') }} " alt="" />
              </div>
            </div>
            {{-- Game Title Below Image --}}
            <div style="text-align: center; margin-top: 12px; margin-bottom: 8px;">
              <h3 style="color: #fff; font-size: 18px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em;">{{ $gameTitle }}</h3>
            </div>
            <div class="cta">
              <div class="segmented">
                @if($singleAllowed)
                  <a
                    href="{{ $singleUrl ?: '#' }}"
                    class="tab-btn active"
                    style="{{ $singleUrl ? '' : 'pointer-events:none;opacity:0.4;' }}"
                  >
                    {{ content('tours-reg.links.single', __('Single')) }}
                  </a>
                @endif

                @if($teamAllowed)
                  <a
                    href="{{ $teamUrl ?: '#' }}"
                    class="tab-btn active"
                    style="{{ $teamUrl ? '' : 'pointer-events:none;opacity:0.4;' }}"
                  >
                    {{ content('tours-reg.links.team', __('Team')) }}
                  </a>
                @endif
              </div>

              @unless($singleAllowed || $teamAllowed)
                <p class="mini" style="margin-top:8px; opacity:0.7;">
                  {{ __('Registrations are not available for this game.') }}
                </p>
              @endunless
            </div>
          </li>
        @empty
          <li class="char-card theme-dark" style="text-align:center; padding:40px;">
            <p style="color:#fff;">{{ __('Game lineup will be announced soon.') }}</p>
          </li>
        @endforelse
      </ul>
    </section>
  </section>
@else
  @php
      $toursRegCards = [
          [
              'key' => 'card1',
              'theme' => 'theme-dark',
              'label_classes' => 'vlabel',
              'name_class' => 'phoenix',
              'fallback_name' => 'PHOENIX',
              'fallback_country' => 'United Kingdom',
              'image' => 'img/Art(3).png',
              'abilities' => [
                  ['key' => 'ability1', 'fallback' => 'img/vectors/Vector.png'],
                  ['key' => 'ability2', 'fallback' => 'img/vectors/Vector3.png'],
                  ['key' => 'ability3', 'fallback' => 'img/vectors/Vector(2).png'],
                  ['key' => 'ability4', 'fallback' => 'img/vectors/Vector-1.png'],
              ],
          ],
          [
              'key' => 'card2',
              'theme' => 'theme-slate',
              'label_classes' => 'vlabel vlabel--light',
              'name_class' => '',
              'fallback_name' => 'JETT',
              'fallback_country' => 'South Korea',
              'image' => 'img/Art(2).png',
              'abilities' => [
                  ['key' => 'ability1', 'fallback' => 'img/vectors/Vector(1).png'],
                  ['key' => 'ability2', 'fallback' => 'img/vectors/Vector3.png'],
                  ['key' => 'ability3', 'fallback' => 'img/vectors/Vector(3).png'],
                  ['key' => 'ability4', 'fallback' => 'img/vectors/Vector-1.png'],
              ],
          ],
          [
              'key' => 'card3',
              'theme' => 'theme-coal',
              'label_classes' => 'vlabel',
              'name_class' => '',
              'fallback_name' => 'SOVA',
              'fallback_country' => 'Russia',
              'image' => 'img/Art(1).png',
              'abilities' => [
                  ['key' => 'ability1', 'fallback' => 'img/vectors/Vector3.png'],
                  ['key' => 'ability2', 'fallback' => 'img/vectors/Vector(2).png'],
                  ['key' => 'ability3', 'fallback' => 'img/vectors/Vector.png'],
                  ['key' => 'ability4', 'fallback' => 'img/vectors/Vector-1.png'],
              ],
          ],
          [
              'key' => 'card4',
              'theme' => 'theme-coal',
              'label_classes' => 'vlabel',
              'name_class' => '',
              'fallback_name' => 'SAGE',
              'fallback_country' => 'China',
              'image' => 'img/Art.png',
              'abilities' => [
                  ['key' => 'ability1', 'fallback' => 'img/vectors/Vector(2).png'],
                  ['key' => 'ability2', 'fallback' => 'img/vectors/Vector3.png'],
                  ['key' => 'ability3', 'fallback' => 'img/vectors/Vector.png'],
                  ['key' => 'ability4', 'fallback' => 'img/vectors/Vector-1.png'],
              ],
          ],
      ];
  @endphp

  <section class="tr-cards" aria-labelledby="tr-title">
    <h2 style="display: flex; justify-content: center">
      <button class="tab-btn active" style="font-size: 25px; padding: 10px 40px; border-radius: 5px !important;">
                {{ content('tours-reg.header.title', __('E-Sports')) }}
      </button>
    </h2>

    <section class="our-news-section">
      <h2 style="display: flex; justify-content: start">
        <button class="secondary-btn" style="font-size: 25px; padding: 10px 40px; border-radius: 5px !important;">
          {{ content('tours-reg.section.title', __('Current games')) }}
        </button>
      </h2>
      <span class="tri t1" aria-hidden="true"></span>
      <span class="tri t2" aria-hidden="true"></span>
      <span class="tri t3" aria-hidden="true"></span>
      <span class="tri t4" aria-hidden="true"></span>
      <ul class="char-grid">
        @foreach($toursRegCards as $card)
          @php
              $cardKey = 'tours-reg.' . $card['key'];
              $cardName = content($cardKey . '.name', __($card['fallback_name']));
              $cardCountry = content($cardKey . '.country', __($card['fallback_country']));
          @endphp
          <li class="char-card {{ $card['theme'] }}">
            <div class="char-wrap">
              <figure class="art">
                <img
                  src="{{ content_media($cardKey . '.image', $card['image']) }}"
                  alt="{{ __(':name artwork', ['name' => $cardName]) }}"
                />
              </figure>

              <div class="{{ $card['label_classes'] }}">
                <strong class="{{ $card['name_class'] }}">{{ $cardName }}</strong>
                <em>{{ $cardCountry }}</em>
              </div>
              <i class="accent" aria-hidden="true"></i>

              <div class="abilities">
                @foreach($card['abilities'] as $index => $ability)
                  <img
                    class="ab"
                    src="{{ content_media($cardKey . '.' . $ability['key'], $ability['fallback']) }}"
                    alt="{{ __(':name ability :number', ['name' => $cardName, 'number' => $loop->iteration]) }}"
                  />
                @endforeach
                <span class="under" aria-hidden="true"></span>
              </div>
            </div>

            <div class="cta">
              <button class="btn-register" type="button">
                {{ content('tours-reg.card.register_button', __('Register now')) }}
              </button>
              <div class="segmented">
                @auth
                  <a href="{{ route('register.single') }}" class="mini">
                    {{ content('tours-reg.links.single', __('Single')) }}
                  </a>
                  <a href="{{ route('register.team') }}" class="mini">
                    {{ content('tours-reg.links.team', __('Team')) }}
                  </a>
                @else
                  <a
                    href="{{ route('login') }}"
                    class="mini"
                    onclick="sessionStorage.setItem('loginMessage', '{{ __('You must login to register') }}'); return true;"
                  >
                    {{ content('tours-reg.links.single', __('Single')) }}
                  </a>
                  <a
                    href="{{ route('login') }}"
                    class="mini"
                    onclick="sessionStorage.setItem('loginMessage', '{{ __('You must login to register') }}'); return true;"
                  >
                    {{ content('tours-reg.links.team', __('Team')) }}
                  </a>
                @endauth
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    </section>
  </section>
@endif

@endsection
@push('scripts')
@vite('resources/js/script.js')
@endpush
