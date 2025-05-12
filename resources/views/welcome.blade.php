<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
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

    <!-- Inline script to prevent flash of incorrect theme -->
    <script>
        // Check for saved theme preference or use system preference
        if (localStorage.getItem('dark-mode') === 'true' || 
            (!localStorage.getItem('dark-mode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-100 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-sm transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-code text-indigo-600 dark:text-indigo-400 text-2xl mr-2"></i>
                        <a href="{{ url('/') }}" class="text-xl font-bold text-indigo-600 dark:text-indigo-400">CodeIn</a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ url('/') }}" class="border-indigo-500 text-gray-900 dark:text-gray-100 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Home</a>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <div class="darkmode-toggle flex items-center cursor-pointer">
                        <span class="sun text-xs">☀️</span>
                        <span class="moon text-xs">🌙</span>
                    </div>

                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">Sign In</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-500 dark:bg-green-700 dark:hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">Sign Up</a>
                        @endif
                    @endauth
                </div>
                <div class="-mr-2 flex items-center sm:hidden">
                    <!-- Mobile Dark Mode Toggle -->
                    <div class="darkmode-toggle flex items-center cursor-pointer mr-3">
                        <span class="sun text-xs">☀️</span>
                        <span class="moon text-xs">🌙</span>
                    </div>
                    
                    <button type="button" id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-200 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition-colors">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ url('/') }}" class="bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200 block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors">Home</a>
                <div class="mt-4 p-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-full bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium block text-center transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="w-full bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium block text-center transition-colors">Sign In</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="w-full mt-2 bg-green-600 hover:bg-green-500 dark:bg-green-700 dark:hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium block text-center transition-colors">Sign Up</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-700 to-violet-700 dark:from-indigo-900 dark:to-violet-900 text-white transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
                        Belajar, Tantang Diri, dan Diskusi Bareng <span class="text-yellow-300 dark:text-yellow-200">Komunitas Coding</span>
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 opacity-90">
                        Platform latihan programming interaktif: mulai dari materi, tantangan coding, hingga forum diskusi dan leaderboard. Cocok untuk pemula maupun yang ingin leveling up!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}"
                           class="bg-white text-indigo-600 hover:bg-gray-100 dark:bg-gray-100 dark:hover:bg-white px-6 py-3 rounded-lg font-semibold text-lg shadow-lg transition duration-300">
                            Daftar & Mulai Gratis
                        </a>
                        <a href="{{ url('/forum') }}"
                           class="bg-transparent border-2 border-white hover:bg-white hover:text-indigo-600 dark:hover:text-indigo-800 px-6 py-3 rounded-lg font-semibold text-lg shadow-lg transition duration-300">
                            Gabung Forum
                        </a>
                        <a href="{{ url('/dashboard') }}"
                           class="bg-yellow-400 text-indigo-900 hover:bg-yellow-300 dark:bg-yellow-300 dark:hover:bg-yellow-200 px-6 py-3 rounded-lg font-semibold text-lg shadow-lg transition duration-300">
                            Coba Coding Challenge
                        </a>
                    </div>
                    <div class="mt-8 flex items-center">
                        <div class="flex -space-x-2">
                            <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white dark:ring-gray-800" src="https://i.pravatar.cc/100?img=1" alt="">
                            <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white dark:ring-gray-800" src="https://i.pravatar.cc/100?img=2" alt="">
                            <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white dark:ring-gray-800" src="https://i.pravatar.cc/100?img=3" alt="">
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
    <div class="bg-white dark:bg-gray-800 py-12 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="mx-auto mb-3 text-indigo-600 dark:text-indigo-400 text-4xl"><i class="fas fa-code"></i></div>
                    <h3 class="font-semibold text-lg mb-1 text-gray-800 dark:text-white">Coding Challenge</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Latihan soal dan tantangan coding real-time, langsung uji kode kamu.</p>
                </div>
                <div>
                    <div class="mx-auto mb-3 text-yellow-500 dark:text-yellow-400 text-4xl"><i class="fas fa-book-open"></i></div>
                    <h3 class="font-semibold text-lg mb-1 text-gray-800 dark:text-white">Materi Interaktif</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Materi belajar terstruktur, cocok untuk pemula hingga mahir.</p>
                </div>
                <div>
                    <div class="mx-auto mb-3 text-pink-500 dark:text-pink-400 text-4xl"><i class="fas fa-comments"></i></div>
                    <h3 class="font-semibold text-lg mb-1 text-gray-800 dark:text-white">Forum Diskusi</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Tanya jawab, diskusi, dan sharing bareng komunitas aktif.</p>
                </div>
                <div>
                    <div class="mx-auto mb-3 text-green-600 dark:text-green-400 text-4xl"><i class="fas fa-trophy"></i></div>
                    <h3 class="font-semibold text-lg mb-1 text-gray-800 dark:text-white">Leaderboard & Badge</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Naik level, kumpulkan badge, dan puncaki leaderboard mingguan!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Trusted By Section -->
    <div class="bg-gray-50 dark:bg-gray-900 py-12 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 dark:text-gray-400 mb-8">Trusted by developers at</p>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 items-center justify-center">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a7/React-icon.svg" alt="React" class="h-12 mx-auto opacity-60 hover:opacity-100 transition dark:invert">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6a/JavaScript-logo.png" alt="JavaScript" class="h-12 mx-auto opacity-60 hover:opacity-100 transition">
                <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg" alt="Laravel" class="h-12 mx-auto opacity-60 hover:opacity-100 transition dark:invert">
                <img src="https://upload.wikimedia.org/wikipedia/commons/1/18/ISO_C%2B%2B_Logo.svg" alt="C++" class="h-12 mx-auto opacity-60 hover:opacity-100 transition">
                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c3/Python-logo-notext.svg" alt="Python" class="h-12 mx-auto opacity-60 hover:opacity-100 transition">
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white dark:bg-gray-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Why Learn with CodeIn?</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">Our platform is designed to help you learn programming effectively and efficiently.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="feature-card bg-white dark:bg-gray-700 p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                    <div class="feature-icon bg-indigo-100 dark:bg-indigo-900 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-laptop-code text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">Interactive Coding</h3>
                    <p class="text-gray-600 dark:text-gray-300">Write and run code directly in your browser with our built-in IDE. Get instant feedback as you learn.</p>
                </div>
                <div class="feature-card bg-white dark:bg-gray-700 p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                    <div class="feature-icon bg-indigo-100 dark:bg-indigo-900 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-road text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">Structured Paths</h3>
                    <p class="text-gray-600 dark:text-gray-300">Follow our curated learning paths to go from beginner to job-ready developer in any tech stack.</p>
                </div>
                <div class="feature-card bg-white dark:bg-gray-700 p-8 rounded-xl shadow-md hover:shadow-xl transition duration-300">
                    <div class="feature-icon bg-indigo-100 dark:bg-indigo-900 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-chalkboard-teacher text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">Expert Instructors</h3>
                    <p class="text-gray-600 dark:text-gray-300">Learn from industry professionals who have worked at top tech companies and startups.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CTA Section -->
    <div class="bg-indigo-700 dark:bg-indigo-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-4">Ready to start your coding journey?</h2>
                    <p class="text-indigo-100 text-xl mb-8">Join thousands of students who have transformed their careers with CodeIn.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('register') }}" class="bg-white text-indigo-600 hover:bg-gray-100 dark:hover:bg-gray-200 px-6 py-3 rounded-lg font-semibold text-lg shadow-lg transition duration-300">Get Started for Free</a>
                    <a href="{{ url('/contact') }}" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-indigo-600 dark:hover:text-indigo-800 px-6 py-3 rounded-lg font-semibold text-lg shadow-lg transition duration-300">Talk to an Advisor</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 dark:bg-gray-950 text-white transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">CodeIn</h3>
                    <p class="text-gray-400">Learn programming the right way with our interactive courses and expert instructors.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Courses</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/courses/web-development') }}" class="text-gray-400 hover:text-white transition-colors">Web Development</a></li>
                        <li><a href="{{ url('/courses/mobile-development') }}" class="text-gray-400 hover:text-white transition-colors">Mobile Development</a></li>
                        <li><a href="{{ url('/courses/data-science') }}" class="text-gray-400 hover:text-white transition-colors">Data Science</a></li>
                        <li><a href="{{ url('/courses/machine-learning') }}" class="text-gray-400 hover:text-white transition-colors">Machine Learning</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Company</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/about') }}" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="{{ url('/careers') }}" class="text-gray-400 hover:text-white transition-colors">Careers</a></li>
                        <li><a href="{{ url('/blog') }}" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Connect</h3>
                    <div class="flex space-x-4 mb-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors"><i class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors"><i class="fab fa-linkedin text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors"><i class="fab fa-youtube text-xl"></i></a>
                    </div>
                    <p class="text-gray-400">Subscribe to our newsletter</p>
                    <div class="mt-2 flex">
                        <input type="email" placeholder="Your email" class="px-3 py-2 bg-gray-800 dark:bg-gray-950 text-white rounded-l focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full border border-gray-700">
                        <button class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-600 px-4 py-2 rounded-r transition-colors"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">© {{ date('Y') }} CodeIn. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="{{ url('/privacy') }}" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy Policy</a>
                    <a href="{{ url('/terms') }}" class="text-gray-400 hover:text-white text-sm transition-colors">Terms of Service</a>
                    <a href="{{ url('/cookies') }}" class="text-gray-400 hover:text-white text-sm transition-colors">Cookies Settings</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Dark Mode JS -->
    <script src="{{ asset('js/darkmode.js') }}"></script>

    <!-- JavaScript for smooth scrolling -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
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
        
        // Mobile menu toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>