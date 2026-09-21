@props(['ad'])

@php
    // معالجة واستخراج روابط الصور بشكل آمن
    $images = collect();

    if ($ad->relationLoaded('images') && $ad->images->isNotEmpty()) {
        $images = $ad->images->take(3)->map(function ($img) {
            $path = trim((string) ($img->image_path ?? ''));

            if (blank($path)) {
                return asset('bgg.jfif');
            }

            if (filter_var($path, FILTER_VALIDATE_URL)) {
                return $path;
            }

            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->url($path);
            }

            if (str_starts_with($path, 'storage/')) {
                return asset($path);
            }

            return asset('storage/' . ltrim($path, '/'));
        });
    }

    $fallbackImg = asset('bgg.jfif');
    $imagesJson = json_encode($images->isNotEmpty() ? $images->values()->all() : [$fallbackImg]);
@endphp

<div class="car__item border rounded shadow-sm overflow-hidden bg-white w-100 h-100 position-relative d-flex flex-column" 
     data-slug="{{ $ad->slug }}"
     data-preview-url="{{ route('ads.preview', $ad->slug) }}"
     data-images='{!! $imagesJson !!}'
     dir="rtl">
    
    <!-- حاوية الصورة مع حماية overflow لمنع خروج عناصر السلايدر -->
    <div class="car__item__pic position-relative w-100 overflow-hidden" style="aspect-ratio: 16 / 10; min-height: 180px; max-height: 240px; background-color: #f8f9fa;">
        @if($images->isNotEmpty())
            <div class="car__item__pic__slider owl-carousel preview-trigger h-100 w-100 overflow-hidden">
                @foreach($images as $imgUrl)
                    <div class="car-img-holder h-100 w-100 overflow-hidden">
                        <img src="{{ $imgUrl }}" 
                             alt="سيارة {{ $ad->title }}" 
                             loading="lazy" 
                             onerror="this.onerror=null; this.src='{{ $fallbackImg }}';"
                             class="w-100 h-100"
                             style="object-fit: cover; display: block;">
                    </div>
                @endforeach
            </div>
        @else
            <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-muted p-3">
                <i class="fa-solid fa-car" style="font-size: 2.5rem; color: #4B9FE1;" aria-hidden="true"></i>
                <span class="mt-2 text-center small">لا تتوفر صورة لهذه السيارة</span>
            </div>
        @endif

        <!-- شارة السعر -->
        <div class="car__item__price position-absolute bottom-0 end-0 bg-primary text-white px-2 px-sm-3 py-1 fw-bold" 
             style="font-size: clamp(0.75rem, 2.5vw, 0.875rem); z-index: 2; border-top-right-radius: 6px;">
            {{ $ad->price !== null ? number_format((float) $ad->price, 0, '.', ' ') . ' د.ج' : 'عند الطلب' }}
        </div>

        <!-- شارة حالة السيارة -->
        @if($ad->condition)
            <div class="position-absolute top-0 start-0 m-2 badge bg-danger text-uppercase px-2 py-1" 
                 style="z-index: 2; font-size: clamp(0.65rem, 2vw, 0.75rem);">
                سيارة {{ $ad->condition }}
            </div>
        @endif
    </div>

    <!-- تفاصيل السيارة -->
    <div class="car__item__text p-3 d-flex flex-column justify-content-between flex-grow-1 overflow-hidden">
        <div class="car__item__text_title mb-2">
            <span class="text-primary text-uppercase fw-bold d-block text-truncate mb-1" style="font-size: 0.75rem;">
                <i class="fa-solid fa-circle-check ms-1" style="font-size: 0.7rem;"></i>
                سيارة {{ $ad->category?->name ?? 'متوفرة' }}
            </span>
            <h5 class="m-0 text-truncate fw-bold" style="font-size: clamp(0.9rem, 2.5vw, 1.05rem);">
                <a href="{{ route('ads.show', $ad->slug) }}" class="text-dark text-decoration-none" title="سيارة {{ $ad->title }}">
                    سيارة {{ $ad->title }}
                </a>
            </h5>
        </div>

        <!-- أشرطة المواصفات السريعة -->
        <div class="border-top border-bottom py-2 mt-auto text-muted d-flex align-items-center justify-content-between flex-nowrap gap-1" style="font-size: clamp(0.68rem, 1.8vw, 0.78rem);">
            <div class="d-flex align-items-center gap-1 text-truncate" title="سنة الصنع">
                <i class="fa-regular fa-calendar-alt text-primary flex-shrink-0"></i> 
                <span class="text-truncate">{{ $ad->year ?? 'غير محدد' }}</span>
            </div>
            <div class="d-flex align-items-center gap-1 text-truncate" title="ناقل الحركة">
                <i class="fa-solid fa-gauge-high text-primary flex-shrink-0"></i> 
                <span class="text-truncate">{{ $ad->transmission ?? 'يدوي' }}</span>
            </div>
            <div class="d-flex align-items-center gap-1 text-truncate" title="نوع الوقود">
                <i class="fa-solid fa-gas-pump text-primary flex-shrink-0"></i> 
                <span class="text-truncate">{{ $ad->fuel_type ?? 'ديزل' }}</span>
            </div>
        </div>
    </div>
</div>