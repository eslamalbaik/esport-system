@php($item = $item ?? null)

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
        value="{{ old('title.en', data_get($item, 'title.en')) }}"
        class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
        required
      >
    </div>
    <div>
      <label class="block text-sm text-gray-300 mb-1">{{ __('Title (AR)') }}</label>
      <input
        name="title[ar]"
        dir="rtl"
        value="{{ old('title.ar', data_get($item, 'title.ar')) }}"
        class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
      >
    </div>
  </div>

  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Slug (optional)') }}</label>
    <input
      name="slug"
      value="{{ old('slug', $item->slug ?? '') }}"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
      placeholder="{{ __('auto-generated-from-title') }}"
    >
    <p class="mt-1 text-xs text-gray-500">{{ __('Leave blank to generate from the English title.') }}</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm text-gray-300 mb-1">{{ __('Media Source') }}</label>
      <select
        name="video_type"
        class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
        required
      >
        @php($videoType = old('video_type', $item->video_type ?? \App\Models\GalleryItem::VIDEO_TYPE_YOUTUBE))
        <option value="youtube" {{ $videoType === 'youtube' ? 'selected' : '' }}>{{ __('YouTube Embed') }}</option>
        <option value="vimeo" {{ $videoType === 'vimeo' ? 'selected' : '' }}>{{ __('Vimeo Embed') }}</option>
        <option value="file" {{ $videoType === 'file' ? 'selected' : '' }}>{{ __('Upload Image') }}</option>
      </select>
      <p class="mt-1 text-xs text-gray-500">{{ __('Choose how the media will be loaded on the public page.') }}</p>
    </div>

    <div class="flex items-center gap-2 pt-6">
      <input
        type="checkbox"
        name="is_published"
        id="is_published"
        value="1"
        {{ old('is_published', data_get($item, 'is_published', true)) ? 'checked' : '' }}
        class="w-4 h-4 text-purple-500 bg-neutral-800 border-neutral-600 rounded focus:ring-purple-500"
      >
      <label for="is_published" class="text-sm text-gray-300">{{ __('Published') }}</label>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm text-gray-300 mb-1">{{ __('Video URL (YouTube/Vimeo)') }}</label>
      <input
        name="video_url"
        value="{{ old('video_url', $item->video_url ?? '') }}"
        class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
        placeholder="{{ __('https://youtube.com/watch?v=...') }}"
      >
      <p class="mt-1 text-xs text-gray-500">{{ __('Required when video source is YouTube or Vimeo.') }}</p>
    </div>
    <div>
      <label class="block text-sm text-gray-300 mb-1">{{ __('Upload Image File') }}</label>
      <input
        type="file"
        name="video_file"
        accept="image/jpeg,image/png,image/webp"
        class="w-full text-gray-200"
      >
      @if($item && $item->video_type === \App\Models\GalleryItem::VIDEO_TYPE_FILE && $item->video_path)
        <img
          src="{{ asset($item->video_path) }}"
          alt="{{ __('Uploaded image') }}"
          class="mt-3 h-32 w-auto rounded border border-neutral-700 object-cover"
        >
      @endif
      <p class="mt-1 text-xs text-gray-500">{{ __('Required when the source is set to upload.') }}</p>
    </div>
  </div>

  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Thumbnail Image (optional)') }}</label>
    <input
      type="file"
      name="thumb"
      accept=".jpg,.jpeg,.png,.webp"
      class="w-full text-gray-200"
    >
    @if($item && $item->thumb_path)
      <img
        src="{{ asset($item->thumb_path) }}"
        alt="{{ __('Thumbnail') }}"
        class="mt-3 h-24 w-auto rounded border border-neutral-700 object-cover"
      >
    @endif
    <p class="mt-1 text-xs text-gray-500">{!! __('Used on the gallery grid. Stored under <code>content-images/gallery</code>.') !!}</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm text-gray-300 mb-1">{{ __('Description (EN)') }}</label>
      <textarea
        name="description[en]"
        rows="6"
        class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
        required
      >{{ old('description.en', data_get($item, 'description.en')) }}</textarea>
    </div>
    <div>
      <label class="block text-sm text-gray-300 mb-1">{{ __('Description (AR)') }}</label>
      <textarea
        name="description[ar]"
        dir="rtl"
        rows="6"
        class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
      >{{ old('description.ar', data_get($item, 'description.ar')) }}</textarea>
    </div>
  </div>

  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Publish Date (optional)') }}</label>
    <input
      type="datetime-local"
      name="published_at"
      value="{{ old('published_at', optional(data_get($item, 'published_at'))->format('Y-m-d\TH:i')) }}"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
    >
    <p class="mt-1 text-xs text-gray-500">{{ __('Optional metadata shown in the admin tools; leave blank if you do not need to record a publish date.') }}</p>
  </div>
</div>
