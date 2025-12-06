@extends('layouts.app')

@section('title', 'Signup')

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
        <a href="{{ route('login') }}" class="tab-btn">{{ content('nav.login', 'Login') }}</a>
        <button class="tab-btn active">{{ content('auth.register.title', 'Sign up') }}</button>
    </div>
    <p class="description">
        {{ content('auth.register.description', 'Join our esports community and start your competitive gaming journey today.') }}
    </p>

    <form class="signup-form" method="POST" action="{{ route('register') }}">
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
            <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ content('auth.register.name_placeholder', 'Enter your Full name') }}" required />
            <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ content('auth.register.email_placeholder', 'Enter your E-mail') }}" required />
        </div>
        <div class="form-row">
            <input type="text" name="mobile" value="{{ old('mobile') }}" placeholder="{{ content('auth.register.mobile_placeholder', 'Enter your Mobile number') }}" />
            <select name="state">
                <option value="">{{ content('auth.register.state_placeholder', 'Select your State') }}</option>
                <option value="abu_dhabi" {{ old('state') == 'abu_dhabi' ? 'selected' : '' }}>Abu Dhabi</option>
                <option value="dubai" {{ old('state') == 'dubai' ? 'selected' : '' }}>Dubai</option>
                <option value="sharjah" {{ old('state') == 'sharjah' ? 'selected' : '' }}>Sharjah</option>
                <option value="ajman" {{ old('state') == 'ajman' ? 'selected' : '' }}>Ajman</option>
                <option value="umm_al_quwain" {{ old('state') == 'umm_al_quwain' ? 'selected' : '' }}>Umm Al Quwain</option>
                <option value="ras_al_khaimah" {{ old('state') == 'ras_al_khaimah' ? 'selected' : '' }}>Ras Al Khaimah</option>
                <option value="fujairah" {{ old('state') == 'fujairah' ? 'selected' : '' }}>Fujairah</option>
            </select>
        </div>
        <div class="form-row">
            <input type="text" name="address" value="{{ old('address') }}" placeholder="{{ content('auth.register.address_placeholder', 'Enter your Address') }}" />
            <select name="gender">
                <option value="">{{ content('auth.register.gender_placeholder', 'Select your Gender') }}</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>
        <div class="form-row">
            <input type="date" name="birth_date" value="{{ old('birth_date') }}" placeholder="{{ content('auth.register.birth_date_placeholder', 'Date of Birth') }}" />
            <input type="text" name="emirates_id" value="{{ old('emirates_id') }}" placeholder="{{ content('auth.register.emirates_id_placeholder', 'Enter your ID Emirates') }}" />
        </div>
        <div class="form-row">
            <input type="password" name="password" placeholder="{{ content('auth.register.password_placeholder', 'Enter your Password') }}" required />
            <input type="password" name="password_confirmation" placeholder="{{ content('auth.register.password_confirmation_placeholder', 'Enter your Confirm password') }}" required />
        </div>

        <div class="checkbox-group">
            <label><input type="checkbox" name="accept_privacy" required /> {{ content('auth.register.privacy_text', 'I agree to the') }} <a href="{{ route('privacy') }}" class="href">{{ content('auth.register.privacy_link', 'Privacy Policy') }}</a></label>
        </div>
        <div class="checkbox-group">
            <label><input type="checkbox" name="accept_terms" required /> {{ content('auth.register.terms_text', 'I agree to the') }} <a href="{{ route('terms') }}" class="href">{{ content('auth.register.terms_link', 'Terms and Conditions') }}</a></label>
        </div>

        <button type="submit" class="btn-submit">{{ content('auth.register.button', 'Sign up') }}</button>
    </form>
</div>
</div>
@endsection
@push('scripts')
@vite('resources/js/script.js')
@endpush
