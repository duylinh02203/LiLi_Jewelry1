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
                                <ul class="nav-menu">
                                    <li class="back-btn d-xl-none">
                                        <div class="close-btn">
                                            Menu
                                            <span class="mobile-back"><i class="fa fa-angle-left"></i>
                                            </span>
                                        </div>
                                    </li>
                                    <li><a href="{{ route('home') }}" class="nav-link menu-title">Trang chủ</a></li>
                                    <li><a href="{{ route('shop') }}" class="nav-link menu-title">Shop</a></li>
                                    <li><a href="{{ route('cart') }}" class="nav-link menu-title">Giỏ hàng</a></li>
                                    <li><a href="{{ route('about') }}" class="nav-link menu-title">Chúng tôi</a></li>
                                    <li><a href="{{ route('contact') }}" class="nav-link menu-title">Liên hệ</a>
                                    </li>
                                    <li><a href="blog.html" class="nav-link menu-title">Bảng tin</a></li>
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
                                    <a href="wishlist/list.html">
                                        <i data-feather="heart"></i>
                                        <span id="wishlist-count" class="label label-theme rounded-pill">
                                            0
                                        </span>
                                    </a>
                                </div>
                            </li>
                            <li class="onhover-dropdown wislist-dropdown">
                                <div class="cart-media">
                                    <a href="cart/list.html">
                                        <i data-feather="shopping-cart"></i>
                                        <span id="cart-count" class="label label-theme rounded-pill">
                                            0
                                        </span>
                                    </a>
                                </div>
                            </li>
                            <li class="onhover-dropdown">
                                <div class="cart-media name-usr " style="background-color:#bd1125;">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div class="onhover-div profile-dropdown">
                                    <ul>
                                        @if (session()->has('userData'))
                                            <li>
                                                <a href="{{ route('information') }}" class="d-block">Thông tin</a>
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
                            <div class="input-group" style="border-radius:10px;">
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
