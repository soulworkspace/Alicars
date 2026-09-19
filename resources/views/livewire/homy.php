<div>
    {{-- 1. الهيرو (Hero Section) --}}
    @include('components.hero')

    {{-- 2. أحدث الإعلانات (Recent Ads Section) --}}
    <section class="container mx-auto px-4 py-24 relative " id="collections">
        {{-- عنوان القسم بتنسيق عصري --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div class="space-y-2">
                <span class="text-brand font-black tracking-[0.4em] text-[10px] uppercase block">Latest Drop</span>
                <h2 class="text-4xl md:text-5xl font-black tracking-tighter text-zinc-900 dark:text-white uppercase">
                    وصل حديثاً<span class="text-brand">.</span>
                </h2>
            </div>
            <a href="{{ route('ads.index') }}" class="group flex items-center gap-3 text-xs font-black uppercase tracking-widest text-zinc-500 hover:text-brand transition-colors">
                اكتشف المزيد 
                <i class="fa-solid fa-arrow-left-long transition-transform group-hover:translate-x-[-5px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            @forelse($recentAds as $ad)
                <div class="group relative flex flex-col">
                    {{-- حاوية الصورة --}}
                    <div class="relative aspect-[3/4] overflow-hidden rounded-[2.5rem] bg-zinc-100 dark:bg-zinc-900 border border-zinc-200/50 dark:border-zinc-800/50 transition-all duration-500 group-hover:shadow-2xl group-hover:shadow-brand/10">
                        
                        {{-- شارة (Tag) --}}
                        <div class="absolute top-5 right-5 z-20">
                            <span class="bg-white/90 dark:bg-zinc-950/90 backdrop-blur-md text-[9px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest shadow-sm border border-zinc-100 dark:border-zinc-800">New</span>
                        </div>

                        @if($ad->primaryImage)
                            <img src="{{ asset('storage/' . $ad->primaryImage->image_path) }}" 
                                 class="w-full h-full object-cover transition-transform duration-1000 ease-out group-hover:scale-110"
                                 alt="{{ $ad->title }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-zinc-300 dark:text-zinc-700">
                                <i class="fa-solid fa-image text-5xl"></i>
                            </div>
                        @endif

                        {{-- زر معاينة سريعة - تم ربطه بالمنتج --}}
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                            <a href="{{ route('ads.show', $ad->slug) }}" class="z-30 bg-white text-black text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded-full transform translate-y-4 group-hover:translate-y-0 transition-all duration-500 hover:bg-brand hover:text-white">
                                تفاصيل القطعة
                            </a>
                        </div>
                    </div>

                    {{-- معلومات المنتج --}}
                    <div class="mt-6 px-2 text-center">
                        <p class="text-[10px] text-zinc-400 font-bold uppercase tracking-widest mb-1">{{ $ad->category->name ?? 'أزياء' }}</p>
                        
                        {{-- عنوان المنتج - تم ربطه بالمنتج لزيادة التفاعل --}}
                        <a href="{{ route('ads.show', $ad->slug) }}" class="relative z-20">
                            <h3 class="text-lg font-black text-zinc-900 dark:text-white mb-2 line-clamp-1 group-hover:text-brand transition-colors uppercase tracking-tighter">
                                {{ $ad->title }}
                            </h3>
                        </a>

                        <div class="flex items-center justify-center gap-2">
                            <span class="text-brand font-black text-xl tracking-tighter">
                                {{ number_format($ad->price) }} <small class="text-[10px] uppercase">د.ج</small>
                            </span>
                        </div>
                    </div>
                    
                    {{-- الرابط الخفي (الخارق) - يغطي الكارد بالكامل في z-10 --}}
                    <a href="{{ route('ads.show', $ad->slug) }}" class="absolute inset-0 z-10" aria-label="عرض {{ $ad->title }}"></a>
                </div>
            @empty
                {{-- Skeleton Loader المطور --}}
                @for($i = 0; $i < 4; $i++)
                    <div class="animate-pulse">
                        <div class="aspect-[3/4] rounded-[2.5rem] bg-zinc-200 dark:bg-zinc-800 mb-6"></div>
                        <div class="h-4 w-1/3 bg-zinc-200 dark:bg-zinc-800 rounded mx-auto mb-3"></div>
                        <div class="h-6 w-3/4 bg-zinc-200 dark:bg-zinc-800 rounded mx-auto"></div>
                    </div>
                @endfor
            @endforelse
        </div>
    </section>

    {{-- 3. إحصائيات المنصة --}}
    @include('components.stats')
    @include('components.categories')
</div>