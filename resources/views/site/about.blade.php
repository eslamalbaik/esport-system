@extends('layouts.app')

@section('title', __('About'))

@push('styles')
    @vite([
        'resources/css/style.css',
        'resources/css/about.css',
    ])
@endpush

@section('content')

<section class="about" aria-labelledby="about-title">


    <div class="right-panel">
        <div class="form-header">
           
            <button
                class="tab-btn active"
                style="font-size: 20px; border-radius: 10px">
                {{ content('about.header.text', __('About Us')) }}
            </button>
        </div>
    </div>

    <div class="about__stats">
        <!-- Stat 1 -->
        <article class="stat">
            <figure class="stat__avatar">
                <img src="{{ content_media('about.games.image', 'img/esport iamges.png') }}" alt="{{ content('about.games.alt', __('Games')) }}">
            </figure>

            <div class="stat__value">
                <span class="num">{{ content('about.stats.games.count', '89') }}</span>
                <span class="label">{{ content('about.stats.games', __('Games')) }}</span>
            </div>

            <div class="stat__icon" aria-hidden="true">
                <!-- heart -->
                <svg viewBox="0 0 24 24">
                    <path d="M20.8 8.6a5 5 0 0 0-8.8-3.4l-.9.9-.9-.9a5 5 0 0 0-8.8 3.4 5.7 5.7 0 0 0 1.7 4L11 22l8.9-9.4a5.7 5.7 0 0 0 1.7-4z" />
                </svg>
            </div>

            <div class="tile">
                <h3 class="tile__title">{{ content('about.story.title', __('Our Story')) }}</h3>
                <p class="tile__body">
                    {{ content('about.story.text', __('In early winter 2020, amidst a raging pandemic, FOUR04 ESPORTS was born. Our goal is to reinvent the region\'s esports championship by bringing together diverse expert teams to execute events that serve the game community better.')) }}
                </p>
            </div>
        </article>

        <!-- Stat 2 -->
        <article class="stat">
            <figure class="stat__avatar">
                <img src="{{ content_media('about.locations.image', 'img/esport iamges(2).png') }}" alt="{{ content('about.locations.alt', __('Locations')) }}">
            </figure>

            <div class="stat__value">
                <span class="num">{{ content('about.stats.locations.count', '6') }}</span>
                <span class="label">{{ content('about.stats.locations', __('Locations')) }}</span>
            </div>

            <div class="stat__icon" aria-hidden="true">
                <!-- search -->
                <svg viewBox="0 0 24 24">
                    <path d="M21 21l-4.3-4.3M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" />
                </svg>
            </div>

            <div class="tile">
                <h3 class="tile__title">{{ content('about.mission.title', __('Our Mission')) }}</h3>
                <p class="tile__body">
                    {{ content('about.mission.text', __('Establish a scalable esports platform in the Middle East, linking local and international communities with solutions for players and brands to get involved.')) }}
                </p>
            </div>
        </article>

        <!-- Stat 3 -->
        <article class="stat">
            <figure class="stat__avatar">
                <img src="{{ content_media('about.total.prizes.image', 'img/esport iamges(1).png') }}" alt="{{ content('about.prizes.alt', __('Total Prizes')) }}">
            </figure>

            <div class="stat__value">
                <span class="num">{{ content('about.stats.prizes.amount', '590K $') }}</span>
                <span class="label">{{ content('about.stats.prizes', __('Total Prizes')) }}</span>
            </div>

            <div class="stat__icon" aria-hidden="true">
                <!-- plus in square -->
                <svg viewBox="0 0 24 24">
                    <path d="M4 4h16v16H4zM12 8v8M8 12h8" />
                </svg>
            </div>

            <div class="tile">
                <h3 class="tile__title">{{ content('about.vision.title', __('Our Vision')) }}</h3>
                <p class="tile__body">
                    {{ content('about.vision.text', __('Build a community where players feel energized and supported, with events that value mental health and lasting happiness.')) }}
                </p>
            </div>
        </article>
    </div>
</section>



@endsection
@push('scripts')
@vite('resources/js/script.js')
@endpush
