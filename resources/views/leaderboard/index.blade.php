<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leaderboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Rank</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">User</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Solved</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Score</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($leaderboard as $index => $user)
                                    @php
                                        $rank = $index + 1;
                                        $badge = '';
                                        $badgeColor = '';
                                        if($rank === 1) { $badge = '🥇'; $badgeColor = 'text-yellow-500'; }
                                        elseif($rank === 2) { $badge = '🥈'; $badgeColor = 'text-gray-400'; }
                                        elseif($rank === 3) { $badge = '🥉'; $badgeColor = 'text-orange-500'; }
                                    @endphp
                                    <tr class="{{ $user->id === auth()->id() ? 'bg-blue-50 font-bold ring-2 ring-blue-300' : 'hover:bg-gray-50 transition' }}">
                                        <td class="px-4 py-3 whitespace-nowrap text-lg font-semibold {{ $badgeColor }}">
                                            @if($badge)
                                                <span class="mr-1">{!! $badge !!}</span>
                                            @endif
                                            <span>{{ $rank }}</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap flex items-center gap-2">
                                            <span class="inline-block w-8 h-8 rounded-full bg-gradient-to-br from-indigo-300 to-indigo-500 flex items-center justify-center text-white font-bold text-base">
                                                {{ strtoupper(substr($user->name,0,1)) }}
                                            </span>
                                            <span class="text-gray-800">{{ $user->name }}</span>
                                            @if($user->id === auth()->id())
                                                <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">You</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center">
                                            <span class="inline-block bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-semibold">{{ $user->completed_count }}</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-indigo-700">{{ $user->total_score ?? 0 }}</span>
                                                <div class="flex-1 min-w-[80px] bg-gray-200 rounded-full h-2">
                                                    <div class="bg-indigo-500 h-2 rounded-full transition-all duration-500" style="width: {{ ($leaderboard[0]->total_score > 0) ? min(100, round(($user->total_score ?? 0)/$leaderboard[0]->total_score*100)) : 0 }}%;"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6 text-xs text-gray-400">Top 3 diberi badge 🥇🥈🥉. Baris biru = kamu sendiri.</div>
    </div>
</x-app-layout>