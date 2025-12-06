@extends('admin.layout')

@section('title', __('Add Gallery Item'))

@section('content')
<div class="space-y-5">
  <div>
    <h2 class="text-xl font-semibold text-white">{{ __('Add Gallery Item') }}</h2>
    <p class="text-sm text-gray-400">{{ __('Create a new entry for the public gallery page.') }}</p>
  </div>

  <form action="{{ route('admin.gallery-items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @include('admin.gallery._form', ['item' => null])

    <div class="flex items-center gap-3">
      <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded transition">{{ __('Create') }}</button>
      <a href="{{ route('admin.gallery-items.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-gray-200 rounded transition">{{ __('Cancel') }}</a>
    </div>
  </form>
</div>
@endsection
