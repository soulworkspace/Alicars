<!-- Footer Section Begin -->
<footer class="footer-pro" dir="rtl">
    <div class="container overflow-hidden">
        
        <!-- TOP CALL-TO-ACTION BANNER -->
        <div class="footer-cta-card mb-4">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 text-center text-lg-start mb-3 mb-lg-0">
                    <span class="cta-badge"><i class="fa fa-car ms-1"></i> ضمان أفضل العروض</span>
                    <h2 class="cta-title">اشترِ، بيع أو استبدل سيارتك بكل سهولة</h2>
                    <p class="cta-desc">تقييم سريع وتواصل مباشر داخل الجزائر.</p>
                </div>
                <div class="col-lg-5 col-md-12">
                    <div class="cta-actions">
                        <a href="tel:0670897630" class="btn-cta-phone">
                            <i class="fa fa-phone ms-1"></i> اتصل 0670897630
                        </a>
                        <a href="https://wa.me/213670897630" target="_blank" class="btn-cta-wa">
                            <i class="fa-brands fa-whatsapp ms-1"></i> واتساب
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN FOOTER LINKS -->
        <div class="row g-4 pt-2 pb-3">
            <!-- BRAND & ABOUT -->
            <div class="col-lg-4 col-md-6 text-center text-md-start">
                <div class="footer-brand-block">
                    <a href="{{ url('/') }}" class="d-inline-block mb-2">
                        <img src="{{ asset('logo.png') }}" alt="Jmou3y Auto" class="footer-logo">
                    </a>
                    <p class="footer-about-text">
                        منصتك الموثوقة لشراء وبيع واستبدال السيارات في جميع أنحاء الجزائر.
                    </p>
                    <div class="social-pills justify-content-center justify-content-md-start my-3">
                        <a href="https://www.instagram.com/el_hadjaissa/" target="_blank" class="social-pill insta" aria-label="Instagram">
                            <i class="fa-brands fa-instagram"></i> إنستغرام
                        </a>
                        <a href="https://wa.me/213670897630" target="_blank" class="social-pill wa" aria-label="WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i> واتساب
                        </a>
                    </div>
                </div>
            </div>

            <!-- NAVIGATION & CATEGORIES -->
            <div class="col-6 col-lg-2">
                <h5 class="footer-heading">التنقل السريع</h5>
                <ul class="footer-menu">
                    <li><a href="{{ url('/') }}">الرئيسية</a></li>
                    <li><a href="{{ url('/#services') }}">الخدمات</a></li>
                    <li><a href="{{ url('/#Trusted') }}">من نحن</a></li>
                    <li><a href="{{ url('/ads') }}">السيارات</a></li>
                    <li><a href="https://wa.me/213670897630" target="_blank">تواصل معنا</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <h5 class="footer-heading">التصنيفات</h5>
                <ul class="footer-menu">
                    <li><a href="#">سيدان (Sedan)</a></li>
                    <li><a href="#">رباعية الدفع (SUV)</a></li>
                    <li><a href="#">تجاري (Commercial)</a></li>
                    <li><a href="#">هاتشباك (Hatchback)</a></li>
                </ul>
            </div>

            <!-- TOP BRANDS -->
            <div class="col-lg-4 col-md-12 mt-4 mt-lg-0">
                <h5 class="footer-heading text-center text-md-start">العلامات التجارية الشائعة</h5>
                <div class="row g-2">
                    <div class="col-6">
                        <ul class="footer-menu">
                            <li><a href="#">تويوتا (Toyota)</a></li>
                            <li><a href="#">هيونداي (Hyundai)</a></li>
                            <li><a href="#">بيجو (Peugeot)</a></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="footer-menu">
                            <li><a href="#">رونو (Renault)</a></li>
                            <li><a href="#">فولكسفاغن (Volkswagen)</a></li>
                            <li><a href="#">داتشيا (Dacia)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- COPYRIGHT BOTTOM -->
        <div class="footer-bottom">
<p class="m-0">&copy; {{ date('Y') }} <strong>جميع الحقوق محفوظة لـوكالة الحاج عيسى  الجزائر</strong></p>        </div>

    </div>
</footer>

<!-- SEARCH MODAL -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center position-relative">
        <div class="search-close-switch"><i class="fa fa-times"></i></div>
        <form class="search-model-form px-3">
            <input type="text" id="search-input" placeholder="ابحث عن سيارة باسم أو الماركة...">
        </form>
    </div>
</div>

<!-- OPTIMIZED MOBILE-FIRST CSS -->
<style>
    /* BASE FOOTER CONTAINER */
    .footer-pro {
        background: #0B132B !important;
        color: #94A3B8;
        padding-top: 30px;
        padding-bottom: 20px;
        font-family: inherit;
    }

    /* CTA CARD RESPONSIVE */
    .footer-cta-card {
        background: linear-gradient(135deg, #1D3354 0%, #111D32 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
    }

    .cta-badge {
        background: rgba(75, 159, 225, 0.15);
        color: #4B9FE1;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 8px;
    }

    .cta-title {
        color: #FFFFFF;
        font-size: 18px;
        font-weight: 800;
        margin: 0;
        line-height: 1.3;
    }

    .cta-desc {
        color: #94A3B8;
        font-size: 13px;
        margin-top: 4px;
        margin-bottom: 0;
    }

    .cta-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 10px;
    }

    .btn-cta-phone, .btn-cta-wa {
        flex: 1;
        padding: 10px 14px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        white-space: nowrap;
        transition: transform 0.2s;
    }

    .btn-cta-phone { background: #4B9FE1; color: #FFFFFF !important; }
    .btn-cta-wa { background: #25D366; color: #FFFFFF !important; }

    /* BRAND & LOGO */
    .footer-logo {
        max-width: 120px;
        height: auto;
    }

    .footer-about-text {
        font-size: 13px;
        line-height: 1.5;
        color: #8E9BAE;
        margin-bottom: 0;
    }

    /* SOCIAL PILLS */
    .social-pills {
        display: flex;
        gap: 8px;
    }

    .social-pill {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        color: #FFF !important;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .social-pill.insta { background: linear-gradient(45deg, #f09433, #dc2743, #bc1888); }
    .social-pill.wa { background: #25D366; }

    /* HEADINGS & LISTS */
    .footer-heading {
        color: #FFFFFF;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 12px;
        letter-spacing: 0.3px;
        text-align: right;
    }

    .footer-menu {
        list-style: none;
        padding: 0;
        margin: 0;
        text-align: right;
    }

    .footer-menu li {
        margin-bottom: 8px;
    }

    .footer-menu a {
        color: #8E9BAE !important;
        text-decoration: none !important;
        font-size: 13px;
        transition: color 0.2s ease;
    }

    .footer-menu a:hover {
        color: #4B9FE1 !important;
    }

    /* BOTTOM COPYRIGHT */
    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        padding-top: 15px;
        margin-top: 15px;
        text-align: center;
        font-size: 12px;
        color: #64748B;
    }

    /* SEARCH MODAL ADJUSTMENTS */
    .search-model-form input {
        background: transparent;
        border: none;
        border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        font-size: 18px;
        width: 100%;
        padding: 8px 0;
        outline: none;
        text-align: right;
    }
    
    .search-close-switch {
        position: absolute;
        width: 40px;
        height: 40px;
        background: #1D3354;
        color: #fff;
        text-align: center;
        line-height: 40px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 16px;
        top: 20px;
        left: 20px;
    }

    /* MEDIA QUERIES FOR DESKTOP (>= 992px) */
    @media (min-width: 992px) {
        .footer-pro { padding-top: 50px; }
        .footer-cta-card { padding: 28px; }
        .cta-title { font-size: 22px; }
        .cta-actions { justify-content: flex-start; margin-top: 0; }
        .btn-cta-phone, .btn-cta-wa { flex: initial; padding: 12px 22px; font-size: 14px; }
        .footer-logo { max-width: 140px; }
        .footer-heading { font-size: 15px; margin-bottom: 18px; }
        .footer-menu a { font-size: 14px; }
    }
</style>