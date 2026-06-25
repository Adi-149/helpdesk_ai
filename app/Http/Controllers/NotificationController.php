<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'all');
        $user = auth()->user();

        if ($tab === 'unread') {
            $notifications = $user->unreadNotifications()->paginate(15)->withQueryString();
        } else {
            $notifications = $user->notifications()->paginate(15)->withQueryString();
        }

        return view('notifications.index', compact('notifications', 'tab'));
    }

    public function getUnread(Request $request)
    {
        $user = auth()->user();
        $unreadNotifications = $user->unreadNotifications()
            ->take(5)
            ->get()
            ->map(function ($notif) {
                return [
                    'id' => $notif->id,
                    'data' => $notif->data,
                    'read_at' => $notif->read_at,
                    'created_at' => $notif->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'notifications' => $unreadNotifications,
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }

    public function click($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $ticketId = $notification->data['ticket_id'] ?? null;
        if ($ticketId) {
            return redirect()->route('tickets.show', $ticketId);
        }

        return redirect()->route('dashboard');
    }

    public function markRead($id)
    {
        $notification = auth()->user()->unreadNotifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Semua notifikasi berhasil ditandai sebagai dibaca.');
    }
}
