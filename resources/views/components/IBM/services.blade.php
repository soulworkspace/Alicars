<!-- Services Section Begin -->
<section class="services spad" id="services" dir="rtl">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <span>خدماتنا</span>
                    <h2>ماذا نقدم لك</h2>
                    <p>اكتشف خدماتنا الشاملة المصممة لشراء، بيع، واستبدال السيارات بكل سهولة وسلاسة.</p>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <!-- Service 1: شراء السيارات -->
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="services__item">
                    <img src="{{ asset('front/img/services/services-1.png') }}" alt="شراء السيارات" class="img-fluid">
                    <h5>شراء السيارات</h5>
                    <p>استكشف مجموعتنا الواسعة من السيارات المفحوصة والمضمونة والمجهزة للسوق المحلي.</p>
                    <a href="#"><i class="fa fa-long-arrow-left"></i></a>
                </div>
            </div>
            
            <!-- Service 2: بيع مبسط -->
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="services__item">
                    <img src="{{ asset('front/img/services/services-2.png') }}" alt="بيع مبسط" class="img-fluid">
                    <h5>بيع مبسط</h5>
                    <p>أضف إعلانك في خطوات بسيطة وتواصل مباشرة مع المشتريين المهتمين.</p>
                    <a href="#"><i class="fa fa-long-arrow-left"></i></a>
                </div>
            </div>
            
            <!-- Service 3: استبدال سريع -->
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="services__item">
                    <img src="{{ asset('front/img/services/services-3.png') }}" alt="استبدال سريع" class="img-fluid">
                    <h5>استبدال سريع</h5>
                    <p>استبدل سيارتك الحالية بمركبة جديدة من كتالوجنا بعد تقييم عادل ودقيق.</p>
                    <a href="#"><i class="fa fa-long-arrow-left"></i></a>
                </div>
            </div>
            
            <!-- Service 4: الذكاء الاصطناعي اختيار سيارتك (قيد التجربة) -->
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="services__item position-relative overflow-hidden border-primary-subtle">
                    <!-- Beta Badge -->
                    <span class="ai-beta-badge">قيد التجربة 🧪</span>
                    
                    <div class="ai-icon-wrapper mb-2">
                        <i class="fa-solid fa-robot text-primary" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5>المساعد الذكي للسيارات</h5>
                    <p>دع الذكاء الاصطناعي يساعدك في اختيار السيارة المثالية بناءً على ميزانيتك واحتياجاتك اليومية.</p>
                    <a href="#" class="ai-btn"><i class="fa fa-sparkles"></i> جرب الآن</a>
                </div>
            </div>

            <!-- Service 5: دعم 24/7 -->
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="services__item">
                    <img src="{{ asset('front/img/services/services-4.png') }}" alt="دعم 24/7" class="img-fluid">
                    <h5>دعم 24/7</h5>
                    <p>يقوم فريقنا بإرشادك في كل خطوة لضمان معاملة آمنة وشفافة تماماً.</p>
                    <a href="#"><i class="fa fa-long-arrow-left"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->

<style>
    /* RTL Direction overrides */
    .services[dir="rtl"] {
        text-align: right;
    }

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
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
    }

    .services__item:hover {
        border-color: #4B9FE1 !important;
        transform: translateY(-5px) !important;
        box-shadow: 0 10px 25px rgba(29, 51, 84, 0.08) !important;
    }

    /* 4. Typography Styles */
    .services .section-title span {
        color: #4B9FE1 !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
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

    /* 5. AI Service Badge Custom Styling */
    .ai-beta-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #fff3cd;
        color: #856404;
        font-size: 11px;
        font-weight: bold;
        padding: 4px 10px;
        border-radius: 20px;
        border: 1px solid #ffeeba;
    }

    .services__item a.ai-btn {
        width: auto !important;
        border-radius: 20px !important;
        padding: 0 18px !important;
        font-size: 13px;
        font-weight: 600;
        gap: 6px;
    }
</style>