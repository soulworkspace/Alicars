<section class="container mx-auto px-4 py-20 my-28 relative">
    {{-- تدرج خلفي معكوس: غامق في اللايت ومضيء في الدارك --}}
    <div class="absolute inset-0 bg-zinc-900/5 dark:bg-white/[0.03] -z-10 rounded-[4rem] border border-zinc-900/5 dark:border-white/[0.05]"></div>
    
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-y-16 gap-x-4">
        
        {{-- Item: Brands (الماركات المتاحة) --}}
        <div class="text-center group cursor-default relative">
            <div class="absolute inset-0 flex items-center justify-center -top-10 select-none pointer-events-none">
                <span class="text-5xl font-black text-zinc-900/[0.05] dark:text-white/[0.08] tracking-[0.2em] font-international transition-all duration-700 group-hover:tracking-[0.4em]">BRANDS</span>
            </div>
            <h3 class="font-international font-black text-5xl md:text-6xl mb-4 text-zinc-900 dark:text-white group-hover:text-brand transition-all duration-500 tracking-tighter">
                12<span class="text-brand text-3xl ml-1">+</span>
            </h3>
            <p class="text-[10px] md:text-xs text-zinc-600 dark:text-zinc-300 font-black uppercase tracking-[0.4em] leading-none">
                ماركة صينية رائدة
            </p>
        </div>

        {{-- Item: Happy Clients (العملاء والملّاك) --}}
        <div class="text-center group cursor-default relative border-r border-zinc-900/10 dark:border-white/10">
            <div class="absolute inset-0 flex items-center justify-center -top-10 select-none pointer-events-none">
                <span class="text-5xl font-black text-zinc-900/[0.05] dark:text-white/[0.08] tracking-[0.2em] font-international transition-all duration-700 group-hover:tracking-[0.4em]">DRIVERS</span>
            </div>
            <h3 class="font-international font-black text-5xl md:text-6xl mb-4 text-zinc-900 dark:text-white group-hover:text-brand transition-all duration-500 tracking-tighter">
                3<span class="text-brand text-3xl ml-1">K+</span>
            </h3>
            <p class="text-[10px] md:text-xs text-zinc-600 dark:text-zinc-300 font-black uppercase tracking-[0.4em] leading-none">
                عميل يثق بنا
            </p>
        </div>

        {{-- Item: Warranty (سنوات الضمان الممتد) --}}
        <div class="text-center group cursor-default relative border-r border-zinc-900/10 dark:border-white/10">
            <div class="absolute inset-0 flex items-center justify-center -top-10 select-none pointer-events-none">
                <span class="text-5xl font-black text-zinc-900/[0.05] dark:text-white/[0.08] tracking-[0.2em] font-international transition-all duration-700 group-hover:tracking-[0.4em]">WARRANTY</span>
            </div>
            <h3 class="font-international font-black text-5xl md:text-6xl mb-4 text-zinc-900 dark:text-white group-hover:text-brand transition-all duration-500 tracking-tighter">
                6<span class="text-brand text-3xl ml-1">Y</span>
            </h3>
            <p class="text-[10px] md:text-xs text-zinc-600 dark:text-zinc-300 font-black uppercase tracking-[0.4em] leading-none">
                ضمان مصنعي ممتد
            </p>
        </div>

        {{-- Item: Spare Parts (توفر قطع الغيار والدعم) --}}
        <div class="text-center group cursor-default relative border-r border-zinc-900/10 dark:border-white/10">
            <div class="absolute inset-0 flex items-center justify-center -top-10 select-none pointer-events-none">
                <span class="text-5xl font-black text-zinc-900/[0.05] dark:text-white/[0.08] tracking-[0.2em] font-international transition-all duration-700 group-hover:tracking-[0.4em]">PARTS</span>
            </div>
            <h3 class="font-international font-black text-5xl md:text-6xl mb-4 text-zinc-900 dark:text-white group-hover:text-brand transition-all duration-500 tracking-tighter">
                100%
            </h3>
            <p class="text-[10px] md:text-xs text-zinc-600 dark:text-zinc-300 font-black uppercase tracking-[0.4em] leading-none">
                قطع غيار أصلية متوفرة
            </p>
        </div>

    </div>
</section>