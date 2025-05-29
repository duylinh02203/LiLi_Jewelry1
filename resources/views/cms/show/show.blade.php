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
                            <a href="{{route('home')}}">
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
                                                alt="{{ $product->name }}" style="border-radius: 10px;">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-lg-10">
                                    <div class="details-image-1 ratio_asos">
                                        @foreach($product->images as $index => $image)
                                        <div>
                                            <img style="border-radius: 10px;" src="{{ asset('images/' . $image->image) }}"
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
                                <div class="col-6" class="mt-2 mt-md-3">
                                    <a href="#" style="display:flex; width:fit-content;" class="wishlist wishlistEffect love-icon" data-product-id="{{ $product->id }}">
                                        <i class="fa-regular fa-heart" style="font-size: 20px;"></i>
                                        <p style="margin-left: 10px;">Yêu thích</p>
                                        <form id="addWishlist-{{ $product->id }}" class="wishlist" action="{{route('shop.wishlist.addWishlist')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        </form>
                                        <div id="wishlistMessage-{{ $product->id }}" style="display: none;"></div>
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
                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                                data-bs-target="#review" type="button">Đánh giá</button>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent" style="border-bottom:1px solid #ccc;">
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
                        <div class="tab-pane fade" id="review">
                            <div class="row g-4">
                                <div class="col-lg-4">
                                    <div class="customer-rating">
                                        <h2>Đánh giá của khách hàng</h2>
                                        <ul class="rating my-2 d-inline-block">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="star1 {{ $i <= $roundTbRating ? 'theme-color' : '' }}" data-value="1">★</span>
                                                @endfor
                                        </ul>
                                        <div class="global-rating" style="margin-bottom:15px;">
                                            <h5 class="font-light">{{$reviewCount}} lượt đánh giá</h5>
                                        </div>
                                        @php
                                        $totalReviews = array_sum($ratings);
                                        @endphp
                                        <ul class="rating-progress">
                                            @for ($i = 5; $i >= 1; $i--)
                                            @php
                                            $count = $ratings[$i] ?? 0;
                                            $percent = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
                                            @endphp
                                            <li class="d-flex align-items-center mb-2">
                                                <h5 class="me-2">{{ $i }} Sao</h5>
                                                <div class="progress flex-grow-1 mx-2" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar"
                                                        style=" background-color: #e87316; color: #ffffff;width: {{ $percent }}%"
                                                        aria-valuenow="{{ $percent }}"
                                                        aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <h5 class="ms-2">{{ $count }} đánh giá ({{ $percent }}%)</h5>
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
                                        <span id="message" style="margin-left:15px; color: red; display: none;">Bạn cần chọn sao</span>
                                    </div>
                                    <div class="review-box">
                                        <form id="reviewForm" class="row g-4" action="{{ route('shop.product.review') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="rating" id="rating-value" value="">
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="col-12">
                                                <label class="mb-1" for="comments">Bình luận
                                                    <span id="comment-message" style="margin-left:15px; color: red; display: none;">Bạn cần bình luận</span>
                                                </label>
                                                <textarea class="form-control" name="comment" placeholder="Để lại bình luận ở đây" id="comments" style="height: 100px"></textarea>
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" style="border-radius: 10px;"
                                                    class="btn default-light-theme default-theme default-theme-2">
                                                    Gửi
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                @if($reviewCount>0)
                                <div class="col-12 mt-4">
                                    <div class="customer-review-box">
                                        <h4>Đánh giá của khách hàng</h4>

                                        @foreach($productReviews as $review)
                                        <div class="customer-section">
                                            <div class="customer-profile">
                                                <img src="../assets/images/inner-page/review-image/1.jpg"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </div>

                                            <div class="customer-details">
                                                <h5>{{$review->user->name}}</h5>
                                                <ul class="rating my-2 d-inline-block">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span class="star1 {{ $i <= $review->rating ? 'theme-color' : '' }} " data-value="1">★</span>
                                                        @endfor
                                                </ul>
                                                <p class="font-light">{{$review->comment}}</p>

                                                <p class="date-custo font-light">{{$review->created_at}}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
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
                                            <a href="{{ route('shop.product.details', ['slug' => $product->slug]) }}" data-bs-toggle="modal"
                                                data-bs-target="quick-view">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="javascript:void(0)" class="wishlist wishlistEffect" data-product-id="{{ $relatedProduct->id }}">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-details">
                                @php
                                $tbRating = \App\Models\ProductReview::where('product_id', $relatedProduct->id)->avg('rating');
                                $tbRating = round($tbRating);
                                $countReview = \App\Models\ProductReview::where('product_id', $relatedProduct->id)->count();
                                @endphp
                                <div class="wrap-retail">
                                    <span class="reatail-name" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $relatedProduct->name }}</span>
                                    <h3 class="theme-color">{{ number_format($product->price, 0, ',', '.') }} VNĐ</h3>
                                    <div class="wrap-rating" style="display:flex; justify-content: space-between;">
                                        <ul class="rating mt-0">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="star1 {{ $i <= $tbRating ? 'theme-color' : '' }} " data-value="1">★</span>
                                                @endfor
                                        </ul>
                                        <p style="padding-top: 7px;">{{$countReview}} đánh giá</p>
                                    </div>
                                </div>
                            </div>
                            <form id="addWishlist-{{ $relatedProduct->id }}" class="wishlist" action="{{route('shop.wishlist.addWishlist')}}" method="post">
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
    let selectedRating = 0;

    const stars = document.querySelectorAll('.star');
    const message = document.getElementById('message');
    const ratingInput = document.getElementById('rating-value');
    const form = document.querySelector('.review-box form');
    const commentInput = document.getElementById('comments');
    const commentMessage = document.getElementById('comment-message');
    stars.forEach((star, index) => {
        star.addEventListener('mouseover', () => {
            highlightStars(index + 1, 'hover');
        });

        star.addEventListener('mouseout', () => {
            resetHover();
            highlightStars(selectedRating, 'active');
        });


        star.addEventListener('click', () => {
            selectedRating = index + 1;
            message.style.display = 'none';
            ratingInput.value = selectedRating;
            setActiveStars(selectedRating);
            console.log(`Bạn đã chọn ${selectedRating} sao!`);
        });
    });


    function highlightStars(rating, type) {
        resetAllStars();
        for (let i = 0; i < rating; i++) {
            stars[i].classList.add(type);
        }
    }
    commentInput.addEventListener('input', () => {
        let comment = commentInput.value.trim();
        let wordCount = 0;
        if (comment === '') {
            commentMessage.innerText = 'Bạn cần bình luận.';
            commentMessage.style.display = 'inline';
        } else {
            commentMessage.style.display = 'none';
        }
        for (let i = 0; i < comment.length; i++) {
            if (comment[i] === ' ') {
                wordCount++;
            }
        }
        wordCount++;

        console.log("Word count:", wordCount);

        if (wordCount >= 10) {
            commentMessage.style.display = 'none';
        } else {
            commentMessage.innerText = 'Bình luận phải có ít nhất 10 từ.';
            commentMessage.style.display = 'inline';
        }
    });
    if (form) {
        form.addEventListener('submit', (e) => {
            if (selectedRating === 0) {
                e.preventDefault();
                if (message) message.style.display = 'block';
            } else {
                if (message) message.style.display = 'none';
            }
            let comment = commentInput.value.trim();
            let wordCount = comment.split(/\s+/).filter(word => word.length > 0).length;

            if (comment === '') {
                isValid = false;
                commentMessage.innerText = 'Bạn cần bình luận.';
                commentMessage.style.display = 'inline';
            } else if (wordCount < 10) {
                isValid = false;
                commentMessage.innerText = 'Bình luận phải có ít nhất 10 từ.';
                commentMessage.style.display = 'inline';
            } else {
                commentMessage.style.display = 'none';
            }
            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    function resetHover() {
        stars.forEach((star) => star.classList.remove('hover'));
    }

    function resetAllStars() {
        stars.forEach((star) => star.classList.remove('hover', 'active'));
    }

    function setActiveStars(rating) {
        resetAllStars();
        for (let i = 0; i < rating; i++) {
            stars[i].classList.add('active');
        }
    }
    document.addEventListener('DOMContentLoaded', () => {
        const alert = document.getElementById('alert');
        if (alert) {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 4000);
        }
    });
    $(document).on('submit', '#reviewForm', function(e) {
        e.preventDefault();

        const form = $(this);
        const url = form.attr('action');
        const formData = form.serialize();

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    sessionStorage.setItem('notification', JSON.stringify({
                        type: 'success',
                        message: response.message
                    }));
                    location.reload();
                } else {
                    showNotification('error', response.message);
                }
            },
            error: function() {
                showNotification('error', 'Đã xảy ra lỗi trong quá trình xử lý!');
            }
        });
    });

    function showNotification(type, message) {
        const notification = $(`<div class="notification ${type}">${message}</div>`);

        notification.css({
            position: 'fixed',
            top: '20px',
            right: '20px',
            padding: '10px 20px',
            borderRadius: '8px',
            color: '#fff',
            backgroundColor: type === 'success' ? 'green' : 'red',
            zIndex: 1000,
            boxShadow: '0 4px 8px rgba(0, 0, 0, 0.2)',
            opacity: 1,
            transition: 'opacity 0.5s ease-out',
        });

        $('body').append(notification);

        setTimeout(() => {
            notification.fadeOut(500, function() {
                $(this).remove();
            });
        }, 4000);
    }

    $(document).ready(function() {
        const notificationData = sessionStorage.getItem('notification');
        if (notificationData) {
            const {
                type,
                message
            } = JSON.parse(notificationData);
            showNotification(type, message);

            sessionStorage.removeItem('notification');
        }
    });


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
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                .then(response => response.json())
                .then(data => {
                    showNotification(data.status === 'success' ? 'success' : 'error', data.message);

                    if (data.status === 'success') {
                        document.getElementById('header-wishlist-count').textContent = data.wishlist_count;
                    }
                })
                .catch(error => {
                    console.error('Lỗi xảy ra:', error);
                    showNotification('error', 'Có lỗi xảy ra!');
                });

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
                    setTimeout(() => {
                        notification.remove();
                    }, 200);
                }, 2000);
            }
        });
    });
</script>

@endpush