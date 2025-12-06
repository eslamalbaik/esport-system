@extends('admin.layout')

@section('title', __('All Tournaments'))

@section('content')
<div class="space-y-6">
  <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
    <div>
      <h2 class="text-xl font-semibold text-white">{{ __('All Tournaments') }}</h2>
      <p class="text-sm text-gray-400">{{ __('Browse every tournament status, edit details, or export registrations.') }}</p>
    </div>
    <div class="flex flex-wrap gap-2">
      <a href="{{ route('admin.tournament-cards.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded bg-emerald-600 text-white hover:bg-emerald-700 transition">
        <span class="text-lg leading-none">+</span>
        <span>{{ __('Create Tournament') }}</span>
      </a>
      <a href="{{ route('admin.tournaments.open') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7H7v10h6l5 3V4l-5 3z" />
        </svg>
        <span>{{ __('Open Tournaments') }}</span>
      </a>
    </div>
  </div>

  @if(session('ok'))
    <div class="px-4 py-3 rounded border border-emerald-700 bg-emerald-900/30 text-emerald-200">
      {{ session('ok') }}
    </div>
  @endif

  <form
    id="bulkForm"
    action="{{ route('admin.tournaments.bulk-destroy') }}"
    method="POST"
    onsubmit="return confirm('{{ __('Delete selected tournaments? This cannot be undone.') }}');">
    @csrf
    @method('DELETE')

    <div class="overflow-x-auto rounded-lg border border-neutral-800 bg-neutral-950/60">
      <table class="min-w-full divide-y divide-neutral-800 text-sm">
        <thead class="bg-neutral-900/60 text-xs font-semibold tracking-wide text-gray-300 uppercase">
          <tr>
            <th class="px-3 py-3">
              <input type="checkbox" id="checkAll" class="accent-red-600">
            </th>
            <th class="px-3 py-3 text-left">{{ __('Title') }}</th>
            <th class="px-3 py-3 text-left">{{ __('Status') }}</th>
            <th class="px-3 py-3 text-left">{{ __('Date') }}</th>
            <th class="px-3 py-3 text-left">{{ __('Prize') }}</th>
            <th class="px-3 py-3 text-left">{{ __('Registrations') }}</th>
            <th class="px-3 py-3 text-right">{{ __('Actions') }}</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-neutral-900">
          @forelse($tournaments as $tournament)
            <tr class="bg-neutral-900/40 hover:bg-neutral-900/70 transition">
              <td class="px-3 py-3 align-top">
                <input type="checkbox" name="ids[]" value="{{ $tournament->id }}" class="rowCheck accent-red-600">
              </td>
              <td class="px-3 py-3 align-top">
                <div class="flex items-start gap-3">
                  <img
                    src="{{ $tournament->imageUrl() ?? content_media('tournaments.card.image', 'img/tournaments-inner.png') }}"
                    alt=""
                    class="w-16 h-12 object-cover rounded border border-neutral-800">
                  <div>
                    <div class="font-semibold text-white">
                      {{ $tournament->titleFor(app()->getLocale()) ?: $tournament->slug }}
                    </div>
                    <div class="text-xs text-gray-500">{{ $tournament->slug }}</div>
                  </div>
                </div>
              </td>
              <td class="px-3 py-3 align-top">
                @php
                  $status = $tournament->status ?? 'closed';
                  $pill = match($status) {
                    'open' => 'bg-emerald-700/40 text-emerald-200 border border-emerald-700/60',
                    'finished' => 'bg-indigo-700/30 text-indigo-200 border border-indigo-600/60',
                    default => 'bg-neutral-800 text-gray-200 border border-neutral-700',
                  };
                @endphp
                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $pill }}">
                  {{ ucfirst($status) }}
                </span>
              </td>
              <td class="px-3 py-3 align-top text-gray-200">
                <div>{{ optional($tournament->date)->format('d/m/Y') ?? '—' }}</div>
                <div class="text-xs text-gray-500">{{ __('End:') }} {{ optional($tournament->end_date)->format('d/m/Y') ?? '—' }}</div>
                <div class="text-xs text-gray-500">{{ __('Time:') }} {{ $tournament->time ?: '—' }}</div>
              </td>
              <td class="px-3 py-3 align-top text-gray-200">
                {{ $tournament->prize ?: '—' }}
              </td>
              <td class="px-3 py-3 align-top text-gray-200">
                @php
                  $single = $tournament->single_registrations_count;
                  $team = $tournament->team_registrations_count;
                @endphp
                <div class="font-semibold">{{ $single + $team }}</div>
                <div class="text-xs text-gray-500">{{ $single }} {{ __('solo') }} / {{ $team }} {{ __('teams') }}</div>
              </td>
              <td class="px-3 py-3 align-top text-right">
                <div class="flex justify-end flex-wrap gap-2">
                  <a
                    href="{{ route('admin.tournaments.show', $tournament) }}"
                    class="px-2 py-1 text-xs rounded bg-sky-600 text-white hover:bg-sky-700">
                    {{ __('View') }}
                  </a>
                  <a
                    href="{{ route('admin.tournament-cards.edit', $tournament) }}"
                    class="px-2 py-1 text-xs rounded bg-amber-500 text-black hover:bg-amber-400">
                    {{ __('Edit') }}
                  </a>
                  <form
                    action="{{ route('admin.tournament-cards.destroy', $tournament) }}"
                    method="POST"
                    onsubmit="return confirm('{{ __('Delete this tournament?') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-2 py-1 text-xs rounded bg-red-700 text-white hover:bg-red-800">
                      {{ __('Delete') }}
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-3 py-10 text-center text-gray-400">
                {{ __('No tournaments found.') }}
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
      <div class="flex items-center gap-3">
        <button
          type="submit"
          class="px-4 py-2 rounded bg-red-700 text-white hover:bg-red-800 disabled:opacity-40 disabled:cursor-not-allowed"
          id="bulkDeleteBtn"
          disabled>
          {{ __('Delete Selected') }}
        </button>
        <span class="text-sm text-gray-400" id="bulkCount">0 {{ __('selected') }}</span>
      </div>

      <div>
        {{ $tournaments->links() }}
      </div>
    </div>
  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const checkAll = document.getElementById('checkAll');
  const bulkBtn = document.getElementById('bulkDeleteBtn');
  const bulkCount = document.getElementById('bulkCount');
  const rowChecks = () => Array.from(document.querySelectorAll('.rowCheck'));

  function refreshBulkState() {
    const selected = rowChecks().filter(cb => cb.checked).length;
    if (bulkBtn) {
      bulkBtn.disabled = selected === 0;
    }
    if (bulkCount) {
      bulkCount.textContent = selected + ' {{ __('selected') }}';
    }
  }

  if (checkAll) {
    checkAll.addEventListener('change', () => {
      rowChecks().forEach(cb => {
        cb.checked = checkAll.checked;
      });
      refreshBulkState();
    });
  }

  rowChecks().forEach(cb => cb.addEventListener('change', refreshBulkState));
  refreshBulkState();
});
</script>
@endsection
