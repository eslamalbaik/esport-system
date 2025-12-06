@extends('layouts.app')

@section('title', $article->t('title', app()->getLocale()))

@push('styles')
    @vite('resources/css/style.css')
@endpush

@section('content')
  <h2 style="display:flex;justify-content:center;">
    <button class="tab-btn active" style="font-size:25px;padding:10px 40px;border-radius:5px!important;">
      {{ content('news.header.main_title', __('E-Sports')) }}
    </button>
  </h2>

  <section class="our-news-section">
    <h2 style="display:flex;justify-content:start;">
      <button class="secondary-btn" style="font-size:25px;padding:10px 40px;border-radius:5px!important;">
        {{ content('news.header.section_title', __('Our News')) }}
      </button>
    </h2>

    <div class="news-container">
      <div class="news-card news-card--detailed" style="grid-column:1/-1;">
        @if($article->image_path)
          <div class="news-image-wrapper">
            <img
              src="{{ $article->imageUrl() }}"
              alt="{{ $article->t('title', app()->getLocale()) }}"
              class="news-image news-image--large"
            />
          </div>
        @endif
        <div class="news-content">
          <p class="news-date">{{ optional($article->date)->format('F j, Y') }}</p>
          <h1 class="news-title">{{ $article->t('title', app()->getLocale()) }}</h1>
          <p class="news-desc">
            {{ $article->t('description', app()->getLocale()) }}
          </p>
          <a class="news-btn" href="{{ route('news') }}" style="margin-top: 16px;">
            {{ __('Back to News') }}
          </a>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
@vite('resources/js/script.js')
@endpush
