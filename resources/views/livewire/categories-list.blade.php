<div class="container mx-auto px-4 py-24">
    <h1 class="heavy-title text-6xl mb-16">كل <span class="text-emerald-500">التصنيفات</span></h1>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
        @foreach($categories as $category)
            <a href="#" class="aspect-square bg-white/5 border border-white/10 rounded-full flex flex-col items-center justify-center hover:bg-emerald-500 hover:text-black transition-all duration-500 group">
                <i class="fa-solid fa-tag text-2xl mb-3"></i>
                <span class="font-bold text-sm">{{ $category->name }}</span>
            </a>
        @endforeach
    </div>
</div>