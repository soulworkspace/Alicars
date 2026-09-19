@php
    // Fixed & Verified High-Resolution Automotive Images
    $categoryImages = [
        'suv'        => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=1200&q=80', 
        'sedan'      => 'https://images.unsplash.com/photo-1617469767053-d3b508a0d825?auto=format&fit=crop&w=1200&q=80', 
        'ev-hybrid'  => 'https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1200&q=80', 
        'luxury-mpv' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80', 
    ];

    // Premium Fallback car image in case database slugs don't match the array keys
    $fallbackImage = 'https://images.unsplash.com/photo-1617788138017-80ad40651399?auto=format&fit=crop&w=1200&q=80';

    // Fetch the 4 main parent categories
    $mainCategories = \App\Models\Category::whereNull('parent_id')->take(4)->get();
@endphp

<section class="container mx-auto px-4 py-24 relative overflow-hidden">
    {{-- العنوان --}}
    <div class="flex flex-col mb-16 space-y-2 text-right">
        <span class="text-brand font-black tracking-[0.4em] text-[10px] uppercase block">CHINESE DRIVES</span>
        <h2 class="text-4xl md:text-6xl font-black tracking-tighter text-zinc-900 dark:text-white uppercase leading-none">
            تصفح حسب <span class="text-brand">الفئة.</span>
        </h2>
    </div>

    {{-- شبكة التصنيفات (Bento Style) --}}
    <div class="grid grid-cols-1 md:grid-cols-4 md:grid-rows-2 gap-6 h-auto md:h-[750px]">
        @foreach($mainCategories as $index => $category)
            @php
                // Fail-safe check: lowercase the slug to prevent minor mismatch bugs (SUV vs suv)
                $currentSlug = strtolower($category->slug);
                $image = $categoryImages[$currentSlug] ?? $fallbackImage;
                
                // Bento Layout definitions
                $isLarge = $index === 0; 
                $isWide = $index === 1;  
                $gridClass = $isLarge ? 'md:col-span-2 md:row-span-2' : ($isWide ? 'md:col-span-2 md:row-span-1' : 'md:col-span-1 md:row-span-1');
            @endphp

            <a href="{{ route('ads.index', ['category' => $category->slug]) }}" 
               class="{{ $gridClass }} group relative overflow-hidden rounded-[3.5rem] bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm transition-all duration-700">
                
                {{-- الصورة مع معالجة خطأ التحميل المحتمل --}}
                <img src="{{ $image }}" 
                     alt="{{ $category->name }}"
                     onerror="this.onerror=null; this.src='{{ $fallbackImage }}';"
                     class="w-full h-full object-cover transition-transform duration-[1.5s] ease-out group-hover:scale-110">
                
                {{-- الطبقة الشفافة والنصوص --}}
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/90 via-zinc-950/20 to-transparent flex flex-col justify-end p-8 md:p-10 text-right">
                    <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        <h3 class="{{ $isLarge ? 'text-4xl md:text-5xl' : 'text-2xl md:text-3xl' }} text-white font-black uppercase tracking-tighter mb-4">
                            {{ $category->name }}
                        </h3>
                        
                        @if($isLarge)
                            <div class="inline-flex w-14 h-14 rounded-full bg-white/10 backdrop-blur-xl border border-white/20 items-center justify-center text-white group-hover:bg-brand group-hover:text-black group-hover:border-brand transition-all duration-500">
                                <i class="fa-solid fa-arrow-left-long text-xl"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>