<header class="header">
    <!-- Barre supérieure optimisée (Responsive & Pro) -->
    <div class="header__top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7 col-12 text-center text-md-left mb-2 mb-md-0">
                    <ul class="header__top__widget m-0 p-0 d-inline-flex align-items-center flex-wrap justify-content-center justify-content-md-start">
                        <li style="font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 13px; line-height: 1.2;">
                            <!-- تعديل لون الأيقونة إلى الأزرق السماوي #4B9FE1 -->
                            <i class="fa fa-tags" style="color: #4B9FE1; margin-right: 5px;"></i> 
                            Achat, vente et échange de véhicules d'occasion
                        </li>
                    </ul>
                </div>
                <div class="col-md-5 col-12">
                    <div class="header__top__right d-flex flex-column flex-sm-row align-items-center justify-content-center justify-content-md-end gap-2">
                        <div class="header__top__phone my-1 my-sm-0" style="font-size: 13px;">
                            <!-- تعديل لون أيقونة الهاتف إلى الأزرق السماوي #4B9FE1 -->
                            <i class="fa fa-phone" style="color: #4B9FE1; margin-right: 3px;"></i>
                            <span>
                                <a href="tel:0659719027" style="color: inherit; text-decoration: none; font-weight: 600;">0659719027</a> | 
                                <a href="tel:0795632144" style="color: inherit; text-decoration: none; font-weight: 600;">0795632144</a>
                            </span>
                        </div>
                        <div class="header__top__social ml-0 ml-sm-3 d-flex gap-3">
                            <a href="#" class="text-white"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="text-white"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="text-white"><i class="fa fa-google"></i></a>
                            <a href="#" class="text-white"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Zone principale du Header -->
    <div class="container">
        <div class="d-flex align-items-center justify-content-between position-relative py-3 py-lg-0">
            
            <!-- LOGO AUTO-RESPONSIF -->
            <div class="header__logo" style="flex-shrink: 0; max-width: 130px;">
                <a href="{{ url('/') }}" class="d-block" style="text-decoration: none;" aria-label="MB Motors Accueil">
                    <img src="{{ asset('logo.png') }}" alt="MB Motors Premium Selection" style="width: 100%; height: auto; display: block;">
                </a>
            </div>

            <!-- MENU ET BOUTONS D'ACTION -->
            <div class="header__nav_container d-flex align-items-center justify-content-end" style="flex-grow: 1;">
                <div class="header__nav">
                    <nav class="header__menu">
                        <ul class="m-0 p-0">
                            <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Accueil</a></li>
                            <li class="{{ Request::is('cars*') ? 'active' : '' }}"><a href="#">Voitures</a></li>
                            <li class="{{ Request::is('blog*') ? 'active' : '' }}"><a href="#">Blog</a></li>
                            <li><a href="#">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="#">À Propos</a></li>
                                    <li><a href="#">Détails Véhicule</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </nav>
                    
                    <div class="header__nav__widget d-inline-flex align-items-center align-middle">
                        <div class="header__nav__widget__btn mr-3">
                            <a href="#" class="search-switch"><i class="fa fa-search"></i></a>
                        </div>
                        <!-- تعديل زر الدخول بالخلفية الأزرق الكحلي #1D3354 -->
                        <a href="/login" class="primary-btn" style="background: #1D3354; border-color: #1D3354; font-weight: 700; text-transform: uppercase; white-space: nowrap; padding: 10px 20px; font-size: 13px; color: #fff;">
                            Login
                        </a>
                    </div>
                </div>
            </div>

            <!-- FIX APPORTÉ ICI : Visible SEULEMENT sur mobile/tablette (d-block d-lg-none) -->
            <div class="canvas__open d-block d-lg-none m-0 p-0" style="cursor: pointer; margin-left: 15px !important;">
                <span class="fa fa-bars" style="font-size: 22px; color: #111;"></span>
            </div>

        </div>
    </div>
</header>

<!-- تنسيقات إضافية مدمجة للتحكم في ألوان القوائم النشطة والتأثيرات وفق الهوية الجديدة -->
<style>
    /* لون العناصر النشطة في القائمة الرئيسية */
    .header__menu ul li.active > a {
        color: #1D3354 !important;
    }
    
    /* الخط السفلي تحت القائمة النشطة */
    .header__menu ul li.active > a:after {
        background: #1D3354 !important;
    }

    /* تأثير الـ Hover على الروابط باللون الأزرق السماوي */
    .header__menu ul li:hover > a {
        color: #4B9FE1 !important;
    }

    /* لون أيقونة البحث عند التمرير */
    .header__nav__widget__btn a:hover {
        color: #4B9FE1 !important;
    }
</style>