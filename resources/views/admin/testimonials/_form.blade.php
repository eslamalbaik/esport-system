@php($testimonial = $testimonial ?? null)

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
    <label class="block text-sm text-gray-300 mb-1">{{ __('Name (EN)') }}</label>
    <input
      name="name[en]"
      value="{{ old('name.en', data_get($testimonial, 'name.en')) }}"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
      required
    >
  </div>
  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Name (AR)') }}</label>
    <input
      name="name[ar]"
      dir="rtl"
      value="{{ old('name.ar', data_get($testimonial, 'name.ar')) }}"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
    >
  </div>
  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Role (EN)') }}</label>
    <input
      name="role[en]"
      value="{{ old('role.en', data_get($testimonial, 'role.en')) }}"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
    >
  </div>
  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Role (AR)') }}</label>
    <input
      name="role[ar]"
      dir="rtl"
      value="{{ old('role.ar', data_get($testimonial, 'role.ar')) }}"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
    >
  </div>
  <div class="md:col-span-2">
    <label class="block text-sm text-gray-300 mb-1">{{ __('Text (EN)') }}</label>
    <textarea
      name="text[en]"
      rows="4"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
      required>{{ old('text.en', data_get($testimonial, 'text.en')) }}</textarea>
  </div>
  <div class="md:col-span-2">
    <label class="block text-sm text-gray-300 mb-1">{{ __('Text (AR)') }}</label>
    <textarea
      name="text[ar]"
      rows="4"
      dir="rtl"
      class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600">{{ old('text.ar', data_get($testimonial, 'text.ar')) }}</textarea>
  </div>
  <div>
    <label class="block text-sm text-gray-300 mb-1">{{ __('Avatar') }}</label>
    <input
      type="file"
      name="avatar"
      accept=".jpg,.jpeg,.png,.webp"
      class="w-full text-gray-200"
    >
    @if($testimonial && $testimonial->avatar_path)
      <img src="{{ asset($testimonial->avatar_path) }}" alt="{{ __('Current avatar') }}" class="mt-3 h-24 w-24 rounded-full border border-neutral-700 object-cover">
    @endif
  </div>
  <div class="flex items-center gap-2">
    <input
      type="checkbox"
      name="is_published"
      id="is_published"
      value="1"
      {{ old('is_published', data_get($testimonial, 'is_published', true)) ? 'checked' : '' }}
      class="w-4 h-4 text-red-500 bg-neutral-800 border-neutral-600 rounded focus:ring-red-600"
    >
    <label for="is_published" class="text-sm text-gray-300">{{ __('Published') }}</label>
  </div>
  @if($testimonial && isset($testimonial->sort_order))
    <div>
      <label class="block text-sm text-gray-300 mb-1">{{ __('Sort Order') }}</label>
      <input
        type="number"
        name="sort_order"
        value="{{ old('sort_order', $testimonial->sort_order) }}"
        class="w-full bg-neutral-800 text-gray-200 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
        min="0"
      >
    </div>
  @endif
</div>
