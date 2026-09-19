@extends('layouts.dashboard')

@section('title', 'الرسائل')
@section('page-title', 'الرسائل')

@section('content')
    <div class="card">
        <div class="p-6 border-b border-white/5">
            <h3 class="font-bold text-lg">المحادثات</h3>
        </div>
        
        @if($conversations->count() > 0)
            <div class="divide-y divide-white/5">
                @foreach($conversations as $conversation)
                    @php
                        $otherUser = $conversation->sender_id === auth()->id() 
                            ? \App\Models\User::find($conversation->recipient_id ?? $conversation->sender_id)
                            : $conversation->sender;
                    @endphp
                    
                    <a href="{{ route('messages.show', ['user' => $otherUser->id, 'ad' => $conversation->ad_id]) }}" 
                       class="flex items-center gap-4 p-6 hover:bg-white/5 transition-colors">
                        <div class="relative">
                            <div class="w-14 h-14 rounded-full bg-emerald-500/20 flex items-center justify-center">
                                @if($otherUser->avatar)
                                    <img src="{{ asset('storage/' . $otherUser->avatar) }}" alt="" class="w-full h-full rounded-full object-cover">
                                @else
                                    <i class="fa-solid fa-user text-emerald-400 text-xl"></i>
                                @endif
                            </div>
                            @if($conversation->message_count > 0 && $conversation->last_message_at > now()->subMinutes(5))
                                <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-[#1a1d23]"></span>
                            @endif
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="font-bold">{{ $otherUser->name }}</h4>
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($conversation->last_message_at)->diffForHumans() }}</span>
                            </div>
                            
                            @if($conversation->ad)
                                <p class="text-xs text-emerald-400 mb-1">
                                    <i class="fa-solid fa-tag mr-1"></i>
                                    {{ Str::limit($conversation->ad->title, 30) }}
                                </p>
                            @endif
                            
                            <p class="text-sm text-gray-400 truncate">
                                {{ $conversation->last_message ?? 'لا توجد رسائل' }}
                            </p>
                        </div>
                        
                        @if($conversation->message_count > 0)
                            <span class="bg-emerald-500 text-black text-xs px-2 py-1 rounded-full font-bold">
                                {{ $conversation->message_count }}
                            </span>
                        @endif
                        
                        <i class="fa-solid fa-chevron-left text-gray-600"></i>
                    </a>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center text-gray-500">
                <div class="w-20 h-20 rounded-full bg-emerald-500/10 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-envelope-open text-emerald-400 text-3xl"></i>
                </div>
                <h4 class="font-bold text-lg mb-2">لا توجد محادثات</h4>
                <p class="text-sm mb-4">ابدأ محادثة جديدة من صفحة أي إعلان</p>
                <a href="{{ route('ads.index') }}" class="btn-premium px-6 py-2 rounded-lg text-xs inline-block">
                    تصفح الإعلانات
                </a>
            </div>
        @endif
    </div>
@endsection
