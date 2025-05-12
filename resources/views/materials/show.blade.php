<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight flex items-center">
                <i class="fas fa-book-open mr-3 text-indigo-600 dark:text-indigo-400"></i>
                {{ $material->title }}
            </h2>
            <nav class="text-sm breadcrumbs">
                <a href="{{ route('materials.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                    <i class="fas fa-arrow-left mr-1"></i> All Materials
                </a>
            </nav>
        </div>
    </x-slot>

    <div class="py-10 bg-gradient-to-b from-indigo-50 to-white dark:from-gray-900 dark:to-gray-800 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Material content card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-colors duration-300">
                <!-- Header section with pattern background -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-6 px-8 relative">
                    <div class="absolute inset-0 opacity-10 card-header-pattern"></div>
                    <div class="relative z-10">
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $material->title }}</h1>
                        <div class="flex flex-wrap items-center gap-4 text-white text-sm">
                            <span><i class="fas fa-calendar-alt mr-1"></i> Last updated: {{ $material->updated_at->format('M d, Y') }}</span>
                            <span><i class="fas fa-clock mr-1"></i> {{ rand(10, 60) }} min read</span>
                            <span class="px-3 py-1 bg-white bg-opacity-20 rounded-full">{{ $material->category ?? 'General' }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Content section -->
                <div class="p-8">
                    <!-- Table of contents -->
                    <div class="mb-8 p-4 bg-indigo-50 dark:bg-gray-700 rounded-lg">
                        <h3 class="text-lg font-semibold text-indigo-700 dark:text-indigo-300 mb-2">Table of Contents</h3>
                        <ul class="space-y-1 text-gray-700 dark:text-gray-300">
                            @php
                                // Extract headings from content (simplified example)
                                preg_match_all('/#+ (.*)/', $material->content, $matches);
                                $headings = $matches[1] ?? [];
                            @endphp
                            
                            @foreach($headings as $index => $heading)
                                <li class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <a href="#heading-{{ $index }}" class="flex items-center">
                                        <i class="fas fa-chevron-right text-xs mr-2"></i>
                                        <span>{{ $heading }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Main content with dark mode styling -->
                    <div class="prose max-w-none dark:prose-invert prose-headings:text-gray-900 dark:prose-headings:text-gray-100 prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-a:text-indigo-600 dark:prose-a:text-indigo-400 prose-code:bg-gray-100 dark:prose-code:bg-gray-700 prose-code:text-indigo-600 dark:prose-code:text-indigo-400 prose-code:px-1.5 prose-code:rounded prose-pre:bg-gray-900 dark:prose-pre:bg-gray-950 prose-pre:text-white prose-pre:rounded-lg prose-pre:p-3 prose-h2:text-lg prose-h2:mt-4 prose-h2:mb-2 prose-ul:pl-6 prose-li:marker:text-indigo-400 transition-colors duration-300">
                        {!! $contentHtml !!}
                    </div>
                </div>
                
                <!-- Interactive elements -->
                <div class="px-8 py-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 transition-colors duration-300">
                    <div class="flex flex-col md:flex-row justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Rate this material</h3>
                            <div class="flex text-2xl text-gray-400 dark:text-gray-600">
                                <button class="hover:text-yellow-500 transition-colors duration-200 focus:outline-none"><i class="far fa-star"></i></button>
                                <button class="hover:text-yellow-500 transition-colors duration-200 focus:outline-none"><i class="far fa-star"></i></button>
                                <button class="hover:text-yellow-500 transition-colors duration-200 focus:outline-none"><i class="far fa-star"></i></button>
                                <button class="hover:text-yellow-500 transition-colors duration-200 focus:outline-none"><i class="far fa-star"></i></button>
                                <button class="hover:text-yellow-500 transition-colors duration-200 focus:outline-none"><i class="far fa-star"></i></button>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Share this material</h3>
                            <div class="flex space-x-3">
                                <button class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                                <button class="w-10 h-10 rounded-full bg-blue-400 text-white flex items-center justify-center hover:bg-blue-500 transition-colors">
                                    <i class="fab fa-twitter"></i>
                                </button>
                                <button class="w-10 h-10 rounded-full bg-green-600 text-white flex items-center justify-center hover:bg-green-700 transition-colors">
                                    <i class="fab fa-whatsapp"></i>
                                </button>
                                <button class="w-10 h-10 rounded-full bg-red-600 text-white flex items-center justify-center hover:bg-red-700 transition-colors">
                                    <i class="fas fa-envelope"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation buttons -->
            <div class="mt-8 flex flex-col sm:flex-row justify-between gap-4">
                <a href="{{ route('materials.index') }}"
                   class="btn btn-secondary flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Materials
                </a>
                
                <a href="{{ route('questions.index') }}"
                   class="btn btn-primary flex items-center justify-center">
                    Practice with Challenges <i class="fas fa-code ml-2"></i>
                </a>
            </div>
            
            <!-- Related materials -->
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Related Materials</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="material-card enhanced-card bg-white dark:bg-gray-800 border border-transparent dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600">
                            <div class="bg-gradient-to-tr from-indigo-500 to-purple-500 p-4 flex flex-col justify-end relative overflow-hidden">
                                <div class="card-header-pattern"></div>
                                <h3 class="text-white text-lg font-bold relative z-10">
                                    Related Topic {{ $i + 1 }}
                                </h3>
                            </div>
                            <div class="p-4">
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.
                                </p>
                                <a href="#" class="text-indigo-600 dark:text-indigo-400 font-medium hover:underline text-sm">
                                    Learn more <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    
    <!-- Floating action button for feedback -->
    <div class="fixed bottom-6 right-6">
        <button class="w-14 h-14 rounded-full bg-indigo-600 text-white shadow-lg flex items-center justify-center hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 group">
            <i class="fas fa-comment-alt"></i>
            <span class="absolute right-full mr-3 p-2 rounded bg-gray-800 text-white text-sm whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">Send Feedback</span>
        </button>
    </div>
    
    <script>
        // Simple JavaScript to handle the star rating
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.fa-star');
            stars.forEach((star, index) => {
                star.addEventListener('click', () => {
                    // Reset all stars
                    stars.forEach(s => s.classList.replace('fas', 'far'));
                    
                    // Fill stars up to the clicked index
                    for (let i = 0; i <= index; i++) {
                        stars[i].classList.replace('far', 'fas');
                    }
                });
                
                star.addEventListener('mouseover', () => {
                    // Highlight stars on hover
                    for (let i = 0; i <= index; i++) {
                        stars[i].classList.add('text-yellow-500');
                    }
                });
                
                star.addEventListener('mouseout', () => {
                    // Remove highlight on mouseout (keep filled stars)
                    stars.forEach(s => {
                        if (s.classList.contains('far')) {
                            s.classList.remove('text-yellow-500');
                        }
                    });
                });
            });
            
            // Handle scroll to headings from table of contents
            document.querySelectorAll('a[href^="#heading-"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const headingIndex = this.getAttribute('href').replace('#heading-', '');
                    const headings = document.querySelectorAll('.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6');
                    
                    if (headings[headingIndex]) {
                        headings[headingIndex].scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>