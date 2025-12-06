@extends('layouts.app')

@section('title', $item->t('title', app()->getLocale()) ?: __('Gallery Item'))

@push('styles')
    @vite([
        'resources/css/style.css',
        'resources/css/gallery.css',
    ])
@endpush

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

    <figure class="g-frame g-frame--video">
        {!! $item->embedHtml() !!}
        <span class="g-rail" aria-hidden="true"></span>
    </figure>

    <div class="mt-6 text-center">
        </div>
    </section>
    
    <section class="py-16 bg-black">
        <div class="container mx-auto px-6 max-w-5xl space-y-10">
            <div class="space-y-6">
                <h1 class="text-3xl font-bold text-white">
                    {{ $item->t('title', app()->getLocale()) }}
                </h1>
                <div class="text-gray-200 leading-relaxed space-y-4">
                    {!! nl2br(e($item->t('description', app()->getLocale()))) !!}
                </div>
            </div>
            <a
                href="{{ route('gallery') }}"
                class="g-back-btn"
            >
                <span class="g-back-btn__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24">
                        <path d="M15 18l-6-6 6-6" />
                    </svg>
                </span>
                <span>{{ __('Back to Gallery') }}</span>
            </a>
        </div>
</section>
@endsection

@push('scripts')
@vite('resources/js/script.js')
@endpush
