<header class="header">
    <!-- Optimized top bar (Responsive & Pro) -->
    <div class="header__top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7 col-12 text-center text-md-left mb-2 mb-md-0">
                    <ul class="header__top__widget m-0 p-0 d-inline-flex align-items-center flex-wrap justify-content-center justify-content-md-start">
                        <li style="font-family: 'Montserrat', sans-serif; font-weight: 500; font-size: 13px; line-height: 1.2;">
                            <i class="fa fa-tags" style="color: #4B9FE1; margin-right: 5px;"></i> 
                            Buy and sell used vehicles - Algeria
                        </li>
                    </ul>
                </div>
                <div class="col-md-5 col-12">
                    <div class="header__top__right d-flex flex-column flex-sm-row align-items-center justify-content-center justify-content-md-end gap-2">
                        <div class="header__top__phone my-1 my-sm-0" style="font-size: 13px;">
                            <i class="fa fa-phone" style="color: #4B9FE1; margin-right: 3px;"></i>
                            <span>
                                <a href="tel:0670897630" style="color: inherit; text-decoration: none; font-weight: 600;">0670897630</a>
                            </span>
                        </div>
                        <div class="header__top__social ml-0 ml-sm-3 d-flex gap-3">
                            <a href="https://www.instagram.com/el_hadjaissa/" target="_blank" class="text-white"><i class="fa fa-instagram"></i></a>
                            <a href="https://wa.me/213670897630" target="_blank" class="text-white"><i class="fa fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header Zone -->
    <div class="container">
        <div class="d-flex align-items-center justify-content-between position-relative py-2 py-lg-0">
            
            <!-- AUTO-RESPONSIVE LOGO (ENLARGED) -->
            <div class="header__logo" style="flex-shrink: 0; max-width: 170px; display: flex; align-items: center;">
                <a href="{{ url('/') }}" class="d-block w-100" style="text-decoration: none;" aria-label="Jmou3y Auto Home">
                    <img src="{{ asset('logo.png') }}" alt="Jmou3y Auto Algeria" style="width: 100%; height: auto; display: block; object-fit: contain;">
                </a>
            </div>

            <!-- MENU AND ACTION BUTTONS -->
            <div class="header__nav_container d-none d-lg-flex align-items-center justify-content-end" style="flex-grow: 1;">
                <div class="header__nav">
                    <nav class="header__menu">
                        <ul class="m-0 p-0">
                            <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
                            <li class="{{ Request::is('services*') ? 'active' : '' }}"><a href="{{ url('/#services') }}">Services</a></li>
                            <li><a href="{{ url('/#Trusted') }}">A Trusted</a></li>
                            <li class="{{ Request::is('cars*') ? 'active' : '' }}"><a href="ads">Cars</a></li>
                            <li><a href="https://wa.me/213670897630" target="_blank">Contact</a></li>
                        </ul>
                    </nav>
                    
                    <div class="header__nav__widget d-inline-flex align-items-center align-middle">
                        <div class="header__nav__widget__btn mr-3">
                            <a href="#" class="search-switch"><i class="fa fa-search"></i></a>
                        </div>
                        <a href="https://wa.me/213670897630" target="_blank" class="primary-btn" style="background: #1D3354; border-color: #1D3354; font-weight: 700; text-transform: uppercase; white-space: nowrap; padding: 10px 20px; font-size: 13px; color: #fff; border-radius: 4px;">
                            WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <!-- PRO & ENLARGED MOBILE MENU TRIGGER (SAME LINE AS LOGO) -->
            <div class="canvas__open d-flex d-lg-none align-items-center justify-content-center m-0 p-0" 
                 style="cursor: pointer; width: 44px; height: 44px; border-radius: 8px; background: #f8f9fa; border: 1px solid #eaeeed; transition: all 0.3s ease;">
                <span class="fa fa-bars" style="font-size: 24px; color: #1D3354;"></span>
            </div>

        </div>
    </div>
</header>

<!-- Custom styles for active states and hover effects -->
<style>
    /* Responsive Logo Sizing */
    @media (max-width: 767px) {
        .header__logo {
            max-width: 140px !important;
        }
    }

    /* Active menu item color */
    .header__menu ul li.active > a {
        color: #1D3354 !important;
    }
    
    /* Underline below active menu item */
    .header__menu ul li.active > a:after {
        background: #1D3354 !important;
    }

    /* Hover effect in sky blue */
    .header__menu ul li:hover > a {
        color: #4B9FE1 !important;
    }

    /* Search icon hover color */
    .header__nav__widget__btn a:hover {
        color: #4B9FE1 !important;
    }

    /* Mobile toggle icon hover effect */
    .canvas__open:hover {
        background: #1D3354 !important;
        border-color: #1D3354 !important;
    }
    .canvas__open:hover .fa-bars {
        color: #ffffff !important;
    }
</style>