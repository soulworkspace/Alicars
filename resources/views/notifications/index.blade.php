@extends('layouts.dashboard')

@section('title', 'الإشعارات')
@section('page-title', 'الإشعارات')

@section('content')
    <div class="card">
        <div class="p-6 border-b border-white/5 flex items-center justify-between">
            <h3 class="font-bold text-lg">جميع الإشعارات</h3>
            
            @if(auth()->user()->unreadNotifications()->count() > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-emerald-400 hover:text-emerald-300">
                        تحديد الكل كمقروء
                    </button>
                </form>
            @endif
        </div>
        
        @if($notifications->count() > 0)
            <div class="divide-y divide-white/5">
                @foreach($notifications as $notification)
                    <div class="p-6 {{ $notification->read_at ? '' : 'bg-emerald-500/5' }}">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-bell text-emerald-400 text-xl"></i>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-bold {{ $notification->read_at ? '' : 'text-emerald-400' }}">
                                        {{ $notification->data['title'] ?? 'إشعار جديد' }}
                                    </h4>
                                    <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                
                                <p class="text-sm text-gray-400 mb-3">{{ $notification->data['message'] ?? '' }}</p>
                                
                                @if(isset($notification->data['action_url']))
                                    <a href="{{ $notification->data['action_url'] }}" class="text-sm text-emerald-400 hover:text-emerald-300 inline-flex items-center gap-2">
                                        {{ $notification->data['action_text'] ?? 'عرض التفاصيل' }}
                                        <i class="fa-solid fa-arrow-left"></i>
                                    </a>
                                @endif
                                
                                <div class="flex items-center gap-4 mt-4">
                                    @if(!$notification->read_at)
                                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs text-emerald-400 hover:text-emerald-300">
                                                <i class="fa-solid fa-check mr-1"></i> تحديد كمقروء
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-rose-400 hover:text-rose-300">
                                            <i class="fa-solid fa-trash mr-1"></i> حذف
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="p-4 border-t border-white/5">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="p-12 text-center text-gray-500">
                <div class="w-20 h-20 rounded-full bg-amber-500/10 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-regular fa-bell text-amber-400 text-3xl"></i>
                </div>
                <h4 class="font-bold text-lg mb-2">لا توجد إشعارات</h4>
                <p class="text-sm">سيتم إشعارك هنا عند حدوث أي نشاط مهم</p>
            </div>
        @endif
    </div>
@endsection
