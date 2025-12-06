<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title', 'E-Sports04')</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap"
        rel="stylesheet" />

    <!-- Critical inline styles for iOS Safari black screen fix -->
    <style>
        html {
            background: #050505;
            background: linear-gradient(180deg, #050505 0%, #0b0b0b 60%);
            min-height: 100%;
            height: 100%;
        }
        body {
            background: #050505;
            background: linear-gradient(180deg, #050505 0%, #0b0b0b 60%);
            color: #fff;
            min-height: 100vh;
            min-height: -webkit-fill-available;
            margin: 0;
            padding: 0;
            font-family: "Cairo", sans-serif;
            position: relative;
            z-index: 1;
        }
        main {
            position: relative;
            z-index: 2;
            min-height: 50vh;
            background: transparent;
            display: block;
            visibility: visible;
            opacity: 1;
        }
        .home-page, .hero, section {
            position: relative;
            z-index: 3;
            visibility: visible;
            opacity: 1;
            display: block;
        }
        header.navbar, .navbar {
            position: relative;
            z-index: 1000;
            visibility: visible;
            opacity: 1;
            display: flex;
            background: rgba(5, 5, 5, 0.95);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
    <!-- Navbar CSS loads last to ensure it overrides any conflicts -->
    @vite('resources/css/navbar.css')
    <!-- Safari compatibility fixes -->
    @vite('resources/css/safari-fixes.css')
</head>

<body style="background: #050505; background: linear-gradient(180deg, #050505 0%, #0b0b0b 60%); min-height: 100vh; min-height: -webkit-fill-available;">
    @include('layouts.header')
    <main style="position: relative; z-index: 2; min-height: 50vh; display: block; visibility: visible;">

        @yield('content')


    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-links">
            <div class="col">
                <img
                    src="{{ content_media('logo.footer', 'img/footer-logo.png') }}"
                    class="footer-logo"
                    alt="Four04 Logo" />
            </div>
            <div class="col">
                <h4>{{ content('footer.contact.title', 'Our Contact') }}</h4>
                <a href="{{ route('about') }}">{{ content('footer.contact.who_we_are', 'Who we are ?') }}</a>
                <a href="{{ route('terms') }}">{{ content('footer.contact.terms', 'Terms and Conditions') }}</a>
                <p>{{ content('footer.contact.pobox', 'POBOX:123456') }}</p>
            </div>

            <div class="col">
                <h4>{{ content('footer.event_management.title', 'Event Management') }}</h4>

                <p>{{ content('footer.event_management.email', 'info@four04.com') }}</p>
                <p>{{ content('footer.event_management.phone', '+971 50123456') }}</p>
            </div>

            <div class="col">
                <h4>{{ content('footer.esport.title', 'E-spost') }}</h4>
                <p>{{ content('footer.esport.location', 'Bur Dubai') }}</p>
                <p>{{ content('footer.event_management.email', 'Esport@four04.com') }}</p>
                <p>{{ content('footer.event_management.phone', '+971 50123456') }}</p>
            </div>

            <div class="col">
                <h4>{{ content('footer.careers.title', 'Careers') }}</h4>
                <a href="#">{{ content('footer.careers.blog', 'Blog') }}</a>
                <a href="#">{{ content('footer.careers.press', 'Press') }}</a>
                <a href="#">{{ content('footer.careers.partnerships', 'Partnerships') }}</a>
            </div>
        </div>

        <div class="footer-bottom gradient-bar">
            <p>{{ content('footer.copyright', '©Copyright 2025') }}</p>
            <p>{{ content('footer.developed_by', 'Designed & Developed by Four04') }}</p>
        </div>

        <div class="footer-bottom gradient-bar">
            <p>{{ __('Total Visitors: :count', ['count' => number_format($totalVisitorCount ?? 0)]) }}</p>
        </div>

    </footer>
    @stack('scripts')
</body>

</html>
