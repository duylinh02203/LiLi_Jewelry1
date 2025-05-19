@extends('cms.layouts.app')
@push('styles')
<link id="color-link" rel="stylesheet" type="text/css" href="{{asset('cms/assets/css/demo2.css')}}">
<style>
    .quantity-container {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 100px;
        overflow: hidden;
    }

    .btn-plus,
    .btn-minus {
        width: 40px;
        height: 48.1px;
        background-color: #f4f4f4;
        border: none;
        font-size: 14px;
        cursor: pointer;
    }

    .btn-plus:hover,
    .btn-minus:hover {
        background-color: #e2e2e2;
    }

    input[type="number"] {
        width: 40px;
        text-align: center;
        border: none;
        font-size: 16px;
        outline: none;
        pointer-events: none;
        align-items: center;
    }

    #cartEffect {
        margin-left: 15px;
    }

    .size-selector {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 20px;
    }

    .size-selector label {
        display: inline-block;
        width: 45px;
        height: 45px;
        line-height: 45px;
        text-align: center;
        border: 2px solid #ccc;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        user-select: none;
        transition: all 0.3s;
    }

    .size-selector input[type="radio"] {
        display: none;
    }

    .size-selector input[type="radio"]:checked+label {
        border-color: black;
        background-color: #f0f0f0;
    }

    .size-selector label:hover {
        border-color: #999;
    }

    .details-image-concept {
        border-bottom: dashed 1px #333;
        padding-bottom: 10px;
    }

    .rating {
        display: inline-block;
        font-size: 30px;
    }

    .rating {
        display: inline-block;
        font-size: 30px;
    }

    .star {
        display: inline-block;
        color: #ccc;
        /* Màu mặc định của sao */
        cursor: pointer;
        transition: color 0.2s ease-in-out;
    }

    .star.active {
        color: #ffcc00;
        /* Màu vàng khi sao được chọn */
    }

    .star.hover {
        color: #ffcc00;
        /* Màu vàng khi hover */
    }
</style>
@endpush
@section('content')
<section class="breadcrumb-section section-b-space" style="padding-top:20px;padding-bottom:20px;">
    <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>{{$product->name}}</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../index.htm">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row gx-4 gy-5">
            <div class="col-lg-12 col-12">
                <div class="details-items">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="details-image-vertical black-slide rounded">
                                        @foreach($product->images as $image)
                                        <div>
                                            <img src="{{ asset('images/' . $image->image) }} "
                                                class="img-fluid blur-up lazyload"
                                                alt="{{ $product->name }}">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-lg-10">
                                    <div class="details-image-1 ratio_asos">
                                        @foreach($product->images as $index => $image)
                                        <div>
                                            <img src="{{ asset('images/' . $image->image) }}"
                                                class="img-fluid w-100 image_zoom_cls-{{ $index }} blur-up lazyload"
                                                alt="{{ $product->name }}">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="cloth-details-size">
                                <div class="details-image-concept">
                                    <h2>{{$product->name}}</h2>
                                </div>
                                <h3 class="price-detail">
                                    @if($product->price)
                                    {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                    <del>{{ number_format($product->listed_price, 0, ',', '.') }} VNĐ</del><span>{{round((($product->listed_price - $product->price)/$product->listed_price) * 100)}} % off</span>
                                    @else
                                    {{ number_format($product->listed_price, 0, ',', '.') }} VNĐ
                                    @endif
                                </h3>
                                <div class="label-section">
                                    <p>{{$product->description}}</p>
                                </div>
                                <div>
                                    <p><strong>Lưu ý: </strong>{{$product->is_free_size === 1 ? 'Sản phẩm Free Size có thể điều chỉnh kích thước tùy ý. Nếu bạn yêu cầu khắc tên, vui lòng ấn liên hệ (góc phải) để được hỗ trợ' : 'Nếu bạn yêu cầu khắc tên, thắc mắc về size số vui lòng ấn liên hệ (góc phải) để được hỗ trợ !'}}</p>
                                </div>
                                <!--  -->
                                <div class="size-selector">
                                    <strong><span>Kích thước: </span></strong>
                                    @foreach($productSizes as $size)
                                    <div>
                                        <input type="radio" id="size{{ $size->id }}" name="size" value="{{ $size->size }}">
                                        <label for="size{{ $size->id }}">{{ $size->size }}</label>
                                    </div>
                                    @endforeach
                                </div>

                                <!--  -->
                                <div class="product-buttons">
                                    <div class="quantity-container">
                                        <button class="btn-minus" onclick="decreaseQuantity()">-</button>
                                        <input type="number" id="quantity" value="1" min="1" readonly>
                                        <button class="btn-plus" onclick="increaseQuantity()">+</button>
                                    </div>
                                    <a href="javascript:void(0)" style="border-radius: 5px;"
                                        id="cartEffect" class="btn btn-solid hover-solid btn-animation">
                                        <i class="fa fa-shopping-cart"></i>
                                        <span>Thêm vào giỏ hàng</span>
                                        <form id="addtocart" method="post"
                                            action="http://localhost:8000/cart/store">
                                            <input type="hidden" name="_token"
                                                value="MkRqEzTGuoSx6LqJUm0OAKxSgNUYt26wTT7RMUZY"> <input
                                                type="hidden" name="id" value="1">
                                            <input type="hidden" name="name"
                                                value="Autem Repudiandae Accusantium Blanditiis">
                                            <input type="hidden" name="price" value="13">
                                            <input type="hidden" name="quantity" id="qty" value="1">
                                        </form>
                                    </a>
                                </div>
                                <div class="mt-2 mt-md-3 border-product">
                                    <table>
                                        <tr>
                                            <td>Cam kết chất lượng sản phẩm</td>
                                            <td>Đổi trả trong vòng 15 ngày</td>

                                        </tr>
                                        <tr>
                                            <td>Cam kết chất lượng, đảm bảo từng chi tiết</td>
                                            <td>Uy tín hàng đầu – Mua sắm không lo</td>
                                        </tr>
                                    </table>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 78%"></div>
                                    </div>
                                </div>

                                <div class="border-product">
                                    <h6 class="product-title d-block">Chia sẻ</h6>
                                    <div class="product-icon">
                                        <ul class="product-social">
                                            <li>
                                                <a href="https://www.facebook.com/">
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://www.google.com/">
                                                    <i class="fab fa-google-plus-g"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://twitter.com/">
                                                    <i class="fab fa-twitter"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://www.instagram.com/">
                                                    <i class="fab fa-instagram"></i>
                                                </a>
                                            </li>
                                            <li class="pe-0">
                                                <a href="https://www.google.com/">
                                                    <i class="fas fa-rss"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="cloth-review">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                data-bs-target="#desc" type="button">Mô tả</button>

                            <button class="nav-link" id="nav-speci-tab" data-bs-toggle="tab" data-bs-target="#speci"
                                type="button">Thông số kĩ thuật</button>

                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                                data-bs-target="#review" type="button">Đánh giá</button>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="desc">
                            <div class="shipping-chart" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                @foreach($product->images as $image)
                                <div style="margin: 10px;">
                                    <img src="{{ asset('images/' . $image->image) }} "
                                        class="img-fluid blur-up lazyload"
                                        alt="{{ $product->name }}"
                                        style="max-width: 100%; max-height: auto; object-fit: cover; border-radius: 10px;">
                                </div>
                                @endforeach
                            </div>
                            <hr>
                            <h2 style="text-align: center;">THÔNG SỐ SẢN PHẨM</h2>
                            <div class="product-details-table">
                                <style>
                                    .product-details-table {
                                        margin: 20px auto;
                                        width: 80%;
                                        text-align: left;
                                        padding-top: 15px;
                                    }

                                    .product-details-table table {
                                        width: 100%;
                                        border-collapse: collapse;
                                    }

                                    .product-details-table td {
                                        padding: 10px 15px;
                                        vertical-align: top;
                                        text-align: left !important;
                                    }
                                </style>
                                <table>
                                    <tr>
                                        <td>Loại:</td>
                                        <td>{{$product->category->name}}</td>
                                        <td>Kích thước: </td>
                                        <td>
                                            @if ($product->is_free_size === 1)
                                            Free Size
                                            @else
                                            {{ $productSizes->pluck('size')->join(' ') }}
                                            @endif
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>Kiểu dáng:</td>
                                        <td>Sang trọng</td>
                                        <td>Giới tính:</td>
                                        <td>{{ $product->gender == "male" ? "Nam" : ($product->gender == "female" ? "Nữ" : "Cả nam và nữ") }}</td>
                                    </tr>
                                    <tr>
                                        <td>Chất liệu:</td>
                                        <td>Bạc 92.5%</td>
                                        <td>Độ hoàn thiện:</td>
                                        <td>Xuất sắc</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="speci">
                            <div class="pro mb-4">
                                <p class="font-light">The Model is wearing a white blouse from our stylist's
                                    collection, see the image for a mock-up of what the actual blouse would look
                                    like.it has text written on it in a black cursive language which looks great
                                    on a white color.</p>
                                <div class="table-responsive">
                                    <table class="table table-part">
                                        <tr>
                                            <th>Product Dimensions</th>
                                            <td>15 x 15 x 3 cm; 250 Grams</td>
                                        </tr>
                                        <tr>
                                            <th>Date First Available</th>
                                            <td>5 April 2021</td>
                                        </tr>
                                        <tr>
                                            <th>Manufacturer‏</th>
                                            <td>Aditya Birla Fashion and Retail Limited</td>
                                        </tr>
                                        <tr>
                                            <th>ASIN</th>
                                            <td>B06Y28LCDN</td>
                                        </tr>
                                        <tr>
                                            <th>Item model number</th>
                                            <td>AMKP317G04244</td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <td>Men</td>
                                        </tr>
                                        <tr>
                                            <th>Item Weight</th>
                                            <td>250 G</td>
                                        </tr>
                                        <tr>
                                            <th>Item Dimensions LxWxH</th>
                                            <td>15 x 15 x 3 Centimeters</td>
                                        </tr>
                                        <tr>
                                            <th>Net Quantity</th>
                                            <td>1 U</td>
                                        </tr>
                                        <tr>
                                            <th>Included Components‏</th>
                                            <td>1-T-shirt</td>
                                        </tr>
                                        <tr>
                                            <th>Generic Name</th>
                                            <td>T-shirt</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade overflow-auto" id="nav-guide">
                            <div class="table-responsive">
                                <table class="table table-pane mb-0">
                                    <tbody>
                                        <tr class="bg-color">
                                            <th class="my-2">US Sizes</th>
                                            <td>6</td>
                                            <td>6.5</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>8.5</td>
                                            <td>9</td>
                                            <td>9.5</td>
                                            <td>10</td>
                                            <td>10.5</td>
                                            <td>11</td>
                                        </tr>

                                        <tr>
                                            <th>Euro Sizes</th>
                                            <td>39</td>
                                            <td>39</td>
                                            <td>40</td>
                                            <td>40-41</td>
                                            <td>41</td>
                                            <td>41-42</td>
                                            <td>42</td>
                                            <td>42-43</td>
                                            <td>43</td>
                                            <td>43-44</td>
                                        </tr>

                                        <tr class="bg-color">
                                            <th>UK Sizes</th>
                                            <td>5.5</td>
                                            <td>6</td>
                                            <td>6.5</td>
                                            <td>7</td>
                                            <td>7.5</td>
                                            <td>8</td>
                                            <td>8.5</td>
                                            <td>9</td>
                                            <td>10.5</td>
                                            <td>11</td>
                                        </tr>

                                        <tr>
                                            <th>Inches</th>
                                            <td>9.25"</td>
                                            <td>9.5"</td>
                                            <td>9.625"</td>
                                            <td>9.75"</td>
                                            <td>9.9735"</td>
                                            <td>10.125"</td>
                                            <td>10.25"</td>
                                            <td>10.5"</td>
                                            <td>10.765"</td>
                                            <td>10.85</td>
                                        </tr>

                                        <tr class="bg-color">
                                            <th>CM</th>
                                            <td>23.5</td>
                                            <td>24.1</td>
                                            <td>24.4</td>
                                            <td>25.4</td>
                                            <td>25.7</td>
                                            <td>26</td>
                                            <td>26.7</td>
                                            <td>27</td>
                                            <td>27.3</td>
                                            <td>27.5</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="question">
                            <div class="question-answer">
                                <ul>
                                    <li>
                                        <div class="que">
                                            <i class="fas fa-question"></i>
                                            <div class="que-details">
                                                <h6>Is it compatible with all WordPress themes?</h6>
                                                <p class="font-light">If you want to see a demonstration version of
                                                    the premium plugin, you can see that in this page. If you want
                                                    to see a demonstration version of the premium plugin, you can
                                                    see that in this page. If you want to see a demonstration
                                                    version of the premium plugin, you can see that in this page.
                                                </p>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="que">
                                            <i class="fas fa-question"></i>
                                            <div class="que-details">
                                                <h6>How can I try the full-featured plugin? </h6>
                                                <p class="font-light">Compatibility with all themes is impossible,
                                                    because they are too many, but generally if themes are developed
                                                    according to WordPress and WooCommerce guidelines, YITH plugins
                                                    are compatible with them. Compatibility with all themes is
                                                    impossible, because they are too many, but generally if themes
                                                    are developed according to WordPress and WooCommerce guidelines,
                                                    YITH plugins are compatible with them.</p>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="que">
                                            <i class="fas fa-question"></i>
                                            <div class="que-details">
                                                <h6>Is it compatible with all WordPress themes?</h6>
                                                <p class="font-light">If you want to see a demonstration version of
                                                    the premium plugin, you can see that in this page. If you want
                                                    to see a demonstration version of the premium plugin, you can
                                                    see that in this page. If you want to see a demonstration
                                                    version of the premium plugin, you can see that in this page.
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="review">
                            <div class="row g-4">
                                <div class="col-lg-4">
                                    <div class="customer-rating">
                                        <h2>Đánh giá của khách hàng</h2>
                                        <ul class="rating my-2 d-inline-block">
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                        </ul>

                                        <div class="global-rating">
                                            <h5 class="font-light">82 Lượt đánh giá</h5>
                                        </div>

                                        <ul class="rating-progess">
                                            <li>
                                                <h5 class="me-3">5 Sao</h5>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: 78%"
                                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <h5 class="ms-3">78%</h5>
                                            </li>
                                            <li>
                                                <h5 class="me-3">4 Sao</h5>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: 62%"
                                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <h5 class="ms-3">62%</h5>
                                            </li>
                                            <li>
                                                <h5 class="me-3">3 Sao</h5>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: 44%"
                                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <h5 class="ms-3">44%</h5>
                                            </li>
                                            <li>
                                                <h5 class="me-3">2 Sao</h5>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: 30%"
                                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <h5 class="ms-3">30%</h5>
                                            </li>
                                            <li>
                                                <h5 class="me-3">1 Sao</h5>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: 18%"
                                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <h5 class="ms-3">18%</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-lg-8" style="margin-top:45px;">
                                    <h2 style="margin-top: -20px;">Đánh giá của bạn</h2>
                                    <p class="d-inline-block me-2">Đánh giá</p>
                                    <div class="rating mb-3 d-inline-block">
                                        <span class="star" data-value="1">★</span>
                                        <span class="star" data-value="2">★</span>
                                        <span class="star" data-value="3">★</span>
                                        <span class="star" data-value="4">★</span>
                                        <span class="star" data-value="5">★</span>
                                    </div>
                                    <div class="review-box">
                                        <form class="row g-4">
                                            <input type="hidden" name="rating" id="rating-value" value="">
                                            <!-- <div class="col-12 col-md-6">
                                                <label class="mb-1" for="name">Tên</label>
                                                <input type="text" class="form-control" id="name"
                                                    placeholder="Nhập tên của bạn" required="">
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label class="mb-1" for="id">Địa chỉ Email</label>
                                                <input type="email" class="form-control" id="id"
                                                    placeholder="Địa chỉ Email" required="">
                                            </div> -->

                                            <div class="col-12">
                                                <label class="mb-1" for="comments">Bình luận</label>
                                                <textarea class="form-control" placeholder="Để lại bình luận ở đây"
                                                    id="comments" style="height: 100px" required=""></textarea>
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" style="border-radius: 10px;"
                                                    class="btn default-light-theme default-theme default-theme-2">Gửi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <div class="customer-review-box">
                                        <h4>Đánh giá của khách hàng</h4>

                                        <div class="customer-section">
                                            <div class="customer-profile">
                                                <img src="../assets/images/inner-page/review-image/1.jpg"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </div>

                                            <div class="customer-details">
                                                <h5>Mike K</h5>
                                                <ul class="rating my-2 d-inline-block">
                                                    <li>
                                                        <i class="fas fa-star theme-color"></i>
                                                    </li>
                                                    <li>
                                                        <i class="fas fa-star theme-color"></i>
                                                    </li>
                                                    <li>
                                                        <i class="fas fa-star theme-color"></i>
                                                    </li>
                                                    <li>
                                                        <i class="fas fa-star"></i>
                                                    </li>
                                                    <li>
                                                        <i class="fas fa-star"></i>
                                                    </li>
                                                </ul>
                                                <p class="font-light">I purchased my Tab S2 at Best Buy but I wanted
                                                    to
                                                    share my thoughts on Amazon. I'm not going to go over specs and
                                                    such
                                                    since you can read those in a hundred other places. Though I
                                                    will
                                                    say that the "new" version is preloaded with Marshmallow and now
                                                    uses a Qualcomm octacore processor in place of the Exynos that
                                                    shipped with the first gen.</p>

                                                <p class="date-custo font-light">- Sep 08, 2021</p>
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
</section>
<section class="ratio_asos section-b-space overflow-hidden" style="padding-top:30px !important;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <hr>
                <h2 class="mb-lg-4 mb-3" style="text-align: center;">Sản phẩm liên quan</h2>
                <div class="product-wrapper product-style-2 slide-4 p-0 light-arrow bottom-space">
                    @if(count($relatedProducts)>0)
                    @foreach($relatedProducts as $relatedProduct)
                    <div>
                        <div class="product-box">
                            <div class="img-wrapper">
                                <div class="front">
                                    <a href="{{ route('shop.product.details', ['slug' => $relatedProduct->slug]) }}">
                                        @if ($relatedProduct->images->first())
                                        <img src="{{ asset('images/' . $relatedProduct->images->first()->image) }}"
                                            class="bg-img blur-up lazyload"
                                            alt="{{ $relatedProduct->name }}">
                                        @else
                                        <img src="{{ asset('cms/assets/images/fashion/product/back/12.jpg') }}"
                                            class="bg-img blur-up lazyload"
                                            alt="No Image">
                                        @endif
                                    </a>
                                </div>
                                <div class="cart-wrap">
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)" class="addtocart-btn"
                                                data-bs-toggle="modal" data-bs-target="#addtocart">
                                                <i data-feather="shopping-bag"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                data-bs-target="#quick-view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="javascript:void(0)" class="wishlist">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-details">
                                <div class="rating-details">
                                    <span class="font-light grid-content">{{$relatedProduct->description}}</span>
                                    <ul class="rating mt-0">
                                        <li>
                                            <i class="fas fa-star theme-color"></i>
                                        </li>
                                        <li>
                                            <i class="fas fa-star theme-color"></i>
                                        </li>
                                        <li>
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li>
                                            <i class="fas fa-star"></i>
                                        </li>
                                        <li>
                                            <i class="fas fa-star"></i>
                                        </li>
                                    </ul>
                                </div>
                                <div class="main-price">
                                    <a href="{{ route('shop.product.details', ['slug' => $relatedProduct->slug]) }}" class="font-default">
                                        <h5 class="ms-0">{{ $relatedProduct->name }}</h5>
                                    </a>
                                    <div class="listing-content">
                                        <span class="font-light">Regular Fit</span>
                                        <p class="font-light">{{ \Illuminate\Support\Str::limit($relatedProduct->description, 100) }}</p>
                                    </div>
                                    <h3 class="theme-color">{{ number_format($relatedProduct->price, 0, ',', '.') }} VNĐ</h3>
                                    <button onclick="location.href = 'cart.html';" class="btn listing-content">Add
                                        To Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="col-12" style="text-align: center;">
                        <h4>Không có sản phẩm nào.</h4>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sizeSelector = document.querySelector('.size-selector');
        if (sizeSelector && sizeSelector.querySelectorAll('input[type="radio"]').length === 0) {
            sizeSelector.style.display = 'none';
        }
    });

    function increaseQuantity() {
        const input = document.getElementById("quantity");
        input.value = parseInt(input.value) + 1;
    }

    function decreaseQuantity() {
        const input = document.getElementById("quantity");
        if (input.value > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
    // Biến lưu trạng thái số sao đã chọn
    let selectedRating = 0;

    // Lấy danh sách tất cả các sao
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating-value');
    // Thêm sự kiện hover và click vào từng sao
    stars.forEach((star, index) => {
        // Khi hover
        star.addEventListener('mouseover', () => {
            highlightStars(index + 1, 'hover'); // Làm sáng tạm thời các sao
        });

        // Khi chuột rời khỏi khu vực sao
        star.addEventListener('mouseout', () => {
            resetHover(); // Xóa hiệu ứng hover
            highlightStars(selectedRating, 'active'); // Hiển thị số sao đã chọn
        });

        // Khi click để chọn sao
        star.addEventListener('click', () => {
            selectedRating = index + 1; // Cập nhật số sao được chọn
            ratingInput.value = selectedRating; // Cập nhật giá trị vào input ẩn
            setActiveStars(selectedRating); // Làm sáng các sao theo số sao đã chọn
            console.log(`Bạn đã chọn ${selectedRating} sao!`);
        });
    });

    // Hàm làm sáng sao khi hover hoặc chọn
    function highlightStars(rating, type) {
        resetAllStars(); // Xóa tất cả trạng thái hiện có
        for (let i = 0; i < rating; i++) {
            stars[i].classList.add(type); // Thêm trạng thái (hover hoặc active)
        }
    }

    // Hàm xóa hiệu ứng hover và trạng thái trước đó
    function resetHover() {
        stars.forEach((star) => star.classList.remove('hover'));
    }

    // Hàm xóa tất cả trạng thái (hover và active)
    function resetAllStars() {
        stars.forEach((star) => star.classList.remove('hover', 'active'));
    }

    // Hàm làm sáng các sao đã chọn
    function setActiveStars(rating) {
        resetAllStars(); // Xóa trạng thái cũ
        for (let i = 0; i < rating; i++) {
            stars[i].classList.add('active'); // Làm sáng theo số sao được chọn
        }
    }
</script>
@endpush