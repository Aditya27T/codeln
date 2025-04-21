@props(['title', 'route', 'color' => 'indigo', 'icon'])

<a href="{{ $route }}" class="bg-white border-l-4 border-{{ $color }}-500 rounded-xl shadow p-6 hover:bg-{{ $color }}-50 transition block">
    <div class="flex items-center mb-3">
        <div class="p-3 rounded-lg bg-{{ $color }}-100 text-{{ $color }}-600">
            <i class="fas fa-{{ $icon }} text-xl"></i>
        </div>
        <h3 class="ml-4 text-lg font-semibold text-gray-900">{{ $title }}</h3>
    </div>
    <p class="text-gray-600 text-sm">{{ $slot }}</p>
</a>
