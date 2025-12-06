@extends('layouts.app')

@section('title', 'Login')

@push('styles')
    @vite([
        'resources/css/style.css',
        'resources/css/auth-fixes.css',
    ])
@endpush

@section('content')
<div class="main-section">
 <div class="left-panel hero-area">
        <img src="{{ content_media('auth.hero.image', 'img/image 3.png') }}" alt="Gamers" class="hero-img" />
        <!-- Floating triangles around hero image -->
        <div class="hero-triangle t1"></div>
        <div class="hero-triangle t2"></div>
        <div class="hero-triangle t3"></div>
        <div class="hero-triangle t4"></div>
        <div class="hero-triangle t5"></div>
      </div>

      <div class="right-panel">
        <div class="form-header">
          <button class="tab-btn active">{{ content('auth.login.title', 'Login') }}</button>
        </div>
        <p class="description">
          {{ content('auth.login.description', 'Welcome back! Please login to your account to continue your esports journey.') }}
        </p>

        <div id="loginMessage" style="display: none; color: #ff6b6b; background-color: #ffe0e0; border: 1px solid #ff6b6b; padding: 10px; border-radius: 10px; margin-bottom: 15px; text-align: center;"></div>

        <form class="signup-form" method="POST" action="{{ route('login') }}">
          @csrf
          
          <!-- Display validation errors -->
          @if ($errors->any())
            <div class="alert alert-danger">
              @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
              @endforeach
            </div>
          @endif
          
          <div class="form-row">
            <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ content('auth.login.email_placeholder', 'Enter your email address') }}" required />
          </div>
          <div class="form-row">
            <input type="password" name="password" placeholder="{{ content('auth.login.password_placeholder', 'Enter your Password') }}" required />
          </div>

          <div class="form-options">
            <div class="checkbox-group">
              <label><input type="checkbox" name="remember" /> {{ content('auth.login.remember_me', 'Remember me') }}</label>
            </div>
          </div>
          <button type="submit" class="btn-submit">{{ content('auth.login.button', 'Log in') }}</button>
        </form>
      </div>
</div>

@endsection
@push('scripts')
@vite('resources/js/script.js')
<script>
  // Check for login message from registration attempt
  document.addEventListener('DOMContentLoaded', function() {
    const message = sessionStorage.getItem('loginMessage');
    if (message) {
      const messageDiv = document.getElementById('loginMessage');
      messageDiv.textContent = message;
      messageDiv.style.display = 'block';
      // Clear the message so it doesn't persist
      sessionStorage.removeItem('loginMessage');
    }
  });
</script>
@endpush
