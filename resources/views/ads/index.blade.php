@extends('layouts.app')

@section('title', 'معرض السيارات | Jmou3y Auto - الحاج عيسى')

@section('content')
<section class="car-shop-section spad bg-light" dir="rtl">
    <div class="container">
        
        {{-- Header & Total Count --}}
        <div class="row align-items-center mb-4">
            <div class="col-lg-8 col-md-8 text-center text-md-start">
                <div class="section-title">
                    <span class="badge-sub-title">
                        <i class="fa fa-shield-alt ms-1"></i> سوق السيارات في الجزائر
                    </span>
                    <h2 class="font-weight-bold text-dark mt-2" style="font-size: 32px;">
                        معرض <span style="color: #4B9FE1;">Jmou3y Auto</span>
                    </h2>
                    <p class="text-muted mt-1" style="font-size: 14px;">
                        تصفح أفضل عروض السيارات المتاحة للبيع والاستبدال تحت إشراف **الحاج عيسى**.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 text-center text-md-end mt-3 mt-md-0">
                <div class="d-inline-flex align-items-center bg-white p-3 rounded-12 shadow-sm border">
                    <div class="p-3 rounded-circle ms-3" style="background: rgba(75, 159, 225, 0.1); color: #4B9FE1;">
                        <i class="fa fa-car fa-lg"></i>
                    </div>
                    <div class="text-start">
                        <small class="text-muted d-block font-weight-bold" style="font-size: 11px;">السيارات المتاحة</small>
                        <h4 class="font-weight-bold mb-0 text-dark" style="font-size: 20px;">{{ number_format($ads->total()) }} سيارة</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Call To Action Banner (الحاج عيسى) --}}
        <div class="direct-contact-banner mb-4 p-3 rounded-12 text-white" style="background: linear-gradient(135deg, #0B132B 0%, #1D3354 100%); border: 1px solid rgba(75, 159, 225, 0.2);">
            <div class="row align-items-center text-center text-md-start">
                <div class="col-md-7 mb-2 mb-md-0">
                    <h5 class="mb-1 text-white font-weight-bold"><i class="fa fa-phone-alt text-info ms-2"></i> هل ترغب في بيع أو استبدال سيارتك؟</h5>
                    <small style="color: #94A3B8;">تواصل مباشرة مع الحاج عيسى للحصول على تقييم سريع لعرضك.</small>
                </div>
                <div class="col-md-5 text-center text-md-end">
                    <a href="tel:0670897630" class="btn btn-sm btn-outline-light me-1" style="border-radius: 8px;">
                        <i class="fa fa-phone ms-1"></i> 0670897630
                    </a>
                    <a href="https://wa.me/213670897630" target="_blank" class="btn btn-sm text-white" style="background-color: #25D366; border-radius: 8px;">
                        <i class="fa-brands fa-whatsapp ms-1"></i> واتساب
                    </a>
                </div>
            </div>
        </div>

        {{-- Filters & Sort Bar --}}
        <div class="bg-white p-3 rounded-12 shadow-sm border mb-4">
            <div class="row align-items-center justify-content-between g-3">
                <div class="col-lg-5 col-md-6">
                    <div class="position-relative">
                        <input type="text" class="form-control text-start shadow-none" placeholder="ابحث الماركة، الموديل، السنة..." style="border-radius: 8px; height: 45px; padding-start: 40px; font-size: 14px; border: 1px solid #E2E8F0;">
                        <i class="fa fa-search position-absolute text-muted" style="right: 15px; top: 15px;"></i>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 text-md-end d-flex justify-content-md-end align-items-center gap-2">
                    <span class="text-muted small font-weight-bold"><i class="fa fa-sort me-1"></i> الترتيب:</span>
                    <select class="sorting-select form-select" style="max-width: 200px; border-radius: 8px; font-size: 13px;">
                        <option selected>أحدث الإعلانات</option>
                        <option>السعر: من الأقل للأعلى</option>
                        <option>السعر: من الأعلى للأقل</option>
                        <option>الأقل ممشى</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Automotive Grid --}}
        @if($ads->count() > 0)
            <div class="row g-3">
                @foreach($ads as $ad)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <div class="card h-100 border-0 shadow-sm rounded-12 overflow-hidden vehicle-shop-card">
                            
                            {{-- Image View Container --}}
                            <div class="position-relative overflow-hidden" style="aspect-ratio: 1.5 / 1; background: #0B132B;">
                                <img src="{{ $ad->primary_image_url ?? asset('images/placeholder.jpg') }}" 
                                     alt="{{ $ad->title }}" 
                                     class="w-100 h-100 transition-all vehicle-card-img" 
                                     style="object-fit: cover; transition: transform 0.4s ease;">
                                
                                {{-- Condition Badge --}}
                                @if($ad->condition_text)
                                    <span class="badge position-absolute" style="top: 12px; right: 12px; background: rgba(11, 19, 43, 0.85); color: #4B9FE1; border: 1px solid rgba(75, 159, 225, 0.3); font-weight: 700; padding: 5px 10px; border-radius: 6px; font-size: 10px;">
                                        {{ $ad->condition_text }}
                                    </span>
                                @endif

                                {{-- Quick Actions Overlay --}}
                                <div class="card-action-overlay position-absolute d-flex align-items-center justify-content-center" style="inset: 0; background: rgba(11, 19, 43, 0.6); opacity: 0; transition: opacity 0.3s ease; gap: 8px;">
                                    <a href="{{ route('ads.show', $ad->slug) }}" class="btn btn-light rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; padding: 0;" title="معاينة">
                                        <i class="fa fa-eye text-dark"></i>
                                    </a>
                                    <button class="btn btn-light rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; padding: 0;" title="إضافة للمفضلة">
                                        <i class="fa fa-heart text-danger"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Details Body --}}
                            <div class="card-body p-3 d-flex flex-column justify-content-between text-start">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="font-weight-bold small" style="color: #4B9FE1; font-size: 11px;">
                                            <i class="fa fa-tag me-1"></i>{{ $ad->category->name ?? 'سيارات' }}
                                        </span>
                                        <span class="text-muted small" style="font-size: 11px;">
                                            <i class="fa fa-map-marker-alt text-danger me-1"></i>{{ $ad->city ?? 'الجزائر' }}
                                        </span>
                                    </div>
                                    
                                    <h5 class="card-title font-weight-bold mb-3" style="font-size: 14px; line-height: 1.4; height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                        <a href="{{ route('ads.show', $ad->slug) }}" class="text-dark text-decoration-none card-title-link">
                                            {{ $ad->title }}
                                        </a>
                                    </h5>
                                    
                                    {{-- Technical Specs Ribbon --}}
                                    <div class="d-flex justify-content-between text-muted small border-top pt-2 pb-2 mb-2" style="font-size: 11px; font-weight: 600; background: #F8FAFC; padding: 6px; border-radius: 6px;">
                                        <span><i class="fa fa-tachometer-alt ms-1" style="color: #4B9FE1;"></i>{{ number_format($ad->mileage ?? 0) }} كم</span>
                                        <span><i class="fa fa-cog ms-1" style="color: #4B9FE1;"></i>{{ $ad->transmission ?? 'يدوي' }}</span>
                                        <span><i class="fa fa-calendar-alt ms-1" style="color: #4B9FE1;"></i>{{ $ad->year ?? '2025' }}</span>
                                    </div>
                                </div>

                                {{-- Pricing & Action Footer --}}
                                <div class="pt-2 border-top d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-muted d-block" style="font-size: 9px; font-weight: 700;">السعر المطلوب</span>
                                        <span class="h6 font-weight-bold mb-0" style="color: #0B132B; font-size: 15px;">
                                            @if($ad->price)
                                                {{ number_format($ad->price) }} <span style="color: #4B9FE1; font-size: 11px;">د.ج</span>
                                            @else
                                                <span style="color: #4B9FE1; font-size: 12px; font-weight: 700;">قابل للتفاوض</span>
                                            @endif
                                        </span>
                                    </div>
                                    <a href="{{ route('ads.show', $ad->slug) }}" class="btn btn-sm rounded-8 btn-details-custom">
                                        التفاصيل <i class="fa fa-arrow-left ms-1" style="font-size: 10px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center custom-car-pagination">
                    {{ $ads->links() }}
                </div>
            </div>

        @else
            {{-- Empty State Area --}}
            <div class="row">
                <div class="col-12 text-center py-5">
                    <div class="p-5 border rounded-12 bg-white shadow-sm mx-auto" style="max-width: 500px; border-style: dashed !important; border-width: 2px !important;">
                        <div class="mb-3 text-muted">
                            <i class="fa fa-car fa-4x" style="color: #CBD5E1;"></i>
                        </div>
                        <h4 class="font-weight-bold mb-2" style="color: #0B132B;">لا توجد سيارات معروضة حالياً</h4>
                        <p class="text-muted mb-4 small">تواصل مع الحاج عيسى مباشرة لإضافة سيارتك المعروضة في المعرض!</p>
                        <a href="https://wa.me/213670897630" target="_blank" class="btn text-white px-4 py-2" style="background: #25D366; font-size: 14px; font-weight: 600; border-radius: 8px;">
                            <i class="fa-brands fa-whatsapp ms-1"></i> أضف سيارتك عبر واتساب
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

{{-- STYLES matching Jmou3y Auto Theme --}}
<style>
    .rounded-12 { border-radius: 12px !important; }
    .rounded-8 { border-radius: 8px !important; }

    .badge-sub-title {
        background: rgba(75, 159, 225, 0.12);
        color: #4B9FE1;
        font-weight: 700;
        font-size: 11px;
        padding: 5px 12px;
        border-radius: 20px;
        display: inline-block;
    }

    /* Card Interactions */
    .vehicle-shop-card {
        border: 1px solid #E2E8F0 !important;
        transition: all 0.3s ease;
    }
    .vehicle-shop-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px rgba(11, 19, 43, 0.12) !important;
        border-color: #4B9FE1 !important;
    }
    .vehicle-shop-card:hover .vehicle-card-img {
        transform: scale(1.06);
    }
    .vehicle-shop-card:hover .card-action-overlay {
        opacity: 1 !important;
    }
    .card-title-link {
        transition: color 0.2s ease;
    }
    .card-title-link:hover {
        color: #4B9FE1 !important;
    }

    .btn-details-custom {
        border: 1px solid #4B9FE1;
        color: #4B9FE1;
        font-weight: 600;
        padding: 5px 12px;
        font-size: 12px;
        transition: all 0.2s ease;
    }
    .btn-details-custom:hover {
        background: #4B9FE1 !important;
        color: #FFFFFF !important;
    }

    /* Pagination Tweaks */
    .custom-car-pagination nav ul {
        display: flex;
        padding-start: 0;
        list-style: none;
        gap: 6px;
    }
    .custom-car-pagination nav ul li a,
    .custom-car-pagination nav ul li span {
        display: inline-block;
        padding: 8px 14px;
        border: 1px solid #E2E8F0;
        color: #0B132B;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        border-radius: 8px;
    }
    .custom-car-pagination nav ul li.active span {
        background: #0B132B !important;
        border-color: #0B132B !important;
        color: #FFFFFF !important;
    }
    .custom-car-pagination nav ul li a:hover {
        border-color: #4B9FE1 !important;
        color: #4B9FE1 !important;
    }
</style>
@endsection