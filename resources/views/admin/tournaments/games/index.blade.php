@extends('admin.layout')

@section('title', __('Tournament Games'))

@section('content')
<div class="px-6 py-4 space-y-6">
  <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-semibold text-white">{{ __('Games for :name', ['name' => $tournament->titleFor(app()->getLocale()) ?: $tournament->slug]) }}</h1>
      <p class="text-sm text-gray-400">{{ __('Manage games within this tournament container.') }}</p>
    </div>
    <div class="flex items-center gap-3">
      <a href="{{ route('admin.tournaments.show', $tournament) }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-gray-200 rounded transition">
        {{ __('Back to Tournament') }}
      </a>
      <a href="{{ route('admin.tournaments.games.create', $tournament) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded transition">
        {{ __('Add Game') }}
      </a>
    </div>
  </div>

  @if(session('ok'))
    <div class="px-4 py-3 bg-emerald-900/30 border border-emerald-700 text-emerald-200 rounded">
      {{ session('ok') }}
    </div>
  @endif

  @if($errors->any())
    <div class="px-4 py-3 bg-red-900/30 border border-red-700 text-red-200 rounded">
      <ul class="list-disc list-inside space-y-1 text-sm">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="bg-neutral-900 border border-neutral-800 rounded">
    <form method="post" action="{{ route('admin.tournaments.games.reorder', $tournament) }}" class="space-y-4 p-5">
      @csrf
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-white">{{ __('Games') }}</h2>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-800 text-sm">
          <thead class="bg-neutral-900 text-gray-300 uppercase tracking-wide text-xs">
            <tr>
              <th class="px-3 py-2 text-left">{{ __('Title') }}</th>
              <th class="px-3 py-2 text-left">{{ __('Slug') }}</th>
              <th class="px-3 py-2 text-left">{{ __('Status') }}</th>
              <th class="px-3 py-2 text-left">{{ __('Allow Single') }}</th>
              <th class="px-3 py-2 text-left">{{ __('Allow Team') }}</th>
              <th class="px-3 py-2 text-left">{{ __('Sort Order') }}</th>
              <th class="px-3 py-2 text-right">{{ __('Actions') }}</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-neutral-800">
            @forelse($games as $game)
              <tr class="bg-neutral-900/40">
                <td class="px-3 py-2 text-gray-200">
                  <div class="font-semibold">{{ $game->titleFor(app()->getLocale()) ?: __('Untitled') }}</div>
                  <div class="text-xs text-gray-400">#{{ $game->id }}</div>
                </td>
                <td class="px-3 py-2 text-gray-400">{{ $game->slug }}</td>
                <td class="px-3 py-2">
                  <span class="inline-flex items-center gap-2 px-2 py-1 rounded bg-neutral-800 text-xs capitalize">
                    <span class="w-2 h-2 rounded-full {{ $game->status === 'finished' ? 'bg-emerald-400' : ($game->status === 'open' ? 'bg-yellow-400' : 'bg-gray-500') }}"></span>
                    {{ $game->status }}
                  </span>
                </td>
                <td class="px-3 py-2 text-gray-300">{{ $game->allow_single ? __('Yes') : __('No') }}</td>
                <td class="px-3 py-2 text-gray-300">{{ $game->allow_team ? __('Yes') : __('No') }}</td>
                <td class="px-3 py-2">
                  <input type="number" name="orders[{{ $game->id }}]" value="{{ $game->sort_order }}" min="0" class="w-24 px-2 py-1 bg-neutral-800 border border-neutral-700 rounded text-gray-200">
                </td>
                <td class="px-3 py-2 text-right text-gray-200 space-x-2">
                  <a href="{{ route('admin.tournaments.games.edit', [$tournament, $game]) }}" class="text-blue-400 hover:text-blue-200 text-sm">{{ __('Edit') }}</a>
                  <form action="{{ route('admin.tournaments.games.destroy', [$tournament, $game]) }}" method="post" class="inline" onsubmit="return confirm('{{ __('Delete this game?') }}');">
                    @csrf
                    @method('delete')
                    <button type="submit" class="text-red-400 hover:text-red-200 text-sm">{{ __('Delete') }}</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="px-3 py-6 text-center text-gray-400">{{ __('No games yet.') }}</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </form>
  </div>
</div>
@endsection
