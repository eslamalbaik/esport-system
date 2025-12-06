@extends('layouts.app')

@section('title', __('Services'))

@push('styles')
    @vite([
        'resources/css/style.css',
        'resources/css/ourservices.css',
    ])
@endpush

@section('content')


    <section class="services" aria-labelledby="services-title">
      <div class="right-panel">
        <div class="form-header" style=" margin-bottom: 50px;">
          <button
            id="services-title"
            class="tab-btn active"
            style="font-size: 20px; border-radius: 10px;"
          >
            {{ content('services.header.title', __('Our Services')) }}
          </button>
        </div>
      </div>

      @php
          $locale = app()->getLocale();

          $serviceCards = [
              [
                  'icon_key' => 'services.card1.icon',
                  'title_key' => 'services.card1.title',
                  'fallbacks' => [
                      'en' => 'Technology & Platform Development',
                      'ar' => \Illuminate\Support\Facades\Lang::get('Technology & Platform Development', [], 'ar'),
                  ],
                  'items' => [
                      'services.card1.item1' => [
                          'en' => 'Custom tournament platforms and registration portals',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Custom tournament platforms and registration portals', [], 'ar'),
                      ],
                      'services.card1.item2' => [
                          'en' => 'Score tracking dashboards and live updates',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Score tracking dashboards and live updates', [], 'ar'),
                      ],
                      'services.card1.item3' => [
                          'en' => 'Integration with Discord, Twitch, and other gaming tools',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Integration with Discord, Twitch, and other gaming tools', [], 'ar'),
                      ],
                      'services.card1.item4' => [
                          'en' => 'Mobile-first responsive design',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Mobile-first responsive design', [], 'ar'),
                      ],
                  ],
              ],
              [
                  'icon_key' => 'services.card2.icon',
                  'title_key' => 'services.card2.title',
                  'fallbacks' => [
                      'en' => 'Event Management & Production',
                      'ar' => \Illuminate\Support\Facades\Lang::get('Event Management & Production', [], 'ar'),
                  ],
                  'items' => [
                      'services.card2.item1' => [
                          'en' => 'Tournament planning and execution',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Tournament planning and execution', [], 'ar'),
                      ],
                      'services.card2.item2' => [
                          'en' => 'Live streaming and broadcast services',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Live streaming and broadcast services', [], 'ar'),
                      ],
                      'services.card2.item3' => [
                          'en' => 'Professional commentary and analysis',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Professional commentary and analysis', [], 'ar'),
                      ],
                      'services.card2.item4' => [
                          'en' => 'Venue coordination and logistics',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Venue coordination and logistics', [], 'ar'),
                      ],
                  ],
              ],
              [
                  'icon_key' => 'services.card3.icon',
                  'title_key' => 'services.card3.title',
                  'fallbacks' => [
                      'en' => 'Community Building & Engagement',
                      'ar' => \Illuminate\Support\Facades\Lang::get('Community Building & Engagement', [], 'ar'),
                  ],
                  'items' => [
                      'services.card3.item1' => [
                          'en' => 'Discord server setup and management',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Discord server setup and management', [], 'ar'),
                      ],
                      'services.card3.item2' => [
                          'en' => 'Social media strategy and content creation',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Social media strategy and content creation', [], 'ar'),
                      ],
                      'services.card3.item3' => [
                          'en' => 'Player networking and team formation',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Player networking and team formation', [], 'ar'),
                      ],
                      'services.card3.item4' => [
                          'en' => 'Regular community events and activities',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Regular community events and activities', [], 'ar'),
                      ],
                  ],
              ],
              [
                  'icon_key' => 'services.card4.icon',
                  'title_key' => 'services.card4.title',
                  'fallbacks' => [
                      'en' => 'Training & Coaching Services',
                      'ar' => \Illuminate\Support\Facades\Lang::get('Training & Coaching Services', [], 'ar'),
                  ],
                  'items' => [
                      'services.card4.item1' => [
                          'en' => 'One-on-one coaching sessions',
                          'ar' => \Illuminate\Support\Facades\Lang::get('One-on-one coaching sessions', [], 'ar'),
                      ],
                      'services.card4.item2' => [
                          'en' => 'Team strategy development',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Team strategy development', [], 'ar'),
                      ],
                      'services.card4.item3' => [
                          'en' => 'Performance analysis and improvement',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Performance analysis and improvement', [], 'ar'),
                      ],
                      'services.card4.item4' => [
                          'en' => 'Mental health and wellness support',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Mental health and wellness support', [], 'ar'),
                      ],
                  ],
              ],
              [
                  'icon_key' => 'services.card5.icon',
                  'title_key' => 'services.card5.title',
                  'fallbacks' => [
                      'en' => 'Broadcasting & Media Production',
                      'ar' => \Illuminate\Support\Facades\Lang::get('Broadcasting & Media Production', [], 'ar'),
                  ],
                  'items' => [
                      'services.card5.item1' => [
                          'en' => 'Multi-platform streaming setup',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Multi-platform streaming setup', [], 'ar'),
                      ],
                      'services.card5.item2' => [
                          'en' => 'Professional video production',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Professional video production', [], 'ar'),
                      ],
                      'services.card5.item3' => [
                          'en' => 'Graphics and overlay design',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Graphics and overlay design', [], 'ar'),
                      ],
                      'services.card5.item4' => [
                          'en' => 'Post-event highlight reels',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Post-event highlight reels', [], 'ar'),
                      ],
                  ],
              ],
              [
                  'icon_key' => 'services.card6.icon',
                  'title_key' => 'services.card6.title',
                  'fallbacks' => [
                      'en' => 'Sponsorship & Partnership',
                      'ar' => \Illuminate\Support\Facades\Lang::get('Sponsorship & Partnership', [], 'ar'),
                  ],
                  'items' => [
                      'services.card6.item1' => [
                          'en' => 'Brand partnership development',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Brand partnership development', [], 'ar'),
                      ],
                      'services.card6.item2' => [
                          'en' => 'Sponsorship activation strategies',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Sponsorship activation strategies', [], 'ar'),
                      ],
                      'services.card6.item3' => [
                          'en' => 'Marketing campaign execution',
                          'ar' => \Illuminate\Support\Facades\Lang::get('Marketing campaign execution', [], 'ar'),
                      ],
                      'services.card6.item4' => [
                          'en' => 'ROI tracking and reporting',
                          'ar' => \Illuminate\Support\Facades\Lang::get('ROI tracking and reporting', [], 'ar'),
                      ],
                  ],
              ],
          ];

          $resolveContent = function (string $key, array $fallbacks) use ($locale) {
              $fallbackEn = $fallbacks['en'] ?? '';
              $value = content($key, $fallbackEn);

              if ($locale === 'ar') {
                  $fallbackAr = $fallbacks['ar'] ?? $fallbackEn;
                  if (trim($value) === trim($fallbackEn)) {
                      return $fallbackAr;
                  }
              }

              return $value;
          };
      @endphp

      <!-- grid -->
      <ul class="services__grid">
        @foreach($serviceCards as $card)
          <li class="svc-card">
            <article class="svc-card__inner">
              <div class="svc-card__tab">
                <span class="svc-card__puzzle" aria-hidden="true">
                  <img
                    src="{{ content_media($card['icon_key'], 'img/services-icon.png') }}"
                    alt="{{ $resolveContent($card['title_key'], $card['fallbacks']) }}"
                  />
                </span>
                <span class="svc-card__label">
                  {{ $resolveContent($card['title_key'], $card['fallbacks']) }}
                </span>
              </div>

              <div class="svc-card__body">
                <ul class="svc-list">
                  @foreach($card['items'] as $itemKey => $fallbacks)
                    <li>{{ $resolveContent($itemKey, $fallbacks) }}</li>
                  @endforeach
                </ul>
              </div>
            </article>
          </li>
        @endforeach
      </ul>
    </section>
@endsection
@push('scripts')
@vite('resources/js/script.js')
@endpush
