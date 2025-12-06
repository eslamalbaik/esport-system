@extends('admin.layout')

@section('title', 'Edit Single Registration Page - Skeleton View')

@section('content')
<div class="skeleton-editor">
    <!-- Mode Indicator -->
    <div class="skeleton-mode-indicator">
        🎨 SKELETON EDIT MODE - SINGLE REGISTRATION PAGE
    </div>

    <!-- Header -->
    <div class="skeleton-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-white">Single Registration Page - Visual Editor</h1>
                <p class="text-sm text-gray-400">Click any content element to edit it inline - Complete individual player form</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('register.single') }}" 
                   class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700" 
                   target="_blank">
                    👁️ Preview Page
                </a>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    <div class="skeleton-content">
        <div class="skeleton-instructions">
            <h3>How to use the Single Registration Skeleton Editor:</h3>
            <ul>
                <li><span style="color: #60a5fa;">Blue highlighted areas</span> are text content - click to edit text in multiple languages</li>
                <li><span style="color: #34d399;">Green highlighted areas</span> are images - click to upload new images</li>
                <li><strong>This skeleton shows the complete single player registration form</strong> with all form fields and labels</li>
                <li>Changes are saved instantly and will update the live site</li>
                <li>Hover over any content to see its content key identifier</li>
            </ul>
        </div>

        <!-- SINGLE REGISTRATION HEADER -->
        <section id="single-reg-header" class="bg-gradient-to-r from-blue-900 to-blue-800 text-white p-8 mb-8 rounded-lg border-l-4 border-blue-500">
            <div class="section-header mb-6">
                <h2 class="text-2xl font-bold text-blue-400 mb-2">🎮 SINGLE REGISTRATION HEADER</h2>
                <p class="text-gray-300 text-sm">Page title and navigation tabs</p>
            </div>
            
            <div class="text-center space-y-6">
                <div class="inline-block">
                    <h1 class="text-4xl font-bold px-8 py-4 bg-blue-600 rounded-lg">
                        <span data-content-key="single_registration.header.title" 
                              data-content-type="text"
                              data-content-value="{{ $contents['single_registration.header.title']->value ?? '{}' }}">
                            {{ content('single_registration.header.title', 'E-Sports') }}
                        </span>
                    </h1>
                </div>
                
                <!-- Navigation Tabs -->
                <div class="flex flex-wrap justify-center gap-4">
                    <div class="px-4 py-2 bg-gray-600 text-white rounded">
                        <span data-content-key="single_registration.tabs.tournament" 
                              data-content-type="text"
                              data-content-value="{{ $contents['single_registration.tabs.tournament']->value ?? '{}' }}">
                            {{ content('single_registration.tabs.tournament', 'Tournament Registrations') }}
                        </span>
                    </div>
                    <div class="px-4 py-2 bg-blue-600 text-white rounded font-bold">
                        <span data-content-key="single_registration.tabs.register" 
                              data-content-type="text"
                              data-content-value="{{ $contents['single_registration.tabs.register']->value ?? '{}' }}">
                            {{ content('single_registration.tabs.register', 'Register – now') }}
                        </span>
                    </div>
                    <div class="px-3 py-1 bg-gray-600 text-white rounded text-sm">
                        <span data-content-key="single_registration.tabs.single" 
                              data-content-type="text"
                              data-content-value="{{ $contents['single_registration.tabs.single']->value ?? '{}' }}">
                            {{ content('single_registration.tabs.single', 'Single') }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- SINGLE REGISTRATION FORM -->
        <section id="single-reg-form" class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-8 mb-8 rounded-lg border-l-4 border-slate-500">
            <div class="section-header mb-6">
                <h2 class="text-2xl font-bold text-slate-400 mb-2">📝 SINGLE PLAYER REGISTRATION FORM</h2>
                <p class="text-gray-300 text-sm">Complete form with individual player details and information</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Phoenix Image -->
                <div class="lg:col-span-1">
                    <div class="bg-slate-700 p-6 rounded-lg border border-slate-600">
                        <h3 class="text-lg font-semibold mb-4 text-center">Phoenix Character</h3>
                        <div class="text-center">
                            <span data-content-key="single_registration.phoenix_image" 
                                  data-content-type="image"
                                  data-content-value="{{ $contents['single_registration.phoenix_image']->value ?? '{}' }}"
                                  data-image-url="{{ content_media('single_registration.phoenix_image', 'img/Phoenix.png') }}">
                                <img src="{{ content_media('single_registration.phoenix_image', 'img/Phoenix.png') }}" 
                                     alt="Phoenix Character" 
                                     class="max-w-full h-auto rounded border-2 border-green-400" />
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right: Form Content -->
                <div class="lg:col-span-2">
                    <div class="bg-slate-700 p-6 rounded-lg border border-slate-600">
                     
                        <!-- Player Information Form -->
                        <div class="space-y-6">
                            <!-- Player Name & In-Game ID Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-slate-600 rounded border">
                                <!-- Player Name -->
                                <div>
                                    <label class="block text-sm font-medium mb-2">
                                        <span data-content-key="single_registration.form.player_name" 
                                              data-content-type="text"
                                              data-content-value="{{ $contents['single_registration.form.player_name']->value ?? '{}' }}">
                                            {{ content('single_registration.form.player_name', 'Player Name') }}
                                        </span>
                                    </label>
                                    <div class="w-full px-3 py-2 bg-slate-800 border border-slate-500 rounded text-gray-300">
                                        <span data-content-key="single_registration.form.player_name_placeholder" 
                                              data-content-type="text"
                                              data-content-value="{{ $contents['single_registration.form.player_name_placeholder']->value ?? '{}' }}">
                                            {{ content('single_registration.form.player_name_placeholder', 'Enter your name') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- In-Game ID -->
                                <div>
                                    <label class="block text-sm font-medium mb-2">
                                        <span data-content-key="single_registration.form.ingame_id" 
                                              data-content-type="text"
                                              data-content-value="{{ $contents['single_registration.form.ingame_id']->value ?? '{}' }}">
                                            {{ content('single_registration.form.ingame_id', 'In-Game ID') }}
                                        </span>
                                    </label>
                                    <div class="w-full px-3 py-2 bg-slate-800 border border-slate-500 rounded text-gray-300">
                                        <span data-content-key="single_registration.form.ingame_id_placeholder" 
                                              data-content-type="text"
                                              data-content-value="{{ $contents['single_registration.form.ingame_id_placeholder']->value ?? '{}' }}">
                                            {{ content('single_registration.form.ingame_id_placeholder', 'Enter your in-game ID') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Email & Phone Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-slate-600 rounded border">
                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium mb-2">
                                        <span data-content-key="single_registration.form.email" 
                                              data-content-type="text"
                                              data-content-value="{{ $contents['single_registration.form.email']->value ?? '{}' }}">
                                            {{ content('single_registration.form.email', 'Email') }}
                                        </span>
                                    </label>
                                    <div class="w-full px-3 py-2 bg-slate-800 border border-slate-500 rounded text-gray-300">
                                        <span data-content-key="single_registration.form.email_placeholder" 
                                              data-content-type="text"
                                              data-content-value="{{ $contents['single_registration.form.email_placeholder']->value ?? '{}' }}">
                                            {{ content('single_registration.form.email_placeholder', 'Enter your email') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Phone Number -->
                                <div>
                                    <label class="block text-sm font-medium mb-2">
                                        <span data-content-key="single_registration.form.phone" 
                                              data-content-type="text"
                                              data-content-value="{{ $contents['single_registration.form.phone']->value ?? '{}' }}">
                                            {{ content('single_registration.form.phone', 'Phone Number') }}
                                        </span>
                                    </label>
                                    <div class="w-full px-3 py-2 bg-slate-800 border border-slate-500 rounded text-gray-300">
                                        <span data-content-key="single_registration.form.phone_placeholder" 
                                              data-content-type="text"
                                              data-content-value="{{ $contents['single_registration.form.phone_placeholder']->value ?? '{}' }}">
                                            {{ content('single_registration.form.phone_placeholder', 'Enter your phone number') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Player Age Row -->
                            <div class="p-4 bg-slate-600 rounded border">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Player Age -->
                                    <div>
                                        <label class="block text-sm font-medium mb-2">
                                            <span data-content-key="single_registration.form.age" 
                                                  data-content-type="text"
                                                  data-content-value="{{ $contents['single_registration.form.age']->value ?? '{}' }}">
                                                {{ content('single_registration.form.age', 'Player Age') }}
                                            </span>
                                        </label>
                                        <div class="w-full px-3 py-2 bg-slate-800 border border-slate-500 rounded text-gray-300">
                                            <span data-content-key="single_registration.form.age_placeholder" 
                                                  data-content-type="text"
                                                  data-content-value="{{ $contents['single_registration.form.age_placeholder']->value ?? '{}' }}">
                                                {{ content('single_registration.form.age_placeholder', 'Enter your age') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Empty space for balance -->
                                    <div></div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center pt-4">
                                <button class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg">
                                    <span data-content-key="single_registration.form.register_button" 
                                          data-content-type="text"
                                          data-content-value="{{ $contents['single_registration.form.register_button']->value ?? '{}' }}">
                                        {{ content('single_registration.form.register_button', 'Register') }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Completion Summary -->
        <div class="completion-summary bg-green-900/30 border border-green-700 rounded-lg p-6 text-center">
            <h3 class="text-xl font-bold text-green-400 mb-4">✅ Complete Single Registration Skeleton</h3>
            <p class="text-gray-300 mb-4">The single registration skeleton includes:</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
                <div class="bg-blue-800/30 px-3 py-2 rounded">🎮 Page Header</div>
                <div class="bg-slate-800/30 px-3 py-2 rounded">📝 Player Form</div>
                <div class="bg-purple-800/30 px-3 py-2 rounded">👤 Player Details</div>
                <div class="bg-green-800/30 px-3 py-2 rounded">🖼️ Images & Avatar</div>
            </div>
            <p class="text-gray-400 text-sm mt-4">
                Click any highlighted content to edit. All form labels, placeholders, and images are editable.
            </p>
        </div>
    </div>
</div>

<!-- Include Modal -->
@include('admin.components.edit-modal')

<!-- Include Styles -->
@include('admin.components.skeleton-styles')

<!-- Include Scripts -->
@include('admin.components.skeleton-scripts')
@endsection
