    <!-- Header Navigation -->
    <header class="navbar">
      <!-- Logo Section -->
      <div class="logo">
        <a href="{{ route('home') }}" aria-label="{{ content('nav.logo_aria', __('Four04 Esports Home')) }}">
          <img src="{{ content_media('logo.main', 'img/logo.png') }}" class="logo-img" alt="{{ content('nav.logo_alt', __('Four04 Esports Logo')) }}" />
        </a>
      </div>
      
      <!-- Mobile Menu Toggle -->
      <input type="checkbox" id="navbar-toggle" class="navbar-toggle" aria-hidden="true">
      <label for="navbar-toggle" class="navbar-toggler" aria-label="Toggle navigation menu">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
      </label>

      <!-- Navigation Menu -->
      <nav class="nav-links" role="navigation" aria-label="Main navigation">
        <a href="{{ route('home') }}" {{ request()->routeIs('home') ? 'aria-current=page' : '' }}>{{ content('nav.home', __('Home')) }}</a>
        <a href="{{ route('about') }}" {{ request()->routeIs('about') ? 'aria-current=page' : '' }}>{{ content('nav.about', __('About Us')) }}</a>
        <a href="{{ route('services') }}" {{ request()->routeIs('services') ? 'aria-current=page' : '' }}>{{ content('nav.services', __('Our Services')) }}</a>
        <a href="{{ route('tournaments') }}" {{ request()->routeIs('tournaments') ? 'aria-current=page' : '' }}>{{ content('nav.esports', __('Tournaments')) }}</a>
        <a href="{{ route('gallery') }}" {{ request()->routeIs('gallery') || request()->routeIs('gallery.show') ? 'aria-current=page' : '' }}>
          {{ content('Gallery', __('Gallery')) }}
        </a>
        <a href="{{ route('partners') }}" {{ request()->routeIs('partners') || request()->routeIs('partners.show') ? 'aria-current=page' : '' }}>
          {{ content('nav.partners', __('Partners')) }}
        </a>
        <a href="{{ route('news') }}" {{ request()->routeIs('news') ? 'aria-current=page' : '' }}>
          {{ content('News', __('News')) }}
        </a>
        <a href="{{ route('team') }}" {{ request()->routeIs('team') ? 'aria-current=page' : '' }}>{{ content('nav.team', __('Our Team')) }}</a>
        @auth
          <form method="POST" action="{{ route('logout') }}" class="nav-logout-form" id="logout-form">
            @csrf
            <button type="submit" id="logout-button">
              {{ content('nav.logout', __('Logout')) }}
            </button>
          </form>
        @else
          <a href="{{ route('login') }}" {{ request()->routeIs('login') ? 'aria-current=page' : '' }}>{{ content('nav.login', __('Login')) }}</a>
        @endauth
        <a href="{{ route('setLocale', 'en') }}" class="lang-switch {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
        <a href="{{ route('setLocale', 'ar') }}" class="lang-switch {{ app()->getLocale() === 'ar' ? 'active' : '' }}">{{ __('AR') }}</a>
      </nav>
    </header>
