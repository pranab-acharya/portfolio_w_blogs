@section('title', $post->title . ' - ' . config('app.name'))

<div class="min-h-screen">
    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-gray-900/80 border-b border-gray-800/50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('blog.index') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold bg-gradient-to-r from-violet-400 to-fuchsia-400 bg-clip-text text-transparent">
                        {{ config('app.name', 'Blog') }}
                    </h1>
                </a>
                <nav class="flex items-center space-x-6">
                    <a href="{{ route('blog.index') }}" class="text-gray-300 hover:text-violet-400 transition-colors duration-200 font-medium">
                        Blog
                    </a>
                    <a href="{{ route('about') }}" class="text-gray-300 hover:text-violet-400 transition-colors duration-200 font-medium">
                        About
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Back Button -->
        <a href="{{ route('blog.index') }}" class="inline-flex items-center text-gray-400 hover:text-violet-400 transition-colors duration-200 mb-8 group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to all posts
        </a>

        <!-- Post Article -->
        <article class="bg-gray-900/30 border border-gray-800/50 rounded-3xl overflow-hidden backdrop-blur-sm">
            <!-- Hero Image -->
            @if($post->image)
                <div class="aspect-[21/9] overflow-hidden bg-gradient-to-br from-gray-800 to-gray-900">
                    <img 
                        src="{{ asset('storage/' . $post->image) }}" 
                        alt="{{ $post->title }}"
                        class="w-full h-full object-cover"
                    >
                </div>
            @endif

            <!-- Post Content -->
            <div class="p-8 md:p-12">
                <!-- Post Meta -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400 mb-6">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $post->formatted_date }}
                    </span>
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        {{ $post->reading_time }} min read
                    </span>
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        {{ $post->comments->count() }} {{ Str::plural('comment', $post->comments->count()) }}
                    </span>
                </div>

                <!-- Tags -->
                @if($post->tags->count() > 0)
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach($post->tags as $tag)
                            <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-violet-500/10 text-violet-400 border border-violet-500/20">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <!-- Post Title -->
                <h1 class="text-4xl md:text-5xl font-bold text-gray-100 mb-6 leading-tight">
                    {{ $post->title }}
                </h1>

                <!-- Post Excerpt -->
                <p class="text-xl text-gray-300 mb-8 leading-relaxed font-serif">
                    {{ $post->excerpt }}
                </p>

                <!-- Post Content -->
                <div class="prose prose-lg prose-invert max-w-none prose-headings:text-gray-100 prose-p:text-gray-300 prose-a:text-violet-400 prose-strong:text-gray-200 prose-code:text-violet-400 prose-pre:bg-gray-950 prose-pre:border prose-pre:border-gray-800 font-serif">
                    {!! $post->content !!}
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <div class="mt-12">
            <h2 class="text-3xl font-bold text-gray-100 mb-8 flex items-center">
                <svg class="w-8 h-8 mr-3 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                Comments ({{ $post->comments->count() }})
            </h2>

            <!-- Comment Form -->
            <div class="mb-12">
                <livewire:blog.comment-form :post-id="$post->id" :key="'main-comment-form'" />
            </div>

            <!-- Comments List -->
            @if($post->comments->count() > 0)
                <div class="space-y-6">
                    @foreach($post->comments as $comment)
                        <div class="bg-gray-900/30 border border-gray-800/50 rounded-2xl p-6 backdrop-blur-sm">
                            <!-- Comment Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($comment->guest_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-200">{{ $comment->guest_name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $comment->formatted_date }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Comment Content -->
                            <p class="text-gray-300 mb-4 leading-relaxed">{{ $comment->comment }}</p>

                            <!-- Reply Button -->
                            <div class="flex items-center">
                                <livewire:blog.comment-form :post-id="$post->id" :parent-id="$comment->id" :key="'reply-form-' . $comment->id" />
                            </div>

                            <!-- Nested Replies -->
                            @if($comment->replies->count() > 0)
                                <div class="mt-6 ml-8 space-y-4 border-l-2 border-violet-500/20 pl-6">
                                    @foreach($comment->replies as $reply)
                                        <div class="bg-gray-950/50 rounded-xl p-4">
                                            <!-- Reply Header -->
                                            <div class="flex items-start justify-between mb-3">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-fuchsia-500 to-violet-500 flex items-center justify-center text-white font-bold text-xs">
                                                        {{ strtoupper(substr($reply->guest_name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <h5 class="font-semibold text-gray-200 text-sm">{{ $reply->guest_name }}</h5>
                                                        <p class="text-xs text-gray-500">{{ $reply->formatted_date }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Reply Content -->
                                            <p class="text-gray-300 text-sm leading-relaxed">{{ $reply->comment }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-900/20 border border-gray-800/50 rounded-2xl">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-900/50 border border-gray-800 mb-4">
                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-400">No comments yet. Be the first to share your thoughts!</p>
                </div>
            @endif
        </div>
    </main>
</div>
