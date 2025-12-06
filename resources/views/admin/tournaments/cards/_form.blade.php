@php($card = $card ?? null)

@if($errors->any())
  <div class="mb-4 px-4 py-3 bg-red-900/40 border border-red-700 text-red-200 rounded">
    <ul class="list-disc list-inside space-y-1 text-sm">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Title (EN)') }}</label>
    <input
      name="title[en]"
      value="{{ old('title.en', data_get($card, 'title.en')) }}"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
      required
    >
  </div>
  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Title (AR)') }}</label>
    <input
      name="title[ar]"
      dir="rtl"
      value="{{ old('title.ar', data_get($card, 'title.ar')) }}"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
    >
  </div>
  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Date') }}</label>
    <input
      type="date"
      name="date"
      value="{{ old('date', optional(data_get($card, 'date'))->format('Y-m-d')) }}"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
    >
  </div>
  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('End Date') }}</label>
    <input
      type="date"
      name="end_date"
      value="{{ old('end_date', optional(data_get($card, 'end_date'))->format('Y-m-d')) }}"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
    >
  </div>
  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Time') }}</label>
    <input
      name="time"
      value="{{ old('time', data_get($card, 'time')) }}"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
      placeholder="18:00"
    >
  </div>
  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Prize') }}</label>
    <input
      name="prize"
      value="{{ old('prize', data_get($card, 'prize')) }}"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
      placeholder="$5,000.00"
    >
  </div>
  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Register URL (optional)') }}</label>
    <input
      name="register_url"
      value="{{ old('register_url', data_get($card, 'register_url')) }}"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
      placeholder="{{ __('https://example.com/register') }}"
    >
  </div>
  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Image') }}</label>
    <input
      type="file"
      name="image"
      accept=".jpg,.jpeg,.png,.webp"
      class="w-full text-gray-200"
    >
    @if($card && data_get($card, 'image_path'))
      <img src="{{ asset($card->image_path) }}" alt="{{ __('Current image') }}" class="mt-3 h-24 w-auto rounded border border-neutral-700 object-cover">
    @endif
  </div>
  <div class="flex items-center gap-2">
    <input
      type="checkbox"
      name="is_published"
      id="is_published"
      value="1"
      {{ old('is_published', data_get($card, 'is_published', true)) ? 'checked' : '' }}
      class="w-4 h-4 text-red-500 bg-neutral-800 border-neutral-600 rounded focus:ring-red-600"
    >
    <label for="is_published" class="text-sm text-gray-300">{{ __('Published') }}</label>
  </div>
  @if($card && isset($card->sort_order))
    <div>
      <label class="block text-sm text-gray-300 mb-1">{{ __('Sort Order') }}</label>
      <input
        type="number"
        name="sort_order"
        value="{{ old('sort_order', $card->sort_order) }}"
        class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
        min="0"
      >
    </div>
  @endif
</div>
