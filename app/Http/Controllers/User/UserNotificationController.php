<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class UserNotificationController extends Controller
{
    public function index()
    {
        $customer = auth('customer')->user();

        $notifications = Notification::where('customer_id', $customer->id)
            ->latest()
            ->paginate(15);

        $unreadCount = Notification::where('customer_id', $customer->id)
            ->whereNull('read_at')
            ->count();

        return view('user.notifications', compact('customer', 'notifications', 'unreadCount'));
    }

    // Marks one notification as read, then goes to its link (if it has one)
    public function read(Notification $notification)
    {
        abort_unless($notification->customer_id === auth('customer')->id(), 403);

        if (is_null($notification->read_at)) {
            $notification->update(['read_at' => now()]);
        }

        return $notification->url
            ? redirect()->to($notification->url)
            : redirect()->route('user.notifications');
    }

    public function readAll()
    {
        Notification::where('customer_id', auth('customer')->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('success', 'All notifications marked as read.');
    }
}