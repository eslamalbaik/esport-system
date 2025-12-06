@php($titleEn = old('title_en', data_get($game->title, 'en')))
@php($titleAr = old('title_ar', data_get($game->title, 'ar')))
@php($descriptionEn = old('description_en', data_get($game->description, 'en')))
@php($descriptionAr = old('description_ar', data_get($game->description, 'ar')))
@php($status = old('status', $game->status ?? null) ?: 'open')
@php($allowSingle = old('allow_single', $game->allow_single ?? true))
@php($allowTeam = old('allow_team', $game->allow_team ?? true))
@php($sortOrder = old('sort_order', $game->sort_order ?? null))

<div class="space-y-4">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm text-gray-300 mb-1" for="titleEn">{{ __('Title (English)') }}</label>
      <input id="titleEn" type="text" name="title_en" value="{{ $titleEn }}" required class="w-full px-3 py-2 bg-neutral-900 border border-neutral-700 rounded text-gray-100" placeholder="{{ __('Valorant Qualifier') }}">
    </div>
    <div>
      <label class="block text-sm text-gray-300 mb-1" for="titleAr">{{ __('Title (Arabic)') }}</label>
      <input id="titleAr" type="text" name="title_ar" value="{{ $titleAr }}" class="w-full px-3 py-2 bg-neutral-900 border border-neutral-700 rounded text-gray-100" placeholder="{{ __('Arabic title') }}">
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm text-gray-300 mb-1" for="slug">{{ __('Slug') }}</label>
      <input id="slug" type="text" name="slug" value="{{ old('slug', $game->slug) }}" class="w-full px-3 py-2 bg-neutral-900 border border-neutral-700 rounded text-gray-100" placeholder="{{ __('valorant-qualifier') }}">
      <p class="text-xs text-gray-500 mt-1">{{ __('Leave empty to auto-generate from the English title.') }}</p>
    </div>
    <div>
      <label class="block text-sm text-gray-300 mb-1" for="sortOrder">{{ __('Sort Order') }}</label>
      <input id="sortOrder" type="number" name="sort_order" value="{{ $sortOrder }}" min="0" class="w-full px-3 py-2 bg-neutral-900 border border-neutral-700 rounded text-gray-100" placeholder="0">
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm text-gray-300 mb-1" for="descriptionEn">{{ __('Description (English)') }}</label>
      <textarea id="descriptionEn" name="description_en" rows="4" class="w-full px-3 py-2 bg-neutral-900 border border-neutral-700 rounded text-gray-100" placeholder="{{ __('Short blurb about this game slot...') }}">{{ $descriptionEn }}</textarea>
    </div>
    <div>
      <label class="block text-sm text-gray-300 mb-1" for="descriptionAr">{{ __('Description (Arabic)') }}</label>
      <textarea id="descriptionAr" name="description_ar" rows="4" class="w-full px-3 py-2 bg-neutral-900 border border-neutral-700 rounded text-gray-100" placeholder="{{ __('Arabic description...') }}">{{ $descriptionAr }}</textarea>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
    <div>
      <label class="block text-sm text-gray-300 mb-1" for="gameImage">
        {{ __('Game Image') }}
        @if(! $game->image_path)
          <span class="text-red-400">*</span>
        @endif
      </label>
      <input
        id="gameImage"
        type="file"
        name="image"
        accept="image/*"
        class="w-full text-sm text-gray-200 bg-neutral-900 border border-dashed border-neutral-700 rounded px-3 py-2"
      >
      <p class="text-xs text-gray-500 mt-1">{{ __('Recommended at least 800x600px. Formats: JPG, PNG, WEBP (max 1 MB).') }}</p>
    </div>
    @if(!empty($game->image_path))
      <div class="space-y-2">
        <span class="text-xs uppercase text-gray-400">{{ __('Current Image') }}</span>
        <img src="{{ $game->imageUrl() }}" alt="{{ $game->titleFor(app()->getLocale()) }}" class="rounded border border-neutral-700 max-h-48 object-cover">
      </div>
    @endif
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
      <label class="block text-sm text-gray-300 mb-1" for="status">{{ __('Status') }}</label>
      <select id="status" name="status" class="w-full px-3 py-2 bg-neutral-900 border border-neutral-700 rounded text-gray-100">
        <option value="open" {{ $status === 'open' ? 'selected' : '' }}>{{ __('Open') }}</option>
        <option value="closed" {{ $status === 'closed' ? 'selected' : '' }}>{{ __('Closed') }}</option>
        <option value="finished" {{ $status === 'finished' ? 'selected' : '' }}>{{ __('Finished') }}</option>
      </select>
    </div>
    <label class="flex items-center gap-2 text-gray-200">
      <input type="checkbox" name="allow_single" value="1" class="rounded border-neutral-600 bg-neutral-900 text-emerald-500 focus:ring-emerald-500" {{ $allowSingle ? 'checked' : '' }}>
      <span>{{ __('Allow single registrations') }}</span>
    </label>
    <label class="flex items-center gap-2 text-gray-200">
      <input type="checkbox" name="allow_team" value="1" class="rounded border-neutral-600 bg-neutral-900 text-emerald-500 focus:ring-emerald-500" {{ $allowTeam ? 'checked' : '' }}>
      <span>{{ __('Allow team registrations') }}</span>
    </label>
  </div>
</div>
