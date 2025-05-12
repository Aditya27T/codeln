<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Coding Challenges') }}
            </h2>
            <form method="GET" action="{{ route('questions.index') }}" class="flex space-x-2 w-full max-w-xl">
                <div class="relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search challenges..." class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 pr-10">
                    <button type="submit" class="absolute right-3 top-3 text-gray-400 dark:text-gray-500">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-gray-100 via-white to-gray-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Difficulty level legend & View Switcher -->
            <div x-data="{ view: 'grid' }">
                <div class="mb-6 flex flex-wrap gap-4 bg-white dark:bg-gray-800 shadow-sm rounded-xl p-4 transition-colors duration-300">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter by Difficulty:</span>
                <form method="GET" action="{{ route('questions.index') }}" class="flex gap-2">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <button type="submit" name="level" value="easy" class="px-3 py-1 rounded-full text-xs font-medium border transition-all focus:outline-none {{ request('level') == 'easy' ? 'bg-green-600 text-white border-green-700' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 border-green-300 dark:border-green-700' }}">Easy</button>
                    <button type="submit" name="level" value="medium" class="px-3 py-1 rounded-full text-xs font-medium border transition-all focus:outline-none {{ request('level') == 'medium' ? 'bg-yellow-500 text-white border-yellow-700' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 border-yellow-300 dark:border-yellow-700' }}">Medium</button>
                    <button type="submit" name="level" value="hard" class="px-3 py-1 rounded-full text-xs font-medium border transition-all focus:outline-none {{ request('level') == 'hard' ? 'bg-red-600 text-white border-red-700' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 border-red-300 dark:border-red-700' }}">Hard</button>
                </form>
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
            
            <div :class="view === 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6' : 'flex flex-col gap-4'" x-bind:class="view === 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6' : 'flex flex-col gap-4'">
                @foreach($questions as $question)
                    @php
                        $progress = auth()->user()->progress->where('question_id', $question->id)->first();
                        $isDone = $progress && $progress->completed_at;
                        $isAttempt = $progress && !$progress->completed_at;
                        $score = $progress->score ?? 0;
                        $levelIcon = $question->difficulty === 'easy' ? '🟢' : ($question->difficulty === 'medium' ? '🟡' : '🔴');
                        $difficultyClass = 'challenge-difficulty-' . $question->difficulty;
                    @endphp
                    
                    <div class="challenge-card {{ $difficultyClass }} bg-white dark:bg-gray-800 dark:border-gray-700 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 group" data-difficulty="{{ $question->difficulty }}">
                        <!-- Card Header with Animated Pattern -->
                        <div class="card-header {{ $question->difficulty === 'easy' ? 'bg-gradient-to-r from-green-500 to-emerald-600' : 
                                               ($question->difficulty === 'medium' ? 'bg-gradient-to-r from-yellow-500 to-amber-600' : 
                                               'bg-gradient-to-r from-red-500 to-rose-600') }} animated-gradient relative">
                            <div class="card-header-pattern"></div>
                            <div class="absolute top-3 right-4 card-icon">
                                <span class="text-2xl">{!! $levelIcon !!}</span>
                            </div>
                            <h3 class="text-white text-lg font-bold leading-tight drop-shadow relative z-10">{{ $question->title }}</h3>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-semibold
                                {{ $question->difficulty === 'easy' ? 'bg-green-100 text-green-800' :
                                   ($question->difficulty === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}
                                dark:{{ $question->difficulty === 'easy' ? 'bg-green-900 text-green-100' :
                                   ($question->difficulty === 'medium' ? 'bg-yellow-900 text-yellow-100' : 'bg-red-900 text-red-100') }} relative z-10">
                                {{ ucfirst($question->difficulty) }}
                            </span>
                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col gap-2">
                            <div class="text-sm text-gray-600 dark:text-gray-300 mb-1 min-h-[36px]">
                                {{ Str::limit(strip_tags($question->description), 80) }}
                            </div>
                            <div class="flex items-center gap-2 mb-2">
                                @if($isDone)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle mr-1"></i> Completed
                                    </span>
                                @elseif($isAttempt)
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock mr-1"></i> In Progress
                                    </span>
                                @else
                                    <span class="badge badge-primary">
                                        <i class="fas fa-circle-notch mr-1"></i> Not Started
                                    </span>
                                @endif
                                @if($isDone)
                                    <span class="badge badge-primary">
                                        <i class="fas fa-star mr-1"></i> Score: {{ $score }}%
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="progress-bar">
                                <div class="progress-value" style="width: {{ $isDone ? $score : ($isAttempt ? 40 : 0) }}%;"></div>
                            </div>
                            
                            <!-- Stats/Info Row -->
                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1 mb-2">
                                <span>
                                    <i class="fas fa-users mr-1"></i> {{ rand(50, 500) }} attempts
                                </span>
                                <span>
                                    <i class="fas fa-code mr-1"></i> {{ rand(3, 8) }} languages
                                </span>
                            </div>
                            
                            <!-- Action Button -->
                            <div class="flex justify-between items-center mt-2">
                                @if($isDone)
                                    <button class="btn btn-secondary w-1/2" disabled>
                                        <i class="fas fa-check-circle mr-1"></i> Completed
                                    </button>
                                    <a href="{{ route('solve.show', $question) }}" class="btn btn-primary w-1/2 ml-2">
                                        <i class="fas fa-redo mr-1"></i> Retry
                                    </a>
                                @elseif($isAttempt)
                                    <a href="{{ route('solve.show', $question) }}" class="btn btn-warning w-full text-center">
                                        <i class="fas fa-play mr-1"></i> Continue
                                    </a>
                                @else
                                    <a href="{{ route('solve.show', $question) }}" class="btn btn-primary w-full text-center">
                                        <i class="fas fa-code mr-1"></i> Start Challenge
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- No challenges fallback -->
            @if(count($questions) === 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl p-8 text-center shadow-sm">
                    <div class="text-6xl mb-4 text-gray-300 dark:text-gray-600">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">No challenges available yet</h3>
                    <p class="text-gray-500 dark:text-gray-400">Check back later for new coding challenges.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>