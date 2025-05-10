<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            📘 {{ $material->title }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-b from-indigo-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm p-8">
                <div class="prose max-w-none text-gray-900">
                    {!! $contentHtml !!}
                </div>

                <div class="mt-10 flex flex-col sm:flex-row justify-between gap-4">
                    <a href="{{ route('materials.index') }}"
                       class="inline-flex items-center justify-center px-5 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Materials
                    </a>
                    <a href="{{ route('questions.index') }}"
                       class="inline-flex items-center justify-center px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Go to Challenges <i class="fas fa-code ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
