@extends('layouts.dashboard')

@section('title', 'إحصائيات المتجر')
@section('page-title', 'إحصائيات المتجر')

@section('content')
    <!-- Store Overview -->
    <div class="card p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-emerald-500/20 flex items-center justify-center overflow-hidden">
                @if($store->logo)
                    <img src="{{ asset('storage/' . $store->logo) }}" alt="" class="w-full h-full object-cover">
                @else
                    <i class="fa-solid fa-store text-emerald-400 text-2xl"></i>
                @endif
            </div>
            <div>
                <h2 class="text-xl font-black">{{ $store->name }}</h2>
                <p class="text-sm text-gray-500">إحصائيات وأداء المتجر</p>
            </div>
        </div>
    </div>
    
    <!-- Monthly Stats Chart -->
    <div class="card p-6 mb-6">
        <h3 class="font-bold text-lg mb-6">النشاط الشهري</h3>
        
        <div class="space-y-4">
            @foreach($monthlyStats as $stat)
                <div class="flex items-center gap-4">
                    <div class="w-12 text-sm font-bold text-gray-500">{{ $stat['month'] }}</div>
                    <div class="flex-1">
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-emerald-400">إعلانات</span>
                                    <span class="text-xs font-bold">{{ $stat['ads'] }}</span>
                                </div>
                                <div class="h-2 bg-emerald-500/20 rounded-full overflow-hidden">
                                    @php $maxAds = max(array_column($monthlyStats, 'ads')) ?: 1; @endphp
                                    <div class="h-full bg-emerald-500 rounded-full" style="width: {{ ($stat['ads'] / $maxAds) * 100 }}%"></div>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-blue-400">مشاهدات</span>
                                    <span class="text-xs font-bold">{{ number_format($stat['views']) }}</span>
                                </div>
                                <div class="h-2 bg-blue-500/20 rounded-full overflow-hidden">
                                    @php $maxViews = max(array_column($monthlyStats, 'views')) ?: 1; @endphp
                                    <div class="h-full bg-blue-500 rounded-full" style="width: {{ ($stat['views'] / $maxViews) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Top Performing Ads -->
        <div class="card p-6">
            <h3 class="font-bold text-lg mb-6">أفضل الإعلانات أداءً</h3>
            
            @if($topAds->count() > 0)
                <div class="space-y-4">
                    @foreach($topAds as $ad)
                        <div class="flex items-center gap-4 p-4 bg-white/5 rounded-lg">
                            <div class="w-14 h-14 rounded-lg bg-emerald-500/10 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                @if($ad->images->first())
                                    <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-image text-emerald-400"></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-sm truncate">{{ $ad->title }}</h4>
                                <div class="flex items-center gap-3 mt-1 text-xs text-gray-500">
                                    <span class="text-blue-400"><i class="fa-solid fa-eye mr-1"></i>{{ $ad->views_count ?? 0 }}</span>
                                    <span class="text-emerald-400">{{ number_format($ad->price ?? 0) }} د.ج</span>
                                </div>
                            </div>
                            <a href="{{ route('ads.show', $ad->slug) }}" class="text-gray-400 hover:text-emerald-400">
                                <i class="fa-solid fa-external-link-alt"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fa-solid fa-chart-line text-4xl mb-4 opacity-30"></i>
                    <p>لا توجد إعلانات نشطة</p>
                </div>
            @endif
        </div>
        
        <!-- Category Breakdown -->
        <div class="card p-6">
            <h3 class="font-bold text-lg mb-6">الإعلانات حسب التصنيف</h3>
            
            @if($categoryStats->count() > 0)
                <div class="space-y-4">
                    @foreach($categoryStats as $stat)
                        <div class="flex items-center gap-4">
                            <div class="w-32 text-sm truncate">{{ $stat->category?->name ?? 'غير مصنف' }}</div>
                            <div class="flex-1">
                                @php $maxCount = $categoryStats->max('count') ?: 1; @endphp
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 h-2 bg-white/10 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ ($stat->count / $maxCount) * 100 }}%"></div>
                                    </div>
                                    <span class="text-sm font-bold w-8">{{ $stat->count }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fa-solid fa-tags text-4xl mb-4 opacity-30"></i>
                    <p>لا توجد بيانات</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Export Button -->
    <div class="mt-6 text-center">
        <button onclick="window.print()" class="btn-outline px-6 py-3 rounded-xl">
            <i class="fa-solid fa-print mr-2"></i> طباعة التقرير
        </button>
    </div>
@endsection
