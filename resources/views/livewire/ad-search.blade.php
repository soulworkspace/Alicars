<div class="relative">
    <div class="flex flex-col gap-4">
        <div class="relative">
            <input type="text"
                   wire:model.live.debounce.300ms="search"
                   placeholder="بحث ذكي في الملابس، الماركات..."
                   class="w-full px-6 py-4 rounded-xl border-0 shadow-lg focus:ring-2 focus:ring-emerald-500 bg-white/10 text-white placeholder-gray-400">
            
            <div wire:loading class="absolute left-4 top-1/2 -translate-y-1/2">
                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-emerald-500"></div>
            </div>
        </div>

        <div class="grid md:grid-cols-4 gap-4">
            @forelse($ads as $ad)
                @include('partials.ad-card', ['ad' => $ad]) {{-- استخدم الكارد الموحد --}}
            @empty
                <div class="col-span-full text-center py-10 text-gray-400">
                    لا توجد نتائج تطابق بحثك حالياً..
                </div>
            @endforelse
        </div>
        
        <div class="mt-4">
            {{ $ads->links() }}
        </div>
    </div>
</div>