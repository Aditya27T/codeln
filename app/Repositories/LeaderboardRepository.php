<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class LeaderboardRepository
{
    public function getLeaderboard($limit = 100)
    {
        return User::where('role', 'student')
            ->withCount(['progress as total_score' => function ($query) {
                $query->select(DB::raw('sum(score)'));
            }])
            ->withCount(['progress as completed_count' => function ($query) {
                $query->whereNotNull('completed_at');
            }])
            ->orderByDesc('total_score')
            ->orderByDesc('completed_count')
            ->take($limit)
            ->get();
    }
}
