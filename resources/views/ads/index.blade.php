@extends('layouts.app')

@section('title', 'Browse Vehicles | MB Motors')

@section('content')
<!-- تم استخدام spad المعتمدة في القالب الأصلي لضبط الهوامش بدقة -->
<section class="car-shop-section spad bg-light">
    <div class="container">
        
        {{-- Header & Total Count --}}
        <div class="row align-items-center mb-5">
            <div class="col-lg-8 col-md-8">
                <div class="section-title text-left">
                    <span style="color: #c18f54; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-size: 12px;">Global Automotive Marketplace</span>
                    <h2 class="font-weight-bold text-dark mt-1" style="font-size: 36px;">Our Car <span style="color: #c18f54;">Showroom</span></h2>
                    <p class="text-muted mt-2">Explore the finest selection of vehicles curated carefully by premium sellers globally.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 text-md-right text-left mt-3 mt-md-0">
                <div class="d-inline-flex align-items-center bg-white p-3 rounded shadow-sm border">
                    <div class="p-3 rounded-circle mr-3" style="background: rgba(193, 143, 84, 0.1); color: #c18f54;">
                        <i class="fa fa-car fa-lg"></i>
                    </div>
                    <div class="text-left">
                        <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 10px;">Available Cars</small>
                        <h4 class="font-weight-bold mb-0 text-dark" style="font-size: 20px;">{{ number_format($ads->total()) }} Vehicles</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters & Sort Bar (Integrated with nice-select styles) --}}
        <div class="bg-white p-4 rounded shadow-sm border mb-5">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search make, model, year..." style="border-radius: 5px; height: 45px; padding-left: 40px; font-size: 14px;">
                        <i class="fa fa-search position-absolute text-muted" style="left: 15px; top: 15px;"></i>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 text-md-right d-flex justify-content-md-end align-items-center" style="gap: 15px;">
                    <span class="text-muted small font-weight-bold"><i class="fa fa-sort"></i> Sort By:</span>
                    <!-- سيتكفل ملف nice-select.js المرفق في الـ Layout بتنسيق هذا العنصر تلقائياً -->
                    <select class="sorting-select">
                        <option selected>Latest Ads</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Lowest Mileage</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Automotive Grid --}}
        @if($ads->count() > 0)
            <div class="row">
                @foreach($ads as $ad)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm rounded overflow-hidden vehicle-shop-card">
                            
                            {{-- Image View Container --}}
                            <div class="position-relative overflow-hidden" style="aspect-ratio: 1.5 / 1; background: #eaeaea;">
                                <img src="{{ $ad->primary_image_url ?? 'https://via.placeholder.com/500x350?text=MB+Motors' }}" 
                                     alt="{{ $ad->title }}" 
                                     class="w-100 h-100 transition-all vehicle-card-img" 
                                     style="object-fit: cover; transition: transform 0.4s ease;">
                                
                                {{-- Condition Label --}}
                                @if($ad->condition_text)
                                    <span class="badge position-absolute" style="top: 15px; right: 15px; background: rgba(255,255,255,0.95); color: #111; font-weight: 700; padding: 6px 12px; border-radius: 20px; font-size: 11px;">
                                        {{ $ad->condition_text }}
                                    </span>
                                @endif

                                {{-- Quick Actions Hub --}}
                                <div class="card-action-overlay position-absolute d-flex align-items-center justify-content-center" style="inset: 0; background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s ease; gap: 8px;">
                                    <a href="{{ route('ads.show', $ad->slug) }}" class="btn btn-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; padding: 0;">
                                        <i class="fa fa-eye text-dark"></i>
                                    </a>
                                    <button class="btn btn-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; padding: 0;">
                                        <i class="fa fa-heart text-danger"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Details Body --}}
                            <div class="card-body p-3 d-flex flex-column justify-content-between text-left">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="font-weight-bold small" style="color: #c18f54;">{{ $ad->category->name }}</span>
                                        <span class="text-muted small"><i class="fa fa-map-marker"></i> {{ $ad->city ?? 'Algiers' }}</span>
                                    </div>
                                    <h5 class="card-title font-weight-bold mb-3" style="font-size: 15px; line-height: 1.4; height: 42px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                        <a href="{{ route('ads.show', $ad->slug) }}" class="text-dark text-decoration-none card-title-link">
                                            {{ $ad->title }}
                                        </a>
                                    </h5>
                                    
                                    {{-- Technical Specs Ribbon --}}
                                    <div class="d-flex justify-content-between text-muted small border-top pt-2 pb-2 mb-2" style="font-size: 12px; font-weight: 600;">
                                        <span><i class="fa fa-dashboard" style="color: #c18f54; margin-right: 2px;"></i> {{ $ad->mileage ?? '0' }} km</span>
                                        <span><i class="fa fa-cog" style="color: #c18f54; margin-right: 2px;"></i> {{ $ad->transmission ?? 'Manual' }}</span>
                                        <span><i class="fa fa-calendar" style="color: #c18f54; margin-right: 2px;"></i> {{ $ad->year ?? '2025' }}</span>
                                    </div>
                                </div>

                                {{-- Pricing & Action Footer --}}
                                <div class="pt-2 border-top d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-muted d-block uppercase" style="font-size: 9px; font-weight: 700; letter-spacing: 0.5px;">TOTAL PRICE</span>
                                        <span class="h5 font-weight-bold text-dark mb-0" style="font-size: 16px;">
                                            @if($ad->price)
                                                {{ number_format($ad->price) }} <span style="color: #c18f54; font-size: 12px;">DA</span>
                                            @else
                                                <span style="color: #c18f54; font-size: 13px; font-weight: 700;">Negotiable</span>
                                            @endif
                                        </span>
                                    </div>
                                    <a href="{{ route('ads.show', $ad->slug) }}" class="btn btn-sm rounded" style="border: 1px solid #c18f54; color: #c18f54; font-weight: 600; padding: 5px 12px; transition: all 0.2s;">
                                        Details <i class="fa fa-arrow-right" style="font-size: 10px; margin-left: 2px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Template Aligned Pagination --}}
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center custom-car-pagination">
                    {{ $ads->links() }}
                </div>
            </div>

        @else
            {{-- Empty State Area --}}
            <div class="row">
                <div class="col-12 text-center py-5">
                    <div class="p-5 border rounded bg-white shadow-sm mx-auto" style="max-width: 500px; border-style: dashed !important; border-width: 2px !important;">
                        <div class="mb-4 text-muted">
                            <i class="fa fa-car fa-4x" style="color: #dee2e6;"></i>
                        </div>
                        <h4 class="font-weight-bold mb-2 text-dark">No Vehicles Available</h4>
                        <p class="text-muted mb-4 small">Be the first to list your vehicle on MB Motors marketplace!</p>
                        <a href="{{ route('ads.create') }}" class="btn text-white px-4 py-2" style="background: #111; font-size: 14px; font-weight: 600; border-radius: 4px;">
                            <i class="fa fa-plus-circle"></i> Add Your Vehicle
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

{{-- Extra Scoped Hover & Pagination Fixes --}}
<style>
    /* Card Interactions */
    .vehicle-shop-card:hover {
        box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
    }
    .vehicle-shop-card:hover .vehicle-card-img {
        transform: scale(1.05);
    }
    .vehicle-shop-card:hover .card-action-overlay {
        opacity: 1 !important;
    }
    .card-title-link:hover {
        color: #c18f54 !important;
    }
    .vehicle-shop-card .btn-sm:hover {
        background: #c18f54 !important;
        color: #fff !important;
    }

    /* Fixing FontAwesome icons spacing when inside LTR layouts */
    .card-body i {
        margin-right: 2px;
    }

    /* Template Pagination Reset Code */
    .custom-car-pagination nav ul {
        display: flex;
        padding-left: 0;
        list-style: none;
        gap: 6px;
    }
    .custom-car-pagination nav ul li a,
    .custom-car-pagination nav ul li span {
        display: inline-block;
        padding: 8px 16px;
        border: 1px solid #dee2e6;
        color: #495057;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        border-radius: 4px;
    }
    .custom-car-pagination nav ul li.active span {
        background: #c18f54 !important;
        border-color: #c18f54 !important;
        color: #fff !important;
    }
    .custom-car-pagination nav ul li a:hover {
        border-color: #c18f54 !important;
        color: #c18f54 !important;
    }
</style>
@endsection