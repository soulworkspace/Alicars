@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="tricoSearch()">
    <div class="card p-6 mb-8 border border-white/5 bg-gradient-subtle">
        <form action="{{ route('search') }}" method="GET" class="relative group">
            <div class="relative">
                <input type="text" name="q" x-model="query" @input.debounce.300ms="getSuggestions()"
                       placeholder="ماذا تريد أن تلبس اليوم؟" 
                       class="form-input w-full px-8 py-5 rounded-2xl bg-[#1a1d23] border-white/10 text-xl focus:border-emerald-500/50 transition-all">
                <button class="absolute left-6 top-1/2 -translate-y-1/2 text-emerald-500">
                    <i class="fa-solid fa-magnifying-glass text-2xl"></i>
                </button>
            </div>
            
            <div x-show="suggestions.length > 0" x-transition 
                 class="absolute z-50 w-full mt-2 bg-[#1a1d23] border border-emerald-500/20 rounded-xl shadow-2xl overflow-hidden">
                <template x-for="s in suggestions">
                    <a :href="'/search?q=' + s.title" class="block px-6 py-4 hover:bg-emerald-500/5 border-b border-white/5 text-gray-300 transition">
                        <i class="fa-solid fa-arrow-trend-up mr-2 text-xs text-emerald-500"></i>
                        <span x-text="s.title"></span>
                    </a>
                </template>
            </div>
        </form>

        <form action="{{ route('search') }}" method="GET" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
            @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
            
            <select name="category" onchange="this.form.submit()" class="form-input rounded-xl bg-[#0f1115]">
                <option value="">كل الأصناف</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <select name="city" onchange="this.form.submit()" class="form-input rounded-xl bg-[#0f1115]">
                <option value="">كل الجزائر</option>
                @foreach($cities as $city)
                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                @endforeach
            </select>

            <div class="flex gap-2">
                <input type="number" name="min_price" placeholder="أقل سعر" value="{{ request('min_price') }}" class="form-input w-1/2 rounded-xl bg-[#0f1115]">
                <input type="number" name="max_price" placeholder="أعلى" value="{{ request('max_price') }}" class="form-input w-1/2 rounded-xl bg-[#0f1115]">
            </div>

            <select name="sort" onchange="this.form.submit()" class="form-input rounded-xl bg-[#0f1115]">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث أولاً</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>الأرخص</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>الأعلى سعراً</option>
            </select>
        </form>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($ads as $ad)
            <div class="group relative card overflow-hidden hover:border-emerald-500/40 transition-all duration-500">
                <a href="{{ route('ads.show', $ad->slug) }}">
                    <div class="aspect-[4/5] relative overflow-hidden">
                        <img src="{{ asset('storage/'.$ad->images->first()?->image_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-60"></div>
                        <div class="absolute bottom-4 right-4">
                            <span class="text-xl font-black text-emerald-400">{{ number_format($ad->price) }} د.ج</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <span class="text-[10px] uppercase tracking-widest text-emerald-500 font-bold">{{ $ad->category->name }}</span>
                        <h3 class="font-bold text-gray-100 truncate mt-1">{{ $ad->title }}</h3>
                        <div class="flex items-center mt-3 text-xs text-gray-500">
                            <i class="fa-solid fa-location-dot mr-1"></i> {{ $ad->city }}
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-span-full py-32 text-center">
                <i class="fa-solid fa-box-open text-6xl text-white/5 mb-4"></i>
                <p class="text-gray-500">لم نجد ما تبحث عنه، جرب كلمات أخرى</p>
            </div>
        @endforelse
    </div>

    <div class="mt-12">{{ $ads->links() }}</div>
</div>

<script>
function tricoSearch() {
    return {
        query: '{{ request('q') }}',
        suggestions: [],
        getSuggestions() {
            if(this.query.length < 2) return this.suggestions = [];
            fetch(`/search/suggestions?q=${this.query}`)
                .then(r => r.json()).then(data => this.suggestions = data);
        }
    }
}
</script>
@endsection