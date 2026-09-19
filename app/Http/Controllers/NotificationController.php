<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }
    
    public function markRead($id)
    {
        $notification = DatabaseNotification::find($id);
        
        if ($notification && $notification->notifiable_id === auth()->id()) {
            $notification->markAsRead();
        }
        
        return response()->json(['success' => true]);
    }
    
    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        return back()->with('success', 'تم تحديد جميع الإشعارات كمقروءة');
    }
    
    public function destroy($id)
    {
        $notification = DatabaseNotification::find($id);
        
        if ($notification && $notification->notifiable_id === auth()->id()) {
            $notification->delete();
        }
        
        return back()->with('success', 'تم حذف الإشعار');
    }
}
