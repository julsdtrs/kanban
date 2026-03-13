<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())->with('issue')->latest('created_at')->paginate(20);
        return view('notifications.index', compact('notifications'));
    }

    public function show(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }
        $notification->update(['is_read' => true]);
        return view('notifications.show', compact('notification'));
    }

    public function update(Request $request, Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }
        $notification->update($request->validate(['is_read' => 'boolean']));
        return redirect()->route('notifications.index')->with('success', 'Notification updated.');
    }
}
