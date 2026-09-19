<!-- Services Section Begin -->
<section class="services spad" id="services">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Our Services</span>
                    <h2>What We Offer</h2>
                    <p>Discover our comprehensive services designed to make buying, selling, and trading vehicles effortless.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Service 1 -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="services__item">
                    <img src="{{ asset('front/img/services/services-1.png') }}" alt="Car Buying" class="img-fluid">
                    <h5>Car Buying</h5>
                    <p>Explore our wide range of inspected and certified vehicles ready for the local market.</p>
                    <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                </div>
            </div>
            
            <!-- Service 2 -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="services__item">
                    <img src="{{ asset('front/img/services/services-2.png') }}" alt="Car Selling" class="img-fluid">
                    <h5>Simplified Selling</h5>
                    <p>Post your listing in a few clicks and connect directly with serious buyers.</p>
                    <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                </div>
            </div>
            
            <!-- Service 3 -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="services__item">
                    <img src="{{ asset('front/img/services/services-3.png') }}" alt="Vehicle Trade-in" class="img-fluid">
                    <h5>Fast Trade-in</h5>
                    <p>Trade in your current car for a new model from our catalog with a fair valuation.</p>
                    <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                </div>
            </div>
            
            <!-- Service 4 -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="services__item">
                    <img src="{{ asset('front/img/services/services-4.png') }}" alt="24/7 Support" class="img-fluid">
                    <h5>24/7 Support</h5>
                    <p>Our team guides you through every step to ensure a secure and transparent transaction.</p>
                    <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->

<style>
    /* 1. Arrow and Icon Styling Override */
    .services__item a,
    .services__item a.active,
    .services__item.active a {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 42px !important;
        height: 42px !important;
        background: #f0f4f8 !important;
        color: #1D3354 !important;
        border-radius: 50% !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
    }

    /* 2. Hover Effect for Arrow and Card */
    .services__item:hover a {
        background: #4B9FE1 !important;
        color: #ffffff !important;
        box-shadow: 0px 4px 12px rgba(75, 159, 225, 0.35) !important;
    }

    /* 3. Card Base Styling & Border Color Override */
    .services__item {
        background: #ffffff !important;
        border: 1px solid #eef2f6 !important;
        border-radius: 8px !important;
        padding: 30px 20px !important;
        text-align: center !important;
        transition: all 0.3s ease !important;
    }

    .services__item:hover {
        border-color: #4B9FE1 !important;
        transform: translateY(-5px) !important;
        box-shadow: 0 10px 25px rgba(29, 51, 84, 0.08) !important;
    }

    .services__item:after,
    .services__item:before {
        background: #1D3354 !important;
    }

    /* 4. Typography Styles */
    .services .section-title span {
        color: #4B9FE1 !important;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .services__item h5 {
        color: #1D3354 !important;
        font-weight: 700 !important;
        margin-top: 18px !important;
        margin-bottom: 10px !important;
    }

    .services__item p {
        color: #6c757d !important;
        font-size: 14px !important;
        line-height: 1.6 !important;
    }
</style>