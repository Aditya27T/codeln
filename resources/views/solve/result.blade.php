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
                        <div class="mt-2 text-sm text-gray-500">
                            Passed {{ $passedTests ?? 0 }} of {{ $totalTests ?? 0 }} test cases
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">Status</h3>
                        @if($allTestsPassed)
                            <div class="bg-green-100 text-green-800 p-4 rounded-lg">
                                <p class="font-medium">Congratulations! All tests passed successfully!</p>
                                <p class="mt-1">Your solution works correctly for all test cases.</p>
                            </div>
                        @else
                            <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg">
                                <p class="font-medium">Some tests failed. Check the output below for details.</p>
                                <p class="mt-1">Keep trying! You're making progress.</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">Test Results</h3>
                        
                        @if(isset($results))
                            <div class="space-y-4">
                                @foreach($results as $index => $result)
                                    <div class="border rounded-lg overflow-hidden">
                                        <div class="px-4 py-2 bg-gray-100 border-b flex justify-between items-center">
                                            <div class="font-semibold">Test Case #{{ $index + 1 }}</div>
                                            <div class="px-2 py-1 rounded-full text-xs {{ $result['passed'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $result['passed'] ? 'PASSED' : 'FAILED' }}
                                            </div>
                                        </div>
                                        <div class="p-4 space-y-2">
                                            <div>
                                                <div class="text-sm font-medium text-gray-500">Input:</div>
                                                <pre class="bg-gray-50 p-2 rounded text-sm font-mono">{{ $result['test_case']['input'] ?? 'N/A' }}</pre>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-500">Expected:</div>
                                                <pre class="bg-gray-50 p-2 rounded text-sm font-mono">{{ $result['test_case']['expected'] ?? 'N/A' }}</pre>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-500">Your Output:</div>
                                                <pre class="bg-gray-50 p-2 rounded text-sm font-mono">{{ $result['output'] ?? 'N/A' }}</pre>
                                            </div>
                                            @if($result['error'])
                                                <div>
                                                    <div class="text-sm font-medium text-red-500">Error:</div>
                                                    <pre class="bg-red-50 p-2 rounded text-sm font-mono text-red-800">{{ $result['error'] }}</pre>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <pre class="bg-gray-100 p-4 rounded-lg overflow-x-auto whitespace-pre-wrap">{{ $output }}</pre>
                        @endif
                    </div>
                    
                    <div class="flex justify-between">
                        <a href="{{ route('solve.show', $question) }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Editor
                        </a>
                        
                        <div class="space-x-2">
                            @if($allTestsPassed)
                                <a href="{{ route('questions.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                                    <i class="fas fa-list mr-1"></i> All Challenges
                                </a>
                            @else
                                <button onclick="showHintModal()" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                    <i class="fas fa-lightbulb mr-1"></i> Get a Hint
                                </button>
                                <a href="{{ route('solve.show', $question) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    <i class="fas fa-code mr-1"></i> Try Again
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Hint Modal (hidden by default) -->
    <div id="hintModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 max-w-lg w-full">
            <h3 class="text-xl font-bold mb-4">Hint</h3>
            <div class="mb-4">
                <p class="text-gray-600">Here are some tips to help you solve this challenge:</p>
                <ul class="list-disc pl-5 mt-2 space-y-1">
                    <li>Check your output format carefully - spaces, line breaks, and case sensitivity matter</li>
                    <li>Make sure you're handling edge cases properly</li>
                    <li>Review the problem statement to ensure you understand all requirements</li>
                    <li>Try a simpler approach if you're overcomplicating things</li>
                </ul>
            </div>
            <div class="flex justify-end">
                <button onclick="hideHintModal()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Got it!
                </button>
            </div>
        </div>
    </div>
    
    <script>
        function showHintModal() {
            document.getElementById('hintModal').classList.remove('hidden');
        }
        
        function hideHintModal() {
            document.getElementById('hintModal').classList.add('hidden');
        }
    </script>
</x-app-layout>