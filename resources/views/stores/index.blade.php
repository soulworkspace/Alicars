@extends('layouts.app')

@section('title', 'المتاجر الرسمية | TRICO Partners')

@section('content')
{{-- الحاوية الرئيسية بألوان ناعمة جداً وتدرج ليلي احترافي --}}
<div class="bg-[#fcfcfc] dark:bg-[#080808] min-h-screen pb-32 transition-colors duration-700 ease-in-out" dir="rtl">
    
    {{-- 1. Hero Section: تصميم "مينيمال" بسيط يركز على الفخامة --}}
    <div class="relative pt-32 pb-24 overflow-hidden">
        {{-- تأثير ضوئي خفي في الخلفية للوضع الليلي --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-emerald-500/5 via-transparent to-transparent opacity-0 dark:opacity-100"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center space-y-6">
                <h1 class="text-4xl md:text-7xl font-light tracking-tight text-zinc-900 dark:text-zinc-50">
                    متاجر <span class="font-black italic">TRICO</span> <span class="text-emerald-500">.</span>
                </h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-lg md:text-xl font-light leading-relaxed max-w-2xl mx-auto">
                    انغمس في عالم من الأناقة المختارة، حيث تلتقي أفضل العلامات التجارية الجزائرية في منصة واحدة.
                </p>
            </div>
        </div>
    </div>

    {{-- 2. Filters Bar: شريط تصفية بسيط ومنظم --}}
    <div class="container mx-auto px-6 lg:px-20 mb-16">
        <div class="flex flex-col md:flex-row justify-between items-center border-b border-zinc-100 dark:border-white/[0.05] pb-8 gap-6">
            <div class="flex items-center gap-8 overflow-x-auto no-scrollbar w-full md:w-auto">
                <a href="#" class="text-[11px] font-black uppercase tracking-[0.2em] text-emerald-500 border-b-2 border-emerald-500 pb-8 -mb-[34px]">الكل</a>
                <a href="#" class="text-[11px] font-black uppercase tracking-[0.2em] text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors pb-8">الأكثر مبيعاً</a>
                <a href="#" class="text-[11px] font-black uppercase tracking-[0.2em] text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors pb-8">الموثقة حديثاً</a>
            </div>
            <div class="relative w-full md:w-64">
                <input type="text" placeholder="ابحث عن متجر..." class="w-full bg-zinc-100 dark:bg-white/[0.03] border-none rounded-xl py-3 px-5 text-sm focus:ring-1 focus:ring-emerald-500/30 dark:text-white">
            </div>
        </div>
    </div>

    {{-- 3. Stores Grid: شبكة العرض --}}
    <div class="container mx-auto px-6 lg:px-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-24">
            @foreach($stores as $store)
                <div class="group relative flex flex-col">
                    {{-- حامل الصورة (Image Holder) --}}
                    <div class="relative aspect-[16/11] overflow-hidden rounded-[2rem] bg-zinc-100 dark:bg-zinc-900 mb-8 border border-zinc-200/20 dark:border-white/[0.02]">
                        @if($store->cover_image)
                            <img src="{{ asset('storage/' . $store->cover_image) }}" 
                                 class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110" 
                                 alt="{{ $store->name }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-zinc-200 to-zinc-300 dark:from-[#121212] dark:to-[#1a1a1a]"></div>
                        @endif
                        
                        {{-- الطبقة الزجاجية عند التحويم --}}
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-700"></div>

                        {{-- اللوغو: طافٍ بنعومة --}}
                        <div class="absolute bottom-6 right-6 z-10">
                            <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl bg-white/95 dark:bg-[#121212]/95 backdrop-blur-xl p-1 shadow-2xl ring-1 ring-black/5 dark:ring-white/5 transition-transform duration-700 group-hover:-translate-y-2">
                                <img src="{{ $store->logo ? asset('storage/' . $store->logo) : 'https://ui-avatars.com/api/?name=' . $store->name }}" 
                                     class="w-full h-full object-cover rounded-[14px]">
                            </div>
                        </div>
                    </div>

                    {{-- معلومات المتجر --}}
                    <div class="space-y-4 px-2">
                        <div class="flex items-center justify-between gap-4">
                            <h3 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 tracking-tight group-hover:text-emerald-500 transition-colors duration-500">
                                {{ $store->name }}
                            </h3>
                            @if($store->is_verified)
                                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                            @endif
                        </div>
                        
                        <p class="text-zinc-500 dark:text-zinc-500 text-[15px] leading-relaxed line-clamp-2 font-light italic">
                            {{ $store->description ?? 'بوابة الأناقة الجزائرية المعاصرة، استكشف مجموعتنا الحصرية الآن.' }}
                        </p>

                        <div class="flex items-center gap-6 pt-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-zinc-900 dark:text-zinc-100 uppercase tracking-widest">{{ $store->ads_count ?? $store->ads()->count() }}</span>
                                <span class="text-[9px] text-zinc-400 uppercase tracking-widest font-bold">إعلان</span>
                            </div>
                            <div class="w-[1px] h-6 bg-zinc-100 dark:bg-white/10"></div>
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-zinc-900 dark:text-zinc-100 uppercase tracking-widest">{{ $store->city ?? 'الجزائر' }}</span>
                                <span class="text-[9px] text-zinc-400 uppercase tracking-widest font-bold">المقر</span>
                            </div>
                        </div>
                    </div>

                    {{-- الرابط الخفي الشامل --}}
                    <a href="{{ route('stores.show', $store->slug) }}" class="absolute inset-0 z-20" aria-label="Visit {{ $store->name }}"></a>
                </div>
            @endforeach
        </div>

        {{-- 4. Pagination: بسيط وأنيق --}}
        <div class="mt-32 py-12 border-t border-zinc-100 dark:border-white/5 flex justify-center">
            <div class="inline-flex items-center gap-4">
                {{ $stores->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    /* لمسة نهائية للخطوط والتمرير */
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;700;800&display=swap');
    
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* مظهر الـ Pagination المخصص لـ Laravel */
    .pagination svg { width: 1.25rem; height: 1.25rem; }
    .pagination nav div:first-child { display: none; } /* إخفاء نصوص showing results */
    .pagination span, .pagination a {
        border-radius: 10px !important;
        border: none !important;
        background: transparent !important;
        color: #71717a !important;
        font-size: 14px !important;
        padding: 8px 16px !important;
    }
    .pagination .active span {
        background-color: #10b981 !important;
        color: white !important;
    }
</style>
@endsection