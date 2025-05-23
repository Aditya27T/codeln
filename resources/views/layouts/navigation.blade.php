@props(['active' => 'home'])

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <i class="fas fa-code text-indigo-600 text-2xl mr-2"></i>
                    <a href="{{ url('/') }}" class="text-xl font-bold text-indigo-600">CodeIn</a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden sm:flex sm:space-x-8 sm:ml-10">
                    @if (Route::has('login'))
                        <x-nav-link :href="url('/dashboard')" :active="$active === 'dashboard'">
                            Home
                        </x-nav-link>
                    @else
                        <x-nav-link :href="url('/')" :active="$active === 'home'">
                            Home
                        </x-nav-link>
                    @endif 
                    <x-nav-link :href="url('/materials')" :active="$active === 'materials'">
                        Courses
                    </x-nav-link>
                    <x-nav-link :href="url('/questions')" :active="$active === 'questions'">
                        Challenges
                    </x-nav-link>
                    <x-nav-link :href="url('/forum')" :active="$active === 'community'">
                        Community
                    </x-nav-link>
                    <x-nav-link :href="url('/leaderboard')" :active="$active === 'leaderboard'">
                        Leaderboard
                    </x-nav-link>
                </div>
            </div>

            <!-- Auth / User Dropdown -->
            <div class="hidden sm:flex sm:items-center">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Profile
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">Sign In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-md text-sm font-medium">Sign Up</a>
                    @endif
                @endauth
            </div>

            <!-- Mobile Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if (Route::has('login'))
                <x-responsive-nav-link :href="url('/dashboard')" :active="$active === 'dashboard'">Home</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="url('/')" :active="$active === 'home'">Home</x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="url('/courses')" :active="$active === 'courses'">Courses</x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/paths')" :active="$active === 'paths'">Paths</x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/community')" :active="$active === 'community'">Community</x-responsive-nav-link>
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="p-4 space-y-2 border-t border-gray-200">
                <a href="{{ route('login') }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">Sign In</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="block w-full text-center bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-md text-sm font-medium">Sign Up</a>
                @endif
            </div>
        @endauth
    </div>
</nav>
