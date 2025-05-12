<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            // Inline script to prevent flash of incorrect theme
            if (localStorage.getItem('dark-mode') === 'true' || 
                (!localStorage.getItem('dark-mode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased transition-colors duration-300 bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen">
            @if(Auth::check() && Auth::user()->role !== 'admin')
                @include('layouts.navigation')
            @endif

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow transition-colors duration-300">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="transition-colors duration-300">
                {{ $slot }}
            </main>
            
            <!-- Footer with Dark Mode Credits -->
            <footer class="bg-white dark:bg-gray-800 shadow-inner py-4 transition-colors duration-300">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        © {{ date('Y') }} CodeIn. All rights reserved.
                    </div>
                    <div class="mt-2 md:mt-0 text-sm text-gray-500 dark:text-gray-400 flex items-center">
                        <span class="mr-2">Made with ❤️ by CodeIn Team</span>
                    </div>
                </div>
            </footer>
        </div>
        
        <!-- Dark Mode JS -->
        <script src="{{ asset('js/darkmode.js') }}"></script>
    </body>
</html>