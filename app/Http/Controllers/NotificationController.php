<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = max(10, min(100, (int) $request->input('per_page', 10)));
        $query = Notification::where('user_id', auth()->id())->with('issue');
        if ($request->filled('q')) {
            $term = trim((string) $request->input('q'));
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                    ->orWhere('message', 'like', "%{$term}%");
            });
        }
        $notifications = $query->latest('created_at')->paginate($perPage);
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
