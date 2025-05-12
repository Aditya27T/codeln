<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ __('Learning Materials') }}
            </h2>
            <form method="GET" action="{{ route('materials.index') }}" class="relative">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search materials..." class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 pr-10">
    <button type="submit" class="absolute right-3 top-3 text-gray-400 dark:text-gray-500">
        <i class="fas fa-search"></i>
    </button>
</form>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-100 via-white to-gray-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- View Switcher Only -->
            <div x-data="{ view: 'grid' }">
                <div class="mb-6 flex flex-wrap gap-3 justify-center bg-white dark:bg-gray-800 shadow-sm rounded-xl p-4 transition-colors duration-300">
                    
                    <div class="ml-auto flex items-center">
                        <span class="text-sm text-gray-500 dark:text-gray-400 mr-2">View:</span>
                        <button class="p-1 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400" title="Grid View" @click="view = 'grid'" :class="view === 'grid' ? 'text-indigo-600 dark:text-indigo-400' : ''">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button class="p-1 ml-1 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400" title="List View" @click="view = 'list'" :class="view === 'list' ? 'text-indigo-600 dark:text-indigo-400' : ''">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            
            @if($materials->count())
                <div :class="view === 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8' : 'flex flex-col gap-4'" x-bind:class="view === 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8' : 'flex flex-col gap-4'">
                    @foreach($materials as $material)
                        <div class="material-card enhanced-card group bg-white dark:bg-gray-800 border border-transparent dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600">
                            <!-- Card header with animated pattern -->
                            <div class="bg-gradient-to-tr from-indigo-500 to-purple-500 p-5 h-36 flex flex-col justify-end relative overflow-hidden">
                                <!-- Pattern & Icon -->
                                <div class="card-header-pattern"></div>
                                <div class="absolute top-4 right-4 material-icon transform transition-all duration-300">
                                    <span class="inline-block bg-white bg-opacity-30 dark:bg-opacity-20 rounded-full p-2">
                                        <svg class="w-6 h-6 text-white opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20l9 2-7-7 7-7-9 2-2-9-2 9-9-2 7 7-7 7 9-2z"/>
                                        </svg>
                                    </span>
                                </div>
                                
                                <!-- Title and Category -->
                                <h3 class="text-white text-xl font-bold leading-tight drop-shadow relative z-10">
                                    {{ $material->title }}
                                </h3>
                                <p class="text-white text-sm opacity-80 relative z-10">{{ $material->category ?? 'General' }}</p>
                            </div>
                            
                            <!-- Card Body -->
                            <div class="p-5 flex flex-col gap-2">
                                <div class="min-h-[80px]">
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">
                                        {{ Str::limit(strip_tags($material->content), 120) }}
                                    </p>
                                </div>
                                
                                <!-- Progress Section -->
                                @php
                                    // Dummy: replace with real logic from your app
                                    $progress = auth()->user()->material_progress[$material->id] ?? null;
                                    $isDone = $progress && $progress['completed'] ?? false;
                                    $progressPercent = $progress['percent'] ?? 0;
                                    $chapters = $material->chapters_count ?? rand(1, 5);
                                @endphp
                                
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        @if($isDone)
                                            <span class="badge badge-success">Completed</span>
                                        @elseif($progressPercent > 0)
                                            <span class="badge badge-warning">In Progress</span>
                                        @else
                                            <span class="badge badge-primary">Not Started</span>
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-400 dark:text-gray-500">{{ $chapters }} Chapter(s)</span>
                                </div>
                                
                                <!-- Progress bar -->
                                @if($chapters > 1)
                                    <div class="progress-bar">
                                        <div class="progress-value" style="width: {{ $progressPercent }}%;"></div>
                                    </div>
                                @endif
                                
                                <!-- Stats row -->
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1 mb-2">
                                    <span>
                                        <i class="fas fa-users mr-1"></i> {{ rand(20, 200) }} learners
                                    </span>
                                    <span>
                                        <i class="fas fa-clock mr-1"></i> {{ rand(10, 60) }} min read
                                    </span>
                                </div>
                                
                                <!-- Action Button -->
                                <div class="flex justify-between items-center mt-2">
                                    <a href="{{ route('materials.show', $material) }}" class="btn btn-primary w-full text-center">
                                        @if($isDone)
                                            <i class="fas fa-redo mr-1"></i> Review
                                        @elseif($progressPercent > 0)
                                            <i class="fas fa-play mr-1"></i> Continue
                                        @else
                                            <i class="fas fa-book-open mr-1"></i> Start Learning
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow text-gray-600 dark:text-gray-300 text-center">
                    <div class="text-6xl mb-4 text-gray-300 dark:text-gray-600">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">No materials available yet</h3>
                    <p class="text-gray-500 dark:text-gray-400">Check back later for new learning materials.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
