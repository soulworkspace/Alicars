@props(['ad'])

@php
    // استخراج رابط الصورة الرئيسية
    $mainImageUrl = null;

    if ($ad->relationLoaded('images') && $ad->images->isNotEmpty()) {
        $firstImg = $ad->images->first();
        $path = trim((string) ($firstImg->image_path ?? ''));

        if (!blank($path)) {
            if (filter_var($path, FILTER_VALIDATE_URL)) {
                $mainImageUrl = $path;
            } elseif (Storage::disk('public')->exists($path)) {
                $mainImageUrl = Storage::disk('public')->url($path);
            } elseif (str_starts_with($path, 'storage/')) {
                $mainImageUrl = asset($path);
            } else {
                $mainImageUrl = asset('storage/' . ltrim($path, '/'));
            }
        }
    }

    $fallbackImg = asset('bgg.jfif');
    $finalImg = $mainImageUrl ?? $fallbackImg;

    // تنظيف العنوان لمنع تكرار كلمة "سيارة"
    $cleanTitle = preg_replace('/^سيارة\s+/ui', '', trim($ad->title));
@endphp

<div class="vehicle-card bg-white rounded-12 border overflow-hidden h-100 d-flex flex-column transition-all w-100 shadow-sm" dir="rtl">
    
    {{-- Container الصورة والشارات --}}
    <div class="card-img-wrapper position-relative overflow-hidden" style="aspect-ratio: 16 / 10; background-color: #0B132B;">
        <img src="{{ $finalImg }}" 
             alt="{{ $cleanTitle }}" 
             loading="lazy" 
             onerror="this.onerror=null; this.src='{{ $fallbackImg }}';"
             class="w-100 h-100 vehicle-img"
             style="object-fit: cover; transition: transform 0.4s ease;">

        {{-- شارة حالة السيارة --}}
        @if($ad->condition)
            <span class="badge position-absolute" style="top: 12px; right: 12px; background: rgba(11, 19, 43, 0.85); color: #4B9FE1; border: 1px solid rgba(75, 159, 225, 0.3); font-weight: 700; padding: 6px 12px; border-radius: 6px; font-size: 11px;">
                {{ $ad->condition }}
            </span>
        @endif

        {{-- شارة السعر --}}
        <div class="position-absolute bottom-0 start-0 m-2 px-3 py-1 rounded-6 text-white font-weight-bold shadow-sm" style="background: linear-gradient(135deg, #0B132B, #1D3354); font-size: 13px; border: 1px solid rgba(255,255,255,0.15);">
            {{ $ad->price !== null ? number_format((float) $ad->price, 0, '.', ' ') . ' د.ج' : 'عند الطلب' }}
        </div>
    </div>

    {{-- تفاصيل السيارة --}}
    <div class="card-body p-3 d-flex flex-column justify-content-between flex-grow-1">
        <div>
            {{-- شارة معرض السيارات بالأزرق المميز --}}
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="font-weight-bold px-2 py-1 rounded-4" style="font-size: 11px; color: #4B9FE1; background-color: rgba(75, 159, 225, 0.1); border: 1px solid rgba(75, 159, 225, 0.2);">
                    <i class="fa-solid fa-store ms-1"></i> متوفرة في معرض السيارات
                </span>
                @if($ad->city)
                    <span class="text-muted small" style="font-size: 11px;">
                        <i class="fa-solid fa-location-dot text-danger ms-1"></i>{{ $ad->city }}
                    </span>
                @endif
            </div>

            {{-- عنوان السيارة Clean Title --}}
            <h5 class="font-weight-bold mb-3 text-dark mt-2" style="font-size: 15px; line-height: 1.4; height: 42px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                <a href="{{ route('ads.show', $ad->slug) }}" class="text-dark text-decoration-none card-title-hover">
                    {{ $cleanTitle }}
                </a>
            </h5>

            {{-- شريط المواصفات السريعة --}}
            <div class="d-flex align-items-center justify-content-between text-muted py-2 px-2 rounded-8 mb-3" style="background: #F8FAFC; border: 1px solid #E2E8F0; font-size: 12px; font-weight: 600;">
                <div title="سنة الصنع">
                    <i class="fa-regular fa-calendar-alt text-primary ms-1"></i>
                    <span>{{ $ad->year ?? 'غير محدد' }}</span>
                </div>
                <div title="ناقل الحركة">
                    <i class="fa-solid fa-gauge-high text-primary ms-1"></i>
                    <span>{{ $ad->transmission ?? 'يدوي' }}</span>
                </div>
                <div title="نوع الوقود">
                    <i class="fa-solid fa-gas-pump text-primary ms-1"></i>
                    <span>{{ $ad->fuel_type ?? 'مازوت / بنزين' }}</span>
                </div>
            </div>
        </div>

        {{-- زر التفاصيل --}}
        <div class="pt-2 border-top d-flex align-items-center justify-content-between mt-auto">
            <a href="{{ route('ads.show', $ad->slug) }}" class="btn btn-sm w-100 py-2 font-weight-bold d-flex align-items-center justify-content-center gap-2" style="background: #0B132B; color: #FFFFFF; border-radius: 8px; font-size: 13px; transition: all 0.2s ease;">
                <span>عرض التفاصيل الكاملة</span>
                <i class="fa-solid fa-arrow-left" style="font-size: 11px;"></i>
            </a>
        </div>
    </div>
</div>

<style>
    .rounded-12 { border-radius: 12px !important; }
    .rounded-8 { border-radius: 8px !important; }
    .rounded-6 { border-radius: 6px !important; }
    .rounded-4 { border-radius: 4px !important; }

    .vehicle-card {
        border-color: #E2E8F0 !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .vehicle-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(11, 19, 43, 0.12) !important;
        border-color: #4B9FE1 !important;
    }
    .vehicle-card:hover .vehicle-img {
        transform: scale(1.06);
    }
    .card-title-hover:hover {
        color: #4B9FE1 !important;
    }
</style>