<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Ad;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = Message::select('sender_id', 'ad_id')
            ->selectRaw('MAX(created_at) as last_message_at')
            ->selectRaw('COUNT(*) as message_count')
            ->where('recipient_id', Auth::id())
            ->orWhere('sender_id', Auth::id())
            ->with(['sender:id,name,avatar', 'ad:id,title,slug'])
            ->groupBy('sender_id', 'ad_id')
            ->orderByDesc('last_message_at')
            ->get();
        
        return view('messages.index', compact('conversations'));
    }
    
    public function show(Request $request)
    {
        $otherUserId = $request->query('user');
        $adId = $request->query('ad');
        
        if (!$otherUserId) {
            return redirect()->route('messages.index');
        }
        
        $otherUser = User::findOrFail($otherUserId);
        
        $messages = Message::where(function ($query) use ($otherUserId) {
                $query->where('sender_id', Auth::id())
                      ->where('recipient_id', $otherUserId);
            })
            ->orWhere(function ($query) use ($otherUserId) {
                $query->where('sender_id', $otherUserId)
                      ->where('recipient_id', Auth::id());
            })
            ->when($adId, function ($query) use ($adId) {
                $query->where('ad_id', $adId);
            })
            ->with(['sender:id,name,avatar'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Mark messages as read
        Message::where('sender_id', $otherUserId)
            ->where('recipient_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        
        $ad = $adId ? Ad::find($adId) : null;
        
        return view('messages.show', compact('messages', 'otherUser', 'ad'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'ad_id' => 'nullable|exists:ads,id',
            'content' => 'required|string|max:5000',
        ]);
        
        $message = Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $validated['recipient_id'],
            'ad_id' => $validated['ad_id'] ?? null,
            'content' => $validated['content'],
        ]);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }
        
        return back()->with('success', 'تم إرسال الرسالة بنجاح');
    }
    
    public function start(Request $request, User $user)
    {
        $adId = $request->query('ad');
        
        return redirect()->route('messages.show', [
            'user' => $user->id,
            'ad' => $adId,
        ]);
    }
    
    public function destroy(Message $message)
    {
        $this->authorize('delete', $message);
        
        $message->delete();
        
        return back()->with('success', 'تم حذف الرسالة بنجاح');
    }
}
