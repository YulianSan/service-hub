<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Ticket\TicketController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::inertia('/', 'Welcome')->name('home');
    Route::resource('projects', ProjectController::class)->except('show');
    Route::resource('tickets', TicketController::class)->except('show');
    Route::post(
        '/notifications/{id}/read',
        [NotificationController::class, 'markAsRead']
    )->name('notifications.read');
    Route::post(
        '/notifications/read-all',
        [NotificationController::class, 'markAllAsRead']
    )->name('notifications.readAll');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['guest'])->prefix('login')->group(function () {
    Route::inertia('/', 'Login')->name('login');
    Route::post('/', [AuthController::class, 'login'])->name('login.post');
});
