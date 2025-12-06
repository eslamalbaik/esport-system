@extends('layouts.app')

@section('title', $partner->displayName(app()->getLocale()) ?: __('Partner'))

@push('styles')
    @vite([
        'resources/css/style.css',
        'resources/css/partners.css',
        'resources/css/partner_show.css',
    ])
@endpush

@section('content')
@php
    $locale = app()->getLocale();
    $description = trim($partner->displayText($partner->description, $locale)) ?: null;
    $history = trim($partner->displayText($partner->history, $locale)) ?: null;
    $name = $partner->displayName($locale) ?: __('Partner');

    $normalizeLines = static function (?string $text): array {
        if (!$text) {
            return [];
        }

        $segments = preg_split('/\r\n|\r|\n/', trim($text)) ?: [];

        return array_values(array_filter(array_map('trim', $segments)));
    };

    $descriptionLines = $normalizeLines($description);
    $leadParagraph = $descriptionLines ? array_shift($descriptionLines) : null;

    $descriptionBullets = array_values(array_filter(array_map(
        static fn ($line) => ltrim($line, "-•* \t"),
        array_filter($descriptionLines, static fn ($line) => preg_match('/^[-•*]/', $line))
    )));

    if (empty($descriptionBullets) && !empty($descriptionLines)) {
        $descriptionBullets = $descriptionLines;
    }

    $historyEntries = [];
    $historyObjectives = [];

    foreach ($normalizeLines($history) as $line) {
        if (preg_match('/^(?<year>\d{4})\s*(?:-|:|–)\s*(?<detail>.+)$/u', $line, $matches)) {
            $historyEntries[] = [
                'year' => $matches['year'],
                'detail' => trim($matches['detail']),
            ];
            continue;
        }

        if (preg_match('/^\d{4}$/', $line)) {
            $historyEntries[] = ['year' => $line, 'detail' => ''];
            continue;
        }

        $historyObjectives[] = $line;
    }

    $siblings = \App\Models\Partner::published()->ordered()->get(['id', 'slug', 'name']);
    $currentIndex = $siblings->search(static fn ($item) => $item->id === $partner->id);
    $previousPartner = $currentIndex !== false ? ($siblings[$currentIndex - 1] ?? null) : null;
    $nextPartner = $currentIndex !== false ? ($siblings[$currentIndex + 1] ?? null) : null;
@endphp

<section class="sp" aria-labelledby="partner-{{ $partner->id }}-title">
  <div class="sp__inner">
    <div class="sp__badge">{{ __('Our Partners') }}</div>

    <div class="sp__row">
      <div>
        <figure class="sp-card">
          <span class="sp-card__edge" aria-hidden="true"></span>
          <div class="sp-card__media">
            @if($partner->media_type === 'video' && $partner->video_url)
              <div class="ratio-16x9">
                <iframe src="{{ $partner->video_url }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
              </div>
            @elseif($partner->media_type === 'image' && $partner->image_path)
              <img src="{{ asset($partner->image_path) }}" alt="{{ $name }}">
            @else
              <div class="ratio-16x9 placeholder">
                <div class="ratio-16x9__inner">{{ __('Media unavailable') }}</div>
              </div>
            @endif
          </div>
          <figcaption class="sp-card__caption">{{ $name }}</figcaption>
        </figure>
      </div>

      <div class="sp__content" id="partner-{{ $partner->id }}-title">
        <p class="sp__lead">{{ $leadParagraph ?: __('More information will be shared soon.') }}</p>

        @if(!empty($descriptionBullets))
          <p class="sp__kicker">{{ __('Key Information') }}</p>
          <ul class="sp__list">
            @foreach($descriptionBullets as $item)
              <li>{{ $item }}</li>
            @endforeach
          </ul>
        @endif

        @if(!empty($historyObjectives))
          <p class="sp__kicker">{{ __('Objectives') }}</p>
          <ul class="sp__list">
            @foreach($historyObjectives as $objective)
              <li>{{ $objective }}</li>
            @endforeach
          </ul>
        @endif

        @if(!empty($historyEntries))
          <p class="sp__kicker">{{ __('Timeline') }}</p>
          <div class="sp__years">
            @foreach($historyEntries as $entry)
              <div class="sp-year">
                <div class="sp-year__y">{{ $entry['year'] ?: '•' }}</div>
                <div class="sp-year__d">
                  {{ $entry['detail'] ?: __('Milestone details coming soon') }}
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>

    <div class="sp__nav" aria-label="{{ __('Partner navigation') }}">
      <a
        class="sp-nav sp-nav--prev"
        href="{{ $previousPartner ? route('partners.show', $previousPartner) : route('partners') }}"
        aria-disabled="{{ $previousPartner ? 'false' : 'true' }}"
      >
        ‹
      </a>
      <a
        class="sp-nav sp-nav--next"
        href="{{ $nextPartner ? route('partners.show', $nextPartner) : route('partners') }}"
        aria-disabled="{{ $nextPartner ? 'false' : 'true' }}"
      >
        ›
      </a>
    </div>
  </div>
</section>
@endsection
