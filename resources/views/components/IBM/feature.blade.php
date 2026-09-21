<!-- ================= قسم نقاط قوتنا (RTL) ================= -->
<section class="feature spad custom-trusted-section" id="Trusted" dir="rtl">
    <div class="container">
        <div class="row gy-5 align-items-center justify-content-between">
            
            <!-- النصوص والتعريف (جهة اليمين) -->
            <div class="col-lg-5 col-md-12 col-12">
                <div class="feature__text text-right">
                    <div class="section-title">
                        <span>نقاط قوتنا</span>
                        <h2>اسم نثق به في عالم السيارات</h2>
                    </div>
                    <div class="feature__text__desc">
<p>في وكالة حاج عيسى، نحن ملتزمون بالشفافية التامة في كل عملية شراء أو بيع أو استبدال للسيارات.</p>                        <p>تخضع كل سيارة في مخزوننا لفحص دقيق لأجزائها الرئيسية لضمان سلامتك وراحتك على الطريق.</p>
                    </div>
                    <div class="feature__text__btn d-flex flex-wrap gap-2 pt-2">
                        <a href="{{ url('/#Trusted') }}" class="primary-btn">من نحن</a>
                        <a href="https://wa.me/213670897630" target="_blank" class="primary-btn partner-btn">تواصل معنا</a>
                    </div>
                </div>
            </div>
            
            <!-- شبكة أجزاء الفحص (جهة اليسار) -->
            <div class="col-lg-6 col-md-12 col-12">
                <div class="row g-3">
                    
                    <div class="col-lg-4 col-md-4 col-6">
                        <div class="feature__item text-center">
                            <div class="feature__item__icon mb-2">
                                <img src="{{ asset('front/img/feature/feature-1.png') }}" alt="المحرك" class="img-fluid">
                            </div>
                            <h6>المحرك</h6>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-4 col-6">
                        <div class="feature__item text-center">
                            <div class="feature__item__icon mb-2">
                                <img src="{{ asset('front/img/feature/feature-2.png') }}" alt="الشاحن التوربيني" class="img-fluid">
                            </div>
                            <h6>التوربو</h6>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-4 col-6">
                        <div class="feature__item text-center">
                            <div class="feature__item__icon mb-2">
                                <img src="{{ asset('front/img/feature/feature-3.png') }}" alt="نظام التبريد" class="img-fluid">
                            </div>
                            <h6>نظام التبريد</h6>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-4 col-6">
                        <div class="feature__item text-center">
                            <div class="feature__item__icon mb-2">
                                <img src="{{ asset('front/img/feature/feature-4.png') }}" alt="نظام التعليق" class="img-fluid">
                            </div>
                            <h6>نظام التعليق</h6>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-4 col-6">
                        <div class="feature__item text-center">
                            <div class="feature__item__icon mb-2">
                                <img src="{{ asset('front/img/feature/feature-5.png') }}" alt="النظام الكهربائي" class="img-fluid">
                            </div>
                            <h6>النظام الكهربائي</h6>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-4 col-6">
                        <div class="feature__item text-center">
                            <div class="feature__item__icon mb-2">
                                <img src="{{ asset('front/img/feature/feature-6.png') }}" alt="الفرامل" class="img-fluid">
                            </div>
                            <h6>الفرامل</h6>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- ================= CSS الموحد والمعدل ================= -->
<style>
    /* 1. إلغاء أي خلفية أو عناصر متموضعة مسبقاً من القالب القديم */
    #Trusted,
    #Trusted .feature__text,
    #Trusted .row {
        background-image: none !important;
    }

    #Trusted::before,
    #Trusted::after,
    #Trusted .feature__text::before,
    #Trusted .feature__text::after {
        display: none !important;
        content: none !important;
    }

    /* 2. ضبط اتجاه ومحاذاة القسم */
    #Trusted[dir="rtl"] {
        text-align: right !important;
        direction: rtl !important;
        position: relative;
        z-index: 1;
    }

    /* 3. تنسيق العناوين وحمايتها من التداخل */
    #Trusted .section-title {
        position: relative !important;
        z-index: 10 !important;
        text-align: right !important;
        direction: rtl !important;
    }

    #Trusted .section-title span {
        color: #4B9FE1 !important;
        display: block !important;
        font-weight: 700 !important;
        font-size: 15px !important;
        margin-bottom: 8px !important;
        text-align: right !important;
        direction: rtl !important;
    }

    #Trusted .section-title h2 {
        color: #1D3354 !important;
        font-size: 28px !important;
        font-weight: 800 !important;
        line-height: 1.3 !important;
        margin-bottom: 15px !important;
        text-align: right !important;
        direction: rtl !important;
        position: relative !important;
        z-index: 10 !important;
    }

    #Trusted .feature__text__desc p {
        color: #666666;
        line-height: 1.7;
        margin-bottom: 12px;
    }

    /* 4. الأزرار الرئيسية والفرعية */
    #Trusted .feature__text__btn .primary-btn {
        display: inline-block;
        padding: 12px 28px;
        border-radius: 6px;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
    }

    #Trusted .feature__text__btn .primary-btn:not(.partner-btn) {
        background: #4B9FE1 !important;
        border: 2px solid #4B9FE1 !important;
        color: #ffffff !important;
        transition: all 0.3s ease !important;
    }

    #Trusted .feature__text__btn .primary-btn:not(.partner-btn):hover {
        background: #1D3354 !important;
        border-color: #1D3354 !important;
    }

    #Trusted .feature__text__btn .partner-btn {
        background: transparent !important;
        border: 2px solid #cbd5e1 !important;
        color: #1D3354 !important;
        transition: all 0.3s ease !important;
    }

    #Trusted .feature__text__btn .partner-btn:hover {
        border-color: #4B9FE1 !important;
        color: #4B9FE1 !important;
    }

    /* 5. بطاقات الميزات والأيقونات */
    #Trusted .feature__item {
        background: #ffffff;
        border: 1px solid #eaeeed;
        padding: 20px 10px;
        border-radius: 8px;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
    }

    #Trusted .feature__item h6 {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        color: #1D3354;
        transition: color 0.3s ease;
    }

    #Trusted .feature__item:hover {
        border-color: #4B9FE1 !important;
        background: #f8fafc !important;
        transform: translateY(-3px);
    }

    #Trusted .feature__item:hover h6 {
        color: #4B9FE1 !important;
    }
</style>