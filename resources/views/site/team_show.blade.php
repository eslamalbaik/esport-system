@extends('layouts.app')

@php($locale = app()->getLocale())
@php($name = $team->textFor($team->name, $locale))
@php($description = trim($team->textFor($team->description, $locale)))
@php($legacyText = $legacyValuesText ?? '')
@php($icons = ['🎮','🌍','🏆','⚡','🎯'])

@section('title', $name ?: __('Team Member'))

@push('styles')
    @vite([
        'resources/css/style.css',
        'resources/css/team.css',
    ])
@endpush

@section('content')
<section class="team team-show" aria-labelledby="team-member-title">
    <div class="team-head">
        <h2 id="team-member-title" class="pill-red">
           {{ __('Our Team') }}
        </h2>
    </div>

    <div class="team-show-layout">
        <div class="team-profile-card">
            @if($team->imageUrl())
                <div class="team-avatar-frame">
                    <div class="team-avatar-glow">
                        <img src="{{ $team->imageUrl() }}" alt="{{ $name }}">
                    </div>
                    <div class="team-name-tag">{{ $name }}</div>
                </div>
            @endif

            @if($description !== '')
                <p class="team-profile-intro">{!! nl2br(e($description)) !!}</p>
            @endif
        </div>

        <div class="team-values-column">
            @forelse($valueCards as $index => $card)
                <article class="team-value-card">
                    <div class="team-value-heading">
                        <span class="team-value-icon">{{ $icons[$index % count($icons)] }}</span>
                        <span>{{ $card['title'] ?: __('Key Highlight') }}</span>
                    </div>
                    <div class="team-value-body">{!! nl2br(e($card['body'])) !!}</div>
                </article>
            @empty
                @if($legacyText !== '')
                    <article class="team-value-card">
                        <div class="team-value-heading">
                            <span class="team-value-icon">★</span>
                            <span>{{ __('Values') }}</span>
                        </div>
                        <div class="team-value-body">{!! nl2br(e($legacyText)) !!}</div>
                    </article>
                @endif
            @endforelse
        </div>
    </div>

    <a href="{{ route('team') }}" class="team-value-heading">
        {{ __('Back to Team') }}
    </a>
</section>
@endsection
