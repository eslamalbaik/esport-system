@extends('admin.layout')

@section('title', 'Edit Home Page - Skeleton View')

@section('content')
<div class="skeleton-editor">
    <!-- Mode Indicator -->
    <div class="skeleton-mode-indicator">
        🎨 SKELETON EDIT MODE - COMPLETE HOME PAGE
    </div>

    <!-- Header -->
    <div class="skeleton-header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 md:gap-0">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg md:text-xl font-semibold text-white break-words">Home Page - Visual Editor (Complete)</h1>
                <p class="text-xs md:text-sm text-gray-400 mt-1">Click any content element to edit it inline - All 6 sections visible</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                <a href="{{ route('home') }}"
                   class="px-3 py-1.5 text-xs md:text-sm bg-blue-600 text-white rounded hover:bg-blue-700 text-center transition"
                   target="_blank">
                    👁️ Preview Page
                </a>
                <button onclick="scrollToSection()"
                        class="px-3 py-1.5 text-xs md:text-sm bg-green-600 text-white rounded hover:bg-green-700 transition">
                    📍 Jump to Section
                </button>
            </div>
        </div>
    </div>

    <!-- Section Navigation -->
    <div class="skeleton-nav bg-neutral-800/50 border-b border-neutral-700 px-4 md:px-8 py-2 md:py-3">
        <div class="flex flex-wrap gap-1.5 md:gap-2 text-xs md:text-sm">
            <a href="#hero-section" class="px-2 md:px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition whitespace-nowrap">🏠 Hero</a>
            <a href="#services-section" class="px-2 md:px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition whitespace-nowrap">🛠️ Services</a>
            <a href="#tournaments-section" class="px-2 md:px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition whitespace-nowrap">🏆 Tournaments</a>
            <a href="#partners-section" class="px-2 md:px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700 transition whitespace-nowrap">🤝 Partners</a>
            <a href="#testimonials-section" class="px-2 md:px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition whitespace-nowrap">💬 Testimonials</a>
            <a href="#about-section" class="px-2 md:px-3 py-1 bg-pink-600 text-white rounded hover:bg-pink-700 transition whitespace-nowrap">ℹ️ About</a>
        </div>
    </div>

    <!-- Instructions -->
    <div class="skeleton-content">
        <div class="skeleton-instructions">
            <h3>How to use the Complete Skeleton Editor:</h3>
            <ul>
                <li><span style="color: #60a5fa;">Blue highlighted areas</span> are text content - click to edit text in multiple languages</li>
                <li><span style="color: #34d399;">Green highlighted areas</span> are images - click to upload new images</li>
                <li>Use the section navigation above to quickly jump to different parts of the page</li>
                <li>Changes are saved instantly and will update the live site</li>
                <li>Hover over any content to see its content key identifier</li>
                <li><strong>This skeleton shows ALL 6 sections</strong> of the home page for complete editing</li>
            </ul>
        </div>

        <!-- 1. HERO SECTION -->
        <section id="hero-section" class="hero bg-gradient-to-r from-gray-900 to-gray-800 text-white p-4 md:p-6 lg:p-8 mb-6 md:mb-8 rounded-lg border-l-4 border-red-500">
            <div class="section-header mb-4 md:mb-6">
                <h2 class="text-xl md:text-2xl font-bold text-red-400 mb-2">🏠 HERO SECTION</h2>
                <p class="text-gray-300 text-xs md:text-sm">Main landing area with title, description, countdown and call-to-action</p>
            </div>

            <div class="container mx-auto px-0 md:px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 items-center">
                    <!-- Left Column -->
                    <div class="order-2 lg:order-1">
                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-3 md:mb-4">
                            <span data-content-key="home.hero.title"
                                  data-content-type="text"
                                  data-content-value="{{ $contents['home.hero.title']->value ?? '{}' }}">
                                {{ content('home.hero.title', 'Welcome to Esports') }}
                            </span>
                        </h1>

                        <h2 class="text-xl md:text-2xl mb-4 md:mb-6">
                            <span data-content-key="home.hero.subtitle"
                                  data-content-type="text"
                                  data-content-value="{{ $contents['home.hero.subtitle']->value ?? '{}' }}">
                                {{ content('home.hero.subtitle', 'Championship') }}
                            </span>
                        </h2>

                        <p class="text-base md:text-lg mb-6 md:mb-8">
                            <span data-content-key="home.hero.description"
                                  data-content-type="text"
                                  data-content-value="{{ $contents['home.hero.description']->value ?? '{}' }}">
                                {{ content('home.hero.description', 'Join the ultimate gaming experience') }}
                            </span>
                        </p>

                        @php
                            $skeletonNow = now();
                            $skeletonDefaultTarget = (clone $skeletonNow)->addMonths(3)->startOfMinute();
                            $skeletonTargetRaw = content('home.countdown.target_datetime', $skeletonDefaultTarget->toIso8601String());

                            try {
                                $skeletonTarget = \Carbon\Carbon::parse($skeletonTargetRaw);
                            } catch (\Throwable $e) {
                                $skeletonTarget = clone $skeletonDefaultTarget;
                            }

                            $skeletonTarget = $skeletonTarget->timezone($skeletonNow->timezone);

                            if ($skeletonTarget->lessThanOrEqualTo($skeletonNow)) {
                                $skeletonMonths = $skeletonDays = $skeletonMinutes = 0;
                            } else {
                                $skeletonInterval = $skeletonNow->diff($skeletonTarget);
                                $skeletonMonths = max(0, ($skeletonInterval->y * 12) + $skeletonInterval->m);
                                $skeletonDays = max(0, $skeletonInterval->d);
                                $skeletonMinutes = max(0, $skeletonInterval->i);
                            }
                        @endphp

                        <!-- Countdown -->
                        <div class="countdown flex flex-wrap justify-center gap-3 md:gap-4 mb-4 p-3 md:p-4 bg-gray-800 rounded">
                            <div class="text-center">
                                <div class="text-2xl font-bold">{{ str_pad($skeletonMonths, 2, '0', STR_PAD_LEFT) }}</div>
                                <div data-content-key="home.countdown.months"
                                     data-content-type="text"
                                     data-content-value="{{ $contents['home.countdown.months']->value ?? '{}' }}">
                                    {{ content('home.countdown.months', 'Months') }}
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold">⭐</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold">{{ str_pad($skeletonDays, 2, '0', STR_PAD_LEFT) }}</div>
                                <div data-content-key="home.countdown.days"
                                     data-content-type="text"
                                     data-content-value="{{ $contents['home.countdown.days']->value ?? '{}' }}">
                                    {{ content('home.countdown.days', 'Days') }}
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold">⭐</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold">{{ str_pad($skeletonMinutes, 2, '0', STR_PAD_LEFT) }}</div>
                                <div data-content-key="home.countdown.minutes"
                                     data-content-type="text"
                                     data-content-value="{{ $contents['home.countdown.minutes']->value ?? '{}' }}">
                                    {{ content('home.countdown.minutes', 'Minutes') }}
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-800/70 border border-gray-700 rounded p-4 mb-8 text-sm">
                            <p class="text-gray-300 font-semibold mb-2">Countdown Target (ISO 8601 format)</p>
                            <p class="text-gray-400 mb-2">Set the event date &amp; time (e.g. <code>2025-12-31T18:00:00+00:00</code>). The hero countdown automatically recalculates months, days, and minutes based on this value.</p>
                            <div class="inline-flex items-center gap-2 px-3 py-2 bg-gray-900 rounded border border-gray-700">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2h-1M6 5H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span data-content-key="home.countdown.target_datetime"
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('home.countdown.target_datetime'))->value ?? '{}' }}">
                                    {{ content('home.countdown.target_datetime', $skeletonDefaultTarget->toIso8601String()) }}
                                </span>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="hero-actions flex items-center gap-4 p-4 bg-red-900/20 rounded border border-red-700">
                            <span data-content-key="home.cta.button.image"
                                  data-content-type="image"
                                  data-content-value="{{ $contents['home.cta.button.image']->value ?? '{}' }}"
                                  data-image-url="{{ content_media('home.cta.button.image', 'img/register-now.png') }}">
                                <img src="{{ content_media('home.cta.button.image', 'img/register-now.png') }}"
                                     alt="Register Now"
                                     class="h-12" />
                            </span>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="text-center order-1 lg:order-2">
                        <span data-content-key="home.hero.image"
                              data-content-type="image"
                              data-content-value="{{ $contents['home.hero.image']->value ?? '{}' }}"
                              data-image-url="{{ content_media('home.hero.image', 'content-images/home.hero.image.png') }}">
                            <img src="{{ content_media('home.hero.image', 'content-images/home.hero.image.png') }}"
                                 alt="Hero Image"
                                 class="w-full max-w-full md:max-w-md mx-auto rounded-lg border-2 md:border-4 border-green-500" />
                        </span>

                        <div class="mt-4 bg-gray-800 p-4 rounded border border-gray-600">
                            <small data-content-key="home.hero.tag.ready"
                                   data-content-type="text"
                                   data-content-value="{{ $contents['home.hero.tag.ready']->value ?? '{}' }}">
                                {{ content('home.hero.tag.ready', 'Ready For The') }}
                            </small>
                            <div class="font-bold">
                                <span data-content-key="home.hero.tag.suspension"
                                      data-content-type="text"
                                      data-content-value="{{ $contents['home.hero.tag.suspension']->value ?? '{}' }}">
                                    {{ content('home.hero.tag.suspension', 'Suspension') }}
                                </span>
                                <span data-content-key="home.hero.tag.esports"
                                      data-content-type="text"
                                      data-content-value="{{ $contents['home.hero.tag.esports']->value ?? '{}' }}">
                                    {{ content('home.hero.tag.esports', 'Esports') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. SERVICES SECTION -->
        <section id="services-section" class="services bg-gradient-to-r from-blue-900 to-blue-800 text-white p-4 md:p-6 lg:p-8 mb-6 md:mb-8 rounded-lg border-l-4 border-blue-500">
            <div class="section-header mb-4 md:mb-6">
                <h2 class="text-xl md:text-2xl font-bold text-blue-400 mb-2">🛠️ SERVICES SECTION</h2>
                <p class="text-gray-300 text-xs md:text-sm">Three service cards showcasing key offerings</p>
            </div>

            <div class="container mx-auto px-0 md:px-4">
                <h2 class="text-2xl md:text-3xl font-bold text-center mb-6 md:mb-8">
                    <span data-content-key="home.services.title"
                          data-content-type="text"
                          data-content-value="{{ $contents['home.services.title']->value ?? '{}' }}">
                        {{ content('home.services.title', 'Our Services') }}
                    </span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8">
                    <!-- Service Card 1 -->
                    <div class="text-center bg-blue-700 p-4 md:p-6 rounded-lg border border-blue-600">
                        <div class="mb-4">
                            <span data-content-key="home.services.card1.icon"
                                  data-content-type="image"
                                  data-content-value="{{ $contents['home.services.card1.icon']->value ?? '{}' }}"
                                  data-image-url="{{ content_media('home.services.card1.icon', 'img/Subtract(1).png') }}">
                                <img src="{{ content_media('home.services.card1.icon', 'img/Subtract(1).png') }}"
                                     alt="Service 1"
                                     class="w-16 h-16 mx-auto border-2 border-green-400 rounded" />
                            </span>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">
                            <span data-content-key="home.services.card1.title"
                                  data-content-type="text"
                                  data-content-value="{{ $contents['home.services.card1.title']->value ?? '{}' }}">
                                {{ content('home.services.card1.title', 'Experienced Trainers') }}
                            </span>
                        </h3>
                        <p data-content-key="home.services.card1.description"
                           data-content-type="text"
                           data-content-value="{{ $contents['home.services.card1.description']->value ?? '{}' }}">
                            {{ content('home.services.card1.description', 'Endless action that keeps players coming back.') }}
                        </p>
                    </div>

                    <!-- Service Card 2 -->
                    <div class="text-center bg-blue-700 p-4 md:p-6 rounded-lg border border-blue-600">
                        <div class="mb-4">
                            <span data-content-key="home.services.card2.icon"
                                  data-content-type="image"
                                  data-content-value="{{ $contents['home.services.card2.icon']->value ?? '{}' }}"
                                  data-image-url="{{ content_media('home.services.card2.icon', 'img/Subtract.png') }}">
                                <img src="{{ content_media('home.services.card2.icon', 'img/Subtract.png') }}"
                                     alt="Service 2"
                                     class="w-16 h-16 mx-auto border-2 border-green-400 rounded" />
                            </span>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">
                            <span data-content-key="home.services.card2.title"
                                  data-content-type="text"
                                  data-content-value="{{ $contents['home.services.card2.title']->value ?? '{}' }}">
                                {{ content('home.services.card2.title', 'Every Console') }}
                            </span>
                        </h3>
                        <p data-content-key="home.services.card2.description"
                           data-content-type="text"
                           data-content-value="{{ $contents['home.services.card2.description']->value ?? '{}' }}">
                            {{ content('home.services.card2.description', 'We deliver the complete esports experience.') }}
                        </p>
                    </div>

                    <!-- Service Card 3 -->
                    <div class="text-center bg-blue-700 p-4 md:p-6 rounded-lg border border-blue-600">
                        <div class="mb-4">
                            <span data-content-key="home.services.card3.icon"
                                  data-content-type="image"
                                  data-content-value="{{ $contents['home.services.card3.icon']->value ?? '{}' }}"
                                  data-image-url="{{ content_media('home.services.card3.icon', 'img/Subtract(2).png') }}">
                                <img src="{{ content_media('home.services.card3.icon', 'img/Subtract(2).png') }}"
                                     alt="Service 3"
                                     class="w-16 h-16 mx-auto border-2 border-green-400 rounded" />
                            </span>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">
                            <span data-content-key="home.services.card3.title"
                                  data-content-type="text"
                                  data-content-value="{{ $contents['home.services.card3.title']->value ?? '{}' }}">
                                {{ content('home.services.card3.title', 'Live Streaming') }}
                            </span>
                        </h3>
                        <p data-content-key="home.services.card3.description"
                           data-content-type="text"
                           data-content-value="{{ $contents['home.services.card3.description']->value ?? '{}' }}">
                            {{ content('home.services.card3.description', 'One destination for unforgettable events.') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. TOURNAMENTS SECTION -->
        <section id="tournaments-section" class="tournaments bg-gradient-to-r from-green-900 to-green-800 text-white p-4 md:p-6 lg:p-8 mb-6 md:mb-8 rounded-lg border-l-4 border-green-500">
            <div class="section-header mb-4 md:mb-6">
                <h2 class="text-xl md:text-2xl font-bold text-green-400 mb-2">🏆 TOURNAMENTS SECTION</h2>
                <p class="text-gray-300 text-xs md:text-sm">Popular tournaments list with badge and descriptions</p>
            </div>

            <div class="container mx-auto px-0 md:px-4">
                <div class="text-center mb-6 md:mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold mb-3 md:mb-4">
                        <span data-content-key="home.tournaments.title"
                              data-content-type="text"
                              data-content-value="{{ $contents['home.tournaments.title']->value ?? '{}' }}">
                            {{ content('home.tournaments.title', 'Popular Tournaments') }}
                        </span>
                    </h2>
                    <p class="text-lg md:text-xl">
                        <span data-content-key="home.tournaments.subtitle"
                              data-content-type="text"
                              data-content-value="{{ $contents['home.tournaments.subtitle']->value ?? '{}' }}">
                            {{ content('home.tournaments.subtitle', 'Join the competition') }}
                        </span>
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                     <h1 class="text-3xl font-bold text-center mb-8">TOURNAMENTS APPEAR HERE</h1>
                </div>
            </div>
        </section>

        <!-- 4. PARTNERS SECTION -->
        <section id="partners-section" class="partners bg-gradient-to-r from-purple-900 to-purple-800 text-white p-4 md:p-6 lg:p-8 mb-6 md:mb-8 rounded-lg border-l-4 border-purple-500">
            <div class="section-header mb-4 md:mb-6">
                <h2 class="text-xl md:text-2xl font-bold text-purple-400 mb-2">🤝 PARTNERS SECTION</h2>
                <p class="text-gray-300 text-xs md:text-sm">Partner cards with images and live streaming information</p>
            </div>

            <div class="container mx-auto px-0 md:px-4">
                <h2 class="text-2xl md:text-3xl font-bold text-center mb-6 md:mb-8">
                    <span data-content-key="home.partners.title"
                          data-content-type="text"
                          data-content-value="{{ $contents['home.partners.title']->value ?? '{}' }}">
                        {{ content('home.partners.title', 'Our Partners') }}
                    </span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                             <h1 class="text-3xl font-bold text-center mb-8">PARTNERS APPEAR HERE</h1>
            </div>
        </section>

        <!-- 5. TESTIMONIALS SECTION -->
        @php($testimonials = $testimonials ?? \App\Models\Testimonial::ordered()->get())
        <section id="testimonials-section" class="testimonials bg-gradient-to-r from-yellow-900 to-yellow-800 text-white p-4 md:p-6 lg:p-8 mb-6 md:mb-8 rounded-lg border-l-4 border-yellow-500">
            <div class="section-header mb-4 md:mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 md:gap-4">
                    <div class="flex-1">
                        <h2 class="text-xl md:text-2xl font-bold text-yellow-400 mb-2">💬 TESTIMONIALS SECTION</h2>
                        <p class="text-gray-300 text-xs md:text-sm">Preview live testimonials and jump to the management panel.</p>
                    </div>
                    <a href="{{ route('admin.testimonials.index') }}"
                       class="inline-flex items-center justify-center gap-2 px-3 md:px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded transition text-sm md:text-base w-full md:w-auto">
                        <span class="text-base md:text-lg leading-none">⚙️</span>
                        <span>Manage Testimonials</span>
                    </a>
                </div>
            </div>

            <div class="container mx-auto px-0 md:px-4">
                <div class="text-center mb-6 md:mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold mb-3 md:mb-4">
                        <span data-content-key="home.testimonials.title"
                              data-content-type="text"
                              data-content-value="{{ $contents['home.testimonials.title']->value ?? '{}' }}">
                            {{ content('home.testimonials.title', 'Client') }}
                        </span>
                        <span data-content-key="home.testimonials.subtitle"
                              data-content-type="text"
                              data-content-value="{{ $contents['home.testimonials.subtitle']->value ?? '{}' }}">
                            {{ content('home.testimonials.subtitle', 'Testimonial') }}
                        </span>
                    </h2>
                    <p class="text-base md:text-lg">
                        <span data-content-key="home.testimonials.description"
                              data-content-type="text"
                              data-content-value="{{ $contents['home.testimonials.description']->value ?? '{}' }}">
                            {{ content('home.testimonials.description', 'Our Client feedback is overseas and Localy') }}
                        </span>
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                    @forelse($testimonials as $testimonial)
                        <div class="bg-yellow-700 p-4 md:p-6 rounded-lg border border-yellow-600 shadow-md">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-full border-2 border-green-400 overflow-hidden">
                                    <img src="{{ $testimonial->avatar_path ? asset($testimonial->avatar_path) : content_media('home.testimonial1.avatar', 'img/Rectangle 28.png') }}"
                                         alt="{{ $testimonial->nameFor('en') }}"
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-semibold text-white">
                                        {{ $testimonial->nameFor(app()->getLocale()) ?: $testimonial->nameFor('en') }}
                                    </h4>
                                    <p class="text-sm text-yellow-200">
                                        {{ $testimonial->roleFor(app()->getLocale()) ?: $testimonial->roleFor('en') }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-sm text-yellow-100 leading-relaxed">
                                “{{ $testimonial->textFor(app()->getLocale()) ?: $testimonial->textFor('en') }}”
                            </p>
                            <div class="mt-4 flex justify-between items-center text-xs">
                                <span class="px-2 py-1 rounded {{ $testimonial->is_published ? 'bg-green-500/30 text-green-200' : 'bg-yellow-500/30 text-yellow-200' }}">
                                    {{ $testimonial->is_published ? 'Published' : 'Hidden' }}
                                </span>
                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}"
                                   class="px-2 py-1 bg-blue-600/70 hover:bg-blue-600 text-white rounded">
                                    Edit
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-yellow-700/40 p-6 rounded-lg border border-yellow-600 text-center text-yellow-200">
                            No testimonials yet. Use the “Manage Testimonials” button to add your first testimonial.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- 6. ABOUT SECTION -->
        <section id="about-section" class="about bg-gradient-to-r from-pink-900 to-pink-800 text-white p-4 md:p-6 lg:p-8 mb-6 md:mb-8 rounded-lg border-l-4 border-pink-500">
            <div class="section-header mb-4 md:mb-6">
                <h2 class="text-xl md:text-2xl font-bold text-pink-400 mb-2">ℹ️ ABOUT / WHO WE ARE SECTION</h2>
                <p class="text-gray-300 text-xs md:text-sm">About section with mission, vision, story and subscribe form</p>
            </div>

            <div class="container mx-auto px-0 md:px-4">
                <div class="text-center mb-6 md:mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold mb-3 md:mb-4">
                        <span data-content-key="about.header.title"
                              data-content-type="text"
                              data-content-value="{{ $contents['about.header.title']->value ?? '{}' }}">
                            {{ content('about.header.title', 'WHO WE ARE ?') }}
                        </span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8">
                    <!-- Our Story -->
                    <div class="bg-pink-700 p-4 md:p-6 rounded-lg border border-pink-600">
                        <h3 class="text-xl font-semibold mb-4 text-pink-200">
                            <span data-content-key="about.story.title"
                                  data-content-type="text"
                                  data-content-value="{{ $contents['about.story.title']->value ?? '{}' }}">
                                {{ content('about.story.title', 'Our Story') }}
                            </span>
                        </h3>
                        <p data-content-key="about.team.description"
                           data-content-type="text"
                           data-content-value="{{ $contents['about.team.description']->value ?? '{}' }}">
                            {{ content('about.team.description', 'In early winter 2020, amidst a raging pandemic, FOUR04 ESPORTS was born...') }}
                        </p>
                    </div>

                    <!-- Our Mission -->
                    <div class="bg-pink-700 p-4 md:p-6 rounded-lg border border-pink-600">
                        <h3 class="text-xl font-semibold mb-4 text-pink-200">
                            <span data-content-key="about.mission.title"
                                  data-content-type="text"
                                  data-content-value="{{ $contents['about.mission.title']->value ?? '{}' }}">
                                {{ content('about.mission.title', 'Our Mission') }}
                            </span>
                        </h3>
                        <p data-content-key="about.mission.text"
                           data-content-type="text"
                           data-content-value="{{ $contents['about.mission.text']->value ?? '{}' }}">
                            {{ content('about.mission.text', 'Establish a self-sustaining and progressively scalable eSports platform...') }}
                        </p>
                    </div>

                    <!-- Our Vision -->
                    <div class="bg-pink-700 p-4 md:p-6 rounded-lg border border-pink-600">
                        <h3 class="text-xl font-semibold mb-4 text-pink-200">
                            <span data-content-key="about.vision.title"
                                  data-content-type="text"
                                  data-content-value="{{ $contents['about.vision.title']->value ?? '{}' }}">
                                {{ content('about.vision.title', 'Our Vision') }}
                            </span>
                        </h3>
                        <p data-content-key="about.vision.text"
                           data-content-type="text"
                           data-content-value="{{ $contents['about.vision.text']->value ?? '{}' }}">
                            {{ content('about.vision.text', 'The Healing is fresh!!! can not wait to take my next session...') }}
                        </p>
                    </div>
                </div>

                <!-- Subscribe Form -->
                <div class="mt-6 md:mt-8 text-center">
                    <div class="max-w-md mx-auto bg-pink-700 p-4 md:p-6 rounded-lg border border-pink-600">
                        <h3 class="text-base md:text-lg font-semibold mb-3 md:mb-4 text-pink-200">Stay Updated</h3>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <input type="email"
                                   placeholder="{{ content('home.subscribe.placeholder', 'Enter your email address') }}"
                                   class="flex-1 px-3 py-2 bg-pink-800 border border-pink-600 rounded text-white placeholder-pink-300">
                            <button class="px-4 py-2 bg-pink-600 hover:bg-pink-500 text-white rounded font-medium">
                                <span data-content-key="home.subscribe.button"
                                      data-content-type="text"
                                      data-content-value="{{ $contents['home.subscribe.button']->value ?? '{}' }}">
                                    {{ content('home.subscribe.button', 'Subscribe') }}
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Completion Summary -->
        <div class="completion-summary bg-green-900/30 border border-green-700 rounded-lg p-4 md:p-6 text-center">
            <h3 class="text-lg md:text-xl font-bold text-green-400 mb-3 md:mb-4">✅ Complete Home Page Skeleton</h3>
            <p class="text-gray-300 mb-3 md:mb-4 text-sm md:text-base">All 6 sections of the home page are now visible and editable:</p>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-xs md:text-sm">
                <div class="bg-red-800/30 px-3 py-2 rounded">🏠 Hero Section</div>
                <div class="bg-blue-800/30 px-3 py-2 rounded">🛠️ Services Section</div>
                <div class="bg-green-800/30 px-3 py-2 rounded">🏆 Tournaments Section</div>
                <div class="bg-purple-800/30 px-3 py-2 rounded">🤝 Partners Section</div>
                <div class="bg-yellow-800/30 px-3 py-2 rounded">💬 Testimonials Section</div>
                <div class="bg-pink-800/30 px-3 py-2 rounded">ℹ️ About Section</div>
            </div>
            <p class="text-gray-400 text-sm mt-4">
                Click any highlighted content to edit. Use section navigation at the top to jump between sections.
            </p>
        </div>
    </div>
</div>

<!-- Include Modal -->
@include('admin.components.edit-modal')

<!-- Include Styles -->
@include('admin.components.skeleton-styles')

<!-- Enhanced Scripts for Complete Skeleton -->
<script>
// Section navigation functionality
function scrollToSection() {
    const sections = [
        { id: 'hero-section', name: '🏠 Hero' },
        { id: 'services-section', name: '🛠️ Services' },
        { id: 'tournaments-section', name: '🏆 Tournaments' },
        { id: 'partners-section', name: '🤝 Partners' },
        { id: 'testimonials-section', name: '💬 Testimonials' },
        { id: 'about-section', name: 'ℹ️ About' }
    ];

    const sectionsList = sections.map(s => `${s.name} (#${s.id})`).join('\n');
    const selected = prompt(`Jump to section:\n\n${sectionsList}\n\nEnter section ID:`);

    if (selected) {
        const element = document.getElementById(selected.replace('#', ''));
        if (element) {
            element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            element.classList.add('bg-white/10');
            setTimeout(() => element.classList.remove('bg-white/10'), 2000);
        }
    }
}

// Smooth scroll for navigation links
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('a[href^="#"]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // Highlight the section briefly
                targetElement.classList.add('bg-white/10');
                setTimeout(() => targetElement.classList.remove('bg-white/10'), 2000);
            }
        });
    });
});
</script>

<!-- Include Scripts -->
@include('admin.components.skeleton-scripts')
@endsection
