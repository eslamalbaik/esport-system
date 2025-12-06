@extends('admin.layout')

@section('title', __('Edit: :key', ['key' => $content->key]))

@section('content')
  <div class="mb-4 text-sm">
    <div><strong class="text-gray-300">{{ __('Key:') }}</strong> <span class="font-mono text-gray-100">{{ $content->key }}</span></div>
    <div class="text-gray-300">
      <strong>{{ __('Group:') }}</strong> <span class="text-gray-200">{{ $content->group }}</span>
      <span class="mx-2">|</span>
      <strong>{{ __('Type:') }}</strong> <span class="text-gray-200">{{ $content->type }}</span>
    </div>
    <div class="text-gray-400"><strong>{{ __('Updated:') }}</strong> {{ $content->updated_at?->diffForHumans() }}</div>
    @if($meta)
      <div class="mt-2 text-gray-100">{{ $meta['label'] ?? '' }}</div>
      @if(!empty($meta['help']))<div class="text-gray-400">{{ $meta['help'] }}</div>@endif
    @endif
  </div>

  @if ($errors->any())
    <div class="bg-red-900/40 text-red-200 px-3 py-2 rounded mb-4 border border-red-800">
      <ul class="list-disc list-inside">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="post" action="{{ route('admin.contents.update', $content->key) }}" enctype="multipart/form-data" class="space-y-4">
    @csrf

    @if($content->type === 'text')
      <div>
        <label class="block text-sm font-medium mb-1 text-gray-200">{{ __('English (required)') }}</label>
        <textarea name="value[en]" rows="4"
                  class="w-full border border-neutral-700 rounded p-2 bg-neutral-900 text-white"
                  required>{{ old('value.en', $content->getTranslation('value','en')) }}</textarea>
      </div>
      <div>
        <label class="block text-sm font-medium mb-1 text-gray-200">{{ __('Arabic (optional)') }}</label>
        <textarea name="value[ar]" dir="rtl" rows="4"
                  class="w-full border border-neutral-700 rounded p-2 bg-neutral-900 text-white">{{ old('value.ar', $content->getTranslation('value','ar')) }}</textarea>
      </div>
    @endif

    @if(in_array($content->type, ['image', 'video'], true))
      @php
        $isVideo = $content->type === 'video';
        $rawValue = $content->value;
        if (is_string($rawValue)) {
          $rawValue = ['path' => $rawValue];
        } elseif (!is_array($rawValue)) {
          $rawValue = [];
        }
        $path = $rawValue['path'] ?? null;
        $isExternal = is_string($path) && preg_match('~^https?://~i', $path);
        $previewUrl = $isExternal ? $path : ($path ? asset('content-images/'.$path) : null);
        $embedUrl = $previewUrl;
        if ($isExternal && $previewUrl) {
          if (preg_match('~youtu\.be/([^?/]+)~i', $previewUrl, $matches)) {
            $embedUrl = 'https://www.youtube.com/embed/'.$matches[1];
          } elseif (preg_match('~youtube\.com/(?:watch\?v=|embed/)([^&?/]+)~i', $previewUrl, $matches)) {
            $embedUrl = 'https://www.youtube.com/embed/'.$matches[1];
          } elseif (preg_match('~vimeo\.com/(\d+)~i', $previewUrl, $matches)) {
            $embedUrl = 'https://player.vimeo.com/video/'.$matches[1];
          }
        }
      @endphp
      <div class="flex flex-col md:flex-row md:items-center gap-6">
        <div class="flex-1">
          <label class="block text-sm font-medium mb-1 text-gray-200">
            {{ $isVideo ? __('Upload video (mp4/mov/webm/ogg)') : __('Upload image (png/jpg/webp/gif)') }}
          </label>
          <input type="file" name="image" accept="image/*,video/*"
                 class="block text-sm file:mr-4 file:py-2 file:px-4 file:rounded
                        file:border-0 file:text-sm file:font-semibold
                        file:bg-red-600 file:text-white hover:file:bg-red-700
                        text-gray-200">
          <div class="text-xs text-gray-400 mt-1">
            {{ __('Saved as') }} <code class="font-mono">{{ $content->key }}.&lt;ext&gt;</code>
          </div>
          <div class="text-xs text-gray-400">
            {{ __('Accepted formats:') }}
            @if($isVideo)
              {{ __('MP4, MOV, WebM, OGG (max 100MB)') }}
            @else
              {{ __('PNG, JPG, JPEG, WebP, GIF (max 15MB)') }}
            @endif
          </div>
          @if(!$isVideo && !empty($meta['image']['preferredWidth']) && !empty($meta['image']['preferredHeight']))
            <div class="text-xs text-gray-400">
              {{ __('Recommended: :width×:height px', ['width' => $meta['image']['preferredWidth'], 'height' => $meta['image']['preferredHeight']]) }}
            </div>
          @endif
        </div>
        <div>
          <div class="text-sm mb-1 text-gray-300">{{ __('Current') }}</div>
          @if($previewUrl)
            @if($isVideo)
              @if($isExternal && preg_match('~(youtube\.com|youtu\.be|vimeo\.com)~i', $previewUrl))
                <iframe src="{{ $embedUrl }}" class="max-h-40 w-full border border-neutral-800 rounded" frameborder="0" allowfullscreen></iframe>
              @else
                <video src="{{ $previewUrl }}" controls class="max-h-40 border border-neutral-800 rounded w-full"></video>
              @endif
            @else
              <img src="{{ $previewUrl }}" alt="" class="max-h-40 border border-neutral-800 rounded">
            @endif
          @else
            <div class="text-gray-500">{{ __('No file') }}</div>
          @endif
        </div>
      </div>
    @endif

    <div class="flex gap-2">
      <button class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700 transition">{{ __('Save') }}</button>
      <a href="{{ route('admin.contents.index') }}" class="px-4 py-2 rounded border border-neutral-700 text-gray-200 hover:bg-neutral-900">{{ __('Cancel') }}</a>
    </div>
  </form>
@endsection
