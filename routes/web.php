<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SolveController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForumController;

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

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\ProfileController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

    // Material routes
    Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');

    // Question routes
    Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');

    // Solve routes
    Route::get('/solve/{question}', [SolveController::class, 'show'])->name('solve.show');
    Route::post('/solve/{question}', [SolveController::class, 'submit'])->name('solve.submit');
    Route::get('/api/question/{question}/template/{language}', [App\Http\Controllers\TemplateController::class, 'getTemplate']);


    // Run code via Piston API
    Route::post('/run-code', [\App\Http\Controllers\RunCodeController::class, 'execute'])->name('run.code');

    // Analyze code with Gemini AI
    Route::post('/analyze-code', [App\Http\Controllers\AnalyzeCodeController::class, 'analyze'])->name('analyze.code');
    // Leaderboard route
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::post('/forum/post', [ForumController::class, 'storePost'])->name('forum.post');
    Route::post('/forum/reply', [ForumController::class, 'storeReply'])->name('forum.reply');
    Route::post('/forum/like', [ForumController::class, 'like'])->name('forum.like');
Route::get('/forum/thread/{id}', [ForumController::class, 'threadJson'])->name('forum.thread.json');
});

// Admin routes with middleware
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Materials management
    Route::get('/materials', [AdminController::class, 'materials'])->name('materials.index');
    Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.create');
    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::get('/materials/{material}/edit', [MaterialController::class, 'edit'])->name('materials.edit');
    Route::put('/materials/{material}', [MaterialController::class, 'update'])->name('materials.update');
    Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');
    
    // Questions management
    Route::get('/questions', [AdminController::class, 'questions'])->name('questions.index');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    
    // Users management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{id}/edit', [AdminController::class, 'usersEdit'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'usersUpdate'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'usersDestroy'])->name('users.destroy');
    
});

require __DIR__.'/auth.php';
