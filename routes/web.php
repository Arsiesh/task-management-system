<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tasks/archived', [TaskController::class, 'archived'])->name('tasks.archived');
Route::patch('/tasks/{task}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
Route::get('/tasks/filter', [TaskController::class, 'filter'])->name('tasks.filter');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('tasks', TaskController::class);
    Route::patch('tasks/{task}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
});

require __DIR__.'/auth.php';
