<!DOCTYPE html>
<html lang="en" dir="ltr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="h_skX0O1xH_Nq7bcN-L4lQbNhFIIRoXNtIia-OyAqic" />
    <title>@yield('title', 'MB MOTORS | لبيع وشراء السيارات')</title>
    
    <!-- Google Fonts (Cairo & Lato) لدعم احترافي للغة العربية والإنجليزية -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">

    <!-- FontAwesome الأحدث لدعم الأيقونات البريميوم (مثل الدروع والسيارات) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Local Css Styles (Using Blade asset) -->
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}" type="text/css">

    <style>
        /* دمج خط Cairo للمحتوى العربي لضمان اتساق الواجهة */
        body, h1, h2, h3, h4, h5, h6, select, input, textarea, button {
            font-family: 'Cairo', 'Lato', sans-serif !important;
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

    <!-- Main Content Slot (يدعم Livewire والصفحات العادية المتوافقة مع الشاشات) -->
    <main style="min-height: calc(100vh - 200px);">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer Partial -->
    @include('layouts.partials.footer')

    <!-- Local Js Plugins (Using Blade asset) -->
    <script src="{{ asset('front/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('front/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('front/js/main.js') }}"></script>

    @livewireScripts
</body>
</html>