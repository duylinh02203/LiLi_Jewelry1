<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta name="csrf-token" content="MkRqEzTGuoSx6LqJUm0OAKxSgNUYt26wTT7RMUZY"> -->
    <link rel="manifest" href="manifest.json">
    <link rel="apple-touch-icon" href="assets/images/favicon.ico')}}">
    <!-- <link rel="icon" href="{{asset('cms/assets/images/favicon.ico')}}" type="image/x-icon" >
    <link rel="icon" href="{{asset('cms/assets/images/favicon.ico')}}" type="image/x-icon" > -->
    <meta name="theme-color" content="#e87316">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Surfside Media">
    <meta name="msapplication-TileImage" content="{{asset('cms/assets/images/favicon.ico')}}">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Surfside Media">
    <meta name="keywords" content="Surfside Media">
    <meta name="author" content="Surfside Media">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');
    </style>

    <title>LiLi</title>

    <link id="rtl-link" rel="stylesheet" type="text/css" href="{{asset('cms/assets/css/vendors/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('cms/assets/css/vendors/ion.rangeSlider.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/assets/css/vendors/font-awesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/assets/css/vendors/feather-icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/assets/css/vendors/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/assets/css/vendors/slick/slick.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('cms/assets/css/vendors/slick/slick-theme.css')}}">
    <link id="color-link" rel="stylesheet" type="text/css" href="{{asset('cms/assets/css/demo4.css')}}">
    <link rel="stylesheet" href="{{asset('cms/assets/css/custom.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('cms/assets/css/custom1.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/footer.css')}}">
    @stack('styles')
</head>

<body class="theme-color4 light ltr">
    <header class="header-style-2 fixed-header" id="home">
        @include('cms.layouts.partials.header')
    </header>

    <div class="mobile-menu d-sm-none">
        <ul>
            <li>
                <a href="{{route('home')}}" class="active">
                    <i data-feather="home"></i>
                    <span>Trang chủ</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)">
                    <i data-feather="align-justify"></i>
                    <span>Danh mục</span>
                </a>
            </li>
            <li>
                <a href="{{route('cart')}}">
                    <i data-feather="shopping-bag"></i>
                    <span>Giỏ hàng</span>
                </a>
            </li>
            <li>
                <a href="{{route('wishlist')}}">
                    <i data-feather="heart"></i>
                    <span>Yêu thích</span>
                </a>
            </li>
            <li>
                <a href="user-dashboard.php">
                    <i data-feather="user"></i>
                    <span>Tài khoản</span>
                </a>
            </li>
        </ul>
    </div>
    @yield('content')
    <section class="icon-box-section">
        <div class="icon-box">
            <div class="icon-feat">
                <img src="{{asset('images/Smile-icon1.png')}}" alt="">
            </div>
            <h3>KHÁCH HÀNG HÀI LÒNG</h3>
            <p>Đặt sự hài lòng của khách hàng là ưu tiên số 1 trong mọi suy nghĩ hành động</p>
        </div>
        <div class="icon-box">
            <div class="icon-feat">
                <img src="{{asset('images/945447.png')}}" alt="Medal Icon">
            </div>
            <h3>CHẤT LƯỢNG CAO CẤP</h3>
            <p>Mọi sản phẩm đều được thiết kế và chế tác bởi các nghệ nhân hàng đầu</p>
        </div>
        <div class="icon-box">
            <div class="icon-feat">
                <img src="{{asset('images/return-icon.png')}}" alt="Return Icon">
            </div>
            <h3>ĐỔI TRẢ DỄ DÀNG</h3>
            <p>10 ngày đổi trả (LiLi đến tận nơi nhận hàng). Hoàn tiền nếu không hài lòng</p>
        </div>
        <div class="icon-box">
            <div class="icon-feat">
                <img src="{{asset('images/support.png')}}" alt="Support Icon">
            </div>
            <h3>HỖ TRỢ NHIỆT TÌNH</h3>
            <p>Tất cả câu hỏi đều được các chuyên viên của LiLi tư vấn, giải đáp kỹ càng</p>
        </div>
    </section>
    <footer class="footer-sm-space mt-5">
        @include('cms.layouts.partials.footer')
    </footer>
    <div class="modal fade newletter-modal" id="newsletter">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <img src="{{asset('cms/assets/images/newletter-icon.png')}}" class="img-fluid blur-up lazyload" alt="">
                    <div class="modal-title">
                        <h2 class="tt-title">Sign up for our Newsletter!</h2>
                        <p class="font-light">Never miss any new updates or products we reveal, stay up to date.</p>
                        <p class="font-light">Oh, and it's free!</p>
                        <div class="input-group mb-3">
                            <input placeholder="Email" class="form-control" type="text">
                        </div>
                        <div class="cancel-button text-center">
                            <button class="btn default-theme w-100" data-bs-dismiss="modal"
                                type="button">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade cart-modal" id="addtocart" tabindex="-1" role="dialog" aria-label="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="modal-contain">
                        <div>
                            <div class="modal-messages">
                                <i class="fas fa-check"></i> 3-stripes full-zip hoodie successfully added to
                                you cart.
                            </div>
                            <div class="modal-product">
                                <div class="modal-contain-img">
                                    <img src="{{asset('cms/assets/images/fashion/instagram/4.jpg')}}" class="img-fluid blur-up lazyload"
                                        alt="">
                                </div>
                                <div class="modal-contain-details">
                                    <h4>Premier Cropped Skinny Jean</h4>
                                    <p class="font-light my-2">Yellow, Qty : 3</p>
                                    <div class="product-total">
                                        <h5>TOTAL : <span>$1,140.00</span></h5>
                                    </div>
                                    <div class="shop-cart-button mt-3">
                                        <a href="shop-left-sidebar.php"
                                            class="btn default-light-theme conti-button default-theme default-theme-2 rounded">CONTINUE
                                            SHOPPING</a>
                                        <a href="cart.php"
                                            class="btn default-light-theme conti-button default-theme default-theme-2 rounded">VIEW
                                            CART</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ratio_asos mt-4">
                        <div class="container">
                            <div class="row m-0">
                                <div class="col-sm-12 p-0">
                                    <div
                                        class="product-wrapper product-style-2 slide-4 p-0 light-arrow bottom-space spacing-slider">
                                        <div>
                                            <div class="product-box">
                                                <div class="img-wrapper">
                                                    <div class="front">
                                                        <a href="product/details.html">
                                                            <img src="{{asset('cms/assets/images/fashion/product/front/1.jpg')}}"
                                                                class="bg-img blur-up lazyload" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="product-details text-center">
                                                    <div class="rating-details d-block text-center">
                                                        <span class="font-light grid-content">B&Y Jacket</span>
                                                    </div>
                                                    <div class="main-price mt-0 d-block text-center">
                                                        <h3 class="theme-color">$78.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="product-box">
                                                <div class="img-wrapper">
                                                    <div class="front">
                                                        <a href="product/details.html">
                                                            <img src="{{asset('cms/assets/images/fashion/product/front/2.jpg')}}"
                                                                class="bg-img blur-up lazyload" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="product-details text-center">
                                                    <div class="rating-details d-block text-center">
                                                        <span class="font-light grid-content">B&Y Jacket</span>
                                                    </div>
                                                    <div class="main-price mt-0 d-block text-center">
                                                        <h3 class="theme-color">$78.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="product-box">
                                                <div class="img-wrapper">
                                                    <div class="front">
                                                        <a href="product/details.html">
                                                            <img src="{{asset('cms/assets/images/fashion/product/front/3.jpg')}}"
                                                                class="bg-img blur-up lazyload" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="product-details text-center">
                                                    <div class="rating-details d-block text-center">
                                                        <span class="font-light grid-content">B&Y Jacket</span>
                                                    </div>
                                                    <div class="main-price mt-0 d-block text-center">
                                                        <h3 class="theme-color">$78.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="product-box">
                                                <div class="img-wrapper">
                                                    <div class="front">
                                                        <a href="product/details.html">
                                                            <img src="{{asset('cms/assets/images/fashion/product/front/4.jpg')}}"
                                                                class="bg-img blur-up lazyload" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="product-details text-center">
                                                    <div class="rating-details d-block text-center">
                                                        <span class="font-light grid-content">B&Y Jacket</span>
                                                    </div>
                                                    <div class="main-price mt-0 d-block text-center">
                                                        <h3 class="theme-color">$78.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tap-to-top">
        <a href="#home">
            <i class="fas fa-chevron-up"></i>
        </a>
    </div>
    <div class="bg-overlay"></div>
    <script src="{{asset('cms/assets/js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('cms/assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('cms/assets/js/feather/feather.min.js')}}"></script>
    <script src="{{asset('cms/assets/js/lazysizes.min.js')}}"></script>
    <script src="{{asset('cms/assets/js/slick/slick.js')}}"></script>
    <script src="{{asset('cms/assets/js/slick/slick-animation.min.js')}}"></script>
    <script src="{{asset('cms/assets/js/slick/custom_slick.js')}}"></script>
    <script src="{{asset('cms/assets/js/price-filter.js')}}"></script>
    <script src="{{asset('cms/assets/js/ion.rangeSlider.min.js')}}"></script>
    <script src="{{asset('cms/assets/js/filter.js')}}"></script>
    <script src="{{asset('cms/assets/js/newsletter.js')}}"></script>
    <script src="{{asset('cms/assets/js/cart_modal_resize.js')}}"></script>
    <script src="{{asset('cms/assets/js/bootstrap/bootstrap-notify.min.js')}}"></script>
    <script src="{{asset('cms/assets/js/theme-setting.js')}}"></script>
    <script src="{{asset('cms/assets/js/script.js')}}"></script>
    <script>
        $(function() {
            $('[data-bs-toggle="tooltip"]').tooltip()
        });
    </script>
    @stack('scripts')
</body>

</html>