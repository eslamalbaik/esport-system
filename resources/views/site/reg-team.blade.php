@extends('layouts.app')

@section('title', __('Team Registration'))

@push('styles')
@vite([
'resources/css/style.css',
'resources/css/reg-team.css',
])
@endpush

@section('content')

<section class="reg-team" aria-labelledby="team-esports-title">

  <div class="right-panel">
    <div class="form-header" style=" margin: 50px;">
      <button
        class="tab-btn active"
        style="font-size: 20px; border-radius: 10px;">
        {{ content('team_registration.header.title', __('E-Sports')) }}
      </button>
    </div>
  </div>


  <div class="rt-wrap">
    <!-- LEFT: tabs + Phoenix -->
    <aside class="rt-left">
      <div class="tabs">
        <span class="tab tab--gray">{{ content('team_registration.tabs.tournament', __('Tournament Registrations')) }}</span>
        <span class="tab tab--red">{{ content('team_registration.tabs.register', __('Register now')) }}</span>
        <span class="tab tab--gray tab--sm">{{ content('team_registration.tabs.team', __('Team')) }}</span>
      </div>

      <figure class="phoenix">
        <img src="{{ content_media('team_registration.phoenix_image', 'img/Phoenix.png') }}" alt="{{ __('Phoenix character card') }}">
      </figure>
    </aside>

    <!-- RIGHT: avatar + form -->
    <div class="rt-right">


      @if(session('status') && ! session('registration_success'))
      <div class="alert success">
        {{ session('status') }}
      </div>
      @endif

      @include('components.registration-success-modal', ['redirectUrl' => route('home')])

      @if($errors->any())
      <div class="alert error">
        <ul>
          @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form class="team-form" action="{{ route('register.team.store') }}" method="post" enctype="multipart/form-data" novalidate="">
        @csrf
        @php($stickyGameId = old('tournament_game_id', $selectedGameId ?? null))
        <input type="hidden" name="tournament_game_id" value="{{ $stickyGameId }}">

        <div class="field">
          <label for="tournamentCard" style="display: none;">{{ content('team_registration.form.tournament', __('Choose Tournament')) }}</label>
          @php($selectedTournament = old('tournament_card_id', $selectedTournamentId ?? $tournaments->first()->id ?? null))
          <select id="tournamentCard" name="tournament_card_id" required style="display:none;">
            <option value="">{{ content('team_registration.form.tournament_placeholder', __('Select...')) }}</option>
            @foreach($tournaments as $tournament)
            @php($title = $tournament->title[app()->getLocale()] ?? $tournament->title['en'] ?? __('Tournament'))
            <option value="{{ $tournament->id }}" {{ (int) $selectedTournament === $tournament->id ? 'selected' : '' }}>
              {{ $title }}
            </option>
            @endforeach
          </select>
        </div>
        <div>
          <!-- ! to keep space -->
        </div>




        <!-- Row 1 -->
        <div class="field">
          <label for="teamName">{{ __('Team Name') }}</label>
          <input id="teamName" name="teamName" type="text" placeholder="{{ __('Enter your team name') }}" value="{{ old('teamName') }}">
        </div>
        <div>
          <!-- ! to keep space -->
        </div>

        <!-- Row 2 -->
        <div class="field">
          <label for="captainName">{{ __('Captain\'s Name') }}</label>
          <input id="captainName" name="captainName" type="text" placeholder="{{ __('Enter captain\'s name') }}" value="{{ old('captainName') }}">
        </div>
        <div class="field" style="margin-left: 40px;">
          <label for="captainLogo">{{ __('Captain\'s Logo') }}</label>
          <label class="file-field">
            <input id="captainLogo" name="captainLogo" type="file" accept="image/*">
            <span class="file-placeholder">{{ __('Click to upload') }}</span>
          </label>
        </div>
        <!-- Row 3 -->
        <div class="field">
          <label for="captainEmail">{{ __('Captain\'s Email') }}</label>
          <input id="captainEmail" name="captainEmail" type="email" placeholder="{{ __('Enter captain\'s email') }}" value="{{ old('captainEmail') }}">
        </div>
        <div class="field" style="margin-left: 40px;">
          <label for="teamLogo">{{ __('Team\'s Logo') }}</label>
          <label class="file-field">
            <input id="teamLogo" name="teamLogo" type="file" accept="image/*">
            <span class="file-placeholder">{{ __('Click to upload') }}</span>
          </label>
        </div>


        <div class="field">
          <label for="captainPhone">{{ __('Captain\'s Phone') }}</label>
          <input id="captainPhone" name="captainPhone" type="tel" placeholder="{{ __('Enter captain\'s phone') }}" value="{{ old('captainPhone') }}">
        </div>
        <div class="field" style="margin-left: 40px;">
          <label for="gameId">{{ __('Game ID') }}</label>
          <input id="gameId" name="gameId" type="text" placeholder="{{ __('Enter your game ID') }}" value="{{ old('gameId') }}">
        </div>

        <!-- Subheading -->
        <div class="full">
          <h3 class="subhead">{{ __('Team Members') }}</h3>
        </div>

        <!-- Members (2 columns) -->
        <div class="field">
          <label for="m1">{{ __('Member 1') }}</label>
          <input id="m1" name="m1" type="text" placeholder="{{ __('Enter member 1 name') }}" value="{{ old('m1') }}">
        </div>
        <div class="field" style="margin-left: 40px;">
          <label for="m2">{{ __('Member 2') }}</label>
          <input id="m2" name="m2" type="text" placeholder="{{ __('Enter member 2 name') }}" value="{{ old('m2') }}">
        </div>

        <div class="field">
          <label for="m3">{{ __('Member 3') }}</label>
          <input id="m3" name="m3" type="text" placeholder="{{ __('Enter member 3 name') }}" value="{{ old('m3') }}">
        </div>
        <div class="field" style="margin-left: 40px;">
          <label for="m4">{{ __('Member 4') }}</label>
          <input id="m4" name="m4" type="text" placeholder="{{ __('Enter member 4 name') }}" value="{{ old('m4') }}">
        </div>

        <!-- CTA -->
        <div class="full actions">
          <button class="btn-register" type="submit">{{ __('Register Team') }}</button>
        </div>
      </form>
    </div>
  </div>
</section>


@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var tournamentSelect = document.getElementById('tournamentCard');
    var gameInput = document.querySelector('input[name="tournament_game_id"]');
    if (tournamentSelect && gameInput) {
      tournamentSelect.addEventListener('change', function() {
        gameInput.value = '';
      });
    }
  });
</script>
@endpush
@push('scripts')
@vite('resources/js/script.js')
@endpush