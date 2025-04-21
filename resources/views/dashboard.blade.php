<x-app-layout>
    <div class="py-10 bg-gradient-to-br from-indigo-50 via-white to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- {{-- Welcome Section --}} -->
            <div class="bg-white rounded-2xl shadow p-6 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Welcome to <span class="text-indigo-600">CodeIn</span></h1>
                <p class="mt-2 text-gray-600">Start learning and challenging yourself through code.</p>
            </div>

            <!-- {{-- Progress Overview --}} -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Your Progress</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Challenges Completed</p>
                        <div class="flex items-center gap-4">
                            <div class="flex-1 bg-gray-200 rounded-full h-3">
                                <div class="bg-indigo-600 h-3 rounded-full transition-all duration-500" style="width: {{ auth()->user()->completed_challenges ?? 25 }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-800 whitespace-nowrap">{{ auth()->user()->completed_challenges ?? 25 }}/100</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Leaderboard Rank</p>
                        <p class="text-lg font-bold text-indigo-600">{{ auth()->user()->leaderboard_rank ?? '#42' }}</p>
                    </div>
                </div>
            </div>

            <!-- {{-- Action Cards --}} -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-dashboard-card title="Learning Materials" route="{{ route('materials.index') }}" color="blue" icon="book">
                    Master programming concepts with our curated resources-
                </x-dashboard.card>

                <x-dashboard-card title="Coding Challenges" route="{{ route('questions.index') }}" color="green" icon="code">
                    Sharpen your skills with hands-on coding tasks.
                </x-dashboard-card>

                <x-dashboard-card title="Leaderboard" route="{{ route('leaderboard.index') }}" color="purple" icon="trophy">
                    Compete with peers and climb the ranks!
                </x-dashboard-card>
            </div>

            <!-- {{-- Admin Section --}} -->
            @if(auth()->user()->isAdmin())
                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Admin Actions</h2>
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <i class="fas fa-tools mr-2"></i> Go to Admin Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Optional JS for future profile interaction
        document.getElementById('profile-image-input')?.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
