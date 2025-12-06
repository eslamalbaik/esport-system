@extends('admin.layout')

@section('title', __('Edit News Article'))

@section('content')
<div class="space-y-5">
  <div>
    <h2 class="text-xl font-semibold text-white">{{ __('Edit News Article') }}</h2>
    <p class="text-sm text-gray-400">{{ __('Update the selected news article.') }}</p>
  </div>

  <form action="{{ route('admin.news-articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT')
    @include('admin.news._form', ['article' => $article])

    <div class="flex items-center gap-3">
      <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">{{ __('Save') }}</button>
      <a href="{{ route('admin.news-articles.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-gray-200 rounded transition">{{ __('Cancel') }}</a>
    </div>
  </form>
</div>
@endsection
