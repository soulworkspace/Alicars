@extends('layouts.dashboard')

@section('title', 'لوحة المتجر')
@section('page-title', 'لوحة التحكم - ' . $store->name)

@section('content')
    <!-- Store Header -->
    <div class="card p-6 mb-6">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <div class="w-24 h-24 rounded-2xl bg-emerald-500/20 flex items-center justify-center overflow-hidden">
                @if($store->logo)
                    <img src="{{ asset('storage/' . $store->logo) }}" alt="" class="w-full h-full object-cover">
                @else
                    <i class="fa-solid fa-store text-emerald-400 text-3xl"></i>
                @endif
            </div>
            
            <div class="flex-1 text-center md:text-right">
                <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                    <h2 class="text-2xl font-black">{{ $store->name }}</h2>
                    @if($store->is_verified)
                        <span class="badge badge-emerald" title="متجر موثق"><i class="fa-solid fa-check-circle"></i></span>
                    @endif
                </div>
                <p class="text-gray-400 text-sm mb-3">{{ Str::limit($store->description, 100) ?? 'لا يوجد وصف' }}</p>
                <div class="flex items-center justify-center md:justify-start gap-4 text-xs">
                    <span class="text-gray-500"><i class="fa-solid fa-map-marker-alt ml-1"></i>{{ $store->city ?? 'غير محدد' }}</span>
                    <span class="text-gray-500"><i class="fa-solid fa-calendar ml-1"></i>منذ {{ $store->created_at->diffForHumans() }}</span>
                    <span class="badge {{ $store->is_active ? 'badge-emerald' : 'badge-amber' }}">
                        {{ $store->is_active ? 'نشط' : 'معطل' }}
                    </span>
                </div>
            </div>
            
            <div class="flex gap-2">
                <a href="{{ route('stores.show', $store->slug) }}" target="_blank" class="btn-outline px-4 py-2 rounded-lg text-xs">
                    <i class="fa-solid fa-external-link-alt mr-1"></i> عرض المتجر
                </a>
                <a href="{{ route('vendor.store.settings') }}" class="btn-premium px-4 py-2 rounded-lg text-xs">
                    <i class="fa-solid fa-gear mr-1"></i> الإعدادات
                </a>
            </div>
        </div>
    </div>
    
    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="card stat-card p-5 text-center">
            <i class="fa-solid fa-newspaper text-emerald-400 text-2xl mb-2"></i>
            <p class="text-2xl font-black font-international">{{ $stats['total_ads'] }}</p>
            <p class="text-xs text-gray-500">إجمالي الإعلانات</p>
        </div>
        
        <div class="card stat-card p-5 text-center">
            <i class="fa-solid fa-check-circle text-emerald-400 text-2xl mb-2"></i>
            <p class="text-2xl font-black font-international">{{ $stats['active_ads'] }}</p>
            <p class="text-xs text-gray-500">إعلانات نشطة</p>
        </div>
        
        <div class="card stat-card p-5 text-center">
            <i class="fa-solid fa-star text-amber-400 text-2xl mb-2"></i>
            <p class="text-2xl font-black font-international">{{ $stats['featured_ads'] }}</p>
            <p class="text-xs text-gray-500">إعلانات مميزة</p>
        </div>
        
        <div class="card stat-card p-5 text-center">
            <i class="fa-solid fa-eye text-blue-400 text-2xl mb-2"></i>
            <p class="text-2xl font-black font-international">{{ number_format($stats['total_views']) }}</p>
            <p class="text-xs text-gray-500">مشاهدات</p>
        </div>
        
        <div class="card stat-card p-5 text-center">
            <i class="fa-solid fa-store text-purple-400 text-2xl mb-2"></i>
            <p class="text-2xl font-black font-international">{{ $stats['store_views'] }}</p>
            <p class="text-xs text-gray-500">مشاهدات المتجر</p>
        </div>
    </div>
    
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Recent Ads -->
        <div class="lg:col-span-2">
            <div class="card p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-lg">إعلانات المتجر</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('vendor.ads.manage') }}" class="text-sm text-emerald-400 hover:text-emerald-300">
                            إدارة الإعلانات <i class="fa-solid fa-arrow-left mr-1"></i>
                        </a>
                    </div>
                </div>
                
                @if($recentAds->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentAds as $ad)
                            <div class="flex items-center gap-4 p-4 bg-white/5 rounded-lg">
                                <div class="w-16 h-16 rounded-lg bg-emerald-500/10 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if($ad->images->first())
                                        <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-solid fa-image text-emerald-400"></i>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold truncate">{{ $ad->title }}</h4>
                                    <div class="flex items-center gap-3 mt-1 text-xs text-gray-500">
                                        <span class="badge {{ $ad->status === 'active' ? 'badge-emerald' : ($ad->status === 'pending' ? 'badge-amber' : 'badge-rose') }}">
                                            {{ $ad->status === 'active' ? 'نشط' : ($ad->status === 'pending' ? 'قيد المراجعة' : 'منتهي') }}
                                        </span>
                                        @if($ad->is_featured)
                                            <span class="badge badge-amber"><i class="fa-solid fa-star mr-1"></i>مميز</span>
                                        @endif
                                        <span><i class="fa-solid fa-eye mr-1"></i>{{ $ad->views_count ?? 0 }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('ads.show', $ad->slug) }}" class="p-2 text-gray-400 hover:text-emerald-400">
                                        <i class="fa-solid fa-external-link-alt"></i>
                                    </a>
                                    <a href="{{ route('ads.edit', $ad) }}" class="p-2 text-gray-400 hover:text-emerald-400">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-newspaper text-4xl mb-4 opacity-30"></i>
                        <p>لا توجد إعلانات في المتجر</p>
                        <a href="{{ route('ads.create') }}" class="btn-premium px-6 py-2 rounded-lg text-xs mt-4 inline-block">
                            إضافة إعلان
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Side Actions -->
        <div class="space-y-6">
            <div class="card p-6">
                <h3 class="font-bold mb-4">إجراءات سريعة</h3>
                <div class="space-y-2">
                    <a href="{{ route('ads.create') }}" class="flex items-center gap-3 p-3 bg-emerald-500/10 text-emerald-400 rounded-lg hover:bg-emerald-500/20 transition-colors">
                        <i class="fa-solid fa-plus-circle"></i>
                        <span class="text-sm font-bold">إضافة إعلان جديد</span>
                    </a>
                    <a href="{{ route('vendor.analytics') }}" class="flex items-center gap-3 p-3 bg-white/5 rounded-lg hover:bg-white/10 transition-colors">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span class="text-sm font-bold">الإحصائيات</span>
                    </a>
                    <a href="{{ route('vendor.store.settings') }}" class="flex items-center gap-3 p-3 bg-white/5 rounded-lg hover:bg-white/10 transition-colors">
                        <i class="fa-solid fa-gear"></i>
                        <span class="text-sm font-bold">إعدادات المتجر</span>
                    </a>
                </div>
            </div>
            
            @if($stats['pending_ads'] > 0)
                <div class="card p-6 border-amber-500/30">
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fa-solid fa-clock text-amber-400 text-xl"></i>
                        <h4 class="font-bold text-amber-400">إعلانات قيد المراجعة</h4>
                    </div>
                    <p class="text-sm text-gray-400 mb-3">لديك {{ $stats['pending_ads'] }} إعلان في انتظار الموافقة</p>
                    <a href="{{ route('vendor.ads.manage') }}" class="text-sm text-amber-400 hover:text-amber-300">
                        عرض الإعلانات <i class="fa-solid fa-arrow-left mr-1"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
