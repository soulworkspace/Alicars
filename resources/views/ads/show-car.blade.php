@extends('layouts.app')

@section('title', $ad->title . ' | HA')

@section('content')
<!-- تخصيص الألوان الداكنة والزمردية لصفحة تفاصيل السيارة -->
<style>
    :root {
        --emerald-light: #10b981;
        --card-bg: #14171c;
        --input-bg: #0f1115;
        --border-color: #2d3139;
    }
    body {
        background-color: #0b0c10;
        color: #ffffff;
    }
    .premium-card {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
    }
    .attribute-box {
        background-color: var(--input-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }
    .attribute-box:hover {
        border-color: var(--emerald-light);
        transform: translateY(-2px);
    }
    .section-indicator {
        background-color: var(--emerald-light);
        width: 4px;
        height: 24px;
        display: inline-block;
        border-radius: 2px;
    }
    .btn-action-primary {
        background-color: var(--emerald-light);
        color: #ffffff !important;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    .btn-action-primary:hover {
        background-color: #059669;
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
    }
    .btn-action-secondary {
        background-color: var(--input-bg);
        border: 1px solid var(--border-color);
        color: #ffffff;
        transition: all 0.3s ease;
    }
    .btn-action-secondary:hover {
        border-color: #ef4444;
        color: #ef4444;
    }
</style>

<div class="container py-5">
    <h1>555</h1>
    <div class="row g-4">
        <!-- Main Content (تفاصيل السيارة والصور) -->
        <div class="col-xl-8 col-lg-8 col-md-12">
            
            <!-- Image Gallery -->
            <div class="premium-card overflow-hidden mb-4">
                @if($ad->images && $ad->images->count() > 0)
                    <div class="position-relative" style="height: 450px;">
                        <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" 
                             alt="{{ $ad->title }}" 
                             class="w-100 h-100 object-cover">
                        @if($ad->is_featured)
                            <span class="position-absolute top-0 end-0 m-4 badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">
                                <i class="fas fa-star me-1"></i> مميز
                            </span>
                        @endif
                    </div>
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center bg-dark" style="height: 450px;">
                        <i class="fas fa-image text-muted display-4 mb-2"></i>
                        <span class="text-secondary">لا توجد صور متوفرة للمركبة</span>
                    </div>
                @endif
            </div>

            <!-- Car Details Block -->
            <div class="premium-card p-4 p-md-5 mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <div>
                        <h1 class="h2 fw-bold text-white mb-2">{{ $ad->title }}</h1>
                        <p class="text-muted mb-0">
                            <i class="fas fa-map-marker-alt text-secondary me-1 ms-1"></i>
                            {{ $ad->location ?? 'الجزائر' }} {{ $ad->city ? ' - ' . $ad->city : '' }}
                        </p>
                    </div>
                    <div class="text-md-end">
                        <div class="h2 fw-extrabold mb-1" style="color: var(--emerald-light);">
                            {{ $ad->price ? number_format($ad->price, 0, '.', ' ') . ' د.ج' : 'على السوم (غير محدد)' }}
                        </div>
                        <span class="badge bg-dark text-secondary border border-secondary px-3 py-2 rounded-pill small">
                            {{ $ad->condition === 'new' ? 'جديدة تماماً (أصفار)' : 'مستعملة' }}
                        </span>
                    </div>
                </div>

                <hr class="border-secondary my-4">

                <!-- Car Specific Attributes Grid -->
                <div class="d-flex align-items-center mb-4">
                    <span class="section-indicator me-2 ms-2"></span>
                    <h3 class="h5 fw-bold text-white mb-0">المواصفات الفنية للمركبة</h3>
                </div>

                <div class="row g-3 mb-5">
                    {{-- السنة --}}
                    <div class="col-6 col-md-3">
                        <div class="attribute-box p-3 text-center">
                            <i class="fas fa-calendar-alt text-muted mb-2 fs-4"></i>
                            <p class="text-secondary small mb-1">سنة الصنع</p>
                            <p class="fw-bold text-white mb-0">{{ $ad->year ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                    {{-- الماركة / الشركة --}}
                    <div class="col-6 col-md-3">
                        <div class="attribute-box p-3 text-center">
                            <i class="fas fa-car text-muted mb-2 fs-4"></i>
                            <p class="text-secondary small mb-1">الماركة</p>
                            <p class="fw-bold text-white mb-0">{{ $ad->category->parent->name ?? $ad->category->name ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                    {{-- الفئة / الموديل --}}
                    <div class="col-6 col-md-3">
                        <div class="attribute-box p-3 text-center">
                            <i class="fas fa-tags text-muted mb-2 fs-4"></i>
                            <p class="text-secondary small mb-1">الفئة</p>
                            <p class="fw-bold text-white mb-0">{{ $ad->category->name ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                    {{-- المسافة المقطوعة --}}
                    <div class="col-6 col-md-3">
                        <div class="attribute-box p-3 text-center">
                            <i class="fas fa-tachometer-alt text-muted mb-2 fs-4"></i>
                            <p class="text-secondary small mb-1">المسافة</p>
                            <p class="fw-bold text-white mb-0">
                                {{ $ad->mileage ? number_format($ad->mileage, 0, '.', ' ') . ' كم' : '0 كم' }}
                            </p>
                        </div>
                    </div>
                    {{-- نوع الوقود --}}
                    <div class="col-6 col-md-4">
                        <div class="attribute-box p-3 text-center">
                            <i class="fas fa-gas-pump text-muted mb-2 fs-4"></i>
                            <p class="text-secondary small mb-1">نوع الوقود</p>
                            <p class="fw-bold text-white mb-0">
                                @switch($ad->fuel_type)
                                    @case('gasoline') بنزين @break
                                    @case('diesel') ديزل (مازوت) @break
                                    @case('electric') كهربائي بالكامل @break
                                    @case('hybrid') هجين @break
                                    @default {{ $ad->fuel_type }}
                                @endswitch
                            </p>
                        </div>
                    </div>
                    {{-- ناقل الحركة --}}
                    <div class="col-6 col-md-4">
                        <div class="attribute-box p-3 text-center">
                            <i class="fas fa-cog text-muted mb-2 fs-4"></i>
                            <p class="text-secondary small mb-1">ناقل الحركة</p>
                            <p class="fw-bold text-white mb-0">
                                @switch($ad->transmission)
                                    @case('automatic') أوتوماتيك @break
                                    @case('manual') يدوي (عادي) @break
                                    @case('cvt') سي في تي @break
                                    @default {{ $ad->transmission }}
                                @endswitch
                            </p>
                        </div>
                    </div>
                    {{-- حالة السعر --}}
                    <div class="col-12 col-md-4">
                        <div class="attribute-box p-3 text-center">
                            <i class="fas fa-money-bill-wave text-muted mb-2 fs-4"></i>
                            <p class="text-secondary small mb-1">حالة السعر</p>
                            <p class="fw-bold text-white mb-0">
                                @switch($ad->price_type)
                                    @case('fixed') ثابت وغير قابل للنقاش @break
                                    @case('negotiable') قابل للتفاوض @break
                                    @case('offered') عطاو (أعلى سومة) @break
                                    @default سعر محدد
                                @endswitch
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Description Block -->
                <div class="mb-2">
                    <div class="d-flex align-items-center mb-3">
                        <span class="section-indicator me-2 ms-2"></span>
                        <h3 class="h5 fw-bold text-white mb-0">الوصف التفصيلي للمركبة</h3>
                    </div>
                    <p class="text-secondary lh-lg" style="white-space: pre-line;">{{ $ad->description }}</p>
                </div>
            </div>
        </div>

        <!-- Sidebar (معلومات الاتصال والإجراءات السريعة) -->
        <div class="col-xl-4 col-lg-4 col-md-12">
            
            <!-- Contact Card -->
            <div class="premium-card p-4 mb-4">
                <h3 class="h5 fw-bold text-white mb-4 pb-2 border-bottom border-secondary">معلومات الاتصال</h3>
                
                @if($ad->show_contact_info ?? true)
                    @if($ad->contact_phone)
                        <a href="tel:{{ $ad->contact_phone }}" 
                           class="btn btn-action-primary w-100 py-3 rounded-3 mb-3 d-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-phone-alt"></i>
                            <span dir="ltr">{{ $ad->contact_phone }}</span>
                        </a>
                    @endif
                    
                    @if($ad->contact_whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ad->contact_whatsapp) }}" 
                           target="_blank"
                           class="btn btn-success w-100 py-3 rounded-3 mb-4 fw-bold d-flex align-items-center justify-content-center gap-2 shadow-sm">
                            <i class="fab fa-whatsapp fs-5"></i>
                            تواصل عبر الواتساب
                        </a>
                    @endif
                @else
                    <div class="alert bg-dark border-secondary text-secondary text-center small py-3 mb-4 rounded-3">
                        <i class="fas fa-info-circle me-1"></i> صاحب الإعلان يفضل التواصل عبر نموذج المراسلة المباشر أدناه.
                    </div>
                @endif

                <!-- Livewire Contact Form Partial Component -->
                <div class="p-3 rounded-3" style="background-color: var(--input-bg); border: 1px solid var(--border-color);">
                    <livewire:contact-form :ad-id="$ad->id" />
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="premium-card p-4">
                <h3 class="h5 fw-bold text-white mb-4 pb-2 border-bottom border-secondary">إجراءات سريعة</h3>
                <div class="d-flex flex-column gap-2">
                    <button class="btn btn-action-secondary w-100 py-2.5 rounded-3 fw-medium d-flex align-items-center justify-content-center gap-2" style="background-color: rgba(16, 185, 129, 0.08); border-color: rgba(16, 185, 129, 0.2); color: var(--emerald-light);">
                        <i class="fas fa-heart"></i> إضافة إلى المفضلة
                    </button>
                    <button class="btn btn-action-secondary w-100 py-2.5 rounded-3 fw-medium d-flex align-items-center justify-content-center gap-2">
                        <i class="fas fa-flag"></i> الإبلاغ عن هذا الإعلان
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection