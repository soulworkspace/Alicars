<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
            <i class="bi bi-shop"></i> TRICO
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('ads.index') }}">تصفح الملابس</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                @auth
                    <a href="{{ route('cart.show') }}" class="btn btn-outline-light position-relative border-0 p-2">
                        <i class="bi bi-bag-heart fs-5"></i>
                        @php $cartCount = count(Session::get('trico_cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    @if(Auth::user()->role === 'vendor' || Auth::user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-info position-relative border-0 p-2">
                            <i class="bi bi-bell fs-5"></i>
                            @php 
                                $pendingOrders = \App\Models\Order::where('seller_id', Auth::id())
                                                ->where('status', 'pending')->count(); 
                            @endphp
                            @if($pendingOrders > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark" style="font-size: 0.6rem;">
                                    {{ $pendingOrders }}
                                </span>
                            @endif
                        </a>
                    @endif

                    <div class="dropdown">
                        <a class="btn btn-primary dropdown-toggle rounded-pill px-4" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> لوحة التحكم</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="bi bi-box-seam me-2"></i> طلباتي</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> تسجيل الخروج
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-link text-white text-decoration-none">دخول</a>
                    <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4">ابدأ البيع</a>
                @endauth
            </div>
        </div>
    </div>
</nav>