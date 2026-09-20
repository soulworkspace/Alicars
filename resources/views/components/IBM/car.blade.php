<div class="car-component-root">
<section class="car spad" id="collections">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="space-y-2 mb-4 text-center text-md-left">
                    <span class="text-brand font-black uppercase block" style="color: #4B9FE1; letter-spacing: 3px; font-weight: 700; font-size: 10px;">LATEST DROP</span>
                    <h2 class="font-black text-uppercase" style="font-weight: 900; font-size: 2.5rem; color: #18181b;">
                        Recent Arrivals<span style="color: #4B9FE1;">.</span>
                    </h2>
                </div>
                
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 gap-3">
                    <ul class="filter__controls m-0 p-0 d-flex flex-wrap gap-2 justify-content-center">
                        <li class="active" data-filter="*">All Vehicles</li>
                        <li data-filter=".sale">Latest Sales</li>
                    </ul>
                    
                    <a href="{{ route('ads.index') }}" class="group d-flex align-items-center gap-2 text-uppercase font-weight-bold text-secondary discover-link" style="font-size: 12px; letter-spacing: 1px; text-decoration: none;">
                        Discover More 
                        <i class="fa-solid fa-arrow-right-long transition-transform mx-2"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="row car-filter gy-4">
            @forelse($recentAds as $ad)
                @php
                    $adAttributes = $ad->relationLoaded('attributes')
                        ? $ad->attributes->mapWithKeys(function ($attribute) {
                            $key = strtolower((string) ($attribute->name ?: $attribute->label));
                            return [$key => $attribute->pivot->value ?? null];
                        })
                        : collect();

                    $attributeValue = function (array $keys, $fallback = 'N/A') use ($adAttributes) {
                        foreach ($keys as $key) {
                            if (filled($adAttributes->get(strtolower($key)))) {
                                return $adAttributes->get(strtolower($key));
                            }
                        }
                        return filled($fallback) ? $fallback : 'N/A';
                    };

                    $year = $attributeValue(['year', 'model_year', 'السنة']);
                    $make = $attributeValue(['make', 'brand', 'marque', 'العلامة'], 'Auto');
                    $transmission = $attributeValue(['transmission', 'gearbox', 'boite', 'ناقل الحركة'], 'Auto');
                    $condition = $ad->condition ?: 'used';
                    $categoryName = $ad->category?->name ?: 'Vehicle';
                    $previewUrl = route('ads.preview', $ad->slug);
                @endphp

                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mix sale">
                    <div class="car__item position-relative bg-white shadow-sm" data-preview-url="{{ $previewUrl }}">
                        
                        <!-- 1. Top Header Specs -->
                        <div class="car__item__top__specs border-bottom bg-light py-2 px-1">
                            <div class="row m-0 text-center">
                                <div class="col-4 p-0">
                                    <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Year</span>
                                    <strong class="d-block text-dark text-truncate" style="font-size: 12px;">{{ $year }}</strong>
                                </div>
                                <div class="col-4 p-0 border-start border-end">
                                    <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Make</span>
                                    <strong class="d-block text-dark text-truncate" style="font-size: 12px;">{{ $make }}</strong>
                                </div>
                                <div class="col-4 p-0">
                                    <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Transmission</span>
                                    <strong class="d-block text-dark text-truncate" style="font-size: 12px;">{{ $transmission }}</strong>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Image Slider + Status Badge & Price Overlay -->
                        <div class="position-relative">
                            <!-- Status Badge (NEW / USED) -->
                            <span class="badge-status text-uppercase">
                                {{ $condition }}
                            </span>

                            <div class="car__item__pic__slider owl-carousel preview-trigger">
                                @if($ad->images && $ad->images->isNotEmpty())
                                    @foreach($ad->images->take(3) as $img)
                                        <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $ad->title }}" style="object-fit: cover; height: 210px; width: 100%;">
                                    @endforeach
                                @else
                                    <div class="w-100 d-flex align-items-center justify-content-center bg-light text-muted" style="height: 210px;">
                                        <i class="fa-solid fa-image" style="font-size: 3rem; color: #1D3354;"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Price Overlay -->
                            <div class="car-price-overlay">
                                @if(isset($ad->old_price) && $ad->old_price)
                                    <span class="text-decoration-line-through opacity-75 mr-1" style="font-size: 11px;">{{ number_format($ad->old_price) }} DA</span>
                                @endif
                                <span>{{ number_format($ad->price) }} DA</span>
                            </div>
                        </div>
                        
                        <!-- 3. Card Details -->
                        <div class="car__item__text p-3">
                            <!-- Vehicle Category -->
                            <div class="text-uppercase font-weight-bold mb-1" style="color: #4B9FE1; font-size: 11px; letter-spacing: 0.5px;">
                                {{ $categoryName }}
                            </div>

                            <!-- Listing Title -->
                            <h5 class="font-weight-bold mb-3 text-truncate" style="font-size: 1rem;">
                                <a href="{{ route('ads.show', $ad->slug) }}" class="stretched-link text-decoration-none text-dark card-title-link preview-trigger">
                                    {{ $ad->title }}
                                </a>
                            </h5>

                            <!-- Bottom Specs -->
                            <div class="border-top pt-3 mt-2">
                                <div class="row m-0 text-center">
                                    <div class="col-4 p-0">
                                        <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Year</span>
                                        <span class="font-weight-bold text-dark d-block text-truncate" style="font-size: 12px;">{{ $year }}</span>
                                    </div>
                                    <div class="col-4 p-0 border-start border-end">
                                        <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Make</span>
                                        <span class="font-weight-bold text-dark d-block text-truncate" style="font-size: 12px;">{{ $make }}</span>
                                    </div>
                                    <div class="col-4 p-0">
                                        <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Transmission</span>
                                        <span class="font-weight-bold text-dark d-block text-truncate" style="font-size: 12px;">{{ $transmission }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <aside class="car-preview" aria-hidden="true" role="dialog" aria-label="Quick vehicle preview">
                            <div class="car-preview__loading">Loading preview...</div>
                            <div class="car-preview__content"></div>
                        </aside>
                        
                    </div>
                </div>
            @empty
                @for($i = 0; $i < 4; $i++)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="car__item" style="opacity: 0.6; animation: pulse 1.5s infinite ease-in-out;">
                            <div style="height: 35px; background: #f3f4f6;"></div>
                            <div style="height: 210px; background: #eee;"></div>
                            <div class="p-3">
                                <div style="height: 12px; width: 30%; background: #eee; margin-bottom: 8px; border-radius: 4px;"></div>
                                <div style="height: 18px; width: 85%; background: #eee; margin-bottom: 12px; border-radius: 4px;"></div>
                                <div style="height: 25px; width: 100%; background: #eee; border-radius: 4px;"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            @endforelse
        </div>
    </div>
</section>

<style>
    .car__item {
        border-radius: 8px;
        border: 1px solid #eef2f6;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        isolation: isolate;
    }
    
    .car__item:hover {
        transform: translateY(-6px);
        border-color: #4B9FE1 !important;
        box-shadow: 0 12px 25px rgba(29, 51, 84, 0.12);
    }

    .car-preview {
        position: absolute;
        z-index: 30;
        top: 12px;
        left: calc(100% + 14px);
        width: min(330px, 86vw);
        padding: 14px;
        color: #f8fafc;
        background: rgba(16, 35, 60, 0.94);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 12px;
        box-shadow: 0 18px 45px rgba(15, 35, 60, 0.28);
        backdrop-filter: blur(14px);
        opacity: 0;
        visibility: hidden;
        transform: translateX(-8px) translateY(4px);
        transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease;
        pointer-events: none;
    }

    .car__item.preview-open .car-preview {
        opacity: 1;
        visibility: visible;
        transform: translateX(0) translateY(0);
    }

    .car-preview__loading { color: rgba(255, 255, 255, 0.72); font-size: 12px; }
    .car-preview__gallery { display: grid; grid-template-columns: repeat(3, 1fr); gap: 5px; margin-bottom: 11px; }
    .car-preview__gallery img { width: 100%; height: 54px; object-fit: cover; border-radius: 5px; }
    .car-preview__eyebrow { color: #8fd0ff; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
    .car-preview__title { margin: 3px 0 9px; color: #fff; font-size: 15px; font-weight: 800; }
    .car-preview__specs { display: grid; grid-template-columns: repeat(2, 1fr); gap: 7px; margin: 0; }
    .car-preview__specs div { min-width: 0; padding: 7px; background: rgba(255, 255, 255, 0.08); border-radius: 5px; }
    .car-preview__specs dt { color: rgba(255, 255, 255, 0.62); font-size: 9px; text-transform: uppercase; }
    .car-preview__specs dd { margin: 2px 0 0; overflow: hidden; color: #fff; font-size: 11px; text-overflow: ellipsis; white-space: nowrap; }
    .car-preview__price { margin-top: 11px; color: #8fd0ff; font-size: 18px; font-weight: 800; }
    .car-preview__description { margin: 8px 0 0; color: rgba(255, 255, 255, 0.74); font-size: 11px; line-height: 1.5; }

    @media (max-width: 767px) {
        .car-preview { top: calc(100% + 10px); right: 8px; left: 8px; width: auto; transform: translateY(-5px); }
        .car__item.preview-open .car-preview { transform: translateY(0); }
    }

    .card-title-link {
        transition: color 0.2s ease;
    }

    .car__item:hover .card-title-link {
        color: #4B9FE1 !important;
    }

    .badge-status {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 10;
        background-color: #e53e3e;
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 3px;
        letter-spacing: 0.5px;
    }

    .car-price-overlay {
        position: absolute;
        bottom: 0;
        right: 0;
        z-index: 10;
        background: #4B9FE1;
        color: #ffffff;
        font-weight: 800;
        font-size: 0.95rem;
        padding: 6px 14px;
        border-top-left-radius: 6px;
    }

    .car__item .owl-dots, 
    .car__item .owl-nav {
        position: relative;
        z-index: 5;
    }

    .filter__controls li.active, 
    .filter__controls li:hover {
        color: #4B9FE1 !important;
    }
    
    .filter__controls li.active::after {
        background: #4B9FE1 !important;
    }

    .discover-link:hover, .discover-link:hover i {
        color: #4B9FE1 !important;
    }
    
    .discover-link:hover i {
        transform: translateX(5px);
    }
    
    .discover-link i {
        transition: transform 0.3s ease;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .4; }
    }
</style>

<script src="{{ asset('js/car-preview.js') }}"></script>
</div>