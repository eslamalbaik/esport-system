@extends('admin.layout')

@section('title', 'Edit About Page - Skeleton View')

@section('content')
<div class="skeleton-editor">
    <!-- Mode Indicator -->
    <div class="skeleton-mode-indicator">
        🎨 SKELETON EDIT MODE
    </div>

    <!-- Header -->
    <div class="skeleton-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-white">About Page - Visual Editor</h1>
                <p class="text-sm text-gray-400">Click any content element to edit it inline</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('about') }}" 
                   class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700" 
                   target="_blank">
                    Preview Page
                </a>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    <div class="skeleton-content">
        <div class="skeleton-instructions">
            <h3>How to use the Skeleton Editor:</h3>
            <ul>
                <li><span style="color: #60a5fa;">Blue highlighted areas</span> are text content - click to edit text in multiple languages</li>
                <li><span style="color: #34d399;">Green highlighted areas</span> are images - click to upload new images</li>
                <li>Changes are saved instantly and will update the live site</li>
                <li>Hover over any content to see its content key identifier</li>
            </ul>
        </div>

        <!-- ABOUT Section -->
        <section class="about bg-gray-900 text-white p-8 rounded-lg">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="mb-4">
                    <span data-content-key="about.header.image" 
                          data-content-type="image"
                          data-content-value="{{ $contents['about.header.image']->value ?? '{}' }}"
                          data-image-url="{{ content_media('about.header.image', 'content-images/about.header.png') }}">
                        <img src="{{ content_media('about.header.image', 'content-images/about.header.png') }}" 
                             alt="About Header" 
                             class="w-24 h-24 mx-auto rounded-lg" />
                    </span>
                </div>
                
                <h1 class="text-3xl font-bold">
                    <span data-content-key="about.header.text" 
                          data-content-type="text"
                          data-content-value="{{ $contents['about.header.text']->value ?? '{}' }}">
                        {{ content('about.header.text', 'About Us') }}
                    </span>
                </h1>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Stat 1 - Games -->
                <div class="text-center bg-gray-800 p-6 rounded-lg">
                    <div class="mb-4">
                        <span data-content-key="about.games.image" 
                              data-content-type="image"
                              data-content-value="{{ $contents['about.games.image']->value ?? '{}' }}"
                              data-image-url="{{ content_media('about.games.image', 'img/esport iamges.png') }}">
                            <img src="{{ content_media('about.games.image', 'img/esport iamges.png') }}" 
                                 alt="Games" 
                                 class="w-16 h-16 mx-auto rounded" />
                        </span>
                    </div>
                    <div class="text-3xl font-bold mb-2">89</div>
                    <div class="text-gray-400 mb-6">
                        <span data-content-key="about.stats.games" 
                              data-content-type="text"
                              data-content-value="{{ $contents['about.stats.games']->value ?? '{}' }}">
                            {{ content('about.stats.games', 'Games') }}
                        </span>
                    </div>
                    
                    <!-- Story Section -->
                    <div class="text-left">
                        <h3 class="text-xl font-semibold mb-3">
                            <span data-content-key="about.story.title" 
                                  data-content-type="text"
                                  data-content-value="{{ $contents['about.story.title']->value ?? '{}' }}">
                                {{ content('about.story.title', 'Our Story') }}
                            </span>
                        </h3>
                        <p class="text-gray-300 text-sm leading-relaxed"
                           data-content-key="about.story.text" 
                           data-content-type="text"
                           data-content-value="{{ $contents['about.story.text']->value ?? '{}' }}">
                            {{ content('about.story.text', 'In early winter 2020, amidst a raging pandemic, FOUR04 ESPORTS was born. Our goal is to reinvent the region\'s esports championship by bringing together diverse expert teams to execute events that serve the game community better.') }}
                        </p>
                    </div>
                </div>

                <!-- Stat 2 - Locations -->
                <div class="text-center bg-gray-800 p-6 rounded-lg">
                    <div class="mb-4">
                        <span data-content-key="about.locations.image" 
                              data-content-type="image"
                              data-content-value="{{ $contents['about.locations.image']->value ?? '{}' }}"
                              data-image-url="{{ content_media('about.locations.image', 'img/esport iamges(2).png') }}">
                            <img src="{{ content_media('about.locations.image', 'img/esport iamges(2).png') }}" 
                                 alt="Locations" 
                                 class="w-16 h-16 mx-auto rounded" />
                        </span>
                    </div>
                    <div class="text-3xl font-bold mb-2">6</div>
                    <div class="text-gray-400 mb-6">
                        <span data-content-key="about.stats.locations" 
                              data-content-type="text"
                              data-content-value="{{ $contents['about.stats.locations']->value ?? '{}' }}">
                            {{ content('about.stats.locations', 'Locations') }}
                        </span>
                    </div>
                    
                    <!-- Mission Section -->
                    <div class="text-left">
                        <h3 class="text-xl font-semibold mb-3">
                            <span data-content-key="about.mission.title" 
                                  data-content-type="text"
                                  data-content-value="{{ $contents['about.mission.title']->value ?? '{}' }}">
                                {{ content('about.mission.title', 'Our Mission') }}
                            </span>
                        </h3>
                        <p class="text-gray-300 text-sm leading-relaxed"
                           data-content-key="about.mission.text" 
                           data-content-type="text"
                           data-content-value="{{ $contents['about.mission.text']->value ?? '{}' }}">
                            {{ content('about.mission.text', 'Establish a scalable esports platform in the Middle East, linking local and international communities with solutions for players and brands to get involved.') }}
                        </p>
                    </div>
                </div>

                <!-- Stat 3 - Prizes -->
                <div class="text-center bg-gray-800 p-6 rounded-lg">
                    <div class="mb-4">
                        <span data-content-key="about.total.prizes.image" 
                              data-content-type="image"
                              data-content-value="{{ $contents['about.total.prizes.image']->value ?? '{}' }}"
                              data-image-url="{{ content_media('about.total.prizes.image', 'img/esport iamges(1).png') }}">
                            <img src="{{ content_media('about.total.prizes.image', 'img/esport iamges(1).png') }}" 
                                 alt="Total Prizes" 
                                 class="w-16 h-16 mx-auto rounded" />
                        </span>
                    </div>
                    <div class="text-3xl font-bold mb-2">590K $</div>
                    <div class="text-gray-400 mb-6">
                        <span data-content-key="about.stats.prizes" 
                              data-content-type="text"
                              data-content-value="{{ $contents['about.stats.prizes']->value ?? '{}' }}">
                            {{ content('about.stats.prizes', 'Total Prizes') }}
                        </span>
                    </div>
                    
                    <!-- Vision Section -->
                    <div class="text-left">
                        <h3 class="text-xl font-semibold mb-3">
                            <span data-content-key="about.vision.title" 
                                  data-content-type="text"
                                  data-content-value="{{ $contents['about.vision.title']->value ?? '{}' }}">
                                {{ content('about.vision.title', 'Our Vision') }}
                            </span>
                        </h3>
                        <p class="text-gray-300 text-sm leading-relaxed"
                           data-content-key="about.vision.text" 
                           data-content-type="text"
                           data-content-value="{{ $contents['about.vision.text']->value ?? '{}' }}">
                            {{ content('about.vision.text', 'Build a community where players feel energized and supported, with events that value mental health and lasting happiness.') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Include Modal -->
@include('admin.components.edit-modal')

<!-- Include Styles -->
@include('admin.components.skeleton-styles')

<!-- Include Scripts -->
@include('admin.components.skeleton-scripts')
@endsection
