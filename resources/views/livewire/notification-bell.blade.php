<div class="relative">
    <button wire:click="toggleDropdown" class="text-xl hover:text-emerald-500 transition-colors relative">
        <i class="fa-regular fa-bell"></i>
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-rose-500 rounded-full text-[10px] flex items-center justify-center text-white font-bold">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
        @endif
    </button>
    
    @if($showDropdown)
        <div class="absolute left-0 mt-2 w-80 bg-[#16181d] border border-white/10 rounded-xl shadow-2xl z-50" wire:click.outside="$set('showDropdown', false)">
            <div class="p-4 border-b border-white/10 flex items-center justify-between">
                <h3 class="font-bold">الإشعارات</h3>
                @if($unreadCount > 0)
                    <button wire:click="markAllAsRead" class="text-xs text-emerald-400 hover:text-emerald-300">
                        تحديد الكل كمقروء
                    </button>
                @endif
            </div>
            
            <div class="max-h-96 overflow-y-auto">
                @forelse($notifications as $notification)
                    <div class="p-4 border-b border-white/5 hover:bg-white/5 transition-colors {{ $notification['read_at'] ? '' : 'bg-emerald-500/5' }}">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-bell text-emerald-400 text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium truncate">{{ $notification['data']['title'] ?? 'إشعار جديد' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $notification['data']['message'] ?? '' }}</p>
                                <p class="text-[10px] text-gray-600 mt-2">{{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}</p>
                            </div>
                            @if(!$notification['read_at'])
                                <button wire:click="markAsRead('{{ $notification['id'] }}')" class="text-emerald-400 hover:text-emerald-300">
                                    <i class="fa-solid fa-check text-xs"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <i class="fa-regular fa-bell-slash text-3xl mb-3"></i>
                        <p class="text-sm">لا توجد إشعارات</p>
                    </div>
                @endforelse
            </div>
            
            <div class="p-3 border-t border-white/10 text-center">
                <a href="{{ route('notifications.index') }}" class="text-sm text-emerald-400 hover:text-emerald-300">
                    عرض كل الإشعارات
                </a>
            </div>
        </div>
    @endif
</div>
