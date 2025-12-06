@extends('admin.layout')

@section('title', 'Tournament Overview')

@section('content')
@php
  $resolveLogoUrl = static function (?string $url, ?string $path) {
      return $url ?? \App\Models\TeamRegistration::logoPathToUrl($path);
  };
@endphp
<div class="px-6 py-4 space-y-6">
  <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-semibold text-white">{{ $tournament->titleFor(app()->getLocale()) ?: 'Tournament' }}</h1>
      <div class="flex flex-wrap items-center gap-3 text-sm text-gray-400 mt-1">
        <span class="inline-flex items-center gap-2 px-2 py-1 bg-neutral-800 text-gray-200 rounded">
          <span class="w-2 h-2 rounded-full {{ $tournament->status === 'finished' ? 'bg-emerald-400' : 'bg-yellow-400' }}"></span>
          {{ ucfirst($tournament->status) }}
        </span>
        <span>{{ __('Start:') }} {{ $tournament->date?->format('d/m/Y') ?? '--' }}</span>
        <span>{{ __('End:') }} {{ $tournament->end_date?->format('d/m/Y') ?? '--' }}</span>
        <span>{{ __('Time:') }} {{ $tournament->time ?: '--' }}</span>
      </div>
    </div>
    <div class="flex items-center gap-3">
      <a href="{{ route('admin.tournaments.open') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-gray-200 rounded transition">
        Back to Open List
      </a>
      <a href="{{ route('admin.tournaments.export', $tournament) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded transition">
        Export Registrations
      </a>
      <a href="{{ route('admin.tournament-cards.edit', $tournament) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
        Edit Card
      </a>
    </div>
  </div>

  @if(session('ok'))
    <div class="px-4 py-3 bg-green-900/30 border border-green-700 text-green-200 rounded">
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

  <div class="bg-neutral-900 border border-neutral-800 rounded p-5 space-y-4">
    <div class="flex items-center justify-between">
      <h2 class="text-lg font-semibold text-white">Games</h2>
      <div class="flex items-center gap-3">
        <a href="{{ route('admin.tournaments.games.create', $tournament) }}" class="px-3 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded text-sm">
          Add Game
        </a>
        <a href="{{ route('admin.tournaments.games.index', $tournament) }}" class="px-3 py-2 bg-neutral-800 hover:bg-neutral-700 text-gray-200 rounded text-sm">
          Manage All
        </a>
      </div>
    </div>
    @if($tournament->games->isEmpty())
      <p class="text-sm text-gray-400">No games configured yet.</p>
    @else
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-800 text-sm">
          <thead class="bg-neutral-900 text-gray-300 uppercase tracking-wide text-xs">
            <tr>
              <th class="px-3 py-2 text-left">Image</th>
              <th class="px-3 py-2 text-left">Title</th>
              <th class="px-3 py-2 text-left">Status</th>
              <th class="px-3 py-2 text-left">Single</th>
              <th class="px-3 py-2 text-left">Team</th>
              <th class="px-3 py-2 text-left">Sort</th>
              <th class="px-3 py-2 text-left">Winners</th>
              <th class="px-3 py-2 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-neutral-800">
            @foreach($tournament->games as $game)
              @php($gameWinners = $game->winnerEntry?->winners ?? [])
              <tr class="bg-neutral-900/40">
                <td class="px-3 py-2">
                  @if($game->imageUrl())
                    <img src="{{ $game->imageUrl() }}" alt="{{ $game->titleFor(app()->getLocale()) }}" class="w-14 h-14 object-cover rounded border border-neutral-800">
                  @else
                    <span class="text-xs text-gray-500">—</span>
                  @endif
                </td>
                <td class="px-3 py-2 text-gray-200">
                  <div class="font-semibold">{{ $game->titleFor(app()->getLocale()) ?: 'Untitled' }}</div>
                  <div class="text-xs text-gray-500">{{ $game->slug }}</div>
                </td>
                <td class="px-3 py-2 text-gray-300 capitalize">{{ $game->status }}</td>
                <td class="px-3 py-2 text-gray-300">{{ $game->allow_single ? 'Yes' : 'No' }}</td>
                <td class="px-3 py-2 text-gray-300">{{ $game->allow_team ? 'Yes' : 'No' }}</td>
                <td class="px-3 py-2 text-gray-300">{{ $game->sort_order }}</td>
                <td class="px-3 py-2 text-gray-200">
                  @if(!empty($gameWinners))
                    <div class="flex flex-wrap gap-2">
                      @foreach(array_slice($gameWinners, 0, 3) as $winnerName)
                        <span class="inline-flex items-center px-2 py-1 rounded-full bg-neutral-800 text-xs text-gray-200">{{ $winnerName }}</span>
                      @endforeach
                      @if(count($gameWinners) > 3)
                        <span class="text-xs text-gray-500">+{{ count($gameWinners) - 3 }}</span>
                      @endif
                    </div>
                  @else
                    <span class="text-xs text-gray-500">—</span>
                  @endif
                </td>
                <td class="px-3 py-2 text-right text-sm space-x-2">
                  <a href="{{ route('admin.tournaments.games.edit', [$tournament, $game]) }}" class="text-blue-400 hover:text-blue-200">Edit</a>
                  <form action="{{ route('admin.tournaments.games.destroy', [$tournament, $game]) }}" method="post" class="inline" onsubmit="return confirm('Delete this game?');">
                    @csrf
                    @method('delete')
                    <button type="submit" class="text-red-400 hover:text-red-200">Delete</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="col-span-1 bg-neutral-900 border border-neutral-800 rounded p-5 space-y-4">
      <div>
        <h2 class="text-lg font-semibold text-white mb-2">Tournament Details</h2>
        <dl class="space-y-2 text-sm text-gray-300">
          <div class="flex justify-between">
            <dt class="text-gray-400">Prize</dt>
            <dd>{{ $tournament->prize ?: '--' }}</dd>
          </div>
          <div class="flex justify-between">
            <dt class="text-gray-400">Singles</dt>
            <dd>{{ $singleRegistrations->count() }}</dd>
          </div>
          <div class="flex justify-between">
            <dt class="text-gray-400">Teams</dt>
            <dd>{{ $teamRegistrations->count() }}</dd>
          </div>
        </dl>
      </div>

      <div>
        <h2 class="text-lg font-semibold text-white mb-2">Winner Snapshot</h2>
        <?php if (!empty($winnerSnapshot)): ?>
          <div class="space-y-3 text-sm text-gray-300">
            <div>
              <span class="text-gray-400 uppercase text-xs">Kind</span>
              <div class="font-semibold text-white">{{ ucfirst($winnerSnapshot['kind']) }}</div>
            </div>

            <?php if (!empty($winnerSnapshot['singles'])): ?>
              <div class="bg-neutral-800 rounded p-3 space-y-2">
                <div class="text-xs text-gray-400 uppercase">Single Winners</div>
                <div class="space-y-2">
                  <?php foreach ($winnerSnapshot['singles'] as $single): ?>
                    <div class="border border-neutral-700 rounded p-2">
                      <div class="font-semibold text-white">{{ $single['player_name'] ?? '' }}</div>
                      <?php if (!empty($single['ingame_id'])): ?>
                        <div class="text-gray-400 text-xs">{{ $single['ingame_id'] }}</div>
                      <?php endif; ?>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>

            <?php if (!empty($winnerSnapshot['teams'])): ?>
              <div class="bg-neutral-800 rounded p-3 space-y-3">
                <div class="text-xs text-gray-400 uppercase">Team Winners</div>
                <div class="space-y-3">
                  <?php foreach ($winnerSnapshot['teams'] as $team): ?>
                    <?php
                      $teamLogoUrl = $resolveLogoUrl($team['team_logo_url'] ?? null, $team['team_logo_path'] ?? null);
                      $captainLogoUrl = $resolveLogoUrl($team['captain_logo_url'] ?? null, $team['captain_logo_path'] ?? null);
                    ?>
                    <div class="border border-neutral-700 rounded p-3 space-y-2">
                      <div class="font-semibold text-white">{{ $team['team_name'] ?? '' }}</div>
                      <?php if ($teamLogoUrl || $captainLogoUrl): ?>
                        <div class="flex items-center gap-3 pt-1">
                          <?php if ($teamLogoUrl): ?>
                            <img src="{{ $teamLogoUrl }}" alt="Team logo" class="w-16 h-16 object-cover rounded">
                          <?php endif; ?>
                          <?php if ($captainLogoUrl): ?>
                            <img src="{{ $captainLogoUrl }}" alt="Captain logo" class="w-16 h-16 object-cover rounded">
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                      <?php if (!empty($team['captain_name'])): ?>
                        <div class="text-gray-400 text-xs">{{ __('Captain:') }} {{ $team['captain_name'] }}</div>
                      <?php endif; ?>
                      <?php if (!empty($team['members'])): ?>
                        <ul class="text-xs text-gray-300 space-y-1">
                          <?php foreach ($team['members'] as $member): ?>
                            <li>{{ $member['member_name'] ?? '' }} <span class="text-gray-500">{{ $member['member_ingame_id'] ?? '' }}</span></li>
                          <?php endforeach; ?>
                        </ul>
                      <?php endif; ?>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
        <?php else: ?>
          <p class="text-gray-400 text-sm">No winner selected yet.</p>
        <?php endif; ?>
      </div>
    </div>

    <div class="col-span-1 lg:col-span-2 space-y-6">
      @if($tournament->status !== 'finished')
        <div class="bg-neutral-900 border border-neutral-800 rounded p-5 space-y-4">
          <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-white">Finish Tournament</h2>
            <a href="{{ route('admin.tournaments.games.index', $tournament) }}" class="px-3 py-2 text-sm bg-neutral-800 hover:bg-neutral-700 text-gray-200 rounded">
              Manage Games
            </a>
          </div>
          @if($tournament->games->isEmpty())
            <p class="text-sm text-gray-400">Add games before recording winners.</p>
          @else
            @php($oldFinished = collect(old('finished_games', []))->map(fn ($id) => (int) $id)->all())
            <form action="{{ route('admin.tournaments.finish', $tournament) }}" method="POST" class="space-y-6">
              @csrf
              <p class="text-sm text-gray-400">Enter the winners for each game below. Use the checkbox to mark the game as finished and add as many winners as you need.</p>
              <div class="space-y-4">
                @foreach($tournament->games as $game)
                  @php($oldKey = 'game_winners.' . $game->id)
                  @php($existingWinners = collect(old($oldKey, $game->winnerEntry?->winners ?? []))->filter()->values()->all())
                  <div class="border border-neutral-800 rounded p-4 space-y-3" data-game-wrapper>
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                      <div>
                        <h3 class="text-base font-semibold text-white">{{ $game->titleFor(app()->getLocale()) ?: 'Untitled Game' }}</h3>
                        <p class="text-xs text-gray-400">
                          Status: <span class="capitalize">{{ $game->status }}</span> • Single: {{ $game->allow_single ? 'Yes' : 'No' }} • Team: {{ $game->allow_team ? 'Yes' : 'No' }}
                        </p>
                      </div>
                      <label class="inline-flex items-center gap-2 text-sm text-gray-200">
                        <input type="checkbox" name="finished_games[]" value="{{ $game->id }}" class="rounded border-neutral-600 bg-neutral-900 text-emerald-500 focus:ring-emerald-500" {{ in_array($game->id, $oldFinished, true) || $game->status === 'finished' ? 'checked' : '' }}>
                        <span>Mark this game finished</span>
                      </label>
                    </div>
                    <div class="space-y-2" data-game-winners data-field="game_winners[{{ $game->id }}][]">
                      <div class="flex flex-col md:flex-row gap-3">
                        <input type="text" class="flex-1 px-3 py-2 bg-neutral-900 border border-neutral-700 rounded text-gray-100" placeholder="Winner name" data-game-input>
                        <button type="button" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded" data-game-add>Add</button>
                      </div>
                      <p class="text-xs text-gray-500">Press Enter or click Add to capture the winner.</p>
                      <div class="flex flex-wrap gap-2" data-game-chips>
                        @foreach($existingWinners as $winnerName)
                          <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-neutral-800 text-gray-100 text-sm" data-game-chip>
                            <span>{{ $winnerName }}</span>
                            <button type="button" class="text-xs text-gray-400 hover:text-red-300" data-game-remove>&times;</button>
                            <input type="hidden" name="game_winners[{{ $game->id }}][]" value="{{ $winnerName }}">
                          </span>
                        @endforeach
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
              <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded transition">
                  Finish Tournament
                </button>
              </div>
            </form>
          @endif
        </div>
      @endif

      <div class="bg-neutral-900 border border-neutral-800 rounded p-5">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-lg font-semibold text-white">Single Registrations</h2>
          <span class="text-xs text-gray-400">{{ $singleRegistrations->count() }} entries</span>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-neutral-800 text-sm">
            <thead class="bg-neutral-900 text-gray-300 uppercase tracking-wide text-xs">
              <tr>
                <th class="px-3 py-2 text-left">Player</th>
                <th class="px-3 py-2 text-left">In-Game ID</th>
                <th class="px-3 py-2 text-left">Email</th>
                <th class="px-3 py-2 text-left">Phone</th>
                <th class="px-3 py-2 text-left">Age</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-neutral-800">
              @forelse($singleRegistrations as $registration)
                <tr class="bg-neutral-900/40">
                  <td class="px-3 py-2 text-gray-200">{{ $registration->player_name }}</td>
                  <td class="px-3 py-2 text-gray-300">{{ $registration->ingame_id }}</td>
                  <td class="px-3 py-2 text-gray-400">{{ $registration->email ?: '—' }}</td>
                  <td class="px-3 py-2 text-gray-400">{{ $registration->phone ?: '—' }}</td>
                  <td class="px-3 py-2 text-gray-400">{{ $registration->age ?: '—' }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="px-3 py-6 text-center text-gray-400">No single registrations yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="bg-neutral-900 border border-neutral-800 rounded p-5">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-lg font-semibold text-white">Team Registrations</h2>
          <span class="text-xs text-gray-400">{{ $teamRegistrations->count() }} entries</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($teamRegistrations as $team)
            <article class="bg-neutral-900/40 border border-neutral-800 rounded p-4 space-y-2">
              @if($team->team_logo_url || $team->captain_logo_url)
                <div class="flex items-center gap-4">
                  @if($team->team_logo_url)
                    <img src="{{ $team->team_logo_url }}" alt="{{ $team->team_name }} team logo" class="w-16 h-16 object-cover rounded">
                  @endif
                  @if($team->captain_logo_url)
                    <img src="{{ $team->captain_logo_url }}" alt="{{ $team->captain_name }} logo" class="w-16 h-16 object-cover rounded">
                  @endif
                </div>
              @endif
              <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">{{ $team->team_name }}</h3>
                <span class="text-xs text-gray-400">{{ $team->game_id ?: 'N/A' }}</span>
              </div>
              <div class="text-sm text-gray-300">
                <div>Captain: {{ $team->captain_name }}</div>
                <div class="text-gray-400 text-xs">Email: {{ $team->captain_email ?: '—' }}</div>
                <div class="text-gray-400 text-xs">Phone: {{ $team->captain_phone ?: '—' }}</div>
              </div>
              @if($team->members->isNotEmpty())
                <div class="pt-2 text-sm text-gray-300">
                  <div class="text-xs uppercase text-gray-500 mb-1">Members</div>
                  <ul class="space-y-1 text-xs text-gray-300">
                    @foreach($team->members as $member)
                      <li>{{ $member->member_name }} <span class="text-gray-500">{{ $member->member_ingame_id }}</span></li>
                    @endforeach
                  </ul>
                </div>
              @endif
            </article>
          @empty
            <p class="col-span-full text-center text-gray-400 py-6">No team registrations yet.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[data-game-winners]').forEach(function (section) {
    var input = section.querySelector('[data-game-input]');
    var addBtn = section.querySelector('[data-game-add]');
    var chips = section.querySelector('[data-game-chips]');
    var fieldName = section.getAttribute('data-field');

    if (!input || !addBtn || !chips || !fieldName) {
      return;
    }

    function createChip(value) {
      var chip = document.createElement('span');
      chip.className = 'inline-flex items-center gap-2 px-3 py-1 rounded-full bg-neutral-800 text-gray-100 text-sm';
      chip.setAttribute('data-game-chip', '');

      var label = document.createElement('span');
      label.textContent = value;
      chip.appendChild(label);

      var removeBtn = document.createElement('button');
      removeBtn.type = 'button';
      removeBtn.className = 'text-xs text-gray-400 hover:text-red-300';
      removeBtn.setAttribute('data-game-remove', '');
      removeBtn.textContent = '×';
      removeBtn.addEventListener('click', function () {
        chip.remove();
      });
      chip.appendChild(removeBtn);

      var hidden = document.createElement('input');
      hidden.type = 'hidden';
      hidden.name = fieldName;
      hidden.value = value;
      chip.appendChild(hidden);

      chips.appendChild(chip);
    }

    function addWinner() {
      var value = input.value.trim();
      if (!value) {
        return;
      }
      createChip(value);
      input.value = '';
      input.focus();
    }

    addBtn.addEventListener('click', function (event) {
      event.preventDefault();
      addWinner();
    });

    input.addEventListener('keydown', function (event) {
      if (event.key === 'Enter') {
        event.preventDefault();
        addWinner();
      }
    });

    chips.querySelectorAll('[data-game-chip]').forEach(function (chip) {
      var removeButton = chip.querySelector('[data-game-remove]');
      if (removeButton) {
        removeButton.addEventListener('click', function () {
          chip.remove();
        });
      }
    });
  });
});
</script>
@endpush
