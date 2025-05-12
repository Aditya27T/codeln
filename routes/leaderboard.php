<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaderboardController;

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
});
