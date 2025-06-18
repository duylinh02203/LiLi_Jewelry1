@extends('cms.layouts.app')
@push('styles')
    <link id="color-link" rel="stylesheet" type="text/css" href="{{ asset('cms/assets/css/demo2.css') }}">
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
            font-size: 25px;
        }

        .rating {
            display: inline-block;
            font-size: 25px;
        }

        .star {
            display: inline-block;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s ease-in-out;
        }

        .star.active {
            color: #e87316;
        }

        .star.hover {
            color: #e87316;
        }

        .star1 {
            color: #ccc;
        }

        .love-icon {
            cursor: pointer;
            color: black;
            transition: color 0.3s ease;
        }

        .love-icon:hover {
            color: red;
        }

        .love-icon:hover i,
        .love-icon:hover p {
            color: red;
        }

        #alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            padding: 15px 20px;
            border-radius: 10px;
            background-color: #d4edda;
            color: #155724;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: fadeInOut 4s forwards;
        }

        @keyframes fadeInOut {

            0%,
            20% {
                opacity: 1;
            }

            80%,
            100% {
                opacity: 0;
            }
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            padding: 15px 20px;
            border-radius: 10px;
            font-size: 14px;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .notification.success {
            background-color: #28a745;
        }

        .notification.error {
            background-color: #dc3545;
        }

        .dot-menu {
            position: relative;
            display: inline-block;
            cursor: pointer;
            width: 24px;
            height: 24px;
            padding: 4px;
        }

        .dot-menu .dot {
            width: 4px;
            height: 4px;
            background-color: #555;
            border-radius: 50%;
            margin: 2px auto;
        }

        .menu-options {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 6px;
            background: white;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            display: none;
            min-width: 100px;
            z-index: 100;
        }

        .menu-options.show {
            display: block;
        }

        .menu-options a {
            display: block;
            padding: 8px 12px;
            text-decoration: none;
            color: #333;
        }

        .menu-options a:hover {
            background-color: #f2f2f2;
        }

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

        /* Overlay phủ mờ */
        .size-overlay {
            display: none;
            /* Mặc định ẩn */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: flex-end;
        }

        /* Modal chọn size nổi ở dưới */
        .size-modal {
            width: 100%;
            max-height: 33vh;
            background-color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 20px;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.3s ease-out;
        }

        .size-title {
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
            color: #e87316;
        }

        /* Animation xuất hiện mượt */
        @keyframes slideUp {
            from {
                transform: translateY(100%);
            }

            to {
                transform: translateY(0%);
            }
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
                    <h3>{{ $product->name }}</h3>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">
                                    <i class="fas fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
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
                                            @foreach ($product->images as $image)
                                                <div>
                                                    <img src="{{ asset('images/' . $image->image) }} "
                                                        class="img-fluid blur-up lazyload" alt="{{ $product->name }}"
                                                        style="border-radius: 10px;">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-lg-10">
                                        <div class="details-image-1 ratio_asos">
                                            @foreach ($product->images as $index => $image)
                                                <div>
                                                    <img style="border-radius: 10px;"
                                                        src="{{ asset('images/' . $image->image) }}"
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
                                        <h2>{{ $product->name }}</h2>
                                    </div>
                                    <h3 class="price-detail">
                                        @if ($product->price)
                                            {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                            <del>{{ number_format($product->listed_price, 0, ',', '.') }}
                                                VNĐ</del><span>{{ round((($product->listed_price - $product->price) / $product->listed_price) * 100) }}
                                                % off</span>
                                        @else
                                            {{ number_format($product->listed_price, 0, ',', '.') }} VNĐ
                                        @endif
                                    </h3>
                                    <div class="label-section">
                                        <p>{{ $product->description }}</p>
                                    </div>
                                    <div>
                                        <p><strong>Lưu ý:
                                            </strong>{{ $product->is_free_size === 1 ? 'Sản phẩm Free Size có thể điều chỉnh kích thước tùy ý. Nếu bạn yêu cầu khắc tên, vui lòng ấn liên hệ (góc phải) để được hỗ trợ' : 'Nếu bạn yêu cầu khắc tên, thắc mắc về size số vui lòng ấn liên hệ (góc phải) để được hỗ trợ !' }}
                                        </p>
                                    </div>
                                    <div class="size-selector">
                                        <strong><span>Kích thước: </span></strong>
                                        @foreach ($productSizes as $size)
                                            <div>
                                                <input type="radio" id="size{{ $size->id }}" name="size"
                                                    value="{{ $size->size }}">
                                                <label for="size{{ $size->id }}">{{ $size->size }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="product-buttons">
                                        <div class="quantity-container">
                                            <button class="btn-minus" onclick="decreaseQuantity()">-</button>
                                            <input name="quantity" type="number" id="quantity" value="1"
                                                min="1" readonly>
                                            <button class="btn-plus" onclick="increaseQuantity()">+</button>
                                        </div>
                                        <form id="addtocart" method="POST" action="{{ route('cart.addToCart') }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="size" id="selected-size">
                                            <input type="hidden" name="quantity" id="selected-quantity">
                                            <button type="button" class="btn btn-solid hover-solid btn-animation"
                                                id="cartEffect" style="border-radius: 5px;">
                                                <i class="fa fa-shopping-cart"></i>
                                                <span>Thêm vào giỏ hàng</span>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-6" class="mt-2 mt-md-3">
                                        <a href="javascript:void(0)" style="display:flex; width:fit-content;"
                                            class="wishlist wishlistEffect love-icon"
                                            data-product-id="{{ $product->id }}">
                                            <i class="fa-regular fa-heart" style="font-size: 20px;"></i>
                                            <p style="margin-left: 10px;">Yêu thích</p>
                                            <form id="addWishlist-{{ $product->id }}" class="wishlist"
                                                action="{{ route('shop.wishlist.addWishlist') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            </form>
                                            <div id="wishlistMessage-{{ $product->id }}" style="display: none;"></div>
                                        </a>
                                    </div>
                                    <div class="mt-2 mt-md-3 border-product">
                                        <table>
                                            <tr>
                                                <td>Cam kết chất lượng, đảm bảo từng chi tiết</td>
                                            </tr>
                                            <tr>
                                                <td>Uy tín hàng đầu – Mua sắm không lo</td>
                                            </tr>
                                        </table>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 78%"></div>
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
                                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                                    data-bs-target="#review" type="button">Đánh giá</button>
                            </div>
                        </nav>

                        <div class="tab-content" id="nav-tabContent" style="border-bottom:1px solid #ccc;">
                            <div class="tab-pane fade show active" id="desc"
                                style="padding-bottom: 0px !important; ">
                                <div class="shipping-chart"
                                    style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                    @foreach ($product->images as $image)
                                        <div style="margin: 10px;">
                                            <img src="{{ asset('images/' . $image->image) }} "
                                                class="img-fluid blur-up lazyload" alt="{{ $product->name }}"
                                                style="max-width: 100%; max-height: auto; object-fit: cover; border-radius: 10px;">
                                        </div>
                                    @endforeach
                                </div>
                                <hr>
                                <h2 style="text-align: center;">THÔNG SỐ SẢN PHẨM</h2>
                                <div class="product-details-table">
                                    <table>
                                        <tr>
                                            <td>Loại:</td>
                                            <td>{{ $product->category->name }}</td>
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
                                            <td>{{ $product->gender == 'male' ? 'Nam' : ($product->gender == 'female' ? 'Nữ' : 'Cả nam và nữ') }}
                                            </td>
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
                            <div class="tab-pane fade" id="review">
                                <div class="row g-4">
                                    @if ($message = Session::get('success'))
                                        <div id="alert" class="alert alert-success"
                                            style="position: absolute; width: 80.5%;">
                                            {{ $message }}
                                        </div>
                                    @endif
                                    <div class="col-lg-4">
                                        <div class="customer-rating">
                                            <h2>Đánh giá của khách hàng</h2>
                                            <ul class="rating my-2 d-inline-block">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span class="star1 {{ $i <= $roundTbRating ? 'theme-color' : '' }}"
                                                        data-value="1">★</span>
                                                @endfor
                                            </ul>
                                            <div class="global-rating" style="margin-bottom:15px;">
                                                <h5 class="font-light">{{ $reviewCount }} lượt đánh giá</h5>
                                            </div>
                                            @php
                                                $totalReviews = array_sum($ratings);
                                            @endphp
                                            <ul class="rating-progress">
                                                @for ($i = 5; $i >= 1; $i--)
                                                    @php
                                                        $count = $ratings[$i] ?? 0;
                                                        $percent =
                                                            $totalReviews > 0
                                                                ? round(($count / $totalReviews) * 100)
                                                                : 0;
                                                    @endphp
                                                    <li class="d-flex align-items-center mb-2">
                                                        <h5 class="me-2">{{ $i }} Sao</h5>
                                                        <div class="progress flex-grow-1 mx-2" style="height: 20px;">
                                                            <div class="progress-bar" role="progressbar"
                                                                style=" background-color: #e87316; color: #ffffff;width: {{ $percent }}%"
                                                                aria-valuenow="{{ $percent }}" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <h5 class="ms-2">{{ $count }} đánh giá
                                                            ({{ $percent }}%)</h5>
                                                    </li>
                                                @endfor
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-8" style="margin-top:45px;">
                                        <h2 style="margin-top: -20px;">Đánh giá của bạn</h2>
                                        <div class="wrap_rating" style="display: flex; align-items: center;">
                                            <p class="d-inline-block me-2">Đánh giá</p>
                                            <div class="rating mb-3 d-inline-block" style="margin:0px !important;">
                                                <span class="star" data-value="1">★</span>
                                                <span class="star" data-value="2">★</span>
                                                <span class="star" data-value="3">★</span>
                                                <span class="star" data-value="4">★</span>
                                                <span class="star" data-value="5">★</span>
                                            </div>
                                            <div id="ratingMessage" style="margin-left:15px; color: red; display: none;">
                                                Bạn cần chọn sao</div>
                                        </div>
                                        <div class="review-box">
                                            <form id="reviewForm" class="row g-4"
                                                action="{{ route('shop.product.review') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="rating" id="rating-value" value="">
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <div class="col-12">
                                                    <label class="mb-1" for="comments">Bình luận
                                                        <div id="commentMessage"
                                                            style="margin-left:15px; color: red; display: none;">Bạn cần
                                                            bình luận</div>
                                                    </label>
                                                    <textarea class="form-control" name="comment" placeholder="Để lại bình luận ở đây" id="comments"
                                                        style="height: 100px"></textarea>
                                                </div>

                                                <div class="col-12">
                                                    @php
                                                        $order = \App\Models\Order::where(
                                                            'user_id',
                                                            session('userData')->id,
                                                        )
                                                            ->where('status', 'completed')
                                                            ->whereHas('orderItems', function ($query) use ($product) {
                                                                $query->where('product_id', $product->id);
                                                            })
                                                            ->first();
                                                    @endphp
                                                    @if ($order)
                                                        <button type="submit" style="border-radius: 10px;"
                                                            class="btn default-light-theme default-theme default-theme-2">
                                                            Gửi
                                                        </button>
                                                    @else
                                                        <button type="submit" style="border-radius: 10px;"
                                                            class="btn default-light-theme default-theme default-theme-2"
                                                            disabled>
                                                            Gửi
                                                        </button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    @if ($reviewCount > 0)
                                        <div class="col-12 mt-4">
                                            <div class="customer-review-box">
                                                <h4>Đánh giá của khách hàng</h4>

                                                @foreach ($productReviews as $review)
                                                    <div class="customer-section">
                                                        <div class="customer-profile">
                                                            <img src="../assets/images/inner-page/review-image/1.jpg"
                                                                class="img-fluid blur-up lazyload" alt="">
                                                        </div>

                                                        <div class="customer-details">
                                                            <div class="wrap-name"
                                                                style="display:flex; justify-content: space-between;">
                                                                <h5>{{ $review->user->name }}</h5>
                                                                @if (session()->has('userData'))
                                                                    @if (session('userData')->id === $review->user->id)
                                                                        <div class="dot-menu" onclick="toggleMenu(event)">
                                                                            <div class="dot"></div>
                                                                            <div class="dot"></div>
                                                                            <div class="dot"></div>

                                                                            <div class="menu-options">
                                                                                <a href="{{ route('shop.productReview.destroy', $review->id) }}"
                                                                                    class="delete-review"
                                                                                    data-id="{{ $review->id }}">
                                                                                    Xoá
                                                                                </a>

                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                            <ul class="rating my-2 d-inline-block">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <span
                                                                        class="star1 {{ $i <= $review->rating ? 'theme-color' : '' }} "
                                                                        data-value="1">★</span>
                                                                @endfor
                                                            </ul>
                                                            <p class="font-light">{{ $review->comment }}</p>
                                                            <p class="date-custo font-light">
                                                                {{ $review->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <p style="color:#333">Chưa có đánh giá nào.</p>
                                    @endif
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
                    <h2 class="mb-lg-4 mb-3" style="text-align: center;">Sản phẩm liên quan</h2>
                    <div class="product-wrapper product-style-2 slide-4 p-0 light-arrow bottom-space">
                        @if (count($relatedProducts) > 0)
                            @foreach ($relatedProducts as $relatedProduct)
                                <div>
                                    <div class="product-box">
                                        <div class="img-wrapper">
                                            <div class="front">
                                                <a
                                                    href="{{ route('shop.product.details', ['slug' => $relatedProduct->slug]) }}">
                                                    @if ($relatedProduct->images->first())
                                                        <img src="{{ asset('images/' . $relatedProduct->images->first()->image) }}"
                                                            class="bg-img blur-up lazyload"
                                                            alt="{{ $relatedProduct->name }}">
                                                    @else
                                                        <img src="{{ asset('cms/assets/images/fashion/product/back/12.jpg') }}"
                                                            class="bg-img blur-up lazyload" alt="No Image">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="cart-wrap">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:void(0)" class="addtocart-btn addToCart"
                                                            data-product-id="{{ $relatedProduct->id }}"
                                                            data-has-size="{{ $relatedProduct->sizes->count() > 0 ? 1 : 0 }}"
                                                            data-sizes='@json($relatedProduct->sizes->pluck('size'))'>
                                                            <i data-feather="shopping-cart"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="{{ route('shop.product.details', ['slug' => $relatedProduct->slug]) }}">
                                                            <i data-feather="eye"></i>
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="javascript:void(0)" class="wishlist wishlistEffect"
                                                            data-product-id="{{ $relatedProduct->id }}">
                                                            <i data-feather="heart"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="product-details">
                                            @php
                                                $tbRating = \App\Models\ProductReview::where(
                                                    'product_id',
                                                    $relatedProduct->id,
                                                )->avg('rating');
                                                $tbRating = round($tbRating);
                                                $countReview = \App\Models\ProductReview::where(
                                                    'product_id',
                                                    $relatedProduct->id,
                                                )->count();
                                            @endphp
                                            <div class="wrap-retail">
                                                <span class="reatail-name"
                                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $relatedProduct->name }}</span>
                                                <h3 class="theme-color">{{ number_format($product->price, 0, ',', '.') }}
                                                    VNĐ</h3>
                                                <div class="wrap-rating"
                                                    style="display:flex; justify-content: space-between;">
                                                    <ul class="rating mt-0">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <span
                                                                class="star1 {{ $i <= $tbRating ? 'theme-color' : '' }} "
                                                                data-value="1">★</span>
                                                        @endfor
                                                    </ul>
                                                    <p style="padding-top: 7px;">{{ $countReview }} đánh giá</p>
                                                </div>
                                            </div>
                                        </div>
                                        <form id="addWishlist-{{ $relatedProduct->id }}" class="wishlist"
                                            action="{{ route('shop.wishlist.addWishlist') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $relatedProduct->id }}">
                                        </form>
                                        <form id="addToCart{{ $relatedProduct->id }}" class="cart" method="POST"
                                            action="{{ route('cart.addToCart') }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $relatedProduct->id }}">
                                        </form>
                                        <div id="wishlistMessage-{{ $relatedProduct->id }}" style="display: none;"></div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12" style="text-align: center;">
                                <h4 style="margin-left:10px;">Không có sản phẩm nào.</h4>
                            </div>
                        @endif
                    </div>
                </div>
                @if (session()->has('userData'))
                    <input type="hidden" class="check-login" name="check-login" value="hehe">
                @endif
            </div>
        </div>
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const notification = document.createElement('div');
                    notification.innerText = "{{ session('success') }}";

                    Object.assign(notification.style, {
                        position: 'fixed',
                        top: '120px',
                        right: '20px',
                        padding: '10px 20px',
                        borderRadius: '8px',
                        color: 'white',
                        backgroundColor: 'green',
                        zIndex: '1000',
                        boxShadow: '0 4px 8px rgba(0, 0, 0, 0.2)',
                        opacity: '1',
                        transition: 'opacity 0.5s ease-out',
                    });

                    document.body.appendChild(notification);

                    setTimeout(() => {
                        notification.style.opacity = '0';
                        setTimeout(() => {
                            notification.remove();
                        }, 500);
                    }, 3000);
                });
            </script>
        @endif
    </section>
    <div id="sizeOverlay" class="size-overlay" style="display:none;">
        <div class="size-modal">
            <h4 class="size-title">Chọn size</h4>
            <select id="selectedSize" class="form-select mb-3">
                <option value="">-- Chọn size --</option>
                <!-- Các option sẽ được JS chèn vào -->
            </select>
            <div class="d-flex justify-content-between">
                <button id="cancelSize" type="button" class="btn btn-outline-dark">Hủy</button>
                <button id="confirmSize" type="button" class="btn"
                    style="background-color: #e87316; color: black; font-weight: bold;">Xác
                    nhận</button>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // add to cart in related products
        document.addEventListener('DOMContentLoaded', function() {
            let currentProductId = null;
            document.querySelectorAll('.addToCart').forEach(function(btn) {
                btn.addEventListener('click', function(event) {
                    event.preventDefault();
                    const hasSize = this.dataset.hasSize === '1';
                    currentProductId = this.dataset.productId;
                    const form = document.getElementById('addToCart' + currentProductId);
                    if (hasSize) {
                        // Lấy danh sách size từ data attribute
                        const sizes = JSON.parse(this.dataset.sizes);
                        const sizeSelect = document.getElementById('selectedSize');
                        // Xóa các option size cũ (ngoại trừ option mặc định)
                        sizeSelect.innerHTML = '<option value="">-- Chọn size --</option>';
                        // Thêm các option size từ database
                        sizes.forEach(function(size) {
                            const option = document.createElement('option');
                            option.value = size;
                            option.textContent = size;
                            sizeSelect.appendChild(option);
                        });
                        // Reset chọn size
                        sizeSelect.value = "";
                        // Hiện modal chọn size
                        document.getElementById('sizeOverlay').style.display = 'flex';
                    } else {
                        submitForm(form);
                    }
                });
            });

            document.getElementById('confirmSize').addEventListener('click', function(e) {
                e.preventDefault();
                const size = document.getElementById('selectedSize').value;

                if (!size) {
                    alert("Vui lòng chọn size.");
                    return;
                }

                const form = document.getElementById('addToCart' + currentProductId);
                let input = form.querySelector('input[name="size"]');

                if (!input) {
                    input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'size';
                    form.appendChild(input);
                }

                input.value = size;
                document.getElementById('sizeOverlay').style.display = 'none';
                submitForm(form);
            });

            document.getElementById('cancelSize').addEventListener('click', function() {
                document.getElementById('sizeOverlay').style.display = 'none';
            });

            document.getElementById('sizeOverlay').addEventListener('click', function(e) {
                if (e.target.id === 'sizeOverlay') {
                    document.getElementById('sizeOverlay').style.display = 'none';
                }
            });

            function submitForm(form) {
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const formData = new FormData(form);
                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        showNotification(data.status === 'success' ? 'success' : 'error', data.message);
                        if (data.status === 'success') {
                            document.getElementById('cart-count').textContent = data.cart_count;
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi xảy ra:', error);
                        showNotification('error', 'Không thêm được vào giỏ hàng!');
                    });
            }

            function showNotification(type, message) {
                const notification = document.createElement('div');
                notification.className = `notification ${type}`;
                notification.textContent = message;
                Object.assign(notification.style, {
                    position: 'fixed',
                    top: '20px',
                    right: '20px',
                    padding: '10px 20px',
                    borderRadius: '8px',
                    color: 'white',
                    backgroundColor: type === 'success' ? 'green' : 'red',
                    zIndex: '1000',
                    boxShadow: '0 4px 8px rgba(0, 0, 0, 0.2)',
                    opacity: '1',
                    transition: 'opacity 0.5s ease-out',
                });
                document.body.appendChild(notification);
                setTimeout(() => {
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        notification.remove();
                    }, 200);
                }, 2000);
            }
        });


        document.addEventListener('DOMContentLoaded', function() {
            // Ẩn size-selector nếu không có lựa chọn size
            const sizeSelector = document.querySelector('.size-selector');
            const hasSizeOptions = sizeSelector && sizeSelector.querySelectorAll('input[type="radio"]').length > 0;
            if (sizeSelector && !hasSizeOptions) {
                sizeSelector.style.display = 'none';
            }

            // Tăng / giảm số lượng
            window.increaseQuantity = function() {
                const input = document.getElementById("quantity");
                input.value = parseInt(input.value) + 1;
            }

            window.decreaseQuantity = function() {
                const input = document.getElementById("quantity");
                if (input.value > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            }

            // Wishlist effect
            document.querySelectorAll('.wishlistEffect').forEach((element) => {
                element.addEventListener('click', function(event) {
                    event.preventDefault();

                    let productId = this.getAttribute('data-product-id');
                    let form = document.querySelector(`#addWishlist-${productId}`);
                    let messageDiv = document.getElementById(`wishlistMessage-${productId}`);

                    fetch(form.action, {
                            method: 'POST',
                            body: new FormData(form),
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                        })
                        .then(response => {
                            if (response.status === 401) {
                                window.location.href = '/auth/login';
                                return null;
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (!data) return;
                            showNotification(data.status === 'success' ? 'success' : 'error',
                                data.message);

                            if (data.status === 'success') {
                                document.getElementById('header-wishlist-count').textContent =
                                    data.wishlist_count;
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi xảy ra:', error);
                            showNotification('error', 'Có lỗi xảy ra!');
                        });
                });
            });

            // Đánh giá sản phẩm
            const checkLogin = document.querySelector('.check-login')?.value;
            if (checkLogin != null) {
                let selectedRating = 0;
                const stars = document.querySelectorAll('.star');
                const message = document.getElementById('ratingMessage');
                const ratingInput = document.getElementById('rating-value');
                const form = document.getElementById('reviewForm');
                const commentInput = document.getElementById('comments');
                const commentMessage = document.getElementById('commentMessage');

                stars.forEach((star, index) => {
                    star.addEventListener('mouseover', () => highlightStars(index + 1, 'hover'));
                    star.addEventListener('mouseout', () => {
                        resetHover();
                        highlightStars(selectedRating, 'active');
                    });
                    star.addEventListener('click', () => {
                        selectedRating = index + 1;
                        ratingInput.value = selectedRating;
                        setActiveStars(selectedRating);
                        message.style.display = 'none';
                    });
                });

                function highlightStars(count, type) {
                    stars.forEach((star, i) => star.classList.toggle(type, i < count));
                }

                function resetHover() {
                    stars.forEach(star => star.classList.remove('hover'));
                }

                function setActiveStars(count) {
                    stars.forEach((star, i) => star.classList.toggle('active', i < count));
                }

                commentInput.addEventListener('input', () => {
                    const comment = commentInput.value.trim();
                    const wordCount = comment.split(/\s+/).filter(word => word.length > 0).length;

                    if (comment === '') {
                        commentMessage.innerText = 'Bạn cần bình luận.';
                        commentMessage.style.display = 'inline';
                    } else if (wordCount < 10) {
                        commentMessage.innerText = 'Bình luận phải có ít nhất 10 từ.';
                        commentMessage.style.display = 'inline';
                    } else {
                        commentMessage.style.display = 'none';
                    }
                });

                form?.addEventListener('submit', function(e) {
                    e.preventDefault();

                    let isValid = true;
                    const rating = parseInt(ratingInput.value || '0');
                    const comment = commentInput.value.trim();
                    const wordCount = comment.split(/\s+/).filter(word => word.length > 0).length;

                    if (rating === 0) {
                        message.style.display = 'inline';
                        isValid = false;
                    } else {
                        message.style.display = 'none';
                    }

                    if (comment === '') {
                        commentMessage.innerText = 'Bạn cần bình luận.';
                        commentMessage.style.display = 'inline';
                        isValid = false;
                    } else if (wordCount < 10) {
                        commentMessage.innerText = 'Bình luận phải có ít nhất 10 từ.';
                        commentMessage.style.display = 'inline';
                        isValid = false;
                    } else {
                        commentMessage.style.display = 'none';
                    }

                    if (!isValid) return;

                    const formData = new FormData(form);

                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => {
                            if (response.status === 401) {
                                window.location.href = '/auth/login';
                                return null;
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (!data) return;
                            showNotification(data.status === 'success' ? 'success' : 'error', data
                                .message);
                            if (data.status === 'success') {
                                sessionStorage.setItem('notification', JSON.stringify({
                                    type: 'success',
                                    message: data.message
                                }));
                                location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            showNotification('error', 'Có lỗi xảy ra!');
                        });
                });
            }

            // Add to cart (hỗ trợ cả sản phẩm không có size)
            document.getElementById('cartEffect').addEventListener('click', function() {
                const selectedSize = document.querySelector('input[name="size"]:checked');
                const quantity = document.getElementById('quantity').value;
                const form = document.getElementById('addtocart');

                // Nếu có selector thì cần kiểm tra size, còn không thì bỏ qua
                if (hasSizeOptions && !selectedSize) {
                    showNotification('error', 'Vui lòng chọn kích thước!');
                    return;
                }

                if (selectedSize) {
                    document.getElementById('selected-size').value = selectedSize.value;
                }

                document.getElementById('selected-quantity').value = quantity;

                fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.status === 401) {
                            window.location.href = '/auth/login';
                            return null;
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (!data) return;
                        showNotification(data.status === 'success' ? 'success' : 'error', data.message);

                        if (data.status === 'success') {
                            const countElem = document.getElementById('cart-count');
                            if (countElem) {
                                countElem.textContent = data.cart_count;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                        showNotification('error', 'Có lỗi xảy ra!');
                    });
            });

            // Các xử lý giao diện khác
            function showNotification(type, message) {
                const notification = document.createElement('div');
                notification.className = `notification ${type}`;
                notification.textContent = message;

                Object.assign(notification.style, {
                    position: 'fixed',
                    top: '20px',
                    right: '20px',
                    padding: '10px 20px',
                    borderRadius: '8px',
                    color: 'white',
                    backgroundColor: type === 'success' ? 'green' : type === 'error' ? 'red' : 'orange',
                    zIndex: '1000',
                    boxShadow: '0 4px 8px rgba(0, 0, 0, 0.2)',
                    opacity: '1',
                    transition: 'opacity 0.5s ease-out',
                });

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            // Menu toggle
            document.querySelectorAll('.btn').forEach(button => {
                button.addEventListener('click', (e) => e.stopPropagation());
            });

            document.addEventListener('click', function() {
                document.querySelectorAll('.menu-options').forEach(menu => menu.classList.remove('show'));
            });
            //Show menu options on click
            window.toggleMenu = function(event) {
                event.stopPropagation();
                document.querySelectorAll('.menu-options').forEach(menu => {
                    if (menu !== event.currentTarget.querySelector('.menu-options')) {
                        menu.classList.remove('show');
                    }
                });
                const menu = event.currentTarget.querySelector('.menu-options');
                menu.classList.toggle('show');
            };

            // Ẩn alert sau 3 giây
            setTimeout(() => {
                let alert = document.getElementById('alert');
                if (alert) {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 500);
                }
            }, 3000);
        });
    </script>
@endpush
