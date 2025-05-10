<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the user dashboard with dynamic progress and rank.
     */
    public function dashboard()
    {
        $user = auth()->user();
        // Statistik tantangan
        $totalChallenges = \App\Models\Question::count();
        $completedChallenges = $user->progress()->whereNotNull('completed_at')->count();
        $inProgress = $user->progress()->whereNull('completed_at')->with('question')->get();
        $totalScore = $user->progress()->sum('score');

        // Aktivitas terakhir
        $recentActivities = $user->progress()->with('question')->orderByDesc('updated_at')->take(5)->get();

        // Badge sederhana
        $badges = [];
        if ($completedChallenges > 0) $badges[] = 'First Challenge!';
        if ($completedChallenges >= 5) $badges[] = '5 Challenges';
        if ($completedChallenges == $totalChallenges && $totalChallenges > 0) $badges[] = 'All Completed!';
        // Streak (jumlah hari berturut-turut aktif)
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

        // Saran challenge berikutnya
        $nextChallenge = \App\Models\Question::whereDoesntHave('progress', function($q) use ($user) {
            $q->where('user_id', $user->id)->whereNotNull('completed_at');
        })->orderBy('id')->first();

        // Forum highlight (thread terbaru & populer)
        $latestThreads = \App\Models\Post::with('user')->latest()->take(3)->get();
        $popularThreads = \App\Models\Post::with('user')->withCount('likes')->orderByDesc('likes_count')->take(3)->get();

        // Leaderboard rank
        $users = \App\Models\User::where('role', 'student')
            ->withCount(['progress as total_score' => function ($query) {
                $query->select(\DB::raw('sum(score)'));
            }])
            ->orderByDesc('total_score')
            ->get(['id', 'name']);
        $rank = $users->search(function ($u) use ($user) {
            return $u->id === $user->id;
        });
        $leaderboardRank = $rank !== false ? ('#' . ($rank + 1)) : '-';

        return view('dashboard', [
            'completedChallenges' => $completedChallenges,
            'totalChallenges' => $totalChallenges,
            'leaderboardRank' => $leaderboardRank,
            'totalScore' => $totalScore,
            'badges' => $badges,
            'recentActivities' => $recentActivities,
            'inProgress' => $inProgress,
            'maxStreak' => $maxStreak,
            'nextChallenge' => $nextChallenge,
            'latestThreads' => $latestThreads,
            'popularThreads' => $popularThreads,
        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
