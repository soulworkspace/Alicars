<section class="relative container mx-auto px-4 py-12 lg:py-32 overflow-hidden">
    {{-- لمسة جمالية خلفية - DRIVE Glow --}}
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-brand/10 rounded-full blur-[120px] pointer-events-none -z-20"></div>

    <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
        {{-- محتوى النص --}}
        <div class="space-y-8 lg:space-y-10 relative z-1">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-3">
                <span class="w-8 lg:w-12 h-[1px] bg-brand"></span>
                <span class="text-brand font-black tracking-[0.3em] text-[9px] lg:text-[10px] uppercase">
                    مستقبل القيادة الذكية | 2026
                </span>
            </div>

            {{-- Title --}}
            <h1 class="font-international font-black text-6xl md:text-7xl lg:text-[7rem] leading-[0.85] tracking-tighter text-zinc-900 dark:text-white uppercase">
                عصر <br> 
                <span class="text-brand italic font-black">التنين</span> 
                الذكي<span class="text-brand">.</span>
            </h1>

            {{-- Description --}}
            <p class="text-zinc-500 dark:text-zinc-400 text-base md:text-xl max-w-sm font-medium leading-relaxed">
                بوابتك الأولى لامتلاك أحدث السيارات الصينية الفاخرة. نجمع لك بين الرفاهية المطلقة، التكنولوجيا الذكية، والأداء الاقتصادي المثالي.
            </p>

            {{-- Actions --}}
            <div class="flex flex-wrap gap-4 lg:gap-6 pt-4">
                <a href="{{ route('ads.index') }}" 
                   class="bg-brand hover:bg-zinc-900 dark:hover:bg-white text-black hover:text-white dark:hover:text-black font-black px-8 lg:px-12 py-4 lg:py-5 text-[10px] lg:text-xs uppercase tracking-widest transition-all duration-500 rounded-full shadow-lg shadow-brand/20">
                    احجز تجربة القيادة
                </a>
                
                <a href="#collections" class="flex items-center gap-3 group text-zinc-900 dark:text-white font-bold text-[10px] lg:text-xs uppercase tracking-widest">
                    <span class="w-10 h-10 flex items-center justify-center rounded-full border border-zinc-200 dark:border-zinc-800 group-hover:border-brand transition-colors">
                        <i class="fa-solid fa-car text-[10px]"></i>
                    </span>
                    اكتشف الأسطول
                </a>
            </div>
        </div>

        {{-- قسم الصورة --}}
        <div class="relative mt-12 lg:mt-0">
            <div class="relative z-10 group overflow-hidden rounded-[2rem] lg:rounded-[2.5rem] bg-zinc-200 dark:bg-zinc-800 aspect-[4/5] lg:aspect-auto">
                {{-- تم تحديث الصورة لصورة سيارة صينية فاخرة وحديثة من Unsplash --}}
                <img src="https://images.unsplash.com/photo-1617788138017-80ad40651399?auto=format&fit=crop&q=80&w=1000" 
                     class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-1000 ease-in-out opacity-90 group-hover:opacity-100">
                
                {{-- Overlay info --}}
                <div class="absolute bottom-4 lg:bottom-8 right-4 lg:right-8 left-4 lg:left-8 p-4 lg:p-6 backdrop-blur-md bg-white/10 rounded-2xl translate-y-20 group-hover:translate-y-0 transition-transform duration-500 border border-white/10">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-[8px] lg:text-[10px] text-zinc-300 uppercase tracking-widest font-bold">الأكثر طلباً هذا الشهر</p>
                            <h3 class="text-white text-sm lg:text-base font-black uppercase">Changan Uni-K Intelligent ®</h3>
                        </div>
                        <i class="fa-solid fa-key text-brand"></i>
                    </div>
                </div>
            </div>

            {{-- Decorative Elements --}}
            <div class="absolute -bottom-6 -right-6 w-32 lg:w-48 h-32 lg:h-48 border-2 border-brand/20 rounded-[2rem] lg:rounded-[2.5rem] -z-10"></div>
            <div class="absolute -top-10 right-10 text-[8rem] lg:text-[12rem] font-black text-zinc-100 dark:text-zinc-900/30 -z-10 select-none">CN</div>
        </div>
    </div>
</section>