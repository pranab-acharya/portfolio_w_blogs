<div>
    @if(!$parentId)
        <!-- Main Comment Form -->
        <div class="bg-gray-900/50 border border-gray-800 rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-gray-100 mb-6">Leave a Comment</h3>

            @if(session()->has('comment_success'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl flex items-start space-x-3">
                    <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="text-green-400 font-medium">{{ session('comment_success') }}</p>
                    </div>
                </div>
            @endif

            <form wire:submit="submitComment" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="guest_name" class="block text-sm font-medium text-gray-300 mb-2">
                            Name <span class="text-red-400">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="guest_name"
                            wire:model="guest_name"
                            class="w-full px-4 py-3 bg-gray-950/50 border border-gray-700 rounded-xl text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-200"
                            placeholder="Your name"
                        >
                        @error('guest_name')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="guest_email" class="block text-sm font-medium text-gray-300 mb-2">
                            Email <span class="text-red-400">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="guest_email"
                            wire:model="guest_email"
                            class="w-full px-4 py-3 bg-gray-950/50 border border-gray-700 rounded-xl text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-200"
                            placeholder="your@email.com"
                        >
                        @error('guest_email')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="comment" class="block text-sm font-medium text-gray-300 mb-2">
                        Comment <span class="text-red-400">*</span>
                    </label>
                    <textarea 
                        id="comment"
                        wire:model="comment"
                        rows="5"
                        class="w-full px-4 py-3 bg-gray-950/50 border border-gray-700 rounded-xl text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-200 resize-none"
                        placeholder="Share your thoughts..."
                    ></textarea>
                    @error('comment')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">Your comment will be reviewed before being published.</p>
                    <button 
                        type="submit"
                        wire:loading.attr="disabled"
                        class="px-6 py-3 bg-gradient-to-r from-violet-600 to-fuchsia-600 hover:from-violet-700 hover:to-fuchsia-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-violet-500/30 hover:shadow-violet-500/50 disabled:opacity-50 disabled:cursor-not-allowed flex items-center space-x-2"
                    >
                        <span wire:loading.remove>Post Comment</span>
                        <span wire:loading>
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    @else
        <!-- Reply Form -->
        <div>
            @if(!$showForm)
                <button 
                    wire:click="toggleForm"
                    class="text-sm font-medium text-violet-400 hover:text-violet-300 transition-colors duration-200 flex items-center space-x-1"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                    <span>Reply</span>
                </button>
            @else
                <div class="mt-4 bg-gray-950/50 border border-gray-700 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-semibold text-gray-300">Reply to this comment</h4>
                        <button 
                            wire:click="toggleForm"
                            class="text-gray-500 hover:text-gray-300 transition-colors duration-200"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="submitComment" class="space-y-3">
                        <div>
                            <input 
                                type="text" 
                                wire:model="guest_name"
                                class="w-full px-3 py-2 bg-gray-900 border border-gray-700 rounded-lg text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-200"
                                placeholder="Your name"
                            >
                            @error('guest_name')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <input 
                                type="email" 
                                wire:model="guest_email"
                                class="w-full px-3 py-2 bg-gray-900 border border-gray-700 rounded-lg text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-200"
                                placeholder="your@email.com"
                            >
                            @error('guest_email')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <textarea 
                                wire:model="comment"
                                rows="3"
                                class="w-full px-3 py-2 bg-gray-900 border border-gray-700 rounded-lg text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-200 resize-none"
                                placeholder="Write your reply..."
                            ></textarea>
                            @error('comment')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-2">
                            <button 
                                type="button"
                                wire:click="toggleForm"
                                class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-gray-200 transition-colors duration-200"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit"
                                wire:loading.attr="disabled"
                                class="px-4 py-2 bg-gradient-to-r from-violet-600 to-fuchsia-600 hover:from-violet-700 hover:to-fuchsia-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center space-x-2"
                            >
                                <span wire:loading.remove>Post Reply</span>
                                <span wire:loading class="flex items-center space-x-2">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>Posting...</span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    @endif
</div>
