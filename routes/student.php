<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SolveController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\RunCodeController;
use App\Http\Controllers\AnalyzeCodeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForumController;

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
    // Material routes
    Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
    // Question routes
    Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');
    // Solve routes
    Route::get('/solve/{question}', [SolveController::class, 'show'])->name('solve.show');
    Route::post('/solve/{question}', [SolveController::class, 'submit'])->name('solve.submit');
    Route::get('/api/question/{question}/template/{language}', [TemplateController::class, 'getTemplate']);
    // Run code via Piston API
    Route::post('/run-code', [RunCodeController::class, 'execute'])->name('run.code');
    // Analyze code with Gemini AI
    Route::post('/analyze-code', [AnalyzeCodeController::class, 'analyze'])->name('analyze.code');
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Forum routes
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::post('/forum/post', [ForumController::class, 'storePost'])->name('forum.post');
    Route::post('/forum/reply', [ForumController::class, 'storeReply'])->name('forum.reply');
    Route::post('/forum/like', [ForumController::class, 'like'])->name('forum.like');
    Route::get('/forum/thread/{id}', [ForumController::class, 'threadJson'])->name('forum.thread.json');
});
