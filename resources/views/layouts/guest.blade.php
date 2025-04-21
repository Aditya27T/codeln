<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CodeIn - {{ $title ?? 'Sign In' }}</title>
    <meta name="description" content="Sign in to CodeIn to access interactive coding courses and challenges.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50">
    <!-- Navigation -->
    <x-nav-link active="home" />

    <!-- Main Content -->
    {{ $slot }}

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">CodeIn</h3>
                    <p class="text-gray-400">Learn programming the right way with our interactive courses and expert instructors.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Courses</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/courses/web-development') }}" class="text-gray-400 hover:text-white">Web Development</a></li>
                        <li><a href="{{ url('/courses/mobile-development') }}" class="text-gray-400 hover:text-white">Mobile Development</a></li>
                        <li><a href="{{ url('/courses/data-science') }}" class="text-gray-400 hover:text-white">Data Science</a></li>
                        <li><a href="{{ url('/courses/machine-learning') }}" class="text-gray-400 hover:text-white">Machine Learning</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Company</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/about') }}" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="{{ url('/careers') }}" class="text-gray-400 hover:text-white">Careers</a></li>
                        <li><a href="{{ url('/blog') }}" class="text-gray-400 hover:text-white">Blog</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Connect</h3>
                    <div class="flex space-x-4 mb-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-youtube text-xl"></i></a>
                    </div>
                    <p class="text-gray-400">Subscribe to our newsletter</p>
                    <div class="mt-2 flex">
                        <input type="email" placeholder="Your email" class="px-3 py-2 bg-gray-800 text-white rounded-l focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full">
                        <button class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-r"><i class="fas fa-paper-plane"></i></button>
                    </div>
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

    <!-- Smooth scrolling script -->
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
    </script>
</body>
</html>