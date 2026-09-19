<section class="feature spad">
    <div class="container">
        <div class="row gy-5 align-items-center">
            
            <div class="col-lg-4 col-md-12 col-12">
                <div class="feature__text">
                    <div class="section-title">
                        <span>Our Strengths</span>
                        <h2>A Trusted Name In Automotive</h2>
                    </div>
                    <div class="feature__text__desc">
                        <p>At MB Motors, we are committed to complete transparency for every vehicle purchase, sale, or trade-in transaction.</p>
                        <p>Every vehicle in our inventory undergoes a rigorous inspection of its key components to ensure your safety and peace of mind on the road.</p>
                    </div>
                    <div class="feature__text__btn">
                        <a href="#" class="primary-btn">About Us</a>
                        <a href="#" class="primary-btn partner-btn">Our Partners</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 offset-lg-4 col-md-12 col-12">
                <div class="row g-3">
                    
                    <div class="col-lg-6 col-md-4 col-6">
                        <div class="feature__item">
                            <div class="feature__item__icon">
                                <img src="{{ asset('front/img/feature/feature-1.png') }}" alt="Engine" class="img-fluid">
                            </div>
                            <h6>Engine</h6>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-4 col-6">
                        <div class="feature__item">
                            <div class="feature__item__icon">
                                <img src="{{ asset('front/img/feature/feature-2.png') }}" alt="Turbo" class="img-fluid">
                            </div>
                            <h6>Turbocharger</h6>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-4 col-6">
                        <div class="feature__item">
                            <div class="feature__item__icon">
                                <img src="{{ asset('front/img/feature/feature-3.png') }}" alt="Cooling System" class="img-fluid">
                            </div>
                            <h6>Cooling System</h6>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-4 col-6">
                        <div class="feature__item">
                            <div class="feature__item__icon">
                                <img src="{{ asset('front/img/feature/feature-4.png') }}" alt="Suspension" class="img-fluid">
                            </div>
                            <h6>Suspension</h6>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-4 col-6">
                        <div class="feature__item">
                            <div class="feature__item__icon">
                                <img src="{{ asset('front/img/feature/feature-5.png') }}" alt="Electrical System" class="img-fluid">
                            </div>
                            <h6>Electrical System</h6>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-4 col-6">
                        <div class="feature__item">
                            <div class="feature__item__icon">
                                <img src="{{ asset('front/img/feature/feature-6.png') }}" alt="Brakes" class="img-fluid">
                            </div>
                            <h6>Brakes</h6>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Custom CSS for Brand Colors -->
<style>
    /* Subtitle in primary brand color */
    .feature .section-title span {
        color: #4B9FE1 !important;
    }

    /* Primary CTA Button */
    .feature__text__btn .primary-btn:not(.partner-btn) {
        background: #4B9FE1 !important;
        border-color: #4B9FE1 !important;
        color: #ffffff !important;
        transition: all 0.3s ease !important;
    }

    .feature__text__btn .primary-btn:not(.partner-btn):hover {
        background: #3b82f6 !important;
        border-color: #3b82f6 !important;
    }

    /* Secondary Partner Button */
    .feature__text__btn .partner-btn {
        background: transparent !important;
        border: 2px solid #cbd5e1 !important;
        color: #1D3354 !important;
        transition: all 0.3s ease !important;
    }

    .feature__text__btn .partner-btn:hover {
        border-color: #4B9FE1 !important;
        color: #4B9FE1 !important;
    }

    /* Feature Item Hover Effects */
    .feature__item {
        transition: all 0.3s ease !important;
    }

    .feature__item:hover {
        border-color: #4B9FE1 !important;
        background: #f8fafc !important;
    }
    
    .feature__item:hover h6 {
        color: #4B9FE1 !important;
    }
</style>