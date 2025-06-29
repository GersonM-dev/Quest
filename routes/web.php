<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\MateriController;
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
Route::get('/quiz/my-quizzes', [QuizController::class, 'myQuizzes'])->name('quiz.my-quizzes');
Route::get('/quiz/detail/{id}', [QuizController::class, 'quizDetail'])->name('quiz.detail');

Route::get('/materi', [MateriController::class, 'index'])->name('materi.index');
Route::get('/materi/view/{id}', [MateriController::class, 'view'])->name('materi.view');
Route::post('/materi/timer/{id}', [MateriController::class, 'timer'])->name('materi.timer');





require __DIR__ . '/auth.php';
