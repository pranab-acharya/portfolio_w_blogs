@section('title', 'About - ' . config('app.name'))

<div class="min-h-screen">
    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-gray-900/80 border-b border-gray-800/50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('blog.index') }}" class="flex items-center space-x-3">
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
                    <a href="{{ route('about') }}" class="text-violet-400 font-medium">
                        About
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($about)
            <div class="space-y-8">
                <!-- Profile Section -->
                <div class="bg-gray-900/30 border border-gray-800/50 rounded-3xl overflow-hidden backdrop-blur-sm">
                    <div class="p-8 md:p-12">
                        <div class="flex flex-col md:flex-row gap-8 items-start">
                            <!-- Profile Image -->
                            <div class="flex-shrink-0">
                                @if($about->image)
                                    <img 
                                        src="{{ asset('storage/' . $about->image) }}" 
                                        alt="{{ $about->name }}"
                                        class="w-48 h-48 rounded-2xl object-cover border-2 border-gray-800"
                                    >
                                @else
                                    <div class="w-48 h-48 rounded-2xl bg-gradient-to-br from-violet-600/20 to-fuchsia-600/20 flex items-center justify-center border-2 border-gray-800">
                                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center text-white text-5xl font-bold">
                                            {{ strtoupper(substr($about->name, 0, 1)) }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Profile Info -->
                            <div class="flex-1">
                                <h1 class="text-4xl md:text-5xl font-bold text-gray-100 mb-2">{{ $about->name }}</h1>
                                
                                @if($about->profession)
                                    <p class="text-xl text-violet-400 font-medium mb-6">{{ $about->profession }}</p>
                                @endif

                                @if($about->bio)
                                    <div class="prose prose-lg prose-invert max-w-none prose-headings:text-gray-100 prose-p:text-gray-300 prose-a:text-violet-400 prose-strong:text-gray-200 mb-6">
                                        {!! $about->bio !!}
                                    </div>
                                @endif

                                <!-- Contact Info -->
                                @if($about->email || $about->phone)
                                    <div class="flex flex-wrap gap-4 mb-6">
                                        @if($about->email)
                                            <a href="mailto:{{ $about->email }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-gray-800/50 hover:bg-gray-700 border border-gray-700 hover:border-violet-500/50 rounded-lg transition-all duration-200">
                                                <svg class="w-5 h-5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                <span class="text-gray-300">{{ $about->email }}</span>
                                            </a>
                                        @endif

                                        @if($about->phone)
                                            <a href="tel:{{ $about->phone }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-gray-800/50 hover:bg-gray-700 border border-gray-700 hover:border-violet-500/50 rounded-lg transition-all duration-200">
                                                <svg class="w-5 h-5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                                <span class="text-gray-300">{{ $about->phone }}</span>
                                            </a>
                                        @endif
                                    </div>
                                @endif

                                <!-- Social Links -->
                                @if($about->social_links && is_array($about->social_links) && count($about->social_links) > 0)
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($about->social_links as $social)
                                            @if(isset($social['platform']) && isset($social['url']))
                                                <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" 
                                                   class="inline-flex items-center space-x-2 px-4 py-2 bg-gray-800/50 hover:bg-violet-600 border border-gray-700 hover:border-violet-500 rounded-lg transition-all duration-200 group">
                                                    @if(strtolower($social['platform']) === 'github')
                                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                                        </svg>
                                                    @elseif(strtolower($social['platform']) === 'twitter' || strtolower($social['platform']) === 'x')
                                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                                        </svg>
                                                    @elseif(strtolower($social['platform']) === 'linkedin')
                                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                        </svg>
                                                    @endif
                                                    <span class="text-gray-300 group-hover:text-white capitalize transition-colors">{{ $social['platform'] }}</span>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- No About Info -->
            <div class="bg-gray-900/30 border border-gray-800/50 rounded-3xl overflow-hidden backdrop-blur-sm p-12 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-900/50 border border-gray-800 mb-6">
                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-300 mb-2">About Information Not Available</h2>
                <p class="text-gray-500 mb-6">
                    Please add about information in the admin panel.
                </p>
                <a href="/admin/abouts" class="inline-flex items-center px-6 py-3 bg-violet-600 hover:bg-violet-700 text-white font-medium rounded-lg transition-colors duration-200">
                    Add About Info
                </a>
            </div>
        @endif
    </main>
</div>
