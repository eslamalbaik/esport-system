@extends('layouts.app')

@section('title', __('Single Registration'))

@push('styles')
@vite('resources/css/reg-single.css')
@endpush

@section('content')

<section class="reg" aria-labelledby="reg-esports-title">

  <div class="right-panel">
    <div class="form-header" style=" margin: 50px;">
      <button
        class="tab-btn active"
        style="font-size: 20px; border-radius: 10px;">
        {{ content('single_registration.header.title', __('E-Sports')) }}
      </button>
    </div>
  </div>

  <div class="reg__wrap">
    <!-- Left: tabs + Phoenix -->
    <aside class="reg__left">
      <div class="tabs">
        <span class="tab tab--gray">{{ content('single_registration.tabs.main', __('Tournament Registrations')) }}</span>
        <span class="tab tab--red">{{ content('single_registration.tabs.cta', __('Register now')) }}</span>
        <span class="tab tab--gray tab--sm">{{ content('single_registration.tabs.single', __('Single')) }}</span>
      </div>

      <figure class="phoenix">
        <img src="{{ asset('./img/Phoenix.png') }}" alt="{{ content('single_registration.hero.alt', __('Phoenix character card')) }}">
      </figure>
    </aside>

    <!-- Right: avatar + single-column form -->
    <div class="reg__right">

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

      <form class="reg-form" action="{{ route('register.single.store') }}" method="post" novalidate>
        @csrf
        <input type="text" name="website" value="" style="display:none;">
        @php($stickyGameId = old('tournament_game_id', $selectedGameId ?? null))
        <input type="hidden" name="tournament_game_id" value="{{ $stickyGameId }}">

        <div class="form-row">
          <div class="field">
            <label for="tournamentId" style="display: none;">{{ content('single_registration.form.tournament', __('Choose Tournament')) }}</label>
            @php($selectedTournament = old('tournament_card_id', $selectedTournamentId ?? null))
            <select id="tournamentId" name="tournament_card_id" required style="display:none">
              <option value="">{{ content('single_registration.form.tournament_placeholder', __('Select...')) }}</option>
              @foreach($tournaments as $tournament)
              @php($title = $tournament->title[app()->getLocale()] ?? $tournament->title['en'] ?? __('Tournament'))
              <option value="{{ $tournament->id }}" {{ (int) $selectedTournament === $tournament->id ? 'selected' : '' }}>
                {{ $title }}
              </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="field">
            <label for="playerName">{{ content('single_registration.form.player_name', __('Player Name')) }}</label>
            <input id="playerName" name="player_name" type="text" placeholder="{{ content('single_registration.form.player_placeholder', __('Enter your name')) }}" value="{{ old('player_name') }}" required>
          </div>

          <div class="field right-field">
            <label for="ingameId">{{ content('single_registration.form.ingame', __('In-Game ID')) }}</label>
            <input id="ingameId" name="ingame_id" type="text" placeholder="{{ content('single_registration.form.ingame_placeholder', __('Enter your in-game ID')) }}" value="{{ old('ingame_id') }}" required>
          </div>
        </div>

        <div class="form-row">
          <div class="field">
            <label for="email">{{ content('single_registration.form.email', __('Email')) }}</label>
            <input id="email" name="email" type="email" placeholder="{{ content('single_registration.form.email_placeholder', __('Enter your email')) }}" value="{{ old('email') }}">
          </div>

          <div class="field right-field">
            <label for="phone">{{ content('single_registration.form.phone', __('Phone Number')) }}</label>
            <input id="phone" name="phone" type="tel" placeholder="{{ content('single_registration.form.phone_placeholder', __('Enter your phone number')) }}" value="{{ old('phone') }}">
          </div>
        </div>

        <div class="form-row">
          <div class="field">
            <label for="age">{{ content('single_registration.form.age', __('Player Age')) }}</label>
            <input id="age" name="age" type="number" inputmode="numeric" placeholder="{{ content('single_registration.form.age_placeholder', __('Enter your age')) }}" min="1" value="{{ old('age') }}">
          </div>
        </div>

        <div class="form-actions">
          <button class="btn-register" type="submit">{{ content('single_registration.form.submit', __('Register')) }}</button>
        </div>
      </form>
    </div>
  </div>
</section>


@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var tournamentSelect = document.getElementById('tournamentId');
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