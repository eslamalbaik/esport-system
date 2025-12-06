@extends('admin.layout')

@section('title', __('Team Preview'))

@section('content')
@php($highlightLocales = config('highlights.locales'))
<div class="px-6 py-4 space-y-4">
  <div class="flex flex-col gap-1">
    <h1 class="text-xl font-semibold text-white">{{ data_get($team->name, 'en') ?: __('Team Member') }}</h1>
    <p class="text-sm text-gray-400">{{ __('Quick preview of the published content.') }}</p>
  </div>

  <div class="bg-neutral-900/50 border border-neutral-800 rounded-lg p-6 space-y-4">
    <div class="flex flex-col md:flex-row gap-6">
      @if($team->image_path)
        <img src="{{ asset($team->image_path) }}" alt="{{ data_get($team->name, 'en') }}" class="w-40 h-40 object-cover rounded-lg border border-neutral-800">
      @endif
      <div class="flex-1 space-y-2">
        <div>
          <p class="text-xs uppercase text-gray-400">{{ __('Name') }}</p>
          <p class="text-base text-white">{{ data_get($team->name, 'en') }}</p>
          @if(data_get($team->name, 'ar'))
            <p class="text-base text-gray-300" dir="rtl">{{ data_get($team->name, 'ar') }}</p>
          @endif
        </div>
        <div class="flex items-center gap-3">
          <span class="inline-flex items-center px-2 py-1 text-xs rounded {{ $team->is_published ? 'bg-green-700/60 text-white' : 'bg-neutral-700 text-gray-300' }}">
            {{ $team->is_published ? __('Published') : __('Hidden') }}
          </span>
          <span class="text-xs text-gray-400">{{ __('Sort: :order', ['order' => $team->sort_order]) }}</span>
          <span class="text-xs text-gray-500">{{ __('Slug: :slug', ['slug' => $team->slug]) }}</span>
        </div>
      </div>
    </div>

    @if($team->description)
      <div>
        <p class="text-xs uppercase text-gray-400 mb-1">{{ __('Description (EN)') }}</p>
        <p class="text-sm text-gray-200 whitespace-pre-line">{{ data_get($team->description, 'en') }}</p>
        @if(data_get($team->description, 'ar'))
          <p class="text-xs uppercase text-gray-400 mt-4 mb-1">{{ __('Description (AR)') }}</p>
          <p class="text-sm text-gray-200 whitespace-pre-line" dir="rtl">{{ data_get($team->description, 'ar') }}</p>
        @endif
      </div>
    @endif

    <div>
      <p class="text-xs uppercase text-gray-400 mb-2">{{ __('Story Highlights') }}</p>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($highlightLocales as $localeCode => $meta)
          @php($cards = \App\Support\HighlightParser::normalize(data_get($team->values, $localeCode)))
          <div class="bg-neutral-900/40 border border-neutral-800 rounded-lg p-4 space-y-3" @if($meta['dir'] === 'rtl') dir="rtl" @endif>
            <p class="text-xs uppercase text-gray-500">{{ $meta['label'] }}</p>
            @forelse($cards as $card)
              <div class="rounded-lg border border-neutral-800 p-3">
                <p class="text-sm font-semibold text-white">{{ $card['title'] ?: __('Untitled') }}</p>
                @if($card['body'])
                  <p class="text-sm text-gray-300 mt-1 whitespace-pre-line">{{ $card['body'] }}</p>
                @endif
              </div>
            @empty
              <p class="text-sm text-gray-500">{{ __('No highlights provided for this locale.') }}</p>
            @endforelse
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <div class="flex items-center gap-3">
    <a href="{{ route('admin.teams.edit', $team) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">{{ __('Edit') }}</a>
    <a href="{{ route('admin.teams.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-gray-200 rounded transition">{{ __('Back to list') }}</a>
  </div>
</div>
@endsection
