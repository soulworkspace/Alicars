@extends('layouts.dashboard')

@section('title', 'المفضلة')
@section('page-title', 'إعلاناتي المفضلة')

@section('content')
    <div class="card p-6">
        @if($favorites->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($favorites as $favorite)
                    @php $ad = $favorite->ad; @endphp
                    <div class="bg-white/5 rounded-xl overflow-hidden hover:bg-white/10 transition-colors group">
                        <a href="{{ route('ads.show', $ad->slug) }}" class="block">
                            <div class="aspect-video bg-emerald-500/10 relative overflow-hidden">
                                @if($ad->images->first())
                                    <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fa-solid fa-image text-emerald-400 text-3xl"></i>
                                    </div>
                                @endif
                                
                                <button onclick="event.preventDefault(); removeFavorite({{ $ad->id }})" 
                                    class="absolute top-3 right-3 w-8 h-8 bg-rose-500 rounded-full flex items-center justify-center text-white hover:bg-rose-600 transition-colors">
                                    <i class="fa-solid fa-heart"></i>
                                </button>
                            </div>
                            
                            <div class="p-4">
                                <h4 class="font-bold truncate mb-2">{{ $ad->title }}</h4>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-emerald-400 font-bold">
                                        @if($ad->price)
                                            {{ number_format($ad->price) }} د.ج
                                        @else
                                            مجاني
                                        @endif
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $ad->city ?? 'غير محدد' }}</span>
                                </div>
                                
                                <div class="flex items-center gap-2 mt-3 text-xs text-gray-500">
                                    <span class="badge badge-emerald">{{ $ad->category?->name ?? 'عام' }}</span>
                                    <span><i class="fa-solid fa-eye mr-1"></i>{{ $ad->views_count ?? 0 }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-6">
                {{ $favorites->links() }}
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                <div class="w-20 h-20 rounded-full bg-rose-500/10 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-regular fa-heart text-rose-400 text-3xl"></i>
                </div>
                <h4 class="font-bold text-lg mb-2">لا توجد إعلانات مفضلة</h4>
                <p class="text-sm mb-4">أضف إعلانات إلى المفضلة للوصول إليها بسرعة</p>
                <a href="{{ route('ads.index') }}" class="btn-premium px-6 py-2 rounded-lg text-xs inline-block">
                    تصفح الإعلانات
                </a>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
function removeFavorite(adId) {
    if (confirm('هل تريد إزالة هذا الإعلان من المفضلة؟')) {
        fetch(`/favorites/${adId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        });
    }
}
</script>
@endsection
