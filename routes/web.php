<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::inertia('/', 'Welcome')->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['guest'])->prefix('login')->group(function () {
    Route::inertia('/', 'Login')->name('login');
    Route::post('/', [AuthController::class, 'login'])->name('login.post');
});
