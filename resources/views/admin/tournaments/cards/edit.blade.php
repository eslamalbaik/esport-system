@extends('admin.layout')

@section('title', __('Edit Tournament Card'))

@section('content')
<div class="px-6 py-4 space-y-4">
  <div class="flex flex-col gap-1">
    <h1 class="text-xl font-semibold text-white">{{ __('Edit Tournament Card') }}</h1>
    <p class="text-sm text-gray-400">{{ __('Update the selected tournament card.') }}</p>
  </div>

  <form action="{{ route('admin.tournament-cards.update', $card) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT')

    @include('admin.tournaments.cards._form', ['card' => $card])

    <div class="flex items-center gap-3">
      <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">{{ __('Save Changes') }}</button>
      <a href="{{ route('admin.tournament-cards.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-gray-200 rounded transition">{{ __('Cancel') }}</a>
    </div>
  </form>
</div>
@endsection
