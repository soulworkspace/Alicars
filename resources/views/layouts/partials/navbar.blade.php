<!-- Offcanvas Menu Begin -->
<div class="offcanvas-menu-overlay"></div>
<div class="offcanvas-menu-wrapper">
    <!-- Close Button -->
    <div class="offcanvas__close">
        <i class="fa fa-times"></i>
    </div>

    <!-- Header Actions (Search & WhatsApp) -->
    <div class="offcanvas__widget d-flex align-items-center justify-content-between mb-4">
        <a href="#" class="search-switch search-btn-mobile">
            <i class="fa fa-search"></i>
        </a>
        <a href="https://wa.me/213670897630" target="_blank" class="primary-btn whatsapp-btn-mobile">
            <i class="fa-brands fa-whatsapp me-1"></i> WHATSAPP
        </a>
    </div>

    <!-- Brand Logo -->
    <div class="offcanvas__logo text-center my-3">
        <a href="{{ url('/') }}">
            <img src="{{ asset('logo.png') }}" alt="Jmou3y Auto Algeria" class="mobile-logo-img">
        </a>
    </div>

    <!-- Slicknav Navigation Menu Container -->
    <div id="mobile-menu-wrap"></div>

    <hr class="my-4 opacity-10">

    <!-- Contact Info Section (LTR Layout) -->
    <div class="offcanvas__info">
        <div class="info-item mb-2">
            <i class="fa fa-tags text-primary-sky"></i>
            <span>Buy and sell used vehicles</span>
        </div>
        <div class="info-item mb-2">
            <i class="fa fa-location-dot text-primary-sky"></i>
            <span>Algeria</span>
        </div>
        <div class="info-item phone-item mt-3">
            <i class="fa fa-phone text-primary-sky"></i>
            <a href="tel:0670897630" class="phone-link">0670897630</a>
        </div>
    </div>

    <!-- Social Links (Instagram & WhatsApp) -->
    <div class="offcanvas__social mt-4">
        <a href="https://www.instagram.com/el_hadjaissa/" target="_blank" class="social-icon insta" aria-label="Instagram">
            <i class="fa-brands fa-instagram"></i>
        </a>
        <a href="https://wa.me/213670897630" target="_blank" class="social-icon wa" aria-label="WhatsApp">
            <i class="fa-brands fa-whatsapp"></i>
        </a>
    </div>
</div>
<!-- Offcanvas Menu End -->



<style>
    /* ==========================================================
   Fix & Modern Light LTR Offcanvas Menu
   ========================================================== */

/* إلغاء تموضع اليسار القديم وتحديد التثبيت من اليسار */
@media only screen and (max-width: 767px) {
    .offcanvas-menu-wrapper.active {
        left: 0 !important;
        right: auto !important;
    }
}

.offcanvas-menu-wrapper {
    position: fixed;
    left: -320px !important; /* بداية الانزلاق من أقصى اليسار */
    right: auto !important;
    top: 0;
    width: 300px;
    height: 100%;
    background: #ffffff !important; /* خلفية بيضاء نصعة بدلاً من الداكنة */
    z-index: 999999;
    padding: 30px 20px;
    box-shadow: 5px 0 25px rgba(0, 0, 0, 0.12);
    overflow-y: auto;
    direction: ltr !important;
    text-align: left !important;
    /* انزلاق عالمي وسريع جداً */
    transition: left 0.22s cubic-bezier(0, 0, 0.2, 1) !important;
}

.offcanvas-menu-wrapper.active {
    left: 0 !important;
    right: auto !important;
}

/* زر الإغلاق X */
.offcanvas__close {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 18px;
    color: #1D3354;
    cursor: pointer;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* زر الواتساب والبحث */
.search-btn-mobile {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1D3354;
    border: 1px solid #e2e8f0;
}

.whatsapp-btn-mobile {
    background: #1D3354 !important;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 12px;
    padding: 10px 18px;
    border-radius: 6px;
    text-decoration: none !important;
}

/* عناصر القائمة Slicknav */
.slicknav_menu {
    background: transparent !important;
    padding: 0 !important;
}
.slicknav_nav {
    text-align: left !important;
}
.slicknav_nav a {
    font-size: 15px !important;
    font-weight: 600 !important;
    color: #1D3354 !important;
    padding: 12px 0 !important;
    border-bottom: 1px solid #f1f5f9;
    text-decoration: none !important;
}

/* معلومات التواصل LTR */
.info-item {
    font-size: 13px;
    color: #475569;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 8px;
}

.phone-link {
    font-weight: 700;
    color: #1D3354;
    font-size: 16px;
    text-decoration: none !important;
}

.offcanvas__social {
    display: flex;
    gap: 10px;
    justify-content: flex-start;
}

.social-icon {
    width: 38px;
    height: 38px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff !important;
    font-size: 18px;
    text-decoration: none !important;
}
.social-icon.insta { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
.social-icon.wa { background: #25D366; }

    </style>