<div>home.blade.php
    {{-- تعيين العنوان للصفحة في Livewire 3 --}}
    @section('title', 'الرئيسية | TRICO')

    {{-- 1. الهيرو (Hero Section) --}}
    {{-- تأكد أن مكون الهيرو يستخدم الكلاسات المتغيرة (Dark/Light) التي صممناها --}}
    @include('components.x')

    {{-- 2. أحدث الإعلانات (Recent Ads Section) --}}
    <section class="container mx-auto px-4 py-24">
        <div class="flex justify-between items-end mb-12">
            <div class="space-y-2">
                <span class="text-emerald-500 font-black tracking-[0.3em] text-[10px] uppercase">New Arrivals</span>
                <h2 class="text-4xl md:text-5xl font-black tracking-tighter text-zinc-900 dark:text-white uppercase">
                    وصل حديثاً<span class="text-emerald-500">.</span>
                </h2>
            </div>
            <a href="{{ route('ads.index') }}" class="text-zinc-400 hover:text-emerald-500 font-bold text-xs uppercase tracking-widest transition-colors flex items-center gap-2">
                عرض الكل <i class="fa-solid fa-chevron-left text-[8px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-10">
            @forelse($recentAds as $ad)
                <div class="group relative bg-white dark:bg-zinc-900/50 border border-zinc-100 dark:border-zinc-800/50 p-3 rounded-[2.5rem] transition-all duration-500 hover:shadow-2xl hover:shadow-emerald-500/10">
                    {{-- صورة المنتج --}}
                    <div class="aspect-[4/5] overflow-hidden rounded-[2rem] mb-6 bg-zinc-100 dark:bg-zinc-800 relative">
                        @if($ad->primaryImage)
                            <img src="{{ asset('storage/' . $ad->primaryImage->image_path) }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-zinc-300 dark:text-zinc-700">
                                <i class="fa-solid fa-image text-4xl"></i>
                            </div>
                        @endif
                        
                        {{-- سعر عائم --}}
                        <div class="absolute bottom-4 right-4 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-md px-4 py-2 rounded-full shadow-lg">
                            <span class="text-emerald-500 dark:text-emerald-400 font-black text-sm tracking-tighter">
                                {{ number_format($ad->price) }} <small class="text-[8px]">د.ج</small>
                            </span>
                        </div>
                    </div>

                    {{-- تفاصيل المنتج --}}
                    <div class="px-3 pb-4">
                        <h3 class="font-black text-zinc-900 dark:text-white text-lg truncate uppercase tracking-tight mb-2">
                            {{ $ad->title }}
                        </h3>
                        <div class="flex justify-between items-center text-[10px] font-bold text-zinc-400 uppercase tracking-widest">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-emerald-500/50"></i>
                                {{ $ad->city ?? 'الجزائر' }}
                            </span>
                            <span>{{ $ad->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    
                    {{-- رابط الإعلان الكامل --}}
                    <a href="#" class="absolute inset-0 z-20"></a>
                </div>
            @empty
                {{-- حالة التحميل / السكيلتون --}}
                @for($i = 0; $i < 4; $i++)
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-[2.5rem] animate-pulse">
                        <div class="aspect-[4/5] rounded-[2rem] mb-4 bg-zinc-200 dark:bg-zinc-800"></div>
                        <div class="h-6 w-3/4 bg-zinc-200 dark:bg-zinc-800 rounded-md mb-2"></div>
                        <div class="h-4 w-1/4 bg-zinc-100 dark:bg-zinc-800 rounded-md"></div>
                    </div>
                @endfor
            @endforelse
        </div>
    </section>

    {{-- 3. قسم التصنيفات (Category Grid) --}}
    <div class="py-10">
        <x-category-grid />
    </div>

    {{-- 4. إحصائيات المنصة (Stats) --}}
    {{-- تم تضمين الكود العالمي الذي صممناه سابقاً --}}
    @include('components.stats')

</div>