@extends('admin.layout')

@section('title', 'Edit News Page - Skeleton View')

@section('content')
<div class="skeleton-editor">
    <!-- Mode Indicator -->
    <div class="skeleton-mode-indicator">
        🎨 SKELETON EDIT MODE - COMPLETE NEWS PAGE
    </div>

    <!-- Header -->
    <div class="skeleton-header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-white">News Page - Visual Editor (Complete)</h1>
                <p class="text-sm text-gray-400">Click any content element to edit it inline - live articles previewed from the database.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.news-articles.index') }}"
                   class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">
                    🛠️ Manage News
                </a>
                <a href="{{ route('news') }}" 
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
            <h3>How to use the Complete News Skeleton Editor:</h3>
            <ul>
                <li><span style="color: #60a5fa;">Blue highlighted areas</span> are text content - click to edit text in multiple languages</li>
                <li><span style="color: #34d399;">Green highlighted areas</span> are images - click to upload new images</li>
                <li><strong>The cards below pull directly from your News Articles CMS</strong> so you can preview real entries</li>
                <li>Changes are saved instantly and will update the live site</li>
                <li>Hover over any content to see its content key identifier</li>
            </ul>
        </div>

        <!-- NEWS PAGE HEADER -->
        <section id="news-header" class="bg-gradient-to-r from-orange-900 to-orange-800 text-white p-8 mb-8 rounded-lg border-l-4 border-orange-500">
            <div class="section-header mb-6">
                <h2 class="text-2xl font-bold text-orange-400 mb-2">📰 NEWS PAGE HEADER</h2>
                <p class="text-gray-300 text-sm">Main page title and category header</p>
            </div>
            
            <div class="text-center space-y-4">
                <div class="inline-block">
                    <h1 class="text-4xl font-bold px-8 py-4 bg-orange-600 rounded-lg">
                        <span data-content-key="news.header.main_title" 
                              data-content-type="text"
                              data-content-value="{{ $contents['news.header.main_title']->value ?? '{}' }}">
                            {{ content('news.header.main_title', 'E-Sports') }}
                        </span>
                    </h1>
                </div>
                
                <div class="inline-block">
                    <h2 class="text-2xl font-semibold px-6 py-3 bg-orange-700 rounded">
                        <span data-content-key="news.header.section_title" 
                              data-content-type="text"
                              data-content-value="{{ $contents['news.header.section_title']->value ?? '{}' }}">
                            {{ content('news.header.section_title', 'Our News') }}
                        </span>
                    </h2>
                </div>
            </div>
        </section>

        <!-- NEWS ARTICLES SECTION -->
        <section id="news-articles" class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-8 mb-8 rounded-lg border-l-4 border-slate-500">
            <div class="section-header mb-6">
                <h2 class="text-2xl font-bold text-slate-400 mb-2">📄 NEWS ARTICLES SECTION</h2>
                <p class="text-gray-300 text-sm">Dynamic preview of the articles published on the live news page.</p>
            </div>

            @php($articles = \App\Models\NewsArticle::ordered()->get())
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @forelse($articles as $a)
                    <div class="bg-slate-700 rounded-lg overflow-hidden border border-slate-600 flex">
                        <div class="flex-1 p-6">
                            <div class="mb-3">
                                <span class="text-sm text-slate-300 bg-slate-600 px-2 py-1 rounded">
                                    {{ optional($a->date)->format('F j, Y') }}
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-bold mb-4 text-white">
                                {{ $a->t('title', app()->getLocale()) }}
                            </h3>
                            
                            <p class="text-slate-300 text-sm leading-relaxed">
                                {{ \Illuminate\Support\Str::words($a->t('description', app()->getLocale()), 40) }}
                            </p>
                        </div>
                        
                        @if($a->image_path)
                            <div class="w-32 h-32 flex-shrink-0 m-4">
                                <img src="{{ $a->imageUrl() }}" 
                                     alt="{{ $a->t('title', app()->getLocale()) }}" 
                                     class="w-full h-full object-cover rounded border-2 border-green-400" />
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-slate-700/60 border border-dashed border-slate-500 rounded-lg p-6 text-center text-slate-300">
                            No news articles yet. Use <strong>Manage News</strong> to add your first article.
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- PAGINATION SECTION -->
        <section id="news-pagination" class="bg-gradient-to-r from-gray-900 to-gray-800 text-white p-8 mb-8 rounded-lg border-l-4 border-gray-500">
            <div class="section-header mb-6">
                <h2 class="text-2xl font-bold text-gray-400 mb-2">🎯 PAGINATION SECTION</h2>
                <p class="text-gray-300 text-sm">Navigation dots and arrow controls for news articles</p>
            </div>

            <div class="flex justify-center items-center space-x-8">
                <!-- Pagination Dots -->
                <div class="flex space-x-2">
                    <span class="w-3 h-3 bg-orange-500 rounded-full"></span>
                    <span class="w-3 h-3 bg-gray-600 rounded-full"></span>
                    <span class="w-3 h-3 bg-gray-600 rounded-full"></span>
                    <span class="w-3 h-3 bg-gray-600 rounded-full"></span>
                </div>

                <!-- Navigation Arrows -->
                <div class="flex space-x-4">
                    <button class="w-8 h-8 bg-gray-700 rounded flex items-center justify-center border border-gray-600">
                        <span class="text-white font-bold">&lt;</span>
                    </button>
                    <button class="w-8 h-8 bg-gray-700 rounded flex items-center justify-center border border-gray-600">
                        <span class="text-white font-bold">&gt;</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Completion Summary -->
        <div class="completion-summary bg-green-900/30 border border-green-700 rounded-lg p-6 text-center">
            <h3 class="text-xl font-bold text-green-400 mb-4">✅ Complete News Page Skeleton</h3>
            <p class="text-gray-300 mb-4">The news page skeleton includes:</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
                <div class="bg-orange-800/30 px-3 py-2 rounded">📰 Page Headers</div>
                <div class="bg-slate-800/30 px-3 py-2 rounded">📄 Dynamic Articles</div>
                <div class="bg-gray-800/30 px-3 py-2 rounded">🎯 Pagination Controls</div>
                <div class="bg-green-800/30 px-3 py-2 rounded">🖼️ Article Images</div>
            </div>
            <p class="text-gray-400 text-sm mt-4">
                Click any highlighted content to edit. Articles are managed via the News CMS module.
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
