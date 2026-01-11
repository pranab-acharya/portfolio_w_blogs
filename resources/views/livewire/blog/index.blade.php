@section('title', 'Blog - ' . config('app.name'))

<div class="min-h-screen">
    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-gray-900/80 border-b border-gray-800/50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('blog.index') }}" class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 rounded-lg bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                    </div>
                    <h1
                        class="text-xl font-bold bg-gradient-to-r from-violet-400 to-fuchsia-400 bg-clip-text text-transparent">
                        {{ config('app.name', 'Blog') }}
                    </h1>
                </a>
                <nav class="flex items-center space-x-6">
                    <a href="{{ route('blog.index') }}"
                        class="text-gray-300 hover:text-violet-400 transition-colors duration-200 font-medium">
                        Blog
                    </a>
                    <a href="{{ route('about') }}"
                        class="text-gray-300 hover:text-violet-400 transition-colors duration-200 font-medium">
                        About
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Search and Filter Section -->
        <div class="mb-12 space-y-6">
            <!-- Search Bar -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Search posts by title, content, or excerpt..."
                    class="w-full pl-12 pr-4 py-4 bg-gray-900/50 border border-gray-800 rounded-2xl text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-200">
            </div>

            <!-- Tag Filter -->
            @if ($tags->count() > 0)
                <div class="bg-gray-900/30 border border-gray-800/50 rounded-2xl p-6 backdrop-blur-sm">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Filter by Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($tags as $tag)
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="checkbox" wire:model.live="selectedTags" value="{{ $tag->id }}"
                                    class="sr-only peer">
                                <span
                                    class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200
                                peer-checked:bg-gradient-to-r peer-checked:from-violet-600 peer-checked:to-fuchsia-600 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-violet-500/30
                                bg-gray-800 text-gray-300 hover:bg-gray-700 border border-gray-700 peer-checked:border-transparent">
                                    {{ $tag->name }}
                                    <span class="ml-1.5 text-xs opacity-75">({{ $tag->posts_count }})</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Posts Grid -->
        @if ($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach ($posts as $post)
                    <article wire:key="post-{{ $post->id }}" class="group">
                        <a href="{{ route('blog.show', $post->slug) }}" class="block">
                            <div
                                class="relative overflow-hidden rounded-2xl bg-gray-900/50 border border-gray-800 hover:border-violet-500/50 transition-all duration-300 hover:shadow-2xl hover:shadow-violet-500/20 hover:-translate-y-1">
                                <!-- Post Image -->
                                @if ($post->image)
                                    <div
                                        class="aspect-video overflow-hidden bg-gradient-to-br from-gray-800 to-gray-900">
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                @else
                                    <div
                                        class="aspect-video bg-gradient-to-br from-violet-600/20 to-fuchsia-600/20 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-700" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif

                                <!-- Post Content -->
                                <div class="p-6">
                                    <!-- Tags -->
                                    @if ($post->tags->count() > 0)
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            @foreach ($post->tags->take(2) as $tag)
                                                <span
                                                    class="px-2.5 py-1 text-xs font-medium rounded-full bg-violet-500/10 text-violet-400 border border-violet-500/20">
                                                    {{ $tag->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Title -->
                                    <h2
                                        class="text-xl font-bold text-gray-100 mb-3 line-clamp-2 group-hover:text-violet-400 transition-colors duration-200">
                                        {{ $post->title }}
                                    </h2>

                                    <!-- Excerpt -->
                                    <p class="text-gray-400 text-sm mb-4 line-clamp-3">
                                        {{ $post->excerpt }}
                                    </p>

                                    <!-- Meta Info -->
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <div class="flex items-center space-x-4">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                {{ $post->formatted_date }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                                    </path>
                                                </svg>
                                                {{ $post->approved_comments_count }}
                                            </span>
                                        </div>
                                        <span class="text-violet-400">{{ $post->reading_time }} min read</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-900/50 border border-gray-800 mb-6">
                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-300 mb-2">No posts found</h3>
                <p class="text-gray-500 mb-6">
                    @if ($search || $selectedTags)
                        Try adjusting your search or filter criteria
                    @else
                        Check back soon for new content
                    @endif
                </p>
                @if ($search || $selectedTags)
                    <button wire:click="$set('search', ''); $set('selectedTags', [])"
                        class="px-6 py-3 bg-violet-600 hover:bg-violet-700 text-white font-medium rounded-lg transition-colors duration-200">
                        Clear Filters
                    </button>
                @endif
            </div>
        @endif
    </main>
</div>
