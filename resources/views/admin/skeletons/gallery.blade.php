@extends('admin.layout')

@section('title', 'Edit Gallery Page - Skeleton View')

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
                <h1 class="text-xl font-semibold text-white">Gallery Page - Visual Editor</h1>
                <p class="text-sm text-gray-400">Click any content element to edit it inline. Cards below reflect live gallery items.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.gallery-items.index') }}"
                   class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">
                    🛠️ Manage Gallery
                </a>
                <a href="{{ route('gallery') }}" 
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

        <!-- GALLERY Section -->
        <section class="gallery bg-gray-900 text-white p-8 rounded-lg">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold">
                    <span data-content-key="gallery.header.title" 
                          data-content-type="text"
                          data-content-value="{{ $contents['gallery.header.title']->value ?? '{}' }}">
                        {{ content('gallery.header.title', 'Gallery') }}
                    </span>
                </h1>
                <p class="text-gray-400 mt-4"
                   data-content-key="gallery.header.subtitle" 
                   data-content-type="text"
                   data-content-value="{{ $contents['gallery.header.subtitle']->value ?? '{}' }}">
                    {{ content('gallery.header.subtitle', 'Explore our amazing esports moments and tournaments') }}
                </p>
            </div>

            <!-- Gallery Grid -->
            @php($items = \App\Models\GalleryItem::ordered()->get())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($items as $item)
                    <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700/70">
                        <div class="h-48 overflow-hidden">
                            @php($cardImage = $item->cardImageUrl())
                            <img
                                src="{{ $cardImage ?? asset('img/placeholder-gallery.jpg') }}"
                                alt="{{ $item->t('title', app()->getLocale()) }}"
                                class="w-full h-full object-cover"
                            />
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="flex items-center justify-between text-xs uppercase tracking-wide text-gray-400">
                                <span>{{ $item->sourceLabel() }}</span>
                                <span>#{{ $item->sort_order }}</span>
                            </div>
                            <h3 class="font-semibold text-white text-lg">
                                {{ $item->t('title', app()->getLocale()) }}
                            </h3>
                            <p class="text-sm text-gray-300">
                                {{ $item->excerpt(app()->getLocale(), 24) }}
                            </p>
                            <div class="flex items-center justify-between text-xs text-gray-400">
                                <span>{{ $item->is_published ? 'Published' : 'Hidden' }}</span>
                                <span>{{ optional($item->published_at)->format('M j, Y') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-gray-800/60 border border-dashed border-gray-600 rounded-lg p-6 text-center text-gray-300">
                        No gallery items yet. Use <strong>Manage Gallery</strong> to add your first entry.
                    </div>
                @endforelse
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
