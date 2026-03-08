<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        try {
            $notification = request()->user()->notifications()->findOrFail($id);
            $notification->markAsRead();

            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Notification not found');
        } catch (Throwable $e) {
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function markAllAsRead()
    {
        try {
            request()->user()->unreadNotifications->markAsRead();

            return redirect()->back();
        } catch (Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
