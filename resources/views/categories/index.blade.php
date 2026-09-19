@extends('layouts.app')

@section('title', 'الفئات العالمية | TRICO')

@section('content')
<div class="bg-[#0a0a0a] min-h-screen text-white pb-32">
    
    <header class="py-24 border-b border-white/5 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-500/5 blur-[120px] rounded-full"></div>
        <div class="container mx-auto px-6 lg:px-12 relative z-10 text-right" dir="rtl">
            <span class="text-emerald-500 font-black tracking-[0.5em] text-[10px] uppercase block mb-4">The Directory</span>
            <h1 class="text-7xl lg:text-9xl font-[1000] tracking-[-0.06em] leading-none uppercase mb-8">
                أرشيف <br> <span class="text-emerald-500">الأناقة.</span>
            </h1>
            <p class="text-zinc-500 text-lg max-w-xl mr-auto font-medium">تصفح مكتبتنا المنظمة بعناية للوصول إلى أرقى القطع العالمية والمحلية.</p>
        </div>
    </header>

    <div class="container mx-auto px-6 lg:px-12 py-20" dir="rtl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            @foreach($categories as $category)
                <div class="group space-y-8 text-right">
                    
                    <div class="flex items-end justify-between border-b border-white/10 pb-6 group-hover:border-emerald-500 transition-colors duration-500">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-black transition-all">
                                @if($category->icon)
                                    <i class="{{ $category->icon }} text-lg"></i>
                                @else
                                    <i class="fa-light fa-folder-open text-lg"></i>
                                @endif
                            </div>
                            <h2 class="text-3xl font-black tracking-tighter uppercase">{{ $category->name }}</h2>
                        </div>
                        <a href="{{ route('ads.by-category', $category->slug) }}" class="text-[10px] font-black text-zinc-500 uppercase tracking-widest hover:text-white transition-colors">عرض الكل</a>
                    </div>

                    @if($category->children->count() > 0)
                        <ul class="space-y-4 pr-4">
                            @foreach($category->children as $child)
                                <li class="relative group/item">
                                    <a href="{{ route('ads.by-category', $child->slug) }}" 
                                       class="flex items-center justify-between py-1 group-hover/item:pr-4 transition-all duration-300">
                                        <div class="flex items-center gap-3">
                                            <span class="w-1.5 h-1.5 rounded-full bg-zinc-800 group-hover/item:bg-emerald-500 transition-colors"></span>
                                            <span class="text-zinc-400 group-hover/item:text-white font-bold text-sm transition-colors">{{ $child->name }}</span>
                                        </div>
                                        <span class="text-[10px] font-black text-zinc-700 group-hover/item:text-emerald-500 transition-colors">
                                            {{ $child->ads()->active()->count() }} PIECES
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-zinc-700 text-xs font-bold uppercase tracking-widest pr-4 italic">قريباً في هذا القسم</p>
                    @endif

                    <div class="pt-4 pr-4">
                        <a href="{{ route('ads.by-category', $category->slug) }}" 
                           class="inline-flex items-center gap-4 text-emerald-500 group/btn">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em]">استكشاف القسم</span>
                            <div class="w-8 h-[1px] bg-emerald-500 group-hover/btn:w-16 transition-all duration-500"></div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    /* إضافة لمسة احترافية للخطوط */
    h1, h2, h3 {
        letter-spacing: -0.04em;
    }
</style>
@endsection