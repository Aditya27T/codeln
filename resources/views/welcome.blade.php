<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CodeIn - Learn Programming the Right Way</title>
    <meta name="description" content="CodeIn is a platform to enhance your coding skills with interactive courses, challenges, and a thriving community.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800">
    <!-- Navigation -->
    @include('layouts.navigation')

  <!-- Hero Section -->
<div class="bg-gradient-to-r from-indigo-700 to-violet-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
                    Belajar, Tantang Diri, dan Diskusi Bareng <span class="text-yellow-300">Komunitas Coding</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-90">
                    Platform latihan programming interaktif: mulai dari materi, tantangan coding, hingga forum diskusi dan leaderboard. Cocok untuk pemula maupun yang ingin leveling up!
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') }}"
                       class="bg-white text-indigo-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold text-lg shadow-lg transition duration-300">
                        Daftar & Mulai Gratis
                    </a>
                    <a href="{{ url('/forum') }}"
                       class="bg-transparent border-2 border-white hover:bg-white hover:text-indigo-600 px-6 py-3 rounded-lg font-semibold text-lg shadow-lg transition duration-300">
                        Gabung Forum
                    </a>
                    <a href="{{ url('/dashboard') }}"
                       class="bg-yellow-400 text-indigo-900 hover:bg-yellow-300 px-6 py-3 rounded-lg font-semibold text-lg shadow-lg transition duration-300">
                        Coba Coding Challenge
                    </a>
                </div>
                <div class="mt-8 flex items-center">
                    <div class="flex -space-x-2">
                        <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white" src="https://i.pravatar.cc/100?img=1" alt="">
                        <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white" src="https://i.pravatar.cc/100?img=2" alt="">
                        <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white" src="https://i.pravatar.cc/100?img=3" alt="">
                    </div>
                    <p class="ml-4 text-sm opacity-90">
                        Sudah <span class="font-bold">10,000+</span> member belajar & berbagi di CodeIn
                    </p>
                </div>
            </div>
            <div class="hidden md:block">
                <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=600&q=80" alt="Komunitas Coding"
                     class="w-full max-w-md mx-auto animate-float rounded-lg shadow-lg">
            </div>
        </div>
    </div>
</div>
<!-- Fitur Section -->
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="mx-auto mb-3 text-indigo-600 text-4xl"><i class="fas fa-code"></i></div>
                <h3 class="font-semibold text-lg mb-1">Coding Challenge</h3>
                <p class="text-gray-500 text-sm">Latihan soal dan tantangan coding real-time, langsung uji kode kamu.</p>
            </div>
            <div>
                <div class="mx-auto mb-3 text-yellow-500 text-4xl"><i class="fas fa-book-open"></i></div>
                <h3 class="font-semibold text-lg mb-1">Materi Interaktif</h3>
                <p class="text-gray-500 text-sm">Materi belajar terstruktur, cocok untuk pemula hingga mahir.</p>
            </div>
            <div>
                <div class="mx-auto mb-3 text-pink-500 text-4xl"><i class="fas fa-comments"></i></div>
                <h3 class="font-semibold text-lg mb-1">Forum Diskusi</h3>
                <p class="text-gray-500 text-sm">Tanya jawab, diskusi, dan sharing bareng komunitas aktif.</p>
            </div>
            <div>
                <div class="mx-auto mb-3 text-green-600 text-4xl"><i class="fas fa-trophy"></i></div>
                <h3 class="font-semibold text-lg mb-1">Leaderboard & Badge</h3>
                <p class="text-gray-500 text-sm">Naik level, kumpulkan badge, dan puncaki leaderboard mingguan!</p>
            </div>
        </div>
    </div>
</div>

    <!-- Trusted By Section -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 mb-8">Trusted by developers at</p>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 items-center justify-center">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a7/React-icon.svg" alt="React" class="h-12 mx-auto opacity-60 hover:opacity-100 transition">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6a/JavaScript-logo.png" alt="JavaScript" class="h-12 mx-auto opacity-60 hover:opacity-100 transition">
                <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg" alt="Laravel" class="h-12 mx-auto opacity-60 hover:opacity-100 transition">
                <img src="https://upload.wikimedia.org/wikipedia/commons/1/18/ISO_C%2B%2B_Logo.svg" alt="C++" class="h-12 mx-auto opacity-60 hover:opacity-100 transition">
                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c3/Python-logo-notext.svg" alt="Python" class="h-12 mx-auto opacity-60 hover:opacity-100 transition">
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Why Learn with CodeIn?</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Our platform is designed to help you learn programming effectively and efficiently.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <x-feature-card
                    title="Interactive Coding"
                    description="Write and run code directly in your browser with our built-in IDE. Get instant feedback as you learn."
                    icon="fas fa-laptop-code"
                />
                <x-feature-card
                    title="Structured Paths"
                    description="Follow our curated learning paths to go from beginner to job-ready developer in any tech stack."
                    icon="fas fa-road"
                />
                <x-feature-card
                    title="Expert Instructors"
                    description="Learn from industry professionals who have worked at top tech companies and startups."
                    icon="fas fa-chalkboard-teacher"
                />
            </div>
        </div>
    </div>
    
    <!-- CTA Section -->
    <div class="bg-indigo-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-4">Ready to start your coding journey?</h2>
                    <p class="text-indigo-100 text-xl mb-8">Join thousands of students who have transformed their careers with CodeIn.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('register') }}" class="bg-white text-indigo-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold text-lg shadow-lg transition duration-300">Get Started for Free</a>
                    <a href="{{ url('/contact') }}" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-indigo-600 px-6 py-3 rounded-lg font-semibold text-lg shadow-lg transition duration-300">Talk to an Advisor</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">CodeIn</h3>
                    <p class="text-gray-400">Learn programming the right way with our interactive courses and expert instructors.</p>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">© {{ date('Y') }} CodeIn. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="{{ url('/privacy') }}" class="text-gray-400 hover:text-white text-sm">Privacy Policy</a>
                    <a href="{{ url('/terms') }}" class="text-gray-400 hover:text-white text-sm">Terms of Service</a>
                    <a href="{{ url('/cookies') }}" class="text-gray-400 hover:text-white text-sm">Cookies Settings</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript for smooth scrolling -->
    <script>
        document.querySelectorAll('a[href^="# aphrodite').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>
