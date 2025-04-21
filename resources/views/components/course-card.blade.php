@props([
    'title' => '',
    'description' => '',
    'level' => 'BEGINNER',
    'duration' => '0 hours',
    'rating' => '0',
    'reviews' => '0',
    'icon' => 'fas fa-code',
    'bgColor' => 'bg-indigo-600',
    'textColor' => 'text-indigo-600'
])

<div class="course-card bg-white rounded-xl overflow-hidden shadow-md transition duration-300">
    <div class="h-48 {{ $bgColor }} flex items-center justify-center">
        <i class="{{ $icon }} text-white text-8xl"></i>
    </div>
    <div class="p-6">
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-semibold {{ $textColor }}">{{ $level }}</span>
            <span class="text-sm text-gray-500">{{ $duration }}</span>
        </div>
        <h3 class="text-xl font-bold mb-3">{{ $title }}</h3>
        <p class="text-gray-600 mb-4">{{ $description }}</p>
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-star text-yellow-400 mr-1"></i>
                <span class="font-medium">{{ $rating }}</span>
                <span class="text-gray-500 text-sm ml-1">({{ $reviews }})</span>
            </div>
            <button class="{{ $textColor }} hover:{{ str_replace('600', '800', $textColor) }} font-medium">Enroll Now</button>
        </div>
    </div>
</div>