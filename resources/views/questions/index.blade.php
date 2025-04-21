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
                    <div class="space-y-4">
                        @foreach($questions as $question)
                            <div class="border rounded-lg p-4 flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-medium">{{ $question->title }}</h3>
                                    <div class="mt-1 flex space-x-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $question->difficulty === 'easy' ? 'bg-green-100 text-green-800' : 
                                          ($question->difficulty === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($question->difficulty) }}
                                        </span>

                                        @php
                                            $progress = auth()->user()->progress->where('question_id', $question->id)->first();
                                        @endphp

                                        @if($progress && $progress->completed_at)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Completed ({{ $progress->score }}%)
                                            </span>
                                        @elseif($progress)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Attempted
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('solve.show', $question) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    {{ $progress ? 'Continue' : 'Start' }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>