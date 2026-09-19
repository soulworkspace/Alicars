<div class="group relative bg-[#121212] border border-white/5 rounded-[2.5rem] overflow-hidden transition-all duration-700 hover:border-emerald-500/30 hover:-translate-y-2 shadow-2xl">
    {{-- Image Section --}}
    <div class="relative aspect-[4/5] overflow-hidden">
        <img src="{{ $ad->primary_image_url }}" 
             alt="{{ $ad->title }}" 
             class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
        
        {{-- Overlay Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-transparent to-transparent opacity-60"></div>

        {{-- Top Badges --}}
        <div class="absolute top-6 right-6 flex flex-col gap-2">
            <span class="bg-black/40 backdrop-blur-xl border border-white/10 text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest">
                {{ $ad->condition_text }}
            </span>
        </div>

        {{-- Quick View Button --}}
        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 translate-y-4 group-hover:translate-y-0">
            <a href="{{ route('ads.show', $ad->slug) }}" 
               class="bg-white text-black text-[10px] font-black px-8 py-3 rounded-full uppercase tracking-[0.2em] hover:bg-emerald-500 transition-colors shadow-2xl">
                تفاصيل القطعة
            </a>
        </div>
    </div>

    {{-- Content Section --}}
    <div class="p-8">
        <div class="flex items-center gap-2 mb-3">
            <span class="text-emerald-500 text-[9px] font-black uppercase tracking-[0.3em]">{{ $ad->category->name }}</span>
            <span class="w-1 h-1 bg-zinc-800 rounded-full"></span>
            <span class="text-zinc-500 text-[9px] font-bold uppercase">{{ $ad->city ?? 'الجزائر' }}</span>
        </div>
        
        <h3 class="text-white text-lg font-black leading-tight mb-4 group-hover:text-emerald-500 transition-colors line-clamp-1">
            {{ $ad->title }}
        </h3>

        <div class="flex items-end justify-between border-t border-white/5 pt-5">
            <div class="flex flex-col">
                <span class="text-zinc-600 text-[8px] font-black uppercase tracking-widest mb-1">السعر التقديري</span>
                <span class="text-2xl font-black text-white italic tracking-tighter">
                    {{ number_format($ad->price) }} <span class="text-emerald-500 text-xs not-italic">DA</span>
                </span>
            </div>
            
            <button class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-zinc-500 hover:border-emerald-500 hover:text-emerald-500 transition-all group/fav">
                <i class="fa-light fa-heart group-hover/fav:fa-solid transition-all"></i>
            </button>
        </div>
    </div>
</div>