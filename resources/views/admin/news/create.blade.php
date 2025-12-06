@extends('admin.layout')

@section('title', __('Add News Article'))

@section('content')
<div class="space-y-5">
  <div>
    <h2 class="text-xl font-semibold text-white">{{ __('Add News Article') }}</h2>
    <p class="text-sm text-gray-400">{{ __('Create a new article for the public news page.') }}</p>
  </div>

  <form action="{{ route('admin.news-articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @include('admin.news._form', ['article' => null])

    <div class="flex items-center gap-3">
      <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded transition">{{ __('Create') }}</button>
      <a href="{{ route('admin.news-articles.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-gray-200 rounded transition">{{ __('Cancel') }}</a>
    </div>
  </form>
</div>
@endsection
