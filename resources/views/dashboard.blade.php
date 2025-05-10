<x-app-layout>

    <div class="py-10 bg-gradient-to-br from-indigo-50 via-white to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- {{-- Welcome Section --}} -->
            <div class="bg-white rounded-2xl shadow p-6 text-center">
                <h1 class="text-3xl font-bold text-gray-800">Welcome to <span class="text-indigo-600">CodeIn</span></h1>
                <p class="mt-2 text-gray-600">Start learning and challenging yourself through code.</p>
            </div>

            <!-- {{-- Progress Overview --}} -->
            <div class="bg-white rounded-2xl shadow p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div class="flex-1">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Your Progress</h2>
            <div class="flex flex-col md:flex-row gap-4 md:gap-8 items-center">
                <div class="w-40 h-40">
                    <canvas id="progressPieChart"></canvas>
                </div>
                <div class="flex-1">
                    <div class="mb-2">
                        <span class="text-sm text-gray-600">Challenges Completed</span>
                        <span class="ml-2 text-lg font-bold text-indigo-700">{{ $completedChallenges }}/{{ $totalChallenges }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-sm text-gray-600">Total Score</span>
                        <span class="ml-2 text-lg font-bold text-green-700">{{ $totalScore }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-sm text-gray-600">Longest Streak</span>
                        <span class="ml-2 text-lg font-bold text-orange-700">{{ $maxStreak }} days</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Leaderboard Rank</span>
                        <span class="ml-2 text-lg font-bold text-purple-700">{{ $leaderboardRank }}</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach($badges as $badge)
                    <span class="inline-block bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-xs font-semibold">🏅 {{ $badge }}</span>
                @endforeach
            </div>
        </div>
        <div class="flex-1 mt-8 md:mt-0">
            <h3 class="text-md font-semibold mb-2">Next Challenge</h3>
            @if($nextChallenge)
                <a href="{{ route('solve.show', $nextChallenge->id) }}" class="block p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                    <div class="font-bold text-indigo-700">{{ $nextChallenge->title }}</div>
                    <div class="text-sm text-gray-600 mt-1">{{ \Illuminate\Support\Str::limit($nextChallenge->description, 60) }}</div>
                </a>
            @else
                <div class="text-gray-500">Semua challenge sudah selesai! 🎉</div>
            @endif
        </div>
    </div>
</div>

<!-- Aktivitas terakhir & in progress -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-2xl shadow p-6">
        <h3 class="font-semibold text-lg mb-3">Recent Activities</h3>
        <ul class="divide-y divide-gray-100">
            @forelse($recentActivities as $act)
                <li class="py-2 flex items-center gap-2">
                    <span class="text-green-600 font-bold">✔</span>
                    <span class="flex-1">Completed <b>{{ $act->question->title ?? '-' }}</b> <span class="text-xs text-gray-400 ml-2">({{ $act->updated_at->diffForHumans() }})</span></span>
                </li>
            @empty
                <li class="py-2 text-gray-400">Belum ada aktivitas.</li>
            @endforelse
        </ul>
    </div>
    <div class="bg-white rounded-2xl shadow p-6">
        <h3 class="font-semibold text-lg mb-3">In Progress Challenges</h3>
        <ul class="divide-y divide-gray-100">
            @forelse($inProgress as $prog)
                <li class="py-2 flex items-center gap-2">
                    <span class="text-yellow-600 font-bold">⏳</span>
                    <span class="flex-1">{{ $prog->question->title ?? '-' }}</span>
                    <a href="{{ route('solve.show', $prog->question->id) }}" class="text-indigo-600 text-xs font-semibold">Continue</a>
                </li>
            @empty
                <li class="py-2 text-gray-400">Tidak ada challenge yang sedang berlangsung.</li>
            @endforelse
        </ul>
    </div>
</div>

<!-- Forum highlight -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-2xl shadow p-6">
        <h3 class="font-semibold text-lg mb-3">Latest Forum Threads</h3>
        <ul class="divide-y divide-gray-100">
            @foreach($latestThreads as $thread)
                <li class="py-2">
                    <a href="{{ url('/forum#'.$thread->id) }}" class="font-semibold text-indigo-700 hover:underline">{{ $thread->title }}</a>
                    <div class="text-xs text-gray-500">by {{ $thread->user->name ?? '-' }} • {{ $thread->created_at->diffForHumans() }}</div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="bg-white rounded-2xl shadow p-6">
        <h3 class="font-semibold text-lg mb-3">Popular Forum Threads</h3>
        <ul class="divide-y divide-gray-100">
            @foreach($popularThreads as $thread)
                <li class="py-2">
                    <a href="{{ url('/forum#'.$thread->id) }}" class="font-semibold text-indigo-700 hover:underline">{{ $thread->title }}</a>
                    <div class="text-xs text-gray-500">by {{ $thread->user->name ?? '-' }} • {{ $thread->likes_count }} likes</div>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<!-- Pie chart script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('progressPieChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Completed', 'Remaining'],
            datasets: [{
                data: [{{ $completedChallenges }}, {{ max(0, $totalChallenges - $completedChallenges) }}],
                backgroundColor: ['#6366f1', '#e5e7eb'],
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>


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
@include('components.forum-thread-modal')

<script>
function openForumModal(threadId) {
    const modal = document.getElementById('forum-thread-modal');
    const content = document.getElementById('forum-modal-content');
    modal.classList.remove('hidden');
    content.innerHTML = '<div class="flex justify-center items-center h-40"><span class="text-gray-400">Loading...</span></div>';
    fetch(`/forum/thread/${threadId}`)
        .then(resp => resp.json())
        .then(data => {
            if (!data.success) { content.innerHTML = '<div class="text-red-500">Thread not found.</div>'; return; }
            const t = data.thread;
            let html = `<div class='mb-2'><span class='text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded'>#${t.id}</span> <span class='text-gray-500 text-xs'>${t.created_at_human}</span></div>`;
            html += `<h2 class='text-xl font-bold mb-1'>${t.title}</h2>`;
            html += `<div class='text-sm text-gray-700 mb-2'>${t.content}</div>`;
            html += `<div class='flex gap-4 items-center mb-2'><span class='text-xs text-gray-500'>by ${t.user_name}</span>`;
            html += `<button onclick='likeThread(${t.id},this)' class='ml-2 px-2 py-1 rounded text-gray-600 hover:text-red-500 border border-gray-200 bg-gray-50 flex items-center'><span class='like-icon'>❤️</span> <span class='like-count'>${t.likes_count}</span></button></div>`;
            html += `<div class='mt-4'><h3 class='font-semibold mb-2'>Replies (${t.replies.length})</h3>`;
            if (t.replies.length == 0) html += `<div class='text-gray-400 text-sm'>No replies yet.</div>`;
            t.replies.forEach(r => {
                html += `<div class='border-t pt-2 mt-2 text-sm'><b>${r.user_name}</b> <span class='text-xs text-gray-400'>${r.created_at_human}</span><div>${r.content}</div></div>`;
            });
            html += '</div>';
            content.innerHTML = html;
        });
}
function closeForumModal() {
    document.getElementById('forum-thread-modal').classList.add('hidden');
    history.replaceState(null, null, ' ');
}
document.querySelectorAll('.forum-thread-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const threadId = this.getAttribute('data-thread-id');
        openForumModal(threadId);
        history.replaceState(null, null, `#${threadId}`);
    });
});
// Auto open if #id in URL
window.addEventListener('DOMContentLoaded', () => {
    const hash = window.location.hash;
    if (hash && /^#\d+$/.test(hash)) {
        openForumModal(hash.substring(1));
    }
});
// Like in modal
function likeThread(threadId, btn) {
    btn.disabled = true;
    fetch("/forum/like", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
        },
        body: JSON.stringify({ post_id: threadId })
    }).then(r => r.json()).then(data => {
        if (data.success) {
            btn.querySelector('.like-count').textContent = data.count;
            btn.classList.toggle('text-red-500', data.liked);
        }
        btn.disabled = false;
    });
}
</script>
</x-app-layout>
