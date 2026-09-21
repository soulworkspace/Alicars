<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="h_skX0O1xH_Nq7bcN-L4lQbNhFIIRoXNtIia-OyAqic" />
    <title>@yield('title', 'MB MOTORS | لبيع وشراء السيارات')</title>
    
    <!-- Google Fonts (Cairo for Headings, Tajawal for Body, Montserrat for Latin/Numbers) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Montserrat:wght@400;600;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Local Css Styles -->
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}" type="text/css">

    <style>
        /* 1. تفعيل الانسيابية العامة للتمرير */
        html {
            scroll-behavior: smooth !important;
        }

        /* 2. الخط العام لجسم الصفحة للنصوص الطويلة والقوائم (Tajawal) */
        body {
            font-family: 'Tajawal', 'Montserrat', sans-serif !important;
            text-align: right;
        }

        /* 3. خط العناوين والأسعار والشعارات (Cairo) */
        h1, h2, h3, h4, h5, h6, .site-logo, .car__item__price, .price, .badge {
            font-family: 'Cairo', sans-serif !important;
            font-weight: 700;
        }

        /* 4. خط الإدخالات والأزرار والروابط */
        select, input, textarea, button, .btn, a {
            font-family: 'Tajawal', 'Montserrat', sans-serif !important;
        }

        /* 5. الأرقام والنصوص اللاتينية والـ Badges المكتوبة بالإنجليزية (Montserrat) */
        .en-text, [lang="en"], .vin-number {
            font-family: 'Montserrat', 'Cairo', sans-serif !important;
        }

        /* مسافة تعويضية للهيدر الثابت */
        [id] {
            scroll-margin-top: 90px;
        }

        /* تحسين الانتقالات */
        a, button, .btn, input, select {
            transition: all 0.3s ease-in-out;
        }
    </style>

    @livewireStyles
</head>
<body class="antialiased text-right">

    <!-- Preloader -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Navbar Partial -->
    @include('layouts.partials.navbar')

    <!-- Main Content Slot -->
    <main style="min-height: calc(100vh - 200px);">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer Partial -->
    @include('layouts.partials.footer')

    <!-- Local Js Plugins -->
    <script src="{{ asset('front/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('front/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('front/js/main.js') }}"></script>

    <!-- السكريبت المساعد للتمرير السلس -->
    <script>
        $(document).ready(function() {
            $('a[href*="#"]:not([href="#"])').click(function(e) {
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    if (target.length) {
                        e.preventDefault();
                        $('html, body').animate({
                            scrollTop: target.offset().top - 80
                        }, 800);
                    }
                }
            });
        });
    </script>

    @livewireScripts
</body>
</html>