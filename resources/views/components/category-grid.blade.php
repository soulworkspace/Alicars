@php
    // جلب الأقسام الرئيسية من قاعدة البيانات
    $categories = \App\Models\Category::root()->get();
    
    // نحدد أي قسم يظهر في أي مكان بناءً على الـ slug لضمان بقاء التصميم متناسقاً
    $men = $categories->where('slug', 'men')->first();
    $women = $categories->where('slug', 'women')->first();
    $kids = $categories->where('slug', 'kids')->first(); // سنضعه مكان الإكسسوارات أو بجانبها
    $collections = $categories->where('slug', 'collections')->first();
@endphp

<section class="container mx-auto px-4 py-24 lg:py-32 bg-[#0a0a0a]">
    {{-- العنوان الرئيسي --}}
    <div class="mb-20 space-y-6 text-right">
        <span class="text-emerald-500 font-black tracking-[0.4em] text-xs block uppercase">المجموعات المختارة</span>
        <h2 class="text-white font-[1000] text-6xl lg:text-8xl tracking-tighter leading-none uppercase">
            تصفح حسب <br> <span class="text-emerald-500">الفئة.</span>
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        
        {{-- فئة الرجال - ديناميكية --}}
        @if($men)
        <div onclick="window.location='{{ route('ads.index', ['category' => $men->slug]) }}'" 
             class="md:col-span-7 relative group cursor-pointer overflow-hidden rounded-[2.5rem] border border-white/5 min-h-[500px]">
            <div class="absolute inset-0 bg-black/40 z-10 group-hover:bg-black/10 transition-all duration-700"></div>
            <img src="{{ $men->image ?? 'https://images.unsplash.com/photo-1490578474895-699cd4e2cf59?auto=format&fit=crop&w=1200&q=80' }}" 
                 class="absolute inset-0 w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-[1.5s] ease-out">
            
            <div class="absolute bottom-10 right-10 z-20 text-right">
                <h3 class="text-5xl font-black text-white tracking-tighter mb-6 uppercase">{{ $men->name }}</h3>
                <span class="inline-block bg-white text-black px-10 py-4 text-[10px] font-black uppercase tracking-widest hover:bg-emerald-500 transition-all duration-500">
                    اكتشف الآن
                </span>
            </div>
        </div>
        @endif

        {{-- فئة النساء - ديناميكية --}}
        @if($women)
        <div onclick="window.location='{{ route('ads.index', ['category' => $women->slug]) }}'" 
             class="md:col-span-5 relative group cursor-pointer overflow-hidden rounded-[2.5rem] border border-white/5 min-h-[500px]">
            <div class="absolute inset-0 bg-black/40 z-10 group-hover:bg-black/10 transition-all duration-700"></div>
            <img src="{{ $women->image ?? 'https://images.unsplash.com/photo-1581044777550-4cfa60707c03?auto=format&fit=crop&w=800&q=80' }}" 
                 class="absolute inset-0 w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-[1.5s] ease-out">
            
            <div class="absolute bottom-10 right-10 z-20 text-right">
                <h3 class="text-5xl font-black text-white tracking-tighter mb-6 uppercase">{{ $women->name }}</h3>
                <span class="inline-block border border-white text-white px-10 py-4 text-[10px] font-black uppercase tracking-widest hover:bg-emerald-500 hover:border-emerald-500 transition-all duration-500">
                    المجموعة كاملة
                </span>
            </div>
        </div>
        @endif

        {{-- فئة الأطفال (أو الإكسسوارات) - ديناميكية --}}
        @if($kids)
        <div onclick="window.location='{{ route('ads.index', ['category' => $kids->slug]) }}'" 
             class="md:col-span-5 relative group cursor-pointer overflow-hidden rounded-[2.5rem] border border-white/5 min-h-[400px]">
            <div class="absolute inset-0 bg-black/60 z-10 group-hover:bg-black/30 transition-all duration-700"></div>
            <img src="{{ $kids->image ?? 'https://images.unsplash.com/photo-1519704943920-1844582b7b04?auto=format&fit=crop&w=800&q=80' }}" 
                 class="absolute inset-0 w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-[1.5s] ease-out">
            
            <div class="absolute inset-0 flex items-center justify-center z-20">
                <h3 class="text-3xl font-black text-white uppercase tracking-[0.4em] border-b-2 border-emerald-500 pb-2">{{ $kids->name }}</h3>
            </div>
        </div>
        @endif

        {{-- بطاقة "كن بائعاً" - ثابتة لأنها مرتبطة بالتسجيل --}}
        <div class="md:col-span-7 bg-[#111111] rounded-[2.5rem] border border-white/5 p-12 lg:p-20 flex flex-col justify-center space-y-8 relative overflow-hidden group">
            <div class="absolute -left-10 -bottom-10 w-64 h-64 bg-emerald-500/5 blur-[100px] rounded-full group-hover:bg-emerald-500/10 transition-all duration-1000"></div>
            
            <div class="relative z-10 space-y-6 text-right">
                <span class="text-emerald-500 font-black tracking-[0.3em] text-[10px] uppercase block">فرصة للنمو</span>
                <h3 class="text-5xl lg:text-6xl font-black text-white tracking-tighter leading-[0.9] uppercase">
                    هل تمتلك <br> <span class="text-emerald-500">متجراً</span> خاصاً؟
                </h3>
                <p class="text-zinc-500 text-lg max-w-sm font-medium leading-relaxed mr-0 ml-auto">
                    انضم إلى منصة TRICO واعرض منتجاتك في بيئة رقمية تليق بالفخامة العالمية.
                </p>
                <div class="pt-6">
                    <a href="/register" class="inline-block bg-emerald-500 text-black px-12 py-5 text-[11px] font-black uppercase tracking-[0.2em] hover:bg-white transition-all duration-500 rounded-none shadow-xl shadow-emerald-500/10">
                        ابدأ البيع الآن
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>