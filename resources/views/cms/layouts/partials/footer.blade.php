<style>
    .menu-link {
        position: relative;
        text-decoration: none;
        color: #333;
        font-size: 16px;
        font-weight: normal;
        line-height: 1;
        display: inline-block;
        box-sizing: border-box;
    }

    .menu-link::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -7px;
        width: 0;
        height: 1px;
        background: #000;
        transition: width 0.3s ease-in-out;
        box-sizing: border-box;
    }

    .menu-link:hover::after {
        width: 50%;
    }

    .shop-under {
        position: relative;
    }

    .we-under {
        position: relative;
    }

    .help-under {
        position: relative;
    }

    .cate-under {
        position: relative;
    }

    .shop-under:hover::after {
        width: 30%;
    }

    .we-under:hover::after {
        width: 30%;
    }

    .help-under:hover::after {
        width: 30%;
    }

    .cate-under:hover::after {
        width: 30%;
    }
</style>
@php
$categories = \App\Models\Category::with('products')
->orderBy('created_at', 'desc')
->take(5)
->get();
@endphp
<div class="main-footer">
    <div class="container">
        <div class="row gy-4">
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="footer-contact">
                    <div class="brand-logo">
                        <a href="index.htm" class="footer-logo float-start">
                            <img src="{{ asset('cms/assets/images/LiLi_logo.png') }}"
                                class="f-logo img-fluid blur-up lazyload" alt="logo">
                        </a>
                    </div>
                    <ul class="contact-lists" style="clear:both;">
                        <li>
                            <div>
                                <i class="fa-solid fa-phone-volume"></i>
                                <span style="margin-left: 5px;"><b>Điện thoại:</b> <span class="font-light">+84
                                        97326216</span></span>
                            </div>
                        </li>
                        <li>
                            <div>
                                <i class="fa-solid fa-location-dot"></i>
                                <span style="margin-left: 5px;"><b>Địa chỉ:</b><span class="font-light"> 149 Khương
                                        Thượng, Đống Đa, Hà Nội</span></span>
                            </div>
                        </li>
                        <li>
                            <div>
                                <i class="fa-solid fa-envelope"></i>
                                <span style="margin-left: 5px;"><b>Email:</b><span class="font-light">
                                        dangduylinh@gmail.com</span></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="footer-links">
                    <div class="footer-title">
                        <h3 style="font-weight: bold;" class="we-under">CHÚNG TÔI</h3>
                    </div>
                    <div class="footer-content">
                        <ul>
                            <li>
                                <a href="{{ route('home') }}" class=" menu-link">Trang chủ</a>
                            </li>
                            <li>
                                <a href="{{ route('shop') }}" class=" menu-link">Cửa hàng</a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}" class=" menu-link">Liên hệ</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                <div class="footer-links">
                    <div class="footer-title">
                        <h3 style="font-weight: bold;" class="cate-under">DANH MỤC MỚI</h3>
                    </div>
                    <div class="footer-content">

                        <ul>
                            @foreach ($categories as $category)
                            <li>
                                <form action="{{ route('shop') }}" id="form_cate" name="category" method="GET">
                                    <a href="javascript:void(0)"
                                        class="menu-link cate-click-1">{{ $category->name }}</a>
                                    <input type="hidden" id="category_{{ $category->id }}" name="category[]"
                                        value="{{ $category->slug }}"
                                        {{ is_array(request('category')) && in_array($category->slug, request('category')) ? 'checked' : '' }}>
                                </form>
                            </li>
                            @endforeach

                        </ul>

                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                <div class="footer-links">
                    <div class="footer-title">
                        <h3 style="font-weight: bold;" class="shop-under">CỬA HÀNG</h3>
                    </div>
                    <div class="footer-content">
                        <ul>
                            <li>
                                <a href="{{ route('shop') }}" class="menu-link">Sản phẩm mới</a>
                            </li>
                            <li>
                                <a href="{{ route('shop', ['gender[]' => 'female']) }}" class="menu-link">Trang sức
                                    nam</a>
                            </li>
                            <li>
                                <a href="{{ route('shop', ['gender[]' => 'male']) }}" class="menu-link">Trang sức
                                    nữ</a>
                            </li>
                            <li>
                                <a href="{{ route('shop', ['gender[]' => 'unisex']) }}" class="menu-link">Dành cho
                                    cặp đôi</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                <div class="footer-links">
                    <div class="footer-title">
                        <h3 style="font-weight: bold;" class="help-under">CẨM NANG SỬ DỤNG</h3>
                    </div>
                    <div class="footer-content">
                        <ul>
                            <li>
                                <a href="{{ route('shop.handbook.hb_2') }}" class="menu-link">Tại sao nên chọn bạc
                                    ?</a>
                            </li>
                            <li>
                                <a href="{{ route('shop.handbook.hb_4') }}" class="menu-link">Tác dụng của bạc</a>
                            </li>
                            <li>
                                <a href="{{ route('shop.handbook.hb_3') }}" class="menu-link">Cách làm trắng bạc
                                    tại nhà</a>
                            </li>
                            <li>
                                <a href="{{ route('shop.handbook.hb_1') }}" class="menu-link">Cách bảo quản trang
                                    sức bạc</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sub-footer">
    <div class="container">
        <div class="row gy-3">
            <div class="col-md-6">
                <ul>
                    <li class="font-dark">Chúng tôi chấp nhận:</li>
                    <li>
                        <a href="javascript:void(0)">
                            <img src="{{ asset('cms/assets/images/payment-icon/1.jpg') }}"
                                class="img-fluid blur-up lazyload" alt="payment icon">
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <img src="{{ asset('cms/assets/images/payment-icon/2.jpg') }}"
                                class="img-fluid blur-up lazyload" alt="payment icon">
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <img src="{{ asset('cms/assets/images/payment-icon/3.jpg') }}"
                                class="img-fluid blur-up lazyload" alt="payment icon">
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <p class="mb-0 font-dark">LiLi Jewelry 2025</p>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const clickableLinks = document.querySelectorAll('a.cate-click-1');

        clickableLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const form = this.closest('form');
                if (form) {
                    form.submit();
                }
            });
        });
    });
</script>