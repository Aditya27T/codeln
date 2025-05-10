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
                        <div class="rounded-2xl shadow-md overflow-hidden bg-white hover:shadow-xl hover:-translate-y-1 transition group relative border border-transparent hover:border-indigo-400">
                            <div class="bg-gradient-to-tr from-indigo-500 to-purple-500 p-5 h-36 flex flex-col justify-end relative">
                                <div class="absolute top-4 right-4">
                                    <span class="inline-block bg-white bg-opacity-30 rounded-full p-2">
                                        <svg class="w-6 h-6 text-white opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20l9 2-7-7 7-7-9 2-2-9-2 9-9-2 7 7-7 7 9-2z"/></svg>
                                    </span>
                                </div>
                                <h3 class="text-white text-xl font-bold leading-tight drop-shadow">
                                    {{ $material->title }}
                                </h3>
                                <p class="text-white text-sm opacity-80">{{ $material->category ?? 'General' }}</p>
                            </div>
                            <div class="p-5 flex flex-col gap-2">
                                <p class="text-sm text-gray-600 mb-1 min-h-[40px]">
                                    {{ Str::limit(strip_tags($material->content), 90) }}
                                </p>
                                @php
                                    // Dummy: cek status selesai materi (ganti sesuai logicmu)
                                    $progress = auth()->user()->material_progress[$material->id] ?? null;
                                    $isDone = $progress && $progress['completed'] ?? false;
                                    $progressPercent = $progress['percent'] ?? 0;
                                @endphp
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        @if($isDone)
                                            <span class="inline-block bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">Selesai</span>
                                        @elseif($progressPercent > 0)
                                            <span class="inline-block bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-xs font-semibold">Sedang</span>
                                        @else
                                            <span class="inline-block bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full text-xs font-semibold">Belum</span>
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-400">{{ $material->chapters_count ?? '1' }} Chapter(s)</span>
                                </div>
                                @if(($material->chapters_count ?? 0) > 1)
                                    <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                        <div class="bg-indigo-500 h-2 rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%;"></div>
                                    </div>
                                @endif
                                <div class="flex justify-between items-center mt-2">
                                    <a href="{{ route('materials.show', $material) }}" class="bg-indigo-600 text-white px-4 py-1.5 rounded-lg shadow hover:bg-indigo-700 transition text-sm font-semibold">
                                        @if($isDone)
                                            Review
                                        @elseif($progressPercent > 0)
                                            Lanjutkan
                                        @else
                                            Mulai
                                        @endif
                                    </a>
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
