@extends('admin.layout')

@section('title', 'Open Tournaments')

@section('content')
<div class="px-6 py-4 space-y-6">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
      <h1 class="text-xl font-semibold text-white">Open Tournaments</h1>
      <p class="text-sm text-gray-400">Review active tournaments and manage incoming registrations.</p>
    </div>
    <a href="{{ route('admin.tournament-cards.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
      <span class="text-lg leading-none">⚙️</span>
      <span>Manage Cards</span>
    </a>
  </div>

  @if(session('ok'))
    <div class="px-4 py-3 bg-green-900/30 border border-green-700 text-green-200 rounded">
      {{ session('ok') }}
    </div>
  @endif

  <div class="overflow-hidden rounded border border-neutral-800">
    <table class="min-w-full divide-y divide-neutral-800 text-sm">
      <thead class="bg-neutral-900 text-gray-300 uppercase tracking-wide text-xs">
        <tr>
          <th class="px-3 py-3 text-left">Title</th>
          <th class="px-3 py-3 text-left">Dates</th>
          <th class="px-3 py-3 text-left">Singles</th>
          <th class="px-3 py-3 text-left">Teams</th>
          <th class="px-3 py-3 text-left">Status</th>
          <th class="px-3 py-3 text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-neutral-800">
        @forelse($tournaments as $tournament)
          <tr class="bg-neutral-900/40">
            <td class="px-3 py-3 text-gray-200">
              <div class="font-semibold">{{ $tournament->titleFor(app()->getLocale()) ?: 'Untitled Tournament' }}</div>
              <div class="text-xs text-gray-500">{{ $tournament->slug }}</div>
            </td>
            <td class="px-3 py-3 text-gray-300">
              <div>{{ $tournament->date?->format('d/m/Y') ?? '--' }}</div>
              <div class="text-xs text-gray-500">{{ __('End:') }} {{ $tournament->end_date?->format('d/m/Y') ?? '--' }}</div>
            </td>
            <td class="px-3 py-3 text-gray-300">{{ $tournament->single_registrations_count }}</td>
            <td class="px-3 py-3 text-gray-300">{{ $tournament->team_registrations_count }}</td>
            <td class="px-3 py-3">
              <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-emerald-700/70 text-white">
                {{ ucfirst($tournament->status) }}
              </span>
            </td>
            <td class="px-3 py-3 text-right">
              <a href="{{ route('admin.tournaments.show', $tournament) }}"
                 class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                View
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="px-3 py-12 text-center text-gray-400">
              No open tournaments at the moment.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($tournaments->hasPages())
    <div>
      {{ $tournaments->links() }}
    </div>
  @endif
</div>
@endsection
