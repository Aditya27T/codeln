<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $question->title }} - Results
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">Your Score</h3>
                        <div class="text-4xl font-bold {{ $score === 100 ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ $score }}%
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">Status</h3>
                        @if($allTestsPassed)
                            <div class="bg-green-100 text-green-800 p-4 rounded-lg">
                                <p class="font-medium">All tests passed successfully!</p>
                            </div>
                        @else
                            <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg">
                                <p class="font-medium">Some tests failed. Check the output below.</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">Test Output</h3>
                        <pre class="bg-gray-100 p-4 rounded-lg overflow-x-auto whitespace-pre-wrap">{{ $output }}</pre>
                    </div>
                    
                    <div class="flex justify-between">
                        <a href="{{ route('solve.show', $question) }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                            Back to Editor
                        </a>
                        <a href="{{ route('questions.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            All Challenges
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>