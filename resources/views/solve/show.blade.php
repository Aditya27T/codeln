<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $question->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Problem description -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4">Problem Description</h3>
                    <div class="prose max-w-none">
                        {!! $question->description !!}
                    </div>
                    
                    <div class="mt-4 space-y-2">
                    <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2">Difficulty</h4>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $question->difficulty === 'easy' ? 'bg-green-100 text-green-800' : 
                                ($question->difficulty === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($question->difficulty) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Code editor -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <form action="{{ route('solve.submit', $question) }}" method="POST">
                        @csrf
                        <h3 class="text-lg font-medium mb-4">Your Solution</h3>
                        
                        <div class="mb-4">
                            <textarea name="code" id="code-editor" class="w-full h-96 font-mono text-sm p-4 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $initialCode }}</textarea>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                Run and Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>