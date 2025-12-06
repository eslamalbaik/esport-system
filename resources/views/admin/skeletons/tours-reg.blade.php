@extends('admin.layout')

@section('title', 'Edit Tours Registration Page - Skeleton View')

@section('content')
<div class="skeleton-editor">
    <div class="skeleton-mode-indicator">
        🎨 SKELETON EDIT MODE - TOURS REGISTRATION PAGE
    </div>

    <div class="skeleton-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-white">Tours Registration Page - Visual Editor</h1>
                <p class="text-sm text-gray-400">Click highlighted areas to edit registration showcase content</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('tours-reg') }}" 
                   class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700" 
                   target="_blank">
                    👁️ Preview Page
                </a>
            </div>
        </div>
    </div>

    <div class="skeleton-content">
        <div class="skeleton-instructions">
            <h3>How to use the Tours Registration Skeleton Editor:</h3>
            <ul>
                <li><span style="color: #60a5fa;">Blue highlights</span> mark editable text (multi-language supported)</li>
                <li><span style="color: #34d399;">Green highlights</span> mark editable images (PNG, JPG, WEBP)</li>
                <li>Each agent card includes editable name, country, register button label, and ability icons</li>
                <li>The Single/Team links use shared labels that update across all cards simultaneously</li>
            </ul>
        </div>

        @php
            $cards = [
                [
                    'index' => 1,
                    'theme' => 'theme-dark',
                    'label_classes' => 'vlabel',
                    'name_class' => 'phoenix',
                    'fallback_name' => 'PHOENIX',
                    'fallback_country' => 'United Kingdom',
                    'image_fallback' => 'img/Art(3).png',
                    'abilities' => [
                        ['suffix' => 'ability1', 'fallback' => 'img/vectors/Vector.png'],
                        ['suffix' => 'ability2', 'fallback' => 'img/vectors/Vector3.png'],
                        ['suffix' => 'ability3', 'fallback' => 'img/vectors/Vector(2).png'],
                        ['suffix' => 'ability4', 'fallback' => 'img/vectors/Vector-1.png'],
                    ],
                ],
                [
                    'index' => 2,
                    'theme' => 'theme-slate',
                    'label_classes' => 'vlabel vlabel--light',
                    'name_class' => '',
                    'fallback_name' => 'JETT',
                    'fallback_country' => 'South Korea',
                    'image_fallback' => 'img/Art(2).png',
                    'abilities' => [
                        ['suffix' => 'ability1', 'fallback' => 'img/vectors/Vector(1).png'],
                        ['suffix' => 'ability2', 'fallback' => 'img/vectors/Vector3.png'],
                        ['suffix' => 'ability3', 'fallback' => 'img/vectors/Vector(3).png'],
                        ['suffix' => 'ability4', 'fallback' => 'img/vectors/Vector-1.png'],
                    ],
                ],
                [
                    'index' => 3,
                    'theme' => 'theme-coal',
                    'label_classes' => 'vlabel',
                    'name_class' => '',
                    'fallback_name' => 'SOVA',
                    'fallback_country' => 'Russia',
                    'image_fallback' => 'img/Art(1).png',
                    'abilities' => [
                        ['suffix' => 'ability1', 'fallback' => 'img/vectors/Vector3.png'],
                        ['suffix' => 'ability2', 'fallback' => 'img/vectors/Vector(2).png'],
                        ['suffix' => 'ability3', 'fallback' => 'img/vectors/Vector.png'],
                        ['suffix' => 'ability4', 'fallback' => 'img/vectors/Vector-1.png'],
                    ],
                ],
                [
                    'index' => 4,
                    'theme' => 'theme-white',
                    'label_classes' => 'vlabel vlabel--light',
                    'name_class' => '',
                    'fallback_name' => 'SAGE',
                    'fallback_country' => 'China',
                    'image_fallback' => 'img/Art.png',
                    'abilities' => [
                        ['suffix' => 'ability1', 'fallback' => 'img/vectors/Vector(2).png'],
                        ['suffix' => 'ability2', 'fallback' => 'img/vectors/Vector3.png'],
                        ['suffix' => 'ability3', 'fallback' => 'img/vectors/Vector.png'],
                        ['suffix' => 'ability4', 'fallback' => 'img/vectors/Vector-1.png'],
                    ],
                ],
            ];
        @endphp

        <section class="tr-cards bg-gray-900 text-white p-8 rounded-lg space-y-10">
            <div class="text-center">
                <button class="tab-btn active px-6 py-3 text-lg bg-red-600/80 rounded">
                    <span data-content-key="tours-reg.header.title"
                          data-content-type="text"
                          data-content-value='{{ json_encode(optional($contents->get("tours-reg.header.title"))->value ?? []) }}'>
                        {{ content('tours-reg.header.title', 'E-Sports') }}
                    </span>
                </button>
            </div>

            <section class="our-news-section relative border border-gray-700/60 rounded-lg p-6 bg-gray-800/60">
                <div class="mb-6">
                    <button class="secondary-btn px-6 py-3 text-lg bg-gray-700 rounded">
                        <span data-content-key="tours-reg.section.title"
                              data-content-type="text"
                              data-content-value='{{ json_encode(optional($contents->get("tours-reg.section.title"))->value ?? []) }}'>
                            {{ content('tours-reg.section.title', 'Games') }}
                        </span>
                    </button>
                </div>

                <ul class="char-grid grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                    @foreach($cards as $card)
                        @php
                            $cardKey = "tours-reg.card{$card['index']}";
                        @endphp
                        <li class="char-card {{ $card['theme'] }} border border-gray-700 rounded-lg overflow-hidden">
                            <div class="char-wrap p-4 space-y-4">
                                <figure class="art overflow-hidden rounded-lg">
                                    <span data-content-key="{{ $cardKey }}.image"
                                          data-content-type="image"
                                          data-content-value='{{ json_encode(optional($contents->get($cardKey . ".image"))->value ?? []) }}'
                                          data-image-url="{{ content_media($cardKey . '.image', $card['image_fallback']) }}">
                                        <img src="{{ content_media($cardKey . '.image', $card['image_fallback']) }}"
                                             alt="Agent artwork"
                                             class="w-full h-56 object-cover rounded-lg border border-green-400/50" />
                                    </span>
                                </figure>

                                <div class="{{ $card['label_classes'] }}">
                                    <strong class="{{ $card['name_class'] }}">
                                        <span data-content-key="{{ $cardKey }}.name"
                                              data-content-type="text"
                                              data-content-value='{{ json_encode(optional($contents->get($cardKey . ".name"))->value ?? []) }}'>
                                            {{ content($cardKey . '.name', $card['fallback_name']) }}
                                        </span>
                                    </strong>
                                    <em>
                                        <span data-content-key="{{ $cardKey }}.country"
                                              data-content-type="text"
                                              data-content-value='{{ json_encode(optional($contents->get($cardKey . ".country"))->value ?? []) }}'>
                                            {{ content($cardKey . '.country', $card['fallback_country']) }}
                                        </span>
                                    </em>
                                </div>

                                <div class="abilities flex items-center gap-2 flex-wrap">
                                    @foreach($card['abilities'] as $index => $ability)
                                        @php
                                            $abilityKey = $cardKey . '.' . $ability['suffix'];
                                        @endphp
                                        <span data-content-key="{{ $abilityKey }}"
                                              data-content-type="image"
                                              data-content-value='{{ json_encode(optional($contents->get($abilityKey))->value ?? []) }}'
                                              data-image-url="{{ content_media($abilityKey, $ability['fallback']) }}">
                                            <img src="{{ content_media($abilityKey, $ability['fallback']) }}"
                                                 alt="Ability {{ $index + 1 }}"
                                                 class="ab w-10 h-10 object-contain border border-green-400/50 rounded" />
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="cta p-4 border-t border-gray-700 space-y-3 bg-black/20">
                                <button class="btn-register py-2 bg-red-600 rounded text-sm font-semibold">
                                    <span data-content-key="tours-reg.card.register_button"
                                          data-content-type="text"
                                          data-content-value='{{ json_encode(optional($contents->get("tours-reg.card.register_button"))->value ?? []) }}'>
                                        {{ content('tours-reg.card.register_button', 'Register - now') }}
                                    </span>
                                </button>
                                <div class="segmented flex gap-2 justify-center">
                                    <span data-content-key="tours-reg.links.single"
                                          data-content-type="text"
                                          data-content-value='{{ json_encode(optional($contents->get("tours-reg.links.single"))->value ?? []) }}'
                                          class="inline-flex">
                                        <span class="mini px-3 py-2 bg-gray-700 rounded text-sm">
                                            {{ content('tours-reg.links.single', 'Single') }}
                                        </span>
                                    </span>
                                    <span data-content-key="tours-reg.links.team"
                                          data-content-type="text"
                                          data-content-value='{{ json_encode(optional($contents->get("tours-reg.links.team"))->value ?? []) }}'
                                          class="inline-flex">
                                        <span class="mini px-3 py-2 bg-gray-700 rounded text-sm">
                                            {{ content('tours-reg.links.team', 'Team') }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </section>
        </section>
    </div>
</div>

@include('admin.components.edit-modal')
@include('admin.components.skeleton-styles')
@include('admin.components.skeleton-scripts')
@endsection
