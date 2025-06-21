<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/quiz', [QuizController::class, 'chooseLevel'])->name('quiz.choose-level');
Route::post('/quiz/start', [QuizController::class, 'start'])->name('quiz.start');
Route::get('/quiz/question', [QuizController::class, 'showQuestion'])->name('quiz.question');
Route::post('/quiz/answer', [QuizController::class, 'submitAnswer'])->name('quiz.answer');
Route::get('/quiz/result', [QuizController::class, 'result'])->name('quiz.result');

Route::get('/quiz/history', [QuizController::class, 'history'])->name('quiz.history');



require __DIR__.'/auth.php';
