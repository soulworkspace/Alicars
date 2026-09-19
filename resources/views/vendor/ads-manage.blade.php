@extends('layouts.dashboard')

@section('title', 'إدارة إعلانات المتجر')
@section('page-title', 'إدارة الإعلانات - ' . $store->name)

@section('content')
    <!-- Bulk Actions Toolbar -->
    <div class="card p-4 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" id="select-all" class="w-4 h-4 rounded border-gray-600 bg-white/5 text-emerald-500 focus:ring-emerald-500">
                    <span class="text-sm">تحديد الكل</span>
                </label>
                <span class="text-sm text-gray-500" id="selected-count">(0)</span>
            </div>
            
            <div class="flex items-center gap-2" id="bulk-actions" style="opacity: 0.5; pointer-events: none;">
                <button type="button" class="btn-outline px-4 py-2 rounded-lg text-xs" onclick="bulkAction('activate')">
                    <i class="fa-solid fa-check mr-1"></i> تفعيل
                </button>
                <button type="button" class="btn-outline px-4 py-2 rounded-lg text-xs" onclick="bulkAction('pause')">
                    <i class="fa-solid fa-pause mr-1"></i> إيقاف
                </button>
                <button type="button" class="text-rose-400 hover:text-rose-300 px-4 py-2 rounded-lg text-xs" onclick="bulkAction('delete')">
                    <i class="fa-solid fa-trash mr-1"></i> حذف
                </button>
            </div>
            
            <a href="{{ route('ads.create') }}" class="btn-premium px-4 py-2 rounded-lg text-xs">
                <i class="fa-solid fa-plus mr-1"></i> إضافة إعلان
            </a>
        </div>
    </div>
    
    <!-- Ads List -->
    <div class="card">
        @if($ads->count() > 0)
            <div class="divide-y divide-white/5">
                @foreach($ads as $ad)
                    <div class="flex items-center gap-4 p-4 hover:bg-white/5 transition-colors">
                        <input type="checkbox" name="ad_ids[]" value="{{ $ad->id }}" 
                            class="ad-checkbox w-4 h-4 rounded border-gray-600 bg-white/5 text-emerald-500 focus:ring-emerald-500">
                        
                        <div class="w-16 h-16 rounded-lg bg-emerald-500/10 flex items-center justify-center flex-shrink-0 overflow-hidden">
                            @if($ad->images->first())
                                <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-image text-emerald-400"></i>
                            @endif
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-bold truncate">{{ $ad->title }}</h4>
                                @if($ad->is_featured)
                                    <span class="badge badge-amber text-[10px]"><i class="fa-solid fa-star"></i></span>
                                @endif
                            </div>
                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                <span class="badge {{ $ad->status === 'active' ? 'badge-emerald' : ($ad->status === 'pending' ? 'badge-amber' : 'badge-rose') }}">
                                    {{ $ad->status === 'active' ? 'نشط' : ($ad->status === 'pending' ? 'قيد المراجعة' : 'منتهي') }}
                                </span>
                                <span>{{ $ad->category?->name ?? 'عام' }}</span>
                                <span class="text-emerald-400">{{ $ad->price ? number_format($ad->price) . ' د.ج' : 'مجاني' }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-1">
                            <span class="text-xs text-gray-500 mr-2"><i class="fa-solid fa-eye mr-1"></i>{{ $ad->views_count ?? 0 }}</span>
                            
                            <a href="{{ route('ads.show', $ad->slug) }}" class="p-2 text-gray-400 hover:text-emerald-400" title="عرض">
                                <i class="fa-solid fa-external-link-alt"></i>
                            </a>
                            <a href="{{ route('ads.edit', $ad) }}" class="p-2 text-gray-400 hover:text-emerald-400" title="تعديل">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('ads.destroy', $ad) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الإعلان؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-rose-400" title="حذف">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="p-4 border-t border-white/5">
                {{ $ads->links() }}
            </div>
        @else
            <div class="p-12 text-center text-gray-500">
                <div class="w-20 h-20 rounded-full bg-emerald-500/10 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-newspaper text-emerald-400 text-3xl"></i>
                </div>
                <h4 class="font-bold text-lg mb-2">لا توجد إعلانات</h4>
                <p class="text-sm mb-4">ابدأ بإضافة إعلانات لمتجرك</p>
                <a href="{{ route('ads.create') }}" class="btn-premium px-6 py-2 rounded-lg text-xs inline-block">
                    إضافة أول إعلان
                </a>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
const selectAllCheckbox = document.getElementById('select-all');
const adCheckboxes = document.querySelectorAll('.ad-checkbox');
const selectedCountSpan = document.getElementById('selected-count');
const bulkActions = document.getElementById('bulk-actions');

function updateSelection() {
    const checked = document.querySelectorAll('.ad-checkbox:checked');
    selectedCountSpan.textContent = `(${checked.length})`;
    
    if (checked.length > 0) {
        bulkActions.style.opacity = '1';
        bulkActions.style.pointerEvents = 'auto';
    } else {
        bulkActions.style.opacity = '0.5';
        bulkActions.style.pointerEvents = 'none';
    }
}

selectAllCheckbox.addEventListener('change', function() {
    adCheckboxes.forEach(cb => cb.checked = this.checked);
    updateSelection();
});

adCheckboxes.forEach(cb => {
    cb.addEventListener('change', updateSelection);
});

function bulkAction(action) {
    const checked = document.querySelectorAll('.ad-checkbox:checked');
    if (checked.length === 0) return;
    
    const ids = Array.from(checked).map(cb => cb.value);
    
    if (action === 'delete' && !confirm(`هل أنت متأكد من حذف ${ids.length} إعلان؟`)) {
        return;
    }
    
    // Here you would make an AJAX call to perform the bulk action
    alert(`سيتم ${action === 'delete' ? 'حذف' : action === 'activate' ? 'تفعيل' : 'إيقاف'} ${ids.length} إعلان`);
}
</script>
@endsection
