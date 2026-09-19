<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TRICO | منصة الأزياء العالمية')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Almarai', 'sans-serif'],
                        international: ['Montserrat', 'sans-serif'],
                    },
                    colors: {
                        emerald: {
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { 
            font-family: 'Almarai', sans-serif; 
            background-color: #0f1115; 
            color: #f3f4f6; 
        }
        .font-heavy { font-weight: 800; }
        .bg-gradient-subtle { 
            background: radial-gradient(circle at top right, #064e3b22 0%, #0f1115 40%); 
        }
        .heavy-title {
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: -1px;
        }
        .btn-premium {
            background-color: #10b981;
            color: #000;
            font-weight: 800;
            transition: all 0.3s ease;
            text-transform: uppercase;
            display: inline-block;
            text-align: center;
        }
        .btn-premium:hover {
            background-color: white;
            color: black;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
        }
        
        /* Skeleton Animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>

    @livewireStyles
</head>
<body class="antialiased min-h-screen bg-gradient-subtle text-white">
    
    @include('components.navbar')

    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    @include('components.footer')

    @livewireScripts
</body>
</html>