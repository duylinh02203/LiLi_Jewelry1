<style>
    .nav-link {
        font-size: 1rem;
    }

    .nav-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-menu .menu {
        position: relative;
        text-decoration: none;
        color: #333;
        font-size: 16px;
        display: inline-block;
        padding: 5px 10px;
        transition: color 0.3s ease-in-out;
    }

    .nav-menu .menu::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -10px;
        width: 0;
        height: 1.5px;
        background-color: #000;
        transition: width 0.3s ease-in-out;
    }


    .nav-menu .menu:hover::after {
        width: 50%;
    }
</style>
<div class="main-header navbar-searchbar">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-menu">
                    <div class="menu-left">
                        <div class="brand-logo">
                            <a href="{{ route('home') }}" class="logo">
                                <img src="{{ asset('cms/assets/images/LiLi_logo.png') }}"
                                    class="h-logo img-fluid blur-up lazyload" alt="logo">
                            </a>
                        </div>

                    </div>
                    <nav>
                        <div class="main-navbar">
                            <div id="mainnav">
                                <div class="toggle-nav">
                                    <i class="fa fa-bars sidebar-bar"></i>
                                </div>
                                <ul class="nav-menu" style="border-radius: 10px 0px 0px 10px;">
                                    <li class="back-btn d-xl-none">
                                        <div class="close-btn">
                                            Menu
                                            <span class="mobile-back"><i class="fa fa-angle-left"></i>
                                            </span>
                                        </div>
                                    </li>
                                    <li><a href="{{ route('home') }}" class="nav-link menu">Trang chủ</a></li>
                                    <li><a href="{{ route('shop') }}" class="nav-link menu">Cửa hàng</a></li>
                                    <li><a href="{{ route('contact') }}" class="nav-link menu">Liên hệ</a>
                                    </li>
                                    <li><a href="blog.html" class="nav-link menu">Bảng tin</a></li>
                                 
                                    <li><a href="{{ route('allOrders') }}" class="nav-link menu">Đơn hàng đã đặt</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <div class="menu-right">
                        <ul>
                            <li style="display:flex;align-items:center;">
                                <div class="search-box theme-bg-color"
                                    style="width:42px;height: 42px; background-color:#bd1125;">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                            </li>
                            <li class="onhover-dropdown wislist-dropdown">
                                <div class="cart-media">
                                    @if (session()->has('userData'))
                                        <a href="{{ route('wishlist') }}">
                                            <i data-feather="heart"></i>
                                            @if (session()->has('userData'))
                                                @php
                                                    $wishlistCount = \App\Models\Wishlist::where(
                                                        'user_id',
                                                        session('userData')['id'],
                                                    )->count();
                                                @endphp
                                            @endif
                                            <span id="header-wishlist-count" class="label label-theme rounded-pill">
                                                {{ $wishlistCount }}
                                            </span>
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}">
                                            <i data-feather="heart"></i>
                                            <span id="header-wishlist-count" class="label label-theme rounded-pill">
                                                0
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            </li>
                            <li class="onhover-dropdown wislist-dropdown">
                                <div class="cart-media">
                                    @if (session()->has('userData'))
                                        <a href="{{ route('cart') }}">
                                            <i data-feather="shopping-cart"></i>
                                            @php
                                                $cart = \App\Models\Cart::where(
                                                    'user_id',
                                                    session('userData')['id'],
                                                )->first();
                                                $cartCount = 0;
                                                if ($cart) {
                                                    $cartCount = \App\Models\CartItem::where('cart_id', $cart->id)->sum(
                                                        'quantity',
                                                    );
                                                }
                                            @endphp
                                            <span id="cart-count" class="label label-theme rounded-pill">
                                                {{ $cartCount }}
                                            </span>
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}">
                                            <i data-feather="shopping-cart"></i>
                                            <span id="cart-count" class="label label-theme rounded-pill">
                                                0
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            </li>

                            <li class="onhover-dropdown">
                                <div class="cart-media name-usr " style="background-color:#bd1125;">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div class="onhover-div profile-dropdown" style="border-radius: 10px;">
                                    <ul>
                                        @if (session()->has('userData'))
                                            <li>
                                                <a href="{{ route('information') }}" class="d-block">Thông Tin</a>
                                            </li>
                                            <li>
                                                <form action="{{ route('logout') }}" method="POST">
                                                    @csrf
                                                    <a href="" class="d-block"><button
                                                            style="border: none; background-color: transparent; padding: 0; margin: 0">
                                                            Đăng Xuất
                                                        </button></a>
                                                </form>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ route('login') }}" class="d-block">Đăng nhập</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('register') }}" class="d-block">Đăng ký</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="search-full">
                        <form method="GET" class="search-full" action="{{ route('shop') }}">
                            <div class="input-group" style="border-radius:10px; border: 1px solid #333;">
                                <span class="input-group-text">
                                    <i data-feather="search" class="font-light"></i>
                                </span>
                                <input type="text" name="q" class="form-control search-type"
                                    placeholder="Tìm kiếm sản phẩm.." value="{{ request('search-product') }}">
                                <span class="input-group-text close-search">
                                    <i data-feather="x" class="font-light"></i>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
