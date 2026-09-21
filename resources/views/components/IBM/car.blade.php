<div class="car-component-root">
<section class="car spad" id="collections">
    <div class="container">
        <!-- Section Header -->
        <div class="row">
            <div class="col-lg-12">
                <div class="space-y-2 mb-4 text-center text-md-left">
                    <span class="text-brand font-black uppercase block tracking-wider" style="color: #4B9FE1; font-weight: 700; font-size: 10px; letter-spacing: 3px;">LATEST DROP</span>
                    <h2 class="font-black text-uppercase" style="font-weight: 900; font-size: 2.5rem; color: #18181b;">
                        Recent Arrivals<span style="color: #4B9FE1;">.</span>
                    </h2>
                </div>
                
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 gap-3">
                    <ul class="filter__controls m-0 p-0 d-flex flex-wrap gap-2 justify-content-center" role="tablist">
                        <li class="active cursor-pointer" data-filter="*" role="tab" aria-selected="true">All Vehicles</li>
                        <li class="cursor-pointer" data-filter=".sale" role="tab" aria-selected="false">Latest Sales</li>
                    </ul>
                    
                    <a href="{{ route('ads.index') }}" class="group d-flex align-items-center gap-2 text-uppercase font-weight-bold text-secondary discover-link" style="font-size: 12px; letter-spacing: 1px; text-decoration: none;">
                        Discover More 
                        <i class="fa-solid fa-arrow-right-long transition-transform mx-2" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Cards Grid -->
        <div class="row car-filter gy-4">
            @forelse($recentAds as $ad)
                @php
                    $getSpec = function (array $keys, $fallback = 'N/A') use ($ad) {
                        if (!$ad->relationLoaded('attributes')) {
                            return $fallback;
                        }

                        foreach ($keys as $key) {
                            $found = $ad->attributes->first(function ($attr) use ($key) {
                                $name = strtolower((string) ($attr->name ?: $attr->label));
                                return $name === strtolower($key);
                            });

                            if ($found && filled($found->pivot?->value)) {
                                return $found->pivot->value;
                            }
                        }

                        return $fallback;
                    };

                    $year = $getSpec(['year', 'model_year', 'السنة']);
                    $make = $getSpec(['make', 'brand', 'marque', 'العلامة'], 'Auto');
                    $transmission = $getSpec(['transmission', 'gearbox', 'boite', 'ناقل الحركة'], 'Auto');
                    $condition = $ad->condition ?? 'used';
                    $categoryName = $ad->category?->name ?? 'Vehicle';
                    $previewUrl = route('ads.preview', $ad->slug);
                @endphp

                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mix sale">
                    <article class="car__item position-relative bg-white shadow-sm h-100 d-flex flex-column" data-preview-url="{{ $previewUrl }}">
                        
                        <!-- 1. Top Header Specs -->
                        <div class="car__item__top__specs border-bottom bg-light py-2 px-1">
                            <div class="row m-0 text-center">
                                <div class="col-4 p-0">
                                    <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Year</span>
                                    <strong class="d-block text-dark text-truncate px-1" style="font-size: 12px;">{{ $year }}</strong>
                                </div>
                                <div class="col-4 p-0 border-start border-end">
                                    <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Make</span>
                                    <strong class="d-block text-dark text-truncate px-1" style="font-size: 12px;">{{ $make }}</strong>
                                </div>
                                <div class="col-4 p-0">
                                    <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Transmission</span>
                                    <strong class="d-block text-dark text-truncate px-1" style="font-size: 12px;">{{ $transmission }}</strong>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Image Container + Badges -->
                        <div class="car-media-wrapper position-relative overflow-hidden bg-light" style="height: 210px; min-height: 210px; flex: 0 0 210px;">
                            <!-- Status Badge -->
                            <span class="badge-status text-uppercase">
                                {{ $condition }}
                            </span>

                            <!-- Image Carousel / Fallback -->
                            <div class="car__item__pic__slider owl-carousel preview-trigger h-100 w-100">
                                @if($ad->images && $ad->images->isNotEmpty())
                                    @foreach($ad->images->take(3) as $img)
                                        <div class="car-img-holder h-100 w-100">
                                            <img src="{{ Storage::disk('public')->exists($img->image_path) ? Storage::disk('public')->url($img->image_path) : asset('bgg.jfif') }}" 
                                                 alt="{{ $ad->title }}" 
                                                 loading="lazy" 
                                                 onerror="this.onerror=null;this.src='{{ asset('bgg.jfif') }}';"
                                                 style="object-fit: cover; height: 210px; width: 100%; display: block;">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-light text-muted">
                                        <i class="fa-solid fa-car" style="font-size: 2.5rem; color: #4B9FE1;" aria-hidden="true"></i>
                                        <span class="mt-1" style="font-size: 11px;">No Image Available</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Price Overlay -->
                            <div class="car-price-overlay">
                                @if(!empty($ad->old_price))
                                    <span class="text-decoration-line-through opacity-75 me-1" style="font-size: 11px;">{{ number_format($ad->old_price) }} DA</span>
                                @endif
                                <span>{{ number_format($ad->price) }} DA</span>
                            </div>
                        </div>
                        
                        <!-- 3. Card Details -->
                        <div class="car__item__text p-3 d-flex flex-column justify-content-between flex-grow-1">
                            <div>
                                <!-- Vehicle Category -->
                                <div class="text-uppercase font-weight-bold mb-1" style="color: #4B9FE1; font-size: 11px; letter-spacing: 0.5px;">
                                    {{ $categoryName }}
                                </div>

                                <!-- Listing Title -->
                                <h5 class="font-weight-bold mb-2 text-truncate" style="font-size: 1rem;">
                                    <a href="{{ route('ads.show', $ad->slug) }}" class="text-decoration-none text-dark card-title-link preview-trigger">
                                        {{ $ad->title }}
                                    </a>
                                </h5>
                            </div>

                            <!-- Bottom Specs -->
                            <div class="border-top pt-2 mt-auto">
                                <div class="row m-0 text-center">
                                    <div class="col-4 p-0">
                                        <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Year</span>
                                        <span class="font-weight-bold text-dark d-block text-truncate px-1" style="font-size: 12px;">{{ $year }}</span>
                                    </div>
                                    <div class="col-4 p-0 border-start border-end">
                                        <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Make</span>
                                        <span class="font-weight-bold text-dark d-block text-truncate px-1" style="font-size: 12px;">{{ $make }}</span>
                                    </div>
                                    <div class="col-4 p-0">
                                        <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Transmission</span>
                                        <span class="font-weight-bold text-dark d-block text-truncate px-1" style="font-size: 12px;">{{ $transmission }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hover/Touch Quick Preview Tooltip -->
                        <aside class="car-preview" aria-hidden="true" role="dialog" aria-label="Quick vehicle preview">
                            <div class="car-preview__loading">Loading preview...</div>
                            <div class="car-preview__content"></div>
                        </aside>

                    </article>
                </div>
            @empty
                <!-- Skeleton Loaders -->
                @for($i = 0; $i < 4; $i++)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="car__item skeleton-card bg-white p-0" aria-hidden="true">
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
        min-width: 0;
        border-radius: 8px;
        border: 1px solid #eef2f6;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        overflow: visible;
    }
    
    .car__item:hover {
        transform: translateY(-6px);
        border-color: #4B9FE1 !important;
        box-shadow: 0 12px 25px rgba(29, 51, 84, 0.12);
        z-index: 20;
    }

    .car-media-wrapper {
        position: relative;
        z-index: 1;
        width: 100%;
        overflow: hidden;
        flex: 0 0 210px;
    }

    .car__item__pic__slider,
    .car__item__pic__slider .owl-stage-outer,
    .car__item__pic__slider .owl-stage,
    .car__item__pic__slider .owl-item,
    .car-img-holder {
        height: 210px !important;
        min-height: 210px;
    }

    .car__item__pic__slider img {
        display: block;
        width: 100%;
        height: 210px;
        object-fit: cover;
    }

    .badge-status {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 15;
        background-color: #e53e3e;
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        padding: 4px 8px;
        border-radius: 4px;
        letter-spacing: 0.5px;
        pointer-events: none;
    }

    .car-price-overlay {
        position: absolute;
        bottom: 0;
        right: 0;
        z-index: 15;
        background: #4B9FE1;
        color: #ffffff;
        font-weight: 800;
        font-size: 0.9rem;
        padding: 5px 12px;
        border-top-left-radius: 6px;
        pointer-events: none;
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

    .car__item__text,
    .car__item__text > div,
    .card-title-link {
        min-width: 0;
    }

    .card-title-link {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    @media (max-width: 991px) {
        .car-preview { 
            top: calc(100% + 10px); 
            right: 0; 
            left: 0; 
            width: 100%; 
            transform: translateY(-5px); 
        }
        .car__item.preview-open .car-preview { 
            transform: translateY(0); 
        }
    }

    .card-title-link {
        transition: color 0.2s ease;
    }

    .car__item:hover .card-title-link {
        color: #4B9FE1 !important;
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

    .skeleton-card {
        opacity: 0.6;
        animation: pulse 1.5s infinite ease-in-out;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }
</style>

<script src="{{ asset('js/car-preview.js') }}" defer></script>
</div>