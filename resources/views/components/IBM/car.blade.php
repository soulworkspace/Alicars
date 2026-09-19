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
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mix {{ $ad->purpose == 'sale' ? 'sale' : '' }}">
                    <div class="car__item position-relative bg-white shadow-sm overflow-hidden">
                        
                        <!-- 1. Top Header Specs -->
                        <div class="car__item__top__specs border-bottom bg-light py-2 px-1">
                            <div class="row m-0 text-center">
                                <div class="col-4 p-0">
                                    <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Year</span>
                                    <strong class="d-block text-dark text-truncate" style="font-size: 12px;">{{ $ad->year ?? 'N/A' }}</strong>
                                </div>
                                <div class="col-4 p-0 border-start border-end">
                                    <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Make</span>
                                    <strong class="d-block text-dark text-truncate" style="font-size: 12px;">{{ $ad->brand->name ?? ($ad->make ?? 'Auto') }}</strong>
                                </div>
                                <div class="col-4 p-0">
                                    <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Transmission</span>
                                    <strong class="d-block text-dark text-truncate" style="font-size: 12px;">{{ $ad->transmission ?? 'Auto' }}</strong>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Image Slider + Status Badge & Price Overlay -->
                        <div class="position-relative">
                            <!-- Status Badge (NEW / USED) -->
                            <span class="badge-status text-uppercase">
                                {{ $ad->condition ?? ($ad->purpose == 'sale' ? 'Used' : 'New') }}
                            </span>

                            <div class="car__item__pic__slider owl-carousel">
                                @if($ad->images && $ad->images->isNotEmpty())
                                    @foreach($ad->images as $img)
                                        <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $ad->title }}" style="object-fit: cover; height: 210px; width: 100%;">
                                    @endforeach
                                @elseif($ad->primaryImage)
                                    <img src="{{ asset('storage/' . $ad->primaryImage->image_path) }}" alt="{{ $ad->title }}" style="object-fit: cover; height: 210px; width: 100%;">
                                @else
                                    <div class="w-100 d-flex align-items-center justify-content-center bg-light text-muted" style="height: 210px;">
                                        <i class="fa-solid fa-image" style="font-size: 3rem; color: #1D3354;"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Price Overlay -->
                            <div class="car-price-overlay">
                                @if($ad->old_price)
                                    <span class="text-decoration-line-through opacity-75 mr-1" style="font-size: 11px;">{{ number_format($ad->old_price) }} DA</span>
                                @endif
                                <span>{{ number_format($ad->price) }} DA</span>
                            </div>
                        </div>
                        
                        <!-- 3. Card Details -->
                        <div class="car__item__text p-3">
                            <!-- Vehicle Category -->
                            <div class="text-uppercase font-weight-bold mb-1" style="color: #4B9FE1; font-size: 11px; letter-spacing: 0.5px;">
                                {{ $ad->category->name ?? 'SEDAN' }}
                            </div>

                            <!-- Listing Title -->
                            <h5 class="font-weight-bold mb-3 text-truncate" style="font-size: 1rem;">
                                <a href="{{ route('ads.show', $ad->slug) }}" class="stretched-link text-decoration-none text-dark card-title-link">
                                    {{ $ad->title }}
                                </a>
                            </h5>

                            <!-- Bottom Specs -->
                            <div class="border-top pt-3 mt-2">
                                <div class="row m-0 text-center">
                                    <div class="col-4 p-0">
                                        <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Year</span>
                                        <span class="font-weight-bold text-dark d-block text-truncate" style="font-size: 12px;">{{ $ad->year ?? 'N/A' }}</span>
                                    </div>
                                    <div class="col-4 p-0 border-start border-end">
                                        <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Make</span>
                                        <span class="font-weight-bold text-dark d-block text-truncate" style="font-size: 12px;">{{ $ad->brand->name ?? ($ad->make ?? 'Auto') }}</span>
                                    </div>
                                    <div class="col-4 p-0">
                                        <span class="d-block text-muted text-uppercase" style="font-size: 10px;">Transmission</span>
                                        <span class="font-weight-bold text-dark d-block text-truncate" style="font-size: 12px;">{{ $ad->transmission ?? 'Auto' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
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
    }
    
    .car__item:hover {
        transform: translateY(-6px);
        border-color: #4B9FE1 !important;
        box-shadow: 0 12px 25px rgba(29, 51, 84, 0.12);
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