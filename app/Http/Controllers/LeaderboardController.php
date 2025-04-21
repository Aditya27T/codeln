<?php

namespace App\Http\Controllers;

use App\Models\UserProgress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index()
    {
        $leaderboard = User::where('role', 'student')
            ->withCount(['progress as total_score' => function ($query) {
                $query->select(DB::raw('sum(score)'));
            }])
            ->withCount(['progress as completed_count' => function ($query) {
                $query->whereNotNull('completed_at');
            }])
            ->orderByDesc('total_score')
            ->orderByDesc('completed_count')
            ->take(100)
            ->get();
        
        return view('leaderboard.index', compact('leaderboard'));
    }
}