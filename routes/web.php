<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('dashboard');
        }
    }
    return view('welcome');
});

// Auth routes (enabled by Breeze)
// ...

require __DIR__.'/student.php';
require __DIR__.'/admin.php';
require __DIR__.'/leaderboard.php';


require __DIR__.'/auth.php';
