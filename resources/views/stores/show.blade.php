@extends('layouts.app')

@section('title', $store->name . ' | TRICO')

@section('content')
<div class="bg-zinc-50 dark:bg-zinc-950 min-h-screen text-right pb-32 transition-colors duration-500 font-sans" dir="rtl">
    
    {{-- مساحة تعويضية للـ Nav --}}
    <div class="h-24 md:h-32"></div>

    <div class="max-w-[1920px] mx-auto px-4 lg:px-10">
        
        {{-- بروفايل المتجر --}}
        <div class="relative mb-12 p-8 md:p-12 rounded-[3rem] bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-white/5 shadow-2xl overflow-hidden">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="w-32 h-32 rounded-[2rem] overflow-hidden border-4 border-emerald-500/20">
                    <img src="{{ $store->logo ? asset('storage/' . $store->logo) : 'https://ui-avatars.com/api/?name='.urlencode($store->name).'&background=10b981&color=fff' }}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 text-center md:text-right">
                    <h1 class="text-4xl md:text-6xl font-black text-zinc-900 dark:text-white tracking-tighter">{{ $store->name }}</h1>
                    <p class="text-zinc-500 dark:text-zinc-400 mt-4 max-w-2xl italic leading-relaxed">{{ $store->description }}</p>
                </div>
            </div>
        </div>

        {{-- شبكة الإعلانات المصغرة (Lightweight Cards) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($store->ads as $adItem)
                <div class="group bg-white dark:bg-zinc-900 rounded-3xl border border-zinc-100 dark:border-white/5 overflow-hidden transition-all hover:border-emerald-500/50">
                    <div class="aspect-square relative overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                        @if($adItem->primaryImage)
                            <img src="{{ asset('storage/' . $adItem->primaryImage->image_path) }}" class="w-full h-full object-cover transition-transform group-hover:scale-110">
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-zinc-900 dark:text-white truncate">{{ $adItem->title }}</h3>
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-emerald-500 font-black">{{ number_format($adItem->price) }} DZD</span>
                            <a href="{{ route('ads.show', $adItem->id) }}" class="text-[10px] font-black uppercase tracking-widest text-zinc-400 hover:text-emerald-500">التفاصيل ←</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center text-zinc-500">لا توجد إعلانات حالياً.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection