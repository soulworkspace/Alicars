@extends('layouts.dashboard')

@section('title', 'لوحة التحكم')
@section('page-title', 'نظرة عامة')

@section('content')
    {{-- بطاقات الإحصائيات --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="card stat-card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-newspaper text-emerald-400 text-xl"></i>
                </div>
                <span class="text-xs text-gray-500">إعلاناتي</span>
            </div>
            <p class="text-3xl font-black font-international">{{ $stats['total_ads'] }}</p>
            <p class="text-xs text-emerald-400 mt-1">{{ $stats['active_ads'] }} نشط</p>
        </div>
        
        <div class="card stat-card p-5 border-l-4 border-indigo-500">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-indigo-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-cart-shopping text-indigo-400 text-xl"></i>
                </div>
                <span class="text-xs text-gray-500">مبيعات جديدة</span>
            </div>
            <p class="text-3xl font-black font-international text-indigo-400">{{ $stats['new_orders_count'] }}</p>
            <p class="text-xs text-gray-400 mt-1">طلبات بانتظار الشحن</p>
        </div>

        <div class="card stat-card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-eye text-blue-400 text-xl"></i>
                </div>
                <span class="text-xs text-gray-500">المشاهدات</span>
            </div>
            <p class="text-3xl font-black font-international">{{ number_format($stats['total_views']) }}</p>
            <p class="text-xs text-blue-400 mt-1">إجمالي التفاعل</p>
        </div>
        
        <div class="card stat-card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-envelope text-amber-400 text-xl"></i>
                </div>
                <span class="text-xs text-gray-500">الرسائل</span>
            </div>
            <p class="text-3xl font-black font-international">{{ $stats['unread_messages'] }}</p>
            <p class="text-xs text-amber-400 mt-1">غير مقروءة</p>
        </div>
    </div>
    
    @if($storeStats)
        <div class="card p-6 mb-6 border-l-4 border-emerald-500">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-lg">إحصائيات المتجر</h3>
                <a href="{{ route('vendor.dashboard') }}" class="text-sm text-emerald-400 hover:text-emerald-300">
                    لوحة المتجر <i class="fa-solid fa-arrow-left mr-1"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <p class="text-2xl font-black text-emerald-400">{{ $storeStats['store_views'] }}</p>
                    <p class="text-xs text-gray-500">مشاهدات المتجر</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-black text-emerald-400">{{ $storeStats['store_ads'] }}</p>
                    <p class="text-xs text-gray-500">إعلانات المتجر</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-black text-emerald-400">{{ $storeStats['featured_ads'] }}</p>
                    <p class="text-xs text-gray-500">إعلانات مميزة</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-black text-emerald-400">{{ auth()->user()->store->is_verified ? 'نعم' : 'لا' }}</p>
                    <p class="text-xs text-gray-500">موثق</p>
                </div>
            </div>
        </div>
    @endif
    
    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- قسم أحدث طلبات البيع - هنا تم الإصلاح --}}
            <div class="card p-6 border-t-4 border-indigo-500">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-lg">أحدث طلبات البيع</h3>
                    <span class="text-[10px] bg-indigo-500/10 text-indigo-400 px-2 py-1 rounded-full uppercase tracking-wider">Trico Orders</span>
                </div>
                
                @if($recentOrders->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentOrders as $order)
                            <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg border border-white/5 hover:border-indigo-500/30 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded bg-indigo-500/10 flex items-center justify-center text-indigo-400">
                                        <i class="fa-solid fa-shirt"></i>
                                    </div>
                                    <div>
                                        {{-- تم استخدام الـ Null Safe Operator هنا لمنع الخطأ --}}
                                        <h4 class="font-bold text-sm">{{ $order->listing?->title ?? 'منتج غير متوفر حالياً' }}</h4>
                                        <div class="flex gap-2 mt-1">
                                            <span class="text-[10px] bg-white/10 px-2 py-0.5 rounded text-gray-400">S: {{ $order->size }}</span>
                                            <span class="text-[10px] bg-white/10 px-2 py-0.5 rounded text-gray-400">C: {{ $order->color }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-left text-xs text-gray-500">
                                    <p class="font-black text-emerald-400 text-base">{{ number_format($order->total_price) }} د.ج</p>
                                    <p>{{ $order->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center py-6 text-gray-500 text-sm italic">لا توجد مبيعات جديدة بعد</p>
                @endif
            </div>

            {{-- إعلاناتي الحديثة --}}
            <div class="card p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-lg">إعلاناتي الحديثة</h3>
                    <a href="{{ route('ads.create') }}" class="btn-premium px-4 py-2 rounded-lg text-xs">
                        <i class="fa-solid fa-plus mr-1"></i> إضافة إعلان
                    </a>
                </div>
                
                @forelse($recentAds as $ad)
                    <div class="flex items-center gap-4 p-4 bg-white/5 rounded-lg hover:bg-white/10 transition-colors mb-3">
                        <div class="w-16 h-16 rounded-lg bg-emerald-500/10 flex items-center justify-center overflow-hidden">
                            {{-- التحقق من وجود صورة الإعلان --}}
                            @if($ad->images && $ad->images->first())
                                <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-image text-emerald-400"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold truncate text-sm">{{ $ad->title }}</h4>
                            <div class="flex items-center gap-3 mt-1 text-[10px] text-gray-500">
                                <span class="badge {{ $ad->status === 'active' ? 'badge-emerald' : 'badge-amber' }}">
                                    {{ $ad->status === 'active' ? 'نشط' : 'مراجعة' }}
                                </span>
                                <span><i class="fa-solid fa-eye mr-1"></i>{{ $ad->views_count }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('ads.edit', $ad) }}" class="p-2 text-gray-400 hover:text-emerald-400 transition-colors">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500 text-sm">لا توجد إعلانات</div>
                @endforelse
            </div>
        </div>
        
        <div class="space-y-6">
            {{-- الرسائل الجديدة --}}
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold">رسائل جديدة</h3>
                    <a href="{{ route('messages.index') }}" class="text-xs text-emerald-400 hover:text-emerald-300">عرض الكل</a>
                </div>
                
                @forelse($recentMessages as $message)
                    <a href="{{ route('messages.show', ['user' => $message->sender?->id]) }}" class="flex items-start gap-3 p-3 bg-white/5 rounded-lg hover:bg-white/10 transition-colors mb-2">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-user text-emerald-400 text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-xs truncate">{{ $message->sender?->name ?? 'مستخدم غير معروف' }}</p>
                            <p class="text-[10px] text-gray-500 truncate">{{ Str::limit($message->content, 35) }}</p>
                        </div>
                        @if(!$message->read_at)
                            <span class="w-2 h-2 bg-emerald-500 rounded-full flex-shrink-0 mt-1"></span>
                        @endif
                    </a>
                @empty
                    <p class="text-center py-4 text-gray-500 text-xs italic">صندوق الرسائل فارغ</p>
                @endforelse
            </div>
            
            {{-- إجراءات سريعة --}}
            <div class="card p-6">
                <h3 class="font-bold mb-4">إجراءات سريعة</h3>
                <div class="space-y-2">
                    <a href="{{ route('ads.create') }}" class="flex items-center gap-3 p-3 bg-white/5 rounded-lg hover:bg-emerald-500/10 hover:text-emerald-400 transition-all">
                        <i class="fa-solid fa-plus-circle"></i>
                        <span class="text-sm font-bold">إضافة منتج جديد</span>
                    </a>
                    <a href="{{ route('favorites.index') }}" class="flex items-center gap-3 p-3 bg-white/5 rounded-lg hover:bg-rose-500/10 hover:text-rose-400 transition-all">
                        <i class="fa-solid fa-heart"></i>
                        <span class="text-sm font-bold">المفضلة</span>
                    </a>
                    @if(auth()->user()->hasStore())
                        <a href="{{ route('vendor.store.settings') }}" class="flex items-center gap-3 p-3 bg-white/5 rounded-lg hover:bg-blue-500/10 hover:text-blue-400 transition-all">
                            <i class="fa-solid fa-store"></i>
                            <span class="text-sm font-bold">إعدادات المتجر</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection