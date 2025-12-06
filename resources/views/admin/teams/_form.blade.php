@php
  $team = $team ?? null;
  $defaultSortOrder = $defaultSortOrder ?? 0;
  $highlightLocales = config('highlights.locales', []);
  $maxHighlightCards = config('highlights.max_cards', 3);
  $highlightDefaults = [];

  foreach ($highlightLocales as $localeCode => $meta) {
      $old = old("values.$localeCode");

      if (is_array($old)) {
          $rows = collect($old)
              ->map(fn ($entry) => [
                  'title' => $entry['title'] ?? '',
                  'body' => $entry['body'] ?? '',
              ])
              ->all();
      } else {
          $rows = \App\Support\HighlightParser::normalize(data_get($team, "values.$localeCode"));
      }

      $highlightDefaults[$localeCode] = array_pad(
          array_slice($rows, 0, $maxHighlightCards),
          $maxHighlightCards,
          ['title' => '', 'body' => '']
      );
  }
@endphp

@if($errors->any())
  <div class="mb-4 px-4 py-3 bg-red-900/40 border border-red-700 text-red-200 rounded">
    <ul class="list-disc list-inside space-y-1 text-sm">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="space-y-8">
  <!-- Hero profile block -->
  <section class="bg-neutral-900/60 border border-neutral-800 rounded-xl p-6 space-y-6">
    <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
      <div>
        <h3 class="text-lg font-semibold text-white">{{ __('Hero Card') }}</h3>
        <p class="text-sm text-gray-400">
          {{ __('This data feeds the big avatar, red name tag, and hero copy on the public page.') }}
        </p>
      </div>
      <span class="text-xs uppercase tracking-widest text-gray-500">{{ __('Matches the left column in the mock') }}</span>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm text-gray-300 mb-1">{{ __('Name (EN)') }}</label>
        <input
          type="text"
          name="name[en]"
          value="{{ old('name.en', data_get($team, 'name.en')) }}"
          class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
          required
        >
      </div>
      <div>
        <label class="block text-sm text-gray-300 mb-1">{{ __('Name (AR)') }}</label>
        <input
          type="text"
          name="name[ar]"
          dir="rtl"
          value="{{ old('name.ar', data_get($team, 'name.ar')) }}"
          class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
        >
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div>
        <label class="block text-sm text-gray-300 mb-1">{{ __('Hero Image') }}</label>
        <input
          type="file"
          name="image"
          accept=".png,.jpg,.jpeg,.webp"
          class="w-full text-gray-200"
        >
        <p class="text-xs text-gray-400 mt-1">
          {!! __('Square crop works best (600x600). File is saved under <code>content-images/teams</code>.') !!}
        </p>
        @if($team && $team->image_path)
          <img src="{{ asset($team->image_path) }}" alt="{{ __('Current team image') }}" class="mt-3 h-32 w-32 object-cover rounded-2xl border border-neutral-700 shadow-lg">
        @endif
      </div>
      <div class="bg-neutral-900/70 border border-neutral-800 rounded-lg p-4 text-sm text-gray-400">
        <p class="font-semibold text-gray-200 mb-2">{{ __('Hero Copy Tips') }}</p>
        <p>
          {{ __('The hero section mirrors the mock: bold name, red pillow, and a short focus paragraph. Keep it punchy: 2–3 sentences max describing achievements, focus, or mission.') }}
        </p>
      </div>
    </div>
  </section>

  <!-- Focused description -->
  <section class="bg-neutral-900/60 border border-neutral-800 rounded-xl p-6 space-y-4">
    <header>
      <h3 class="text-lg font-semibold text-white">{{ __('Focus Statement') }}</h3>
      <p class="text-sm text-gray-400">
        {{ __('Appears beneath the hero card (bold white copy). Use this to explain their public role.') }}
      </p>
    </header>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm text-gray-300 mb-1">{{ __('Focus Statement (EN)') }}</label>
        <textarea
          name="description[en]"
          rows="4"
          class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
        >{{ old('description.en', data_get($team, 'description.en')) }}</textarea>
      </div>
      <div>
        <label class="block text-sm text-gray-300 mb-1">{{ __('Focus Statement (AR)') }}</label>
        <textarea
          name="description[ar]"
          dir="rtl"
          rows="4"
          class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
        >{{ old('description.ar', data_get($team, 'description.ar')) }}</textarea>
      </div>
    </div>
  </section>

  <!-- Highlight cards -->
  <section class="bg-neutral-900/60 border border-neutral-800 rounded-xl p-6 space-y-4">
    <header class="flex flex-col gap-1">
      <h3 class="text-lg font-semibold text-white">{{ __('Story Highlights (Red Cards)') }}</h3>
      <p class="text-sm text-gray-400">
        {{ __('Provide up to three short highlight cards. Each card has a title and a short supportive paragraph.') }}
      </p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      @foreach(($highlightLocales ?? []) as $localeCode => $meta)
        @php($cards = $highlightDefaults[$localeCode] ?? [])
        <div class="space-y-4" @if($meta['dir'] === 'rtl') dir="rtl" @endif>
          <p class="text-sm font-semibold text-gray-200">{{ $meta['label'] }}</p>
          @foreach($cards as $index => $card)
            <div class="space-y-2 bg-neutral-900/40 border border-neutral-800 rounded-lg p-4">
              <p class="text-xs uppercase tracking-wide text-gray-400">{{ __('Card') }} {{ $index + 1 }}</p>
              <div>
                <label class="block text-sm text-gray-300 mb-1">{{ __('Title') }}</label>
                <input
                  type="text"
                  name="values[{{ $localeCode }}][{{ $index }}][title]"
                  value="{{ $card['title'] }}"
                  class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
                >
              </div>
              <div>
                <label class="block text-sm text-gray-300 mb-1">{{ __('Body') }}</label>
                <textarea
                  name="values[{{ $localeCode }}][{{ $index }}][body]"
                  rows="3"
                  class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
                >{{ $card['body'] }}</textarea>
              </div>
            </div>
          @endforeach
        </div>
      @endforeach
    </div>
  </section>

  <!-- Meta controls -->
  <section class="bg-neutral-900/60 border border-neutral-800 rounded-xl p-6 space-y-4">
    <div class="flex items-center gap-2">
      <input
        type="checkbox"
        name="is_published"
        id="is_published"
        value="1"
        {{ old('is_published', data_get($team, 'is_published', true)) ? 'checked' : '' }}
        class="w-4 h-4 text-red-500 bg-neutral-800 border-neutral-600 rounded focus:ring-red-600"
      >
      <label for="is_published" class="text-sm text-gray-300">{{ __('Published') }}</label>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm text-gray-300 mb-1">{{ __('Sort Order') }}</label>
        <input
          type="number"
          name="sort_order"
          min="0"
          value="{{ old('sort_order', $team->sort_order ?? $defaultSortOrder) }}"
          class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
        >
      </div>
      @if($team)
        <div class="md:col-span-2">
          <label class="block text-sm text-gray-300 mb-1">{{ __('Slug (auto)') }}</label>
          <input
            type="text"
            value="{{ $team->slug }}"
            readonly
            class="w-full bg-neutral-900 text-gray-400 rounded px-3 py-2 border border-neutral-700"
          >
        </div>
      @endif
    </div>
  </section>
</div>
