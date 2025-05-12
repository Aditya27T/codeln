<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-4 bg-transparent">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 sm:p-8 w-full max-w-md transition-colors duration-300 border border-gray-200 dark:border-gray-700">
            <div class="text-center mb-8">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-code text-indigo-600 text-4xl mr-2"></i>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Welcome to <span class="text-indigo-600 dark:text-indigo-400">CodeIn</span></h1>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mt-2">Login to your account</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-6 text-sm text-gray-600 dark:text-gray-300 text-center" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1" />
                    <x-text-input id="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-400 dark:placeholder-gray-400" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1" />
                    <x-text-input id="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-400 dark:placeholder-gray-400" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
                </div>

                <!-- Remember Me and Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" name="remember">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">{{ __('Remember me') }}</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">{{ __('Forgot password?') }}</a>
                    @endif
                </div>

                <!-- Submit Button -->
                <x-primary-button class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    {{ __('Sign In') }}
                </x-primary-button>
            </form>

            <!-- Register Link -->
            @if (Route::has('register'))
                <div class="mt-6 text-center">
                    <p class="text-gray-600 dark:text-gray-300">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-indigo-600 dark:text-indigo-400 font-medium hover:text-indigo-500 dark:hover:text-indigo-300">Sign up</a>
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>