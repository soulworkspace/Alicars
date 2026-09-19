<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    
    <title>@yield('title', 'لوحة التحكم') | TRICO</title>
    
    @yield('styles')
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@400;700;800&family=Montserrat:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --emerald-light: #10b981;
            --emerald-deep: #064e3b;
            --bg-dark: #0f1115;
            --card-bg: #1a1d23;
            --sidebar-bg: #16181d;
        }

        body {
            font-family: 'Almarai', sans-serif;
            background-color: var(--bg-dark);
            color: #f3f4f6;
            letter-spacing: -0.02em;
        }

        .font-heavy { font-weight: 800; }
        .font-international { font-family: 'Montserrat', sans-serif; }

        .sidebar {
            background-color: var(--sidebar-bg);
            border-left: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.25rem;
            color: rgba(255,255,255,0.6);
            font-weight: 600;
            transition: all 0.2s ease;
            border-radius: 0.5rem;
            margin: 0.25rem 0.75rem;
        }

        .sidebar-link:hover {
            background-color: rgba(255,255,255,0.05);
            color: #fff;
        }

        .sidebar-link.active {
            background-color: rgba(16, 185, 129, 0.15);
            color: #10b981;
        }

        .sidebar-link i {
            width: 1.5rem;
            text-align: center;
        }

        .btn-premium {
            background-color: var(--emerald-light);
            color: #000;
            font-weight: 800;
            transition: all 0.3s ease;
            border: 1px solid var(--emerald-light);
        }

        .btn-premium:hover {
            background-color: transparent;
            color: var(--emerald-light);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
        }

        .card {
            background-color: var(--card-bg);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 1rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            border-color: rgba(16, 185, 129, 0.2);
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.02) 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .form-input {
            background-color: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            border-color: var(--emerald-light);
            outline: none;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-emerald { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .badge-amber { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
        .badge-rose { background: rgba(244, 63, 94, 0.2); color: #f43f5e; }

        .dashboard-header {
            background: rgba(15, 17, 21, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .mobile-menu-btn {
            display: none;
        }

        @media (max-width: 1024px) {
            .sidebar {
                position: fixed;
                right: -280px;
                top: 0;
                bottom: 0;
                width: 280px;
                z-index: 50;
                transition: right 0.3s ease;
            }
            
            .sidebar.open {
                right: 0;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 40;
            }
            
            .overlay.show {
                display: block;
            }
        }

        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    
    @livewireStyles
</head>
<body class="min-h-screen bg-gradient-subtle">
    
    <!-- Mobile Overlay -->
    <div class="overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    
    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        <aside class="sidebar flex flex-col" id="sidebar">
            <div class="p-6 border-b border-white/5">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="font-international text-2xl font-black tracking-tighter text-white uppercase">TRI<span class="text-[#10b981]">CO</span></span>
                </a>
                <p class="text-xs text-gray-500 mt-2">لوحة التحكم</p>
            </div>
            
            <nav class="flex-1 py-4 overflow-y-auto scrollbar-hide">
                @include('dashboard.partials.sidebar')
            </nav>
            
            <div class="p-4 border-t border-white/5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full text-rose-400 hover:text-rose-300 hover:bg-rose-500/10">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>تسجيل الخروج</span>
                    </button>
                </form>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            
            <!-- Dashboard Header -->
            <header class="dashboard-header sticky top-0 z-30 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button class="mobile-menu-btn text-xl text-gray-400 hover:text-white" onclick="toggleSidebar()">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <h1 class="text-xl font-bold">@yield('page-title', 'لوحة التحكم')</h1>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        @livewire('notification-bell')
                        
                        <a href="{{ route('profile') }}" class="flex items-center gap-3 hover:bg-white/5 p-2 rounded-lg transition-colors">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-bold">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->role === 'vendor' ? 'بائع' : (auth()->user()->role === 'admin' ? 'مدير' : 'مستخدم') }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fa-solid fa-check-circle ml-2"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fa-solid fa-exclamation-circle ml-2"></i>
                        {{ session('error') }}
                    </div>
                @endif
                
                @if(session('warning'))
                    <div class="alert alert-warning">
                        <i class="fa-solid fa-triangle-exclamation ml-2"></i>
                        {{ session('warning') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }
    </script>
    
    @yield('scripts')
    @livewireScripts
</body>
</html>
