@extends('layouts.app')

@section('title', __('Gallery'))

@push('styles')
    @vite([
        'resources/css/style.css',
        'resources/css/gallery.css',
    ])
@endpush

@php($hasMultipleItems = $items->count() > 1)

@section('content')
<section class="gallery" aria-labelledby="gallery-title">
    <div class="right-panel">
        <div class="form-header">
            <button
                class="tab-btn active"
                style="font-size: 20px; border-radius: 10px">
                {{ content('gallery.header.tab_title', __('Gallery')) }}
            </button>
        </div>
    </div>

    @if($items->isNotEmpty())
        <div class="g-slider js-gallery-slider" data-slider-interval="6000">
            <div class="g-slider__viewport js-gallery-slider-viewport">
                <div class="g-slider__track js-gallery-slider-track">
                    @foreach($items as $item)
                        <div class="g-slide js-gallery-slide">
                            <figure class="g-frame">
                                <div class="g-frame__media">
                                    @php($embed = $item->embedHtml())
                                    @if(trim((string) $embed) !== '')
                                        <div class="g-frame__embed">
                                            {!! $embed !!}
                                        </div>
                                    @else
                                        <img
                                            src="{{ $item->thumbnailUrl() ?? asset('img/placeholder-gallery.jpg') }}"
                                            alt="{{ $item->t('title', app()->getLocale()) }}"
                                        />
                                    @endif
                                </div>

                                <a
                                    href="{{ route('gallery.show', $item->slug) }}"
                                    class="play"
                                    aria-label="{{ __('View :title', ['title' => $item->t('title', app()->getLocale())]) }}"
                                >
                                    <span class="play__ring"></span>
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </a>

                                <span class="g-rail" aria-hidden="true"></span>

                                <figcaption class="g-frame__caption">
                                    <div class="g-frame__text">
                                        <h3 class="g-frame__title">
                                            {{ $item->t('title', app()->getLocale()) }}
                                        </h3>
                                        @if($item->video_type)
                                            <p class="g-frame__meta">{{ $item->sourceLabel() }}</p>
                                        @endif
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>

            @if($hasMultipleItems)
                <div class="g-controls">
                    <div class="dots" role="tablist" aria-label="{{ __('Gallery slides') }}">
                        @foreach($items as $item)
                            <button
                                type="button"
                                class="dot{{ $loop->first ? ' is-active' : '' }}"
                                aria-label="{{ __('Slide :number', ['number' => $loop->iteration]) }}"
                                @if($loop->first) aria-current="true" @endif
                                data-slider-dot="{{ $loop->index }}"
                            ></button>
                        @endforeach
                    </div>

                    <div class="nav">
                        <button
                            class="nav__btn nav__btn--prev"
                            type="button"
                            data-slider-prev
                            aria-label="{{ __('Previous') }}"
                        >
                            <svg viewBox="0 0 24 24">
                                <path d="M15 18l-6-6 6-6" />
                            </svg>
                        </button>
                        <button
                            class="nav__btn nav__btn--next"
                            type="button"
                            data-slider-next
                            aria-label="{{ __('Next') }}"
                        >
                            <svg viewBox="0 0 24 24">
                                <path d="M9 6l6 6-6 6" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
        </div>
        @if(method_exists($items, 'hasPages') && $items->hasPages())
            <div class="g-pagination">
                {{ $items->withQueryString()->links() }}
            </div>
        @endif
    @else
        <div class="g-empty">
            <p>{{ __('Gallery items are coming soon. Please check back later.') }}</p>
        </div>
    @endif
</section>
@endsection
@push('scripts')
@vite('resources/js/script.js')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slider = document.querySelector('.js-gallery-slider');
        if (!slider) {
            return;
        }

        const track = slider.querySelector('.js-gallery-slider-track');
        const viewport = slider.querySelector('.js-gallery-slider-viewport');
        const slides = track ? Array.from(track.querySelectorAll('.js-gallery-slide')) : [];
        const dots = Array.from(slider.querySelectorAll('[data-slider-dot]'));
        const prevBtn = slider.querySelector('[data-slider-prev]');
        const nextBtn = slider.querySelector('[data-slider-next]');
        const slideCount = slides.length;
        const intervalMs = Number(slider.dataset.sliderInterval || '') || 6000;
        let currentIndex = 0;
        let autoTimer = null;
        let slideWidth = 0;

        if (!track || !viewport || slideCount === 0) {
            return;
        }

        const sliderDirection = window.getComputedStyle(slider).direction;
        const isRtl = sliderDirection === 'rtl';

        if (isRtl) {
            track.style.direction = 'ltr';
            track.style.flexDirection = 'row';
            slides.forEach((slide) => {
                slide.style.direction = sliderDirection;
            });
        }

        const updateDots = () => {
            dots.forEach((dot, idx) => {
                const isActive = idx === currentIndex;
                dot.classList.toggle('is-active', isActive);
                if (isActive) {
                    dot.setAttribute('aria-current', 'true');
                } else {
                    dot.removeAttribute('aria-current');
                }
            });
        };

        const updateSliderPosition = (instant = false) => {
            const target = currentIndex * slideWidth;
            const translateValue = isRtl ? target : -target;
            if (instant) {
                const previousTransition = track.style.transition;
                track.style.transition = 'none';
                track.style.transform = `translateX(${translateValue}px)`;
                // Force a reflow so the browser applies the transform before restoring the transition.
                void track.offsetWidth;
                track.style.transition = previousTransition || '';
            } else {
                track.style.transform = `translateX(${translateValue}px)`;
            }
        };

        const applyLayout = (instant = false) => {
            slideWidth = viewport.getBoundingClientRect().width;

            slides.forEach((slide) => {
                slide.style.width = `${slideWidth}px`;
                slide.style.flex = `0 0 ${slideWidth}px`;
            });

            track.style.width = `${slideWidth * slideCount}px`;
            updateSliderPosition(instant);
        };

        const scheduleLayout = (() => {
            let timer = null;

            return (instant = false) => {
                if (timer) {
                    clearTimeout(timer);
                    timer = null;
                }

                if (instant) {
                    applyLayout(true);
                } else {
                    timer = setTimeout(() => applyLayout(true), 120);
                }
            };
        })();

        applyLayout(true);
        updateDots();

        window.addEventListener('resize', () => scheduleLayout());
        window.addEventListener('load', () => scheduleLayout(true));

        const goTo = (index) => {
            currentIndex = (index + slideCount) % slideCount;
            updateSliderPosition();
            updateDots();
        };

        const goToNext = () => goTo(currentIndex + (isRtl ? -1 : 1));
        const goToPrev = () => goTo(currentIndex + (isRtl ? 1 : -1));

        const clearAutoPlay = () => {
            if (autoTimer) {
                clearInterval(autoTimer);
                autoTimer = null;
            }
        };

        const resetAutoPlay = () => {
            clearAutoPlay();
            if (slideCount > 1) {
                autoTimer = setInterval(goToNext, intervalMs);
            }
        };

        if (slideCount > 1) {
            nextBtn?.addEventListener('click', () => {
                goToNext();
                resetAutoPlay();
            });

            prevBtn?.addEventListener('click', () => {
                goToPrev();
                resetAutoPlay();
            });

            dots.forEach((dot, idx) => {
                dot.addEventListener('click', () => {
                    goTo(idx);
                    resetAutoPlay();
                });
            });

            slider.addEventListener('mouseenter', () => {
                clearAutoPlay();
            });

            slider.addEventListener('mouseleave', () => {
                resetAutoPlay();
            });

            resetAutoPlay();
        }
    });
</script>
@endpush
