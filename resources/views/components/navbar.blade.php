@php
    $navLinks = [
        ['route' => 'home', 'label' => 'الرئيسية', 'icon' => 'fa-house', 'active' => request()->routeIs('home')],
        ['route' => 'ads.index', 'label' => 'اكتشف', 'icon' => 'fa-compass', 'active' => request()->routeIs('ads.index')],
        ['route' => 'ads.by-category', 'params' => 'men', 'label' => 'الرجال', 'icon' => 'fa-mars', 'active' => request()->is('category/men*')],
        ['route' => 'ads.by-category', 'params' => 'women', 'label' => 'النساء', 'icon' => 'fa-venus', 'active' => request()->is('category/women*')],
        ['route' => 'stores.index', 'label' => 'المتاجر', 'icon' => 'fa-shop', 'active' => request()->routeIs('stores.*')],
    ];

    if(auth()->check()) {
        $user = auth()->user();
        
        // تحديد مسار اللوحة بناءً على النوع لمنع خطأ Route NotFound
        $dashboardRoute = 'profile.show'; // الافتراضي للمشتري
        if($user->isAdmin()) {
            $dashboardRoute = 'dashboard';
        } elseif($user->isSeller()) {
            $dashboardRoute = 'vendor.dashboard';
        }

        $userLinks = [
            ['route' => $dashboardRoute, 'label' => 'اللوحة', 'icon' => 'fa-chart-line'],
            ['route' => 'messages.index', 'label' => 'الرسائل', 'icon' => 'fa-envelope-open-text'],
            ['route' => 'favorites.index', 'label' => 'المفضلة', 'icon' => 'fa-heart'],
            ['route' => 'my-ads', 'label' => 'إعلاناتي', 'icon' => 'fa-boxes-stacked'],
        ];
    }
@endphp

<nav x-data="{ mobileMenuOpen: false, userMenuOpen: false }" 
     class="sticky top-0 w-full z-[9999] border-b border-zinc-200 dark:border-white/5 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-2xl transition-all duration-500">
    
    <div class="max-w-[1920px] mx-auto px-4 lg:px-10 h-20 md:h-24 flex items-center justify-between gap-4">
        
        {{-- 1. Logo (Left) --}}
        <div class="flex-shrink-0">
            <a href="{{ route('home') }}" class="group">
                <span class="font-international text-2xl md:text-3xl font-black tracking-tighter text-zinc-900 dark:text-white uppercase transition-all">
                    TRI<span class="text-emerald-500">CO</span>
                </span>
            </a>
        </div>

        {{-- 2. Active Center Search (المحرك المباشر) --}}
        <div class="hidden md:flex flex-1 max-w-2xl relative group">
            <form action="{{ route('search') }}" method="GET" class="w-full relative">
                <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none transition-colors group-focus-within:text-emerald-500 text-zinc-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </div>
                
                <input type="text" 
                       name="q" 
                       value="{{ request('q') }}"
                       placeholder="ابحث عن الماركات، المنتجات، أو المتاجر..." 
                       class="w-full bg-zinc-100 dark:bg-white/5 border border-transparent focus:border-emerald-500/50 focus:bg-white dark:focus:bg-zinc-900 focus:ring-4 focus:ring-emerald-500/5 rounded-2xl py-3.5 pr-12 pl-6 text-[13px] font-bold text-zinc-600 dark:text-zinc-300 transition-all hover:bg-zinc-200/50 dark:hover:bg-white/10 outline-none">
                
                {{-- زر إنتر صغير جمالي يظهر عند الكتابة --}}
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none opacity-0 group-focus-within:opacity-100 transition-opacity">
                    <kbd class="text-[10px] font-black bg-zinc-200 dark:bg-zinc-800 text-zinc-500 px-2 py-1 rounded-lg tracking-widest uppercase">ENTER</kbd>
                </div>
            </form>
        </div>

        {{-- 3. Actions (Right) --}}
        <div class="flex items-center gap-2 lg:gap-4">
            
            {{-- Desktop Nav Links --}}
            <div class="hidden xl:flex items-center gap-1 border-l border-zinc-200 dark:border-white/10 ml-2 pl-4">
                @foreach($navLinks as $link)
                    <a href="{{ isset($link['params']) ? route($link['route'], $link['params']) : route($link['route']) }}" 
                       class="p-3 rounded-xl transition-all {{ $link['active'] ? 'text-emerald-500 bg-emerald-500/5' : 'text-zinc-500 dark:text-zinc-400 hover:text-emerald-500 hover:bg-zinc-100 dark:hover:bg-white/5' }}"
                       title="{{ $link['label'] }}">
                        <i class="fa-solid {{ $link['icon'] }} text-lg"></i>
                    </a>
                @endforeach
            </div>

            {{-- 🌓 Theme Toggle --}}
            <button @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light')"
                    class="w-12 h-12 flex items-center justify-center rounded-2xl bg-zinc-100 dark:bg-white/5 text-zinc-600 dark:text-zinc-300 hover:text-emerald-500 transition-all border border-transparent hover:border-emerald-500/20 shadow-sm">
                <i class="fa-solid fa-sun dark:hidden text-lg"></i>
                <i class="fa-solid fa-moon hidden dark:block text-lg"></i>
            </button>

            @auth
                <div class="relative hidden sm:block" @click.away="userMenuOpen = false">
                    <button @click="userMenuOpen = !userMenuOpen" class="w-12 h-12 rounded-2xl overflow-hidden border-2 border-emerald-500/20 hover:border-emerald-500 active:scale-90 transition-all">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=10b981&color=fff" class="w-full h-full object-cover">
                    </button>
                    <div x-show="userMenuOpen" x-cloak x-transition class="absolute top-full left-0 mt-4 w-60 bg-white dark:bg-zinc-900 border border-zinc-100 dark:border-white/5 shadow-2xl rounded-[1.5rem] p-2 overflow-hidden">
                        @foreach($userLinks as $link)
                            <a href="{{ route($link['route']) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-500/5 text-zinc-600 dark:text-zinc-400 hover:text-emerald-500 transition-all">
                                <i class="fa-solid {{ $link['icon'] }} w-5 text-[14px]"></i>
                                <span class="text-[11px] font-black uppercase tracking-widest">{{ $link['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="hidden sm:flex px-6 py-3 bg-zinc-900 dark:bg-white text-white dark:text-black rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-500 dark:hover:bg-emerald-500 dark:hover:text-white transition-all">دخول</a>
            @endauth

            {{-- Mobile Trigger --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="xl:hidden w-12 h-12 flex items-center justify-center rounded-2xl bg-emerald-500 text-white shadow-lg shadow-emerald-500/20 active:scale-90 transition-all">
                <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars-staggered'"></i>
            </button>
        </div>
    </div>

    {{-- 📱 Mobile Navigation Menu --}}
    <div x-show="mobileMenuOpen" x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         class="fixed inset-0 w-full h-screen z-[10000] xl:hidden bg-white dark:bg-zinc-950">
        <div class="relative h-full flex flex-col p-8 pt-24">
            
            {{-- Mobile Active Search --}}
            <form action="{{ route('search') }}" method="GET" class="w-full mb-10">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute right-5 top-1/2 -translate-y-1/2 text-zinc-400"></i>
                    <input type="text" name="q" placeholder="عما تبحث؟" 
                           class="w-full p-5 pr-14 bg-zinc-100 dark:bg-white/5 rounded-3xl outline-none focus:ring-2 focus:ring-emerald-500/20 dark:text-white font-bold text-sm">
                </div>
            </form>

            <div class="space-y-6 overflow-y-auto">
                @foreach($navLinks as $link)
                    <a href="{{ isset($link['params']) ? route($link['route'], $link['params']) : route($link['route']) }}" 
                       class="flex items-center justify-between group">
                        <span class="text-4xl font-black text-zinc-900 dark:text-white uppercase tracking-tighter transition-all group-hover:text-emerald-500">{{ $link['label'] }}</span>
                        <i class="fa-solid {{ $link['icon'] }} text-xl text-emerald-500 opacity-0 group-hover:opacity-100 transition-all"></i>
                    </a>
                @endforeach
            </div>

            <div class="mt-auto border-t border-zinc-100 dark:border-white/10 pt-8 flex flex-col gap-4">
                <a href="{{ route('ads.create') }}" class="w-full py-5 bg-emerald-500 text-white rounded-2xl text-center font-black text-xs uppercase tracking-widest shadow-xl shadow-emerald-500/30">إضافة إعلان</a>
                @guest
                    <a href="{{ route('login') }}" class="w-full py-5 bg-zinc-900 dark:bg-white text-white dark:text-black rounded-2xl text-center font-black text-xs uppercase tracking-widest">دخول</a>
                @endguest
            </div>
        </div>
    </div>
</nav>