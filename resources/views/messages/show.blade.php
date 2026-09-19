@extends('layouts.dashboard')

@section('title', 'محادثة مع ' . $otherUser->name)
@section('page-title', 'الرسائل')

@section('content')
    <div class="card flex flex-col h-[calc(100vh-200px)]">
        <!-- Chat Header -->
        <div class="p-4 border-b border-white/5 flex items-center gap-4">
            <a href="{{ route('messages.index') }}" class="text-gray-400 hover:text-white">
                <i class="fa-solid fa-arrow-right"></i>
            </a>
            
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center">
                    @if($otherUser->avatar)
                        <img src="{{ asset('storage/' . $otherUser->avatar) }}" alt="" class="w-full h-full rounded-full object-cover">
                    @else
                        <i class="fa-solid fa-user text-emerald-400"></i>
                    @endif
                </div>
                <div>
                    <h4 class="font-bold">{{ $otherUser->name }}</h4>
                    @if($ad)
                        <a href="{{ route('ads.show', $ad->slug) }}" class="text-xs text-emerald-400 hover:text-emerald-300">
                            <i class="fa-solid fa-tag mr-1"></i>{{ Str::limit($ad->title, 30) }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messages-container">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-start' : 'justify-end' }}">
                    <div class="max-w-[70%] {{ $message->sender_id === auth()->id() ? 'bg-emerald-500/20 text-emerald-100' : 'bg-white/10 text-white' }} rounded-2xl px-4 py-3">
                        <p class="text-sm">{{ $message->content }}</p>
                        <p class="text-[10px] {{ $message->sender_id === auth()->id() ? 'text-emerald-400' : 'text-gray-500' }} mt-1 text-left">
                            {{ $message->created_at->format('H:i') }}
                            @if($message->sender_id === auth()->id())
                                <i class="fa-solid {{ $message->read_at ? 'fa-check-double' : 'fa-check' }} mr-1"></i>
                            @endif
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-500">
                    <i class="fa-solid fa-comments text-4xl mb-4 opacity-30"></i>
                    <p>ابدأ المحادثة بإرسال رسالة</p>
                </div>
            @endforelse
        </div>
        
        <!-- Message Input -->
        <div class="p-4 border-t border-white/5">
            <form action="{{ route('messages.store') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="hidden" name="recipient_id" value="{{ $otherUser->id }}">
                @if($ad)
                    <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                @endif
                
                <input type="text" name="content" placeholder="اكتب رسالتك..." 
                    class="form-input flex-1 px-4 py-3 rounded-xl" required>
                
                <button type="submit" class="btn-premium px-6 py-3 rounded-xl">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Auto-scroll to bottom of messages
    const container = document.getElementById('messages-container');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
</script>
@endsection
