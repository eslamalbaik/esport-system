@extends('admin.layout')

@section('title', __('Teams'))

@section('content')
<div class="px-6 py-4 space-y-4">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
      <h1 class="text-xl font-semibold text-white">{{ __('Teams') }}</h1>
      <p class="text-sm text-gray-400">{{ __('Manage the people and squads displayed on the public team page.') }}</p>
    </div>
    <a href="{{ route('admin.teams.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded transition">
      <span class="text-lg leading-none">＋</span>
      <span>{{ __('Add Team') }}</span>
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
          <th class="px-3 py-3 text-left">{{ __('Member') }}</th>
          <th class="px-3 py-3 text-left">{{ __('Published') }}</th>
          <th class="px-3 py-3 text-left">{{ __('Sort') }}</th>
          <th class="px-3 py-3 text-right">{{ __('Actions') }}</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-neutral-800">
        @forelse($teams as $team)
          <tr class="bg-neutral-900/40">
            <td class="px-3 py-3 flex items-center gap-3">
              <div class="h-12 w-12 rounded-full overflow-hidden border border-neutral-800 bg-neutral-800 flex items-center justify-center">
                @if($team->image_path)
                  <img src="{{ asset($team->image_path) }}" alt="{{ data_get($team->name, 'en') }}" class="h-full w-full object-cover">
                @else
                  @php($initials = strtoupper(mb_substr(data_get($team->name, 'en') ?? '??', 0, 2)))
                  <span class="text-gray-400 text-sm">{{ $initials }}</span>
                @endif
              </div>
              <div>
                <p class="text-gray-200 font-medium">{{ data_get($team->name, 'en') ?: '—' }}</p>
                @if(data_get($team->name, 'ar'))
                  <p class="text-gray-400 text-xs" dir="rtl">{{ data_get($team->name, 'ar') }}</p>
                @endif
              </div>
            </td>
            <td class="px-3 py-3">
              <span class="inline-flex items-center px-2 py-1 rounded text-xs {{ $team->is_published ? 'bg-green-700/70 text-white' : 'bg-neutral-700 text-gray-300' }}">
                {{ $team->is_published ? __('Yes') : __('No') }}
              </span>
            </td>
            <td class="px-3 py-3 text-gray-300">{{ $team->sort_order }}</td>
            <td class="px-3 py-3 text-right space-x-2">
              <a href="{{ route('admin.teams.show', $team) }}" class="inline-flex items-center px-3 py-1.5 bg-neutral-700 hover:bg-neutral-600 text-gray-200 rounded transition">{{ __('View') }}</a>
              <a href="{{ route('admin.teams.edit', $team) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded transition">{{ __('Edit') }}</a>
              <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Delete this team member?') }}');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded transition">{{ __('Delete') }}</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="px-3 py-12 text-center text-gray-400">
              {{ __('No team members yet.') }} <a href="{{ route('admin.teams.create') }}" class="text-blue-400 hover:underline">{{ __('Create the first profile') }}</a>.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($teams->hasPages())
    <div>
      {{ $teams->links() }}
    </div>
  @endif
</div>
@endsection
