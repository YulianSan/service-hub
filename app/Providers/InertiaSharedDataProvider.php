<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class InertiaSharedDataProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void {
        inertia()->share([
            'notifications' => function () {
                $user = Auth::user();
                return $user ? $user->unreadNotifications->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'type' => class_basename($notification->type),
                        'data' => $notification->data,
                        'read_at' => $notification->read_at,
                        'created_at' => $notification->created_at->toDateTimeString(),
                    ];
                }) : [];
            },
        ]);
    }
}
