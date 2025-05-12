<?php
namespace App\Services;

use App\Repositories\LeaderboardRepository;

class LeaderboardService
{
    protected $leaderboardRepository;
    public function __construct(LeaderboardRepository $leaderboardRepository)
    {
        $this->leaderboardRepository = $leaderboardRepository;
    }
    public function getLeaderboard($limit = 100)
    {
        return $this->leaderboardRepository->getLeaderboard($limit);
    }
}
