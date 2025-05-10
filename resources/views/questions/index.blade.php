<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Coding Challenges') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($questions as $question)
                            @php
                                $progress = auth()->user()->progress->where('question_id', $question->id)->first();
                                $isDone = $progress && $progress->completed_at;
                                $isAttempt = $progress && !$progress->completed_at;
                                $score = $progress->score ?? 0;
                                $levelIcon = $question->difficulty === 'easy' ? '🟢' : ($question->difficulty === 'medium' ? '🟡' : '🔴');
                            @endphp
                            <div class="rounded-2xl shadow-md overflow-hidden bg-white hover:shadow-xl hover:-translate-y-1 transition group border border-transparent hover:border-indigo-400 flex flex-col h-full">
                                <div class="bg-gradient-to-tr from-indigo-500 to-purple-500 p-5 h-28 flex flex-col justify-end relative">
                                    <div class="absolute top-3 right-4 text-2xl">{!! $levelIcon !!}</div>
                                    <h3 class="text-white text-lg font-bold leading-tight drop-shadow">{{ $question->title }}</h3>
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ $question->difficulty === 'easy' ? 'bg-green-100 text-green-800' :
                                           ($question->difficulty === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($question->difficulty) }}
                                    </span>
                                </div>
                                <div class="p-5 flex-1 flex flex-col gap-2">
                                    <div class="text-sm text-gray-600 mb-1 min-h-[36px]">
                                        {{ Str::limit(strip_tags($question->description), 80) }}
                                    </div>
                                    <div class="flex items-center gap-2 mb-2">
                                        @if($isDone)
                                            <span class="inline-block bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">Completed</span>
                                        @elseif($isAttempt)
                                            <span class="inline-block bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-xs font-semibold">Attempted</span>
                                        @else
                                            <span class="inline-block bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full text-xs font-semibold">Not started</span>
                                        @endif
                                        @if($isDone)
                                            <span class="inline-block bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-semibold">Score: {{ $score }}%</span>
                                        @endif
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                        <div class="bg-indigo-500 h-2 rounded-full transition-all duration-500" style="width: {{ $isDone ? $score : ($isAttempt ? 40 : 0) }}%;"></div>
                                    </div>
                                    <div class="flex justify-between items-center mt-2">
                                        @if($isDone)
                                            <button class="bg-green-200 text-green-700 px-4 py-2 rounded cursor-not-allowed w-full" disabled>Completed</button>
                                        @elseif($isAttempt)
                                            <a href="{{ route('solve.show', $question) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 w-full text-center">Continue</a>
                                        @else
                                            <a href="{{ route('solve.show', $question) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full text-center">Start</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>