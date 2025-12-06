@extends('layouts.app')

@section('title', __('Teams'))

@push('styles')
    @vite([
        'resources/css/style.css',
        'resources/css/team.css',
    ])
@endpush

@section('content')

<section class="team" aria-labelledby="team-title">
    <div class="team-head">
        <h2 id="team-title" class="pill-red">
            {{ content('team.title', __('Our Team')) }}
        </h2>
    </div>

    <!-- edge confetti -->
    <i class="tri tl" aria-hidden="true"></i>
    <i class="tri tr" aria-hidden="true"></i>
    <i class="tri ml" aria-hidden="true"></i>
    <i class="tri mr" aria-hidden="true"></i>

    <!-- Grid -->
    @php $locale = app()->getLocale(); @endphp
    <ul class="team-grid">
        @forelse($teams as $team)
            @php
                $name = $team->textFor($team->name, $locale);
                $image = $team->imageUrl() ?? content_media('team.placeholder.image', 'img/image-3.png');
            @endphp
            <li class="member">
                <figure class="avatar">
                    <img src="{{ $image }}" alt="{{ $name }}" />
                </figure>
                <figcaption class="meta">
                    <h3 class="name">{{ $name }}</h3>
                    <a class="pill-red" href="{{ route('teams.show', $team) }}">{{ __('Read more') }}</a>
                </figcaption>
            </li>
        @empty
            <li class="member">
                <figcaption class="meta">
                    <h3 class="name">{{ __('Team profiles coming soon') }}</h3>
                </figcaption>
            </li>
        @endforelse
    </ul>
</section>


@endsection
@push('scripts')
@vite('resources/js/script.js')
@endpush
