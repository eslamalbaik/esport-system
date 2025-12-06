@extends('layouts.app')

@section('title', 'Forgot Password')

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
      <button class="tab-btn active">{{ content('auth.forgot.title', 'Forgot Password') }}</button>
    </div>
    
    <div class="forgot-password-hero">
      <img src="{{ content_media('auth.forgot.image', 'img/forgot-password.png') }}" alt="Forgot Password" class="forgot-img" />
    </div>
    
    <p class="description">
      {{ content('auth.forgot.description', 'Enter the email address associated with your account and we will send you a password reset link.') }}
    </p>
    
    <form class="signup-form" method="POST" action="{{ route('password.email') }}">
      @csrf
      
      <!-- Display status messages -->
      @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
      @endif
      
      <!-- Display validation errors -->
      @if ($errors->any())
        <div class="alert alert-danger">
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif
      
      <div class="form-row">
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="{{ content('auth.forgot.email_placeholder', 'Enter your Email') }}" required />
      </div>
      <button type="submit" class="btn-submit">{{ content('auth.forgot.button', 'Reset Password') }}</button>
    </form>
  </div>
</div>

@endsection
@push('scripts')
@vite('resources/js/script.js')
@endpush
