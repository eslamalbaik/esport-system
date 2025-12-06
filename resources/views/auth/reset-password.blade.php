@extends('layouts.app')

@section('title', 'Reset Password')

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
      <button class="tab-btn active">{{ content('auth.reset.title', 'Reset Password') }}</button>
    </div>
    
    <div class="forgot-password-hero">
      <img src="{{ content_media('auth.reset.image', 'img/forgot-password.png') }}" alt="Reset Password" class="forgot-img" />
    </div>
    
    <p class="description">
      {{ content('auth.reset.description', 'Please enter your new password to complete the reset process.') }}
    </p>
    
    <form class="signup-form" method="POST" action="{{ route('password.store') }}">
      @csrf
      
      <!-- Hidden token field -->
      <input type="hidden" name="token" value="{{ $token ?? request()->route('token') }}" />
      
      <!-- Display validation errors -->
      @if ($errors->any())
        <div class="alert alert-danger">
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif
      
      <div class="form-row">
        <input type="email" name="email" value="{{ old('email', $email ?? request()->email) }}" placeholder="{{ content('auth.reset.email_placeholder', 'Enter your Email') }}" required />
      </div>
      <div class="form-row">
        <input type="password" name="password" placeholder="{{ content('auth.reset.password_placeholder', 'Enter your New Password') }}" required />
      </div>
      <div class="form-row">
        <input type="password" name="password_confirmation" placeholder="{{ content('auth.reset.password_confirmation_placeholder', 'Confirm your New Password') }}" required />
      </div>
      <button type="submit" class="btn-submit">{{ content('auth.reset.button', 'Reset Password') }}</button>
    </form>
  </div>
</div>

@endsection
@push('scripts')
@vite('resources/js/script.js')
@endpush
