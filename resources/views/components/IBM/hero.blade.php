<!-- Hero Section Begin -->
<section class="hero spad set-bg d-flex align-items-center" data-setbg="{{ asset('front/bg.png') }}" style="min-height: 100vh; padding: 80px 0; background-size: cover; background-position: center;">
    <div class="container">
        <div class="row align-items-center gy-5">
            
            <!-- Hero Text Content -->
            <div class="col-lg-7 col-12 text-center text-lg-left">
                <div class="hero__text" style="max-width: 100%;">
                    <div class="hero__text__title mb-4">
                        <span class="d-block mb-2" style="text-transform: uppercase; letter-spacing: 2px; font-weight: 700; color: #4B9FE1; font-size: calc(12px + 0.3vw);">
                            Welcome to MB Motors
                        </span>
                        <h1 class="mb-0" style="font-weight: 900; text-transform: uppercase; font-size: calc(28px + 1.5vw); line-height: 1.2; color: #fff;">
                            Find Your Next Vehicle
                        </h1>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3 mt-4" style="gap: 15px;">
                        <a href="#showroom" class="primary-btn m-0 w-100 w-sm-auto text-center" style="text-transform: uppercase; font-weight: 700; background: #1D3354; border-color: #1D3354; padding: 14px 30px; border-radius: 4px; color: #fff;">
                            View Offers
                        </a>
                        <a href="#" class="primary-btn more-btn m-0 w-100 w-sm-auto text-center" style="text-transform: uppercase; font-weight: 700; padding: 14px 30px; border-radius: 4px; background: transparent; border: 2px solid #c2c2c2; color: #c2c2c2;">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Inline CSS for Responsive Tab Behavior & Brand Colors -->
<style>
    @media (max-width: 576px) {
        .hero {
            padding: 40px 0 !important;
        }
        .hero__tab {
            padding: 15px !important;
        }
        .nav-tabs .nav-link {
            padding: 10px 2px !important;
        }
    }
    
    .hero__tab .nav-tabs .nav-item .nav-link.active {
        color: #4B9FE1 !important;
        border-bottom-color: #4B9FE1 !important;
        background: transparent !important;
    }
    
    .hero__tab .nav-tabs .nav-item .nav-link {
        color: #c2c2c2;
        background: transparent;
    }
</style>
<!-- Hero Section End -->