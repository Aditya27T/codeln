<?php

namespace App\Http\Controllers;

use App\Models\UserProgress;
use App\Models\User;
use App\Services\LeaderboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    protected $leaderboardService;
    public function __construct(LeaderboardService $leaderboardService)
    {
        $this->leaderboardService = $leaderboardService;
    }
    public function index()
    {
        $leaderboard = $this->leaderboardService->getLeaderboard();
        return view('leaderboard.index', compact('leaderboard'));
    }
}