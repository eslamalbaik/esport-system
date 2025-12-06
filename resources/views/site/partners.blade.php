@extends('layouts.app')

@section('title', __('Our Partners'))

@push('styles')
    @vite([
        'resources/css/style.css',
        'resources/css/partners.css',
    ])
@endpush

@section('content')

<section class="partners" aria-labelledby="partners-title">

      <div class="right-panel">
        <div class="form-header" style=" margin: 50px;">
          <button
            class="tab-btn active"
            style="font-size: 20px; border-radius: 10px;"
          >
            {{ content('partners.header.text', __('E-Sports')) }}
          </button>
        </div>
      </div>

  <!-- Section 1 -->
  <div class="section1" style="margin: 20px; text-align: center;">
    <h2 class="section1__title">{{ content('partners.section1.title', __('Our Partnership Benefits')) }}</h2>
    <p class="section1__text">{{ content('partners.section1.text', __('Discover how partnering with us can elevate your brand and connect you with the esports community.')) }}</p>
  </div>

  @php($locale = app()->getLocale())
  @php($partners = \App\Models\Partner::published()->ordered()->get())
  @php($ctaLabel = content('partners.card.cta', __('Read More')))
  <ul class="partners__grid">
    @forelse($partners as $partner)
      <li class="p-card">
        <figure class="p-card__thumb">
          @if($partner->media_type === 'image' && $partner->image_path)
            <img src="{{ asset($partner->image_path) }}" alt="{{ $partner->displayName(app()->getLocale()) ?: content('partners.header.text', __('E-Sports')) }}">
          @elseif($partner->media_type === 'video' && $partner->video_url)
            <div class="ratio-16x9">
              <iframe src="{{ $partner->video_url }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
          @else
            <div class="ratio-16x9 placeholder">
              <div class="ratio-16x9__inner">{{ __('Media unavailable') }}</div>
            </div>
          @endif
        </figure>
        @php($cardDescription = $partner->displayText($partner->description, $locale))
        <p class="p-card__desc">
          {{ $cardDescription ?: content('partners.intro.text', __('The Healing is fresh!!! can not wait to take my next session, really I feel so Energetic and I know care of the quality for my mental health and Happiness no matter what I face.')) }}
        </p>
        @if($partner->slug)
          <a class="btn-more" href="{{ route('partners.show', $partner) }}">
            {{ $ctaLabel }}
          </a>
        @endif
      </li>
    @empty
      <li class="p-card">
        <figure class="p-card__thumb">
          <div class="ratio-16x9">
            <div class="ratio-16x9__inner">{{ __('No partners available at the moment.') }}</div>
          </div>
        </figure>
        <p class="p-card__desc">
          {{ __('Check back soon to see our latest partnerships.') }}
        </p>
        <button class="btn-more" type="button">{{ $ctaLabel }}</button>
      </li>
    @endforelse
  </ul>

  <!-- pager + nav -->
  <div class="partners__controls">
    <div class="dots" role="tablist" aria-label="{{ __('Partners slides') }}">
      @for($i = 1; $i <= 4; $i++)
        <button
          class="dot{{ $i === 1 ? ' is-active' : '' }}"
          @if($i === 1) aria-current="true" @endif
          aria-label="{{ __('Slide :number', ['number' => $i]) }}"
        ></button>
      @endfor
    </div>

    <div class="nav">
      <button class="nav__btn nav__btn--prev" aria-label="{{ __('Previous') }}">
        <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
      </button>
      <button class="nav__btn nav__btn--next" aria-label="{{ __('Next') }}">
        <svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"/></svg>
      </button>
    </div>
  </div>
</section>


@endsection
@push('scripts')
@vite('resources/js/script.js')
@endpush
