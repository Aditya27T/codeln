<x-guest-layout>
    <div class="max-w-md mx-auto p-6 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-2xl border border-gray-200 dark:border-gray-700 transition-colors duration-300">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Join <span class="text-indigo-600 dark:text-indigo-400">CodeIn</span></h1>
            <p class="text-gray-600 dark:text-gray-300 mt-1">Create your account to start learning</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1" />
                <x-text-input id="name" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-400 dark:placeholder-gray-400" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-600 dark:text-red-400" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1" />
                <x-text-input id="email" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-400 dark:placeholder-gray-400" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-600 dark:text-red-400" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1" />
                <x-text-input id="password" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-400 dark:placeholder-gray-400" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-600 dark:text-red-400" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1" />
                <x-text-input id="password_confirmation" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-400 dark:placeholder-gray-400" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-600 dark:text-red-400" />
            </div>

            <!-- Submit Button -->
            <x-primary-button class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                {{ __('Register') }}
            </x-primary-button>
        </form>

        <!-- Login Link -->
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-300">
                Already have an account?
                <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 font-medium hover:text-indigo-500 dark:hover:text-indigo-300">Sign in</a>
            </p>
        </div>
    </div>
</x-guest-layout>