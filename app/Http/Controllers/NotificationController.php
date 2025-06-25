<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function read(DatabaseNotification $notification)
    {
        // Mark the notification as read
        $notification->markAsRead();

        // Redirect to the URL stored in the notification data
        return redirect($notification->data['url'] ?? route('instructor.dashboard'));
    }
}
