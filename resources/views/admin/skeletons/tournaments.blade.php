@extends('admin.layout')

@section('title', 'Edit Tournaments Page - Skeleton View')

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
                <h1 class="text-xl font-semibold text-white">Tournaments Page - Visual Editor</h1>
                <p class="text-sm text-gray-400">Click any content element to edit it inline</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.tournament-cards.index') }}"
                   class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">
                    Manage Cards
                </a>
                <a href="{{ route('tournaments') }}" 
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

        <!-- TOURNAMENTS Section -->
        <section class="tournaments bg-gray-900 text-white p-8 rounded-lg">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold mb-4">
                    <span data-content-key="tournaments.header.title" 
                          data-content-type="text"
                          data-content-value="{{ $contents['tournaments.header.title']->value ?? '{}' }}">
                        {{ content('tournaments.header.title', 'E-Sports') }}
                    </span>
                </h1>
                
                <div class="inline-block bg-gray-700 px-4 py-2 rounded-full text-sm">
                    <span data-content-key="tournaments.our_tournament" 
                          data-content-type="text"
                          data-content-value="{{ $contents['tournaments.our_tournament']->value ?? '{}' }}">
                        {{ content('tournaments.our_tournament', 'Our Tournament') }}
                    </span>
                </div>
            </div>

            <!-- Tournament Cards Grid -->
            @php($cards = $cards ?? \App\Models\TournamentCard::ordered()->get())

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($cards as $card)
                    <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition-all">
                        <div class="aspect-w-16 aspect-h-9">
                            <img src="{{ $card->imageUrl() ?? content_media('tournaments.card.image', 'img/tournaments-inner.png') }}"
                                 alt="{{ $card->titleFor(app()->getLocale()) ?: 'Tournament card' }}"
                                 class="w-full h-48 object-cover">
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-4">
                                {{ $card->titleFor(app()->getLocale()) ?: 'Untitled Tournament' }}
                            </h3>

                            <div class="space-y-2 mb-4 text-sm text-gray-400">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M7 2v3M17 2v3M3 9h18M5 6h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"/>
                                    </svg>
                                    <div class="leading-tight">
                                        <div>{{ __('Start:') }} {{ $card->date?->format('d/m/Y') ?? '--' }}</div>
                                        <div>{{ __('End:') }} {{ $card->end_date?->format('d/m/Y') ?? '--' }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v5l3 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                                    </svg>
                                    <span>{{ $card->time ?: '--' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center gap-2 text-xs uppercase tracking-wide px-2 py-1 rounded bg-gray-700 text-gray-200">
                                    {{ strtoupper($card->status ?? 'open') }}
                                </span>
                                <div class="flex items-center gap-2 text-green-400">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 21h8M12 17v4M5 3h14v2a4 4 0 0 1-4 4h-1a4 4 0 0 1-3 4v0H9v0a4 4 0 0 1-3-4H7A4 4 0 0 1 3 5V3h2z"/>
                                    </svg>
                                    <span class="font-bold text-sm">{{ $card->prize ?: '--' }}</span>
                                </div>
                            </div>

                            @if($card->status === 'open')
                                <a href="{{ $card->register_url ?: route('tours-reg') }}"
                                   class="block w-full bg-red-600 hover:bg-red-700 text-white text-center py-3 rounded-md font-semibold transition-colors">
                                    {{ content('tournaments.card.register', 'REGISTER') }}
                                </a>
                            @elseif($card->status === 'finished')
                                <a href="{{ route('winners.show', $card->slug) }}"
                                   class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white text-center py-3 rounded-md font-semibold transition-colors">
                                    {{ content('tournaments.card.winner', 'Winner') }}
                                </a>
                            @else
                                <span
                                    class="block w-full bg-gray-700 text-gray-300 text-center py-3 rounded-md font-semibold">
                                    {{ content('tournaments.card.closed', 'Closed') }}
                                </span>
                            @endif

                            <div class="mt-3 flex justify-end gap-2 text-sm">
                                <a href="{{ route('admin.tournament-cards.edit', $card) }}"
                                   class="px-3 py-1 bg-blue-700 text-white rounded hover:bg-blue-800">
                                    Edit
                                </a>
                                <form action="{{ route('admin.tournament-cards.destroy', $card) }}" method="POST" onsubmit="return confirm('Delete this card?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-700 text-white rounded hover:bg-red-800">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-gray-800/60 rounded-lg border border-gray-700">
                        <p class="text-gray-300 mb-4">No tournament cards yet.</p>
                        <a href="{{ route('admin.tournament-cards.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
                            Create your first card
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Additional Tournament Content -->
            <div class="mt-12 text-center">
                <h2 class="text-2xl font-bold mb-4">
                    <span data-content-key="tournaments.section.additional_title" 
                          data-content-type="text"
                          data-content-value="{{ $contents['tournaments.section.additional_title']->value ?? '{}' }}">
                        {{ content('tournaments.section.additional_title', 'More Tournaments Coming Soon') }}
                    </span>
                </h2>
                
                <p class="text-gray-400 max-w-2xl mx-auto"
                   data-content-key="tournaments.section.additional_description" 
                   data-content-type="text"
                   data-content-value="{{ $contents['tournaments.section.additional_description']->value ?? '{}' }}">
                    {{ content('tournaments.section.additional_description', 'Stay tuned for more exciting tournaments and competitions. Join our community and never miss an opportunity to compete.') }}
                </p>
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
