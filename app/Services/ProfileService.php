<?php
namespace App\Services;

use App\Models\User;
use App\Models\Question;
use App\Models\Post;
use Carbon\Carbon;

class ProfileService
{
    public function getDashboardData(User $user)
    {
        $totalChallenges = Question::count();
        $completedChallenges = $user->progress()->whereNotNull('completed_at')->count();
        $inProgress = $user->progress()->whereNull('completed_at')->with('question')->get();
        $totalScore = $user->progress()->sum('score');

        $recentActivities = $user->progress()->with('question')->orderByDesc('updated_at')->take(5)->get();

        $badges = [];
        if ($completedChallenges > 0) $badges[] = 'First Challenge!';
        if ($completedChallenges >= 5) $badges[] = '5 Challenges';
        if ($completedChallenges == $totalChallenges && $totalChallenges > 0) $badges[] = 'All Completed!';
        $days = $user->progress()->whereNotNull('completed_at')->pluck('completed_at')->map(fn($d) => $d->toDateString())->unique()->sort();
        $streak = 0; $maxStreak = 0; $prev = null;
        foreach ($days as $day) {
            if ($prev && Carbon::parse($day)->diffInDays($prev) == 1) {
                $streak++;
            } else {
                $streak = 1;
            }
            $maxStreak = max($maxStreak, $streak);
            $prev = Carbon::parse($day);
        }
        if ($maxStreak >= 3) $badges[] = $maxStreak . ' Days Streak';

        $nextChallenge = Question::whereDoesntHave('progress', function($q) use ($user) {
            $q->where('user_id', $user->id)->whereNotNull('completed_at');
        })->orderBy('id')->first();

        $latestThreads = Post::with('user')->latest()->take(3)->get();
        $popularThreads = Post::with('user')->withCount('likes')->orderByDesc('likes_count')->take(3)->get();

        $users = User::where('role', 'student')
            ->withCount(['progress as total_score' => function ($query) {
                $query->select(\DB::raw('sum(score)'));
            }])
            ->orderByDesc('total_score')
            ->get();
        $rank = $users->search(fn($u) => $u->id === $user->id) + 1;

        return [
            'user' => $user,
            'totalChallenges' => $totalChallenges,
            'completedChallenges' => $completedChallenges,
            'inProgress' => $inProgress,
            'totalScore' => $totalScore,
            'recentActivities' => $recentActivities,
            'badges' => $badges,
            'nextChallenge' => $nextChallenge,
            'latestThreads' => $latestThreads,
            'popularThreads' => $popularThreads,
            'rank' => $rank,
            'users' => $users,
            'maxStreak' => $maxStreak,
            'leaderboardRank' => ($rank > 0 ? ('#' . $rank) : '-')
        ];
    }
}
