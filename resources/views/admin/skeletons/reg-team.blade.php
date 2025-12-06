@extends('admin.layout')

@section('title', 'Edit Team Registration Page - Skeleton View')

@section('content')
<div class="skeleton-editor">
    <!-- Mode Indicator -->
    <div class="skeleton-mode-indicator">
        🎨 SKELETON EDIT MODE - TEAM REGISTRATION PAGE
    </div>

    <!-- Header -->
    <div class="skeleton-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-white">Team Registration Page - Visual Editor (Complete)</h1>
                <p class="text-sm text-gray-400">Click any content element to edit it inline - Header, visuals and full form</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('register.team') }}" 
                   class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700" 
                   target="_blank">
                    👁️ Preview Page
                </a>
                <button onclick="scrollToSection()" 
                        class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">
                    📍 Jump to Section
                </button>
            </div>
        </div>
    </div>

    <!-- Section Navigation -->
    <div class="skeleton-nav bg-neutral-800/50 border-b border-neutral-700 px-8 py-3">
        <div class="flex flex-wrap gap-2 text-sm">
            <a href="#header-section" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">🏆 Header</a>
            <a href="#visuals-section" class="px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700">🖼️ Visuals</a>
            <a href="#form-section" class="px-3 py-1 bg-slate-600 text-white rounded hover:bg-slate-700">📋 Form</a>
            <a href="#captain-section" class="px-3 py-1 bg-pink-600 text-white rounded hover:bg-pink-700">🧑‍✈️ Captain</a>
            <a href="#members-section" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">👥 Members</a>
        </div>
    </div>

    <!-- Instructions -->
    <div class="skeleton-content">
        <div class="skeleton-instructions">
            <h3>How to use the Team Registration Skeleton Editor:</h3>
            <ul>
                <li><span style="color: #60a5fa;">Blue highlighted areas</span> are text content - click to edit text in multiple languages</li>
                <li><span style="color: #34d399;">Green highlighted areas</span> are images - click to upload new images</li>
                <li>Use the section navigation above to quickly jump to different parts of the page</li>
                <li>Changes are saved instantly and will update the live site</li>
                <li>Hover over any content to see its content key identifier</li>
                <li><strong>This skeleton shows the complete header, visuals, and form</strong> for team registration</li>
            </ul>
        </div>

        <!-- 1. HEADER SECTION -->
        <section id="header-section" class="bg-gradient-to-r from-red-900 to-red-800 text-white p-8 mb-8 rounded-lg border-l-4 border-red-500">
            <div class="section-header mb-6">
                <h2 class="text-2xl font-bold text-red-400 mb-2">🏆 HEADER</h2>
                <p class="text-gray-300 text-sm">Page title and navigation tabs</p>
            </div>

            <div class="text-center space-y-6">
                <div class="inline-block">
                    <h1 class="text-4xl font-bold px-8 py-4 bg-red-600 rounded-lg">
                        <span data-content-key="team_registration.header.title" 
                              data-content-type="text"
                              data-content-value="{{ optional($contents->get('team_registration.header.title'))->value ?? '{}' }}">
                            {{ content('team_registration.header.title', 'E-Sports') }}
                        </span>
                    </h1>
                </div>

                <!-- Navigation Tabs -->
                <div class="flex flex-wrap justify-center gap-4">
                    <div class="px-4 py-2 bg-gray-600 text-white rounded">
                        <span data-content-key="team_registration.tabs.tournament" 
                              data-content-type="text"
                              data-content-value="{{ optional($contents->get('team_registration.tabs.tournament'))->value ?? '{}' }}">
                            {{ content('team_registration.tabs.tournament', 'Tournament Registrations') }}
                        </span>
                    </div>
                    <div class="px-4 py-2 bg-red-600 text-white rounded font-bold">
                        <span data-content-key="team_registration.tabs.register" 
                              data-content-type="text"
                              data-content-value="{{ optional($contents->get('team_registration.tabs.register'))->value ?? '{}' }}">
                            {{ content('team_registration.tabs.register', 'Register – now') }}
                        </span>
                    </div>
                    <div class="px-3 py-1 bg-gray-600 text-white rounded text-sm">
                        <span data-content-key="team_registration.tabs.team" 
                              data-content-type="text"
                              data-content-value="{{ optional($contents->get('team_registration.tabs.team'))->value ?? '{}' }}">
                            {{ content('team_registration.tabs.team', 'Team') }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. VISUALS SECTION -->
        <section id="visuals-section" class="bg-gradient-to-r from-purple-900 to-purple-800 text-white p-8 mb-8 rounded-lg border-l-4 border-purple-500">
            <div class="section-header mb-6">
                <h2 class="text-2xl font-bold text-purple-300 mb-2">🖼️ VISUALS</h2>
                <p class="text-gray-300 text-sm">Update Phoenix artwork and team avatar</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Phoenix Image -->
                <div class="text-center bg-purple-700 p-6 rounded-lg border border-purple-600">
                    <div class="mb-4 font-medium text-purple-200">Phoenix Artwork</div>
                    <span data-content-key="team_registration.phoenix_image" 
                          data-content-type="image"
                          data-content-value="{{ optional($contents->get('team_registration.phoenix_image'))->value ?? '{}' }}"
                          data-image-url="{{ content_media('team_registration.phoenix_image', 'img/Phoenix.png') }}">
                        <img src="{{ content_media('team_registration.phoenix_image', 'img/Phoenix.png') }}" 
                             alt="Phoenix Image" 
                             class="w-full max-w-md mx-auto rounded border-4 border-green-500" />
                    </span>
                </div>
            </div>
        </section>

        <!-- 3. FORM SECTION -->
        <section id="form-section" class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-8 mb-8 rounded-lg border-l-4 border-slate-500">
            <div class="section-header mb-6">
                <h2 class="text-2xl font-bold text-slate-300 mb-2">📋 REGISTRATION FORM</h2>
                <p class="text-gray-300 text-sm">Full form labels and placeholders</p>
            </div>
            <div class="container mx-auto">
                <!-- Team Name Field -->
                <div class="mb-6 p-4 bg-slate-700/60 rounded border border-slate-600">
                    <label class="block text-sm font-medium mb-2">
                        <span data-content-key="team_registration.form.team_name" 
                              data-content-type="text"
                              data-content-value="{{ optional($contents->get('team_registration.form.team_name'))->value ?? '{}' }}">
                            {{ content('team_registration.form.team_name', 'Team Name') }}
                        </span>
                    </label>
                    <div class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded text-gray-300">
                        <span data-content-key="team_registration.form.team_name_placeholder" 
                              data-content-type="text"
                              data-content-value="{{ optional($contents->get('team_registration.form.team_name_placeholder'))->value ?? '{}' }}">
                            {{ content('team_registration.form.team_name_placeholder', 'Enter your team name') }}
                        </span>
                    </div>
                </div>

                <!-- Captain Information -->
                <div id="captain-section" class="mb-6 p-4 bg-slate-700/60 rounded border border-slate-600">
                    <h4 class="text-lg font-semibold mb-4 text-slate-200">Captain Information</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Captain Name -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                <span data-content-key="team_registration.form.captain_name" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.captain_name'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.captain_name', 'Captain\'s Name') }}
                                </span>
                            </label>
                            <div class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded text-gray-300">
                                <span data-content-key="team_registration.form.captain_name_placeholder" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.captain_name_placeholder'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.captain_name_placeholder', 'Enter captain\'s name') }}
                                </span>
                            </div>
                        </div>

                        <!-- Captain Logo (text label + upload placeholder) -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                <span data-content-key="team_registration.form.captain_logo" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.captain_logo'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.captain_logo', 'Captain\'s Logo') }}
                                </span>
                            </label>
                            <div class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded text-gray-300">
                                <span data-content-key="team_registration.form.upload_placeholder" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.upload_placeholder'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.upload_placeholder', 'Click to upload') }}
                                </span>
                            </div>
                        </div>

                        <!-- Captain Email -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                <span data-content-key="team_registration.form.captain_email" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.captain_email'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.captain_email', 'Captain\'s Email') }}
                                </span>
                            </label>
                            <div class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded text-gray-300">
                                <span data-content-key="team_registration.form.captain_email_placeholder" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.captain_email_placeholder'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.captain_email_placeholder', 'Enter captain\'s email') }}
                                </span>
                            </div>
                        </div>

                        <!-- Team Logo (text label + upload placeholder) -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                <span data-content-key="team_registration.form.team_logo" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.team_logo'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.team_logo', 'Team Logo') }}
                                </span>
                            </label>
                            <div class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded text-gray-300">
                                <span data-content-key="team_registration.form.upload_placeholder" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.upload_placeholder'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.upload_placeholder', 'Click to upload') }}
                                </span>
                            </div>
                        </div>

                        <!-- Captain Phone -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                <span data-content-key="team_registration.form.captain_phone" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.captain_phone'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.captain_phone', 'Captain\'s Phone') }}
                                </span>
                            </label>
                            <div class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded text-gray-300">
                                <span data-content-key="team_registration.form.captain_phone_placeholder" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.captain_phone_placeholder'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.captain_phone_placeholder', 'Enter captain\'s phone') }}
                                </span>
                            </div>
                        </div>

                        <!-- Game ID -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                <span data-content-key="team_registration.form.game_id" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.game_id'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.game_id', 'Game ID') }}
                                </span>
                            </label>
                            <div class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded text-gray-300">
                                <span data-content-key="team_registration.form.game_id_placeholder" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.game_id_placeholder'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.game_id_placeholder', 'Enter Game ID') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Members Section -->
                <div id="members-section" class="mb-6 p-4 bg-slate-700/60 rounded border border-slate-600">
                    <h4 class="text-lg font-semibold mb-4 text-slate-200">
                        <span data-content-key="team_registration.form.team_members" 
                              data-content-type="text"
                              data-content-value="{{ optional($contents->get('team_registration.form.team_members'))->value ?? '{}' }}">
                            {{ content('team_registration.form.team_members', 'Team Members') }}
                        </span>
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Member 1 -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                <span data-content-key="team_registration.form.member1" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.member1'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.member1', 'Member 1') }}
                                </span>
                            </label>
                            <div class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded text-gray-300">
                                <span data-content-key="team_registration.form.member1_placeholder" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.member1_placeholder'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.member1_placeholder', 'Enter member 1\'s name') }}
                                </span>
                            </div>
                        </div>

                        <!-- Member 2 -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                <span data-content-key="team_registration.form.member2" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.member2'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.member2', 'Member 2') }}
                                </span>
                            </label>
                            <div class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded text-gray-300">
                                <span data-content-key="team_registration.form.member2_placeholder" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.member2_placeholder'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.member2_placeholder', 'Enter member 2\'s name') }}
                                </span>
                            </div>
                        </div>

                        <!-- Member 3 -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                <span data-content-key="team_registration.form.member3" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.member3'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.member3', 'Member 3') }}
                                </span>
                            </label>
                            <div class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded text-gray-300">
                                <span data-content-key="team_registration.form.member3_placeholder" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.member3_placeholder'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.member3_placeholder', 'Enter member 3\'s name') }}
                                </span>
                            </div>
                        </div>

                        <!-- Member 4 -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                <span data-content-key="team_registration.form.member4" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.member4'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.member4', 'Member 4') }}
                                </span>
                            </label>
                            <div class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded text-gray-300">
                                <span data-content-key="team_registration.form.member4_placeholder" 
                                      data-content-type="text"
                                      data-content-value="{{ optional($contents->get('team_registration.form.member4_placeholder'))->value ?? '{}' }}">
                                    {{ content('team_registration.form.member4_placeholder', 'Enter member 4\'s name') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg">
                        <span data-content-key="team_registration.form.register_button" 
                              data-content-type="text"
                              data-content-value="{{ optional($contents->get('team_registration.form.register_button'))->value ?? '{}' }}">
                            {{ content('team_registration.form.register_button', 'Register Team') }}
                        </span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Completion Summary -->
        <div class="completion-summary bg-green-900/30 border border-green-700 rounded-lg p-6 text-center">
            <h3 class="text-xl font-bold text-green-400 mb-4">✅ Complete Team Registration Skeleton</h3>
            <p class="text-gray-300 mb-4">This skeleton includes a header, visuals, and a fully editable form:</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
                <div class="bg-red-800/30 px-3 py-2 rounded">🏆 Page Header</div>
                <div class="bg-purple-800/30 px-3 py-2 rounded">🖼️ Visuals</div>
                <div class="bg-slate-800/30 px-3 py-2 rounded">📋 Complete Form</div>
                <div class="bg-green-800/30 px-3 py-2 rounded">👥 Team Members</div>
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

<!-- Enhanced Scripts for Complete Skeleton -->
<script>
// Section navigation functionality
function scrollToSection() {
    const sections = [
        { id: 'header-section', name: '🏆 Header' },
        { id: 'visuals-section', name: '🖼️ Visuals' },
        { id: 'form-section', name: '📋 Form' },
        { id: 'captain-section', name: '🧑\u200d✈️ Captain' },
        { id: 'members-section', name: '👥 Members' }
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
