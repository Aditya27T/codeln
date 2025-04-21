<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ __('Explore Materials') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-white via-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if($materials->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($materials as $material)
                        <div class="rounded-2xl shadow-md overflow-hidden bg-white hover:shadow-lg transition group">
                            <div class="bg-gradient-to-tr from-indigo-500 to-purple-500 p-5 h-36 flex flex-col justify-end">
                                <h3 class="text-white text-xl font-bold leading-tight">
                                    {{ $material->title }}
                                </h3>
                                <p class="text-white text-sm opacity-80">{{ $material->category ?? 'General' }}</p>
                            </div>
                            <div class="p-5">
                                <p class="text-sm text-gray-600 mb-3">
                                    {{ Str::limit(strip_tags($material->content), 100) }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <a href="{{ route('materials.show', $material) }}" class="text-indigo-600 text-sm font-semibold hover:underline">
                                        Read More
                                    </a>
                                    <span class="text-xs text-gray-400">{{ $material->chapters_count ?? '1' }} Chapter(s)</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white p-6 rounded-lg shadow text-gray-600 text-center">
                    No materials available yet.
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
