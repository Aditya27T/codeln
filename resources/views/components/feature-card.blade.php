@props([
    'title' => '',
    'description' => '',
    'icon' => 'fas fa-laptop-code'
])

<div class="feature-card bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300">
    <div class="feature-icon bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
        <i class="{{ $icon }} text-indigo-600 text-2xl"></i>
    </div>
    <h3 class="text-xl font-bold mb-3">{{ $title }}</h3>
    <p class="text-gray-600">{{ $description }}</p>
</div>