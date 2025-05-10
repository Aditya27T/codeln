<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Profile Card -->
            <div class="bg-white shadow rounded-2xl flex flex-col md:flex-row items-center gap-6 p-8">
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-indigo-300 to-indigo-500 flex items-center justify-center text-white text-4xl font-bold">
                        {{ strtoupper(substr($user->name,0,1)) }}
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                        <div>
                            <div class="text-2xl font-bold text-gray-800">{{ $user->name }}</div>
                            <div class="text-gray-500 text-sm">{{ $user->email }}</div>
                            <div class="mt-1">
                                <span class="inline-block bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold uppercase">{{ $user->role }}</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-2 md:mt-0">
                            @php $badges = [];
                            $completed = $user->progress()->whereNotNull('completed_at')->count();
                            if ($completed > 0) $badges[] = 'First Challenge!';
                            if ($completed >= 5) $badges[] = '5 Challenges';
                            if (isset($totalChallenges) && $completed == $totalChallenges && $totalChallenges > 0) $badges[] = 'All Completed!';
                            $days = $user->progress()->whereNotNull('completed_at')->pluck('completed_at')->map(fn($d) => $d->toDateString())->unique()->sort();
                            $streak = 0; $maxStreak = 0; $prev = null;
                            foreach ($days as $day) {
                                if ($prev && \Carbon\Carbon::parse($day)->diffInDays($prev) == 1) {
                                    $streak++;
                                } else {
                                    $streak = 1;
                                }
                                $maxStreak = max($maxStreak, $streak);
                                $prev = \Carbon\Carbon::parse($day);
                            }
                            if ($maxStreak >= 3) $badges[] = $maxStreak.' Days Streak';
                            @endphp
                            @foreach($badges as $badge)
                                <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">🏅 {{ $badge }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                        <div class="text-center">
                            <div class="text-xs text-gray-400">Challenges Selesai</div>
                            <div class="text-lg font-bold text-green-700">{{ $completed }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs text-gray-400">Total Skor</div>
                            <div class="text-lg font-bold text-indigo-700">{{ $user->progress()->sum('score') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs text-gray-400">Streak</div>
                            <div class="text-lg font-bold text-orange-700">{{ $maxStreak ?? 0 }} hari</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs text-gray-400">Rank</div>
                            <div class="text-lg font-bold text-purple-700">
                                @php
                                    $users = \App\Models\User::where('role', 'student')
                                        ->withCount(['progress as total_score' => function ($query) {
                                            $query->select(\DB::raw('sum(score)'));
                                        }])
                                        ->orderByDesc('total_score')
                                        ->get(['id', 'name']);
                                    $rank = $users->search(function ($u) use ($user) {
                                        return $u->id === $user->id;
                                    });
                                @endphp
                                {{ $rank !== false ? ('#' . ($rank + 1)) : '-' }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="bg-gray-200 rounded-full h-3 w-full">
                            <div class="bg-indigo-600 h-3 rounded-full transition-all duration-500" style="width: {{ isset($totalChallenges) && $totalChallenges > 0 ? ($completed / $totalChallenges * 100) : 0 }}%;"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">Progress: {{ $completed }} / {{ $totalChallenges ?? '?' }} challenges</div>
                    </div>
                </div>
            </div>
            <!-- Forms -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    @include('profile.partials.update-profile-information-form')
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    @include('profile.partials.update-password-form')
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
