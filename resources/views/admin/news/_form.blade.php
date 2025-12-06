@php($article = $article ?? null)

@if($errors->any())
  <div class="mb-4 px-4 py-3 bg-red-900/40 border border-red-700 text-red-200 rounded">
    <ul class="list-disc list-inside space-y-1 text-sm">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="grid grid-cols-1 gap-4">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm text-gray-300 mb-1">{{ __('Title (EN)') }}</label>
      <input
        name="title[en]"
        value="{{ old('title.en', data_get($article, 'title.en')) }}"
        class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
        required
      >
    </div>
    <div>
      <label class="block text-sm text-gray-300 mb-1">{{ __('Title (AR)') }}</label>
      <input
        name="title[ar]"
        dir="rtl"
        value="{{ old('title.ar', data_get($article, 'title.ar')) }}"
        class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
      >
    </div>
  </div>

  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Slug (optional)') }}</label>
    <input
      name="slug"
      value="{{ old('slug', $article->slug ?? '') }}"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
      placeholder="{{ __('auto-generated-from-title') }}"
    >
    <p class="mt-1 text-xs text-gray-500">{{ __('Leave blank to generate from the English title.') }}</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm text-gray-300 mb-1">{{ __('Date') }}</label>
      <input
        type="date"
        name="date"
        value="{{ old('date', optional(data_get($article, 'date'))->format('Y-m-d')) }}"
        class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
      >
    </div>
    <div class="flex items-center gap-2 pt-6">
      <input
        type="checkbox"
        name="is_published"
        id="is_published"
        value="1"
        {{ old('is_published', data_get($article, 'is_published', true)) ? 'checked' : '' }}
        class="w-4 h-4 text-amber-500 bg-neutral-800 border-neutral-600 rounded focus:ring-amber-500"
      >
      <label for="is_published" class="text-sm text-gray-300">{{ __('Published') }}</label>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm text-gray-300 mb-1">{{ __('Description (EN)') }}</label>
      <textarea
        name="description[en]"
        rows="6"
        class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
        required
      >{{ old('description.en', data_get($article, 'description.en')) }}</textarea>
    </div>
    <div>
      <label class="block text-sm text-gray-300 mb-1">{{ __('Description (AR)') }}</label>
      <textarea
        name="description[ar]"
        dir="rtl"
        rows="6"
        class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
      >{{ old('description.ar', data_get($article, 'description.ar')) }}</textarea>
    </div>
  </div>

  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Featured Image') }}</label>
    <input
      type="file"
      name="image"
      accept=".jpg,.jpeg,.png,.webp"
      class="w-full text-gray-200"
    >
    @if($article && $article->image_path)
      <img
        src="{{ asset($article->image_path) }}"
        alt="{{ __('Current image') }}"
        class="mt-3 h-24 w-auto rounded border border-neutral-700 object-cover"
      >
    @endif
    <p class="mt-1 text-xs text-gray-500">{!! __('Recommended path: uploads will be stored under <code>content-images/news</code>.') !!}</p>
  </div>
</div>
