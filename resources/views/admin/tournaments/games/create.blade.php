@extends('admin.layout')

@section('title', __('Add Game'))

@section('content')
<div class="px-6 py-4 space-y-6">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-semibold text-white">{{ __('Add Game') }}</h1>
      <p class="text-sm text-gray-400">{{ __('Tournament: :name', ['name' => $tournament->titleFor(app()->getLocale()) ?: $tournament->slug]) }}</p>
    </div>
    <a href="{{ route('admin.tournaments.games.index', $tournament) }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-gray-200 rounded transition">{{ __('Back') }}</a>
  </div>

  @if($errors->any())
    <div class="px-4 py-3 bg-red-900/30 border border-red-700 text-red-200 rounded">
      <ul class="list-disc list-inside space-y-1 text-sm">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="bg-neutral-900 border border-neutral-800 rounded p-6">
    <form method="post" action="{{ route('admin.tournaments.games.store', $tournament) }}" class="space-y-6" novalidate enctype="multipart/form-data">
      @csrf
      @include('admin.tournaments.games._form')
      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded">{{ __('Create Game') }}</button>
      </div>
    </form>
  </div>
</div>
@endsection
