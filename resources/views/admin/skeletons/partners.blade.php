@extends('admin.layout')

@section('title', 'Edit Partners Page - Skeleton View')

@section('content')
<div class="skeleton-editor">
    <!-- Mode Indicator -->
    <div class="skeleton-mode-indicator">
        🎨 SKELETON EDIT MODE
    </div>

    <!-- Header -->
    <div class="skeleton-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-white">Partners Page - Visual Editor</h1>
                <p class="text-sm text-gray-400">Click any content element to edit it inline</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.partners.index') }}"
                   class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">
                    Manage Partners
                </a>
                <a href="{{ route('partners') }}" 
                   class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700" 
                   target="_blank">
                    Preview Page
                </a>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    <div class="skeleton-content">
        <div class="skeleton-instructions">
            <h3>How to use the Skeleton Editor:</h3>
            <ul>
                <li><span style="color: #60a5fa;">Blue highlighted areas</span> are text content - click to edit text in multiple languages</li>
                <li><span style="color: #34d399;">Green highlighted areas</span> are images - click to upload new images</li>
                <li>Changes are saved instantly and will update the live site</li>
                <li>Hover over any content to see its content key identifier</li>
            </ul>
        </div>

        <!-- PARTNERS Section -->
        <section class="partners bg-gray-900 text-white p-8 rounded-lg">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold mb-8">
                    <span data-content-key="partners.header.text" 
                          data-content-type="text"
                          data-content-value="{{ $contents['partners.header.text']->value ?? '{}' }}">
                        {{ content('partners.header.text', 'E-Sports') }}
                    </span>
                </h1>
            </div>

            <!-- Section 1 - Partnership Benefits -->
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold mb-4">
                    <span data-content-key="partners.section1.title" 
                          data-content-type="text"
                          data-content-value="{{ $contents['partners.section1.title']->value ?? '{}' }}">
                        {{ content('partners.section1.title', 'Our Partnership Benefits') }}
                    </span>
                </h2>
                <p class="text-gray-400 text-lg max-w-3xl mx-auto"
                   data-content-key="partners.section1.text" 
                   data-content-type="text"
                   data-content-value="{{ $contents['partners.section1.text']->value ?? '{}' }}">
                    {{ content('partners.section1.text', 'Discover how partnering with us can elevate your brand and connect you with the esports community.') }}
                </p>
            </div>

            @php($partners = $partners ?? \App\Models\Partner::ordered()->get())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                @forelse($partners as $partner)
                    @php($canManagePartner = $partner instanceof \App\Models\Partner && $partner->exists)
                    <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition-all">
                        <div class="aspect-w-16 aspect-h-9 bg-gray-900/40">
                            @if($partner->media_type === 'video' && $partner->video_url)
                                <div class="relative pt-[56.25%]">
                                    <iframe class="absolute inset-0 w-full h-full"
                                            src="{{ $partner->video_url }}"
                                            frameborder="0"
                                            allow="autoplay; encrypted-media"
                                            allowfullscreen></iframe>
                                </div>
                            @elseif($partner->media_type === 'image' && $partner->image_path)
                                <img src="{{ asset($partner->image_path) }}"
                                     alt="{{ $partner->displayName(app()->getLocale()) }}"
                                     class="w-full h-48 object-cover" />
                            @else
                                <div class="flex items-center justify-center h-48 text-sm text-gray-400">
                                    Missing media
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-3 text-white">
                                {{ $partner->displayName(app()->getLocale()) ?: '—' }}
                            </h3>
                            <p class="text-gray-300 leading-relaxed mb-6">
                                {{ content('partners.intro.text', 'The Healing is fresh!!! can not wait to take my next session, really I feel so Energetic and I know care of the quality for my mental health and Happiness no matter what I face.') }}
                            </p>
                            
                            <div class="flex justify-end gap-2 text-sm">
                                @if($canManagePartner)
                                    <a href="{{ route('admin.partners.edit', $partner->getKey()) }}" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.partners.destroy', $partner->getKey()) }}" method="POST" onsubmit="return confirm('Delete this partner?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-500 italic">Preview mode</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-gray-800/60 border border-gray-700 rounded-lg p-6 text-center text-gray-300">
                        No partners found. Use the “Manage Partners” button above to add a partner.
                    </div>
                @endforelse
            </div>
            <!-- Partnership Call to Action -->
            <div class="text-center">
                <h3 class="text-xl font-semibold mb-4">
                    <span data-content-key="partners.cta.title" 
                          data-content-type="text"
                          data-content-value="{{ $contents['partners.cta.title']->value ?? '{}' }}">
                        {{ content('partners.cta.title', 'Ready to Partner With Us?') }}
                    </span>
                </h3>
                <p class="text-gray-400 mb-6 max-w-2xl mx-auto"
                   data-content-key="partners.cta.description" 
                   data-content-type="text"
                   data-content-value="{{ $contents['partners.cta.description']->value ?? '{}' }}">
                    {{ content('partners.cta.description', 'Join our growing network of partners and be part of the esports revolution. Contact us to discuss partnership opportunities.') }}
                </p>
                <button class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    <span data-content-key="partners.cta.button" 
                          data-content-type="text"
                          data-content-value="{{ $contents['partners.cta.button']->value ?? '{}' }}">
                        {{ content('partners.cta.button', 'Contact Us') }}
                    </span>
                </button>
            </div>
        </section>
    </div>
</div>

<!-- Include Modal -->
@include('admin.components.edit-modal')

<!-- Include Styles -->
@include('admin.components.skeleton-styles')

<!-- Include Scripts -->
@include('admin.components.skeleton-scripts')
@endsection
