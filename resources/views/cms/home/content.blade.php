@extends('cms.layouts.app')
@section('content')
<style>
    .category-content>h3 {
        color: #ffffff !important
    }

    .description {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .star {
        color: #ccc;
        font-size: 20px;
    }

    .price-sale {
        background-color: #bd1125;
    }

    .price-color {
        color: #767676;
    }
</style>
<div id="carouselExampleCaptions" class="carousel slide col-12" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="cms/assets/images/banner_5.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="cms/assets/images/banner_6.jpg" class="d-block w-100" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<section class="ratio2_1 banner-style-2">
    <div class="container">
        <div class="row gy-4">
            @foreach ($newCategories as $newCat)
            <div class="col-lg-4 col-md-6">
                <form action="{{ route('shop') }}" id="form_cate_{{$newCat->id}}" name="category" method="GET">
                    <input type="hidden" id="category_{{$newCat->id}}" name="category[]" value="{{$newCat->slug}}"
                        {{ (is_array(request('category')) && in_array($newCat->slug, request('category'))) ? 'checked' : '' }}>
                    <div class="collection-banner p-bottom p-center text-center">
                        <a href="shop-left-sidebar.html" class="banner-img cate-click">
                            <img src="{{asset('images/categories/'.($newCat->image) ?? 'default.png')}}" class="bg-img blur-up lazyload" alt="">
                        </a>
                        <div class="banner-detail">
                            <a href="javacript:void(0)" class="heart-wishlist cate-click">
                                <i class="far fa-heart"></i>
                            </a>
                        </div>
                        <a href="javacript:void(0)" class="contain-banner cate-click">
                            <div class="banner-content with-big" style="border-radius: 10px;">
                                <h2 class="mb-2">{{$newCat->name}}</h2>
                                <span>QUÀ TẶNG CHO NGƯỜI THƯƠNG</span>
                            </div>
                        </a>
                    </div>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</section>
<section class="ratio_asos overflow-hidden">
    <div class="container p-sm-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="title-3 text-center">
                    <h2>Sản Phẩm Mới</h2>
                    <h5 class="theme-color">Bộ sưu tập</h5>
                </div>
            </div>
        </div>
        <div class="row g-sm-4 g-3">
            @foreach ($products as $product)
            @php
            $tbRating = \App\Models\ProductReview::where('product_id', $product->id)->avg('rating');
            $tbRating = round($tbRating);
            $countReview = \App\Models\ProductReview::where('product_id', $product->id)->count();
            @endphp
            <div class="col-xl-2 col-lg-2 col-6">
                <div class="product-box">
                    <div class="img-wrapper">
                        <a href="{{ route('shop.product.details', ['slug' => $product->slug]) }}">
                            <img src="{{ asset('images/' . $product->images->first()->image) }}"
                                class="bg-img blur-up lazyload"
                                alt="{{ $product->name }}">
                        </a>
                        <div class="circle-shape"></div>
                        <div class="label-block">
                            <span class="price-sale label label-theme">{{round((($product->listed_price - $product->price)/$product->listed_price) * 100)}} % off</span>
                        </div>
                        <div class="cart-wrap">
                            <ul>
                                <li>
                                    <a href="javascript:void(0)" class="addtocart-btn">
                                        <i data-feather="shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('shop.product.details', ['slug' => $product->slug]) }}">
                                        <i data-feather="eye"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="wishlist wishlistEffect" data-product-id="{{ $product->id }}">
                                        <i data-feather="heart"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-style-3 product-style-chair">
                        <div class="product-title d-block mb-0">
                            <a href="{{ route('shop.product.details', ['slug' => $product->slug]) }}" class="font-default">
                                <h5>{{$product->name}}</h5>
                            </a>
                            <div class="r-price">
                                <div class="theme-color price-color" style="padding-top: 3.5px;">{{$product->price}} VNĐ</div>
                            </div>
                            <div class="main-price" style="display:flex;justify-content: space-between;">
                                <ul class="rating mb-1 mt-0">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $tbRating ? 'theme-color' : '' }} " data-value="1">★</span>
                                        @endfor
                                </ul>
                                <p style="padding-top: 7px;">{{$countReview}} đánh giá</p>
                            </div>

                            <form id="addWishlist" class="wishlist" action="{{route('shop.wishlist.addWishlist')}}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
                            </form>
                            <div id="wishlistMessage-{{ $product->id }}" style="display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="category-section ratio_40">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="title title-2 text-center">
                    <h2>Danh mục của chúng tôi</h2>
                    <h5 class="text-color" style="color:#e87316;">Bộ sưu tập</h5>
                </div>
            </div>
        </div>
        <div class="row gy-3">
            <div class="col-xxl-2 col-lg-3">
                <div class="category-wrap category-padding category-block theme-bg-color">
                    <div>
                        <h2 class="light-text">Top</h2>
                        <h2 class="top-spacing">Danh mục</h2>
                        <span>Hàng đầu</span>
                    </div>
                </div>
            </div>
            <div class="col-xxl-10 col-lg-9">
                <div class="category-wrapper category-slider1 white-arrow category-arrow">
                    @foreach ($categories as $cat)
                    <form action="{{ route('shop') }}" id="form_cate" name="category" method="GET">
                        <input type="hidden" id="category_{{$cat->id}}" name="category[]" value="{{$cat->slug}}"
                            {{ (is_array(request('category')) && in_array($cat->slug, request('category'))) ? 'checked' : '' }}>
                        <div>
                            <a href="javascript:void(0)" class="category-wrap category-padding cate-click" style="border-radius: 10px;">
                                <img src="{{asset('images/categories/'.($cat->image) ?? 'default.png')}}" class="bg-img blur-up lazyload"
                                    alt="category image">
                                <div class="category-content category-text-1">
                                    <h3 class="text-dark" style="color:#333 !important;">{{$cat->name}}</h3>
                                    <span class="text-dark" style="color:#333 !important;">Jewelry</span>
                                </div>
                            </a>
                        </div>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product-slider overflow-hidden">
    <div>
        <div class="container">
            <div class="row g-3">
                <div class="col-lg-4">
                    <div class="title-3 pb-4 title-border">
                        <h2>Most Popular</h2>
                        <h5 class="theme-color">Our Collection</h5>
                    </div>

                    <div class="product-slider round-arrow">
                        <div>
                            <div class="row g-3">
                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="product-image">
                                        <div>
                                            <a href="product/details.html">
                                                <img src="{{ asset('cms/assets/images/furniture-images/product/1.jpg') }}"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </div>
                                        <div class="product-details">
                                            <a href="product/details.html">
                                                <h6 class="font-light">Fully Confirtable</h6>
                                                <h3>Latest wood handle chair 7854</h3>
                                                <h4 class="font-light mt-1"><del>$49.00</del> <span
                                                        class="theme-color">$35.50</span>
                                                </h4>
                                                <div class="cart-wrap">
                                                    <ul>
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Buy">
                                                            <a href="javascript:void(0)" class="addtocart-btn"
                                                                data-bs-toggle="modal" data-bs-target="#addtocart">
                                                                <i data-feather="shopping-cart"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Quick View">
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="wishlist.php" class="wishlist">
                                                                <i data-feather="heart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="product-image">
                                        <a href="product/details.html">
                                            <img src="{{ asset('cms/assets/images/furniture-images/product/2.jpg') }}"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                        <div class="product-details">
                                            <a href="product/details.html">
                                                <h6 class="font-light">Fully Confirtable</h6>
                                                <h3>Latest wood handle chair 7854</h3>
                                                <h4 class="font-light mt-1"><del>$49.00</del> <span
                                                        class="theme-color">$35.50</span>
                                                </h4>
                                                <div class="cart-wrap">
                                                    <ul>
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Buy">
                                                            <a href="javascript:void(0)" class="addtocart-btn"
                                                                data-bs-toggle="modal" data-bs-target="#addtocart">
                                                                <i data-feather="shopping-cart"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Quick View">
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="wishlist.php" class="wishlist">
                                                                <i data-feather="heart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="product-image">
                                        <a href="product/details.html">
                                            <img src="{{ asset('cms/assets/images/furniture-images/product/3.jpg') }}"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                        <div class="product-details">
                                            <a href="product/details.html">
                                                <h6 class="font-light">Fully Confirtable</h6>
                                                <h3>Latest wood handle chair 7854</h3>
                                                <h4 class="font-light mt-1"><del>$49.00</del> <span
                                                        class="theme-color">$35.50</span>
                                                </h4>
                                                <div class="cart-wrap">
                                                    <ul>
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Buy">
                                                            <a href="javascript:void(0)" class="addtocart-btn"
                                                                data-bs-toggle="modal" data-bs-target="#addtocart">
                                                                <i data-feather="shopping-cart"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Quick View">
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="wishlist.php" class="wishlist">
                                                                <i data-feather="heart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="product-image">
                                        <a href="product/details.html">
                                            <img src="{{ asset('cms/assets/images/furniture-images/product/4.jpg') }}"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                        <div class="product-details">
                                            <a href="product/details.html">
                                                <h6 class="font-light">Fully Confirtable</h6>
                                                <h3>Latest wood handle chair 7854</h3>
                                                <h4 class="font-light mt-1"><del>$49.00</del> <span
                                                        class="theme-color">$35.50</span>
                                                </h4>
                                                <div class="cart-wrap">
                                                    <ul>
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Buy">
                                                            <a href="javascript:void(0)" class="addtocart-btn"
                                                                data-bs-toggle="modal" data-bs-target="#addtocart">
                                                                <i data-feather="shopping-cart"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Quick View">
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="wishlist.php" class="wishlist">
                                                                <i data-feather="heart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="title-3 pb-4 title-border">
                        <h2>Recent Popular</h2>
                        <h5 class="theme-color">Our Collection</h5>
                    </div>

                    <div class="product-slider round-arrow">
                        <div>
                            <div class="row g-3">
                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="product-image">
                                        <a href="product/details.html">
                                            <img src="{{ asset('cms/assets/images/furniture-images/product/1.jpg') }}"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                        <div class="product-details">
                                            <a href="product/details.html">
                                                <h6 class="font-light">Fully Confirtable</h6>
                                                <h3>Latest wood handle chair 7854</h3>
                                                <h4 class="font-light mt-1"><del>$49.00</del> <span
                                                        class="theme-color">$35.50</span>
                                                </h4>
                                                <div class="cart-wrap">
                                                    <ul>
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Buy">
                                                            <a href="javascript:void(0)" class="addtocart-btn"
                                                                data-bs-toggle="modal" data-bs-target="#addtocart">
                                                                <i data-feather="shopping-cart"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Quick View">
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="wishlist.php" class="wishlist">
                                                                <i data-feather="heart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="product-image">
                                        <a href="product/details.html">
                                            <img src="{{ asset('cms/assets/images/furniture-images/product/2.jpg') }}"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                        <div class="product-details">
                                            <a href="product/details.html">
                                                <h6 class="font-light">Fully Confirtable</h6>
                                                <h3>Latest wood handle chair 7854</h3>
                                                <h4 class="font-light mt-1"><del>$49.00</del> <span
                                                        class="theme-color">$35.50</span>
                                                </h4>
                                                <div class="cart-wrap">
                                                    <ul>
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Buy">
                                                            <a href="javascript:void(0)" class="addtocart-btn"
                                                                data-bs-toggle="modal" data-bs-target="#addtocart">
                                                                <i data-feather="shopping-cart"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Quick View">
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="wishlist.php" class="wishlist">
                                                                <i data-feather="heart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="product-image">
                                        <a href="product/details.html">
                                            <img src="{{ asset('cms/assets/images/furniture-images/product/3.jpg') }}"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                        <div class="product-details">
                                            <a href="product/details.html">
                                                <h6 class="font-light">Fully Confirtable</h6>
                                                <h3>Latest wood handle chair 7854</h3>
                                                <h4 class="font-light mt-1"><del>$49.00</del> <span
                                                        class="theme-color">$35.50</span>
                                                </h4>
                                                <div class="cart-wrap">
                                                    <ul>
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Buy">
                                                            <a href="javascript:void(0)" class="addtocart-btn"
                                                                data-bs-toggle="modal" data-bs-target="#addtocart">
                                                                <i data-feather="shopping-cart"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Quick View">
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="wishlist.php" class="wishlist">
                                                                <i data-feather="heart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="product-image">
                                        <a href="product/details.html">
                                            <img src="{{ asset('cms/assets/images/furniture-images/product/4.jpg') }}"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                        <div class="product-details">
                                            <a href="product/details.html">
                                                <h6 class="font-light">Fully Confirtable</h6>
                                                <h3>Latest wood handle chair 7854</h3>
                                                <h4 class="font-light mt-1"><del>$49.00</del> <span
                                                        class="theme-color">$35.50</span>
                                                </h4>
                                                <div class="cart-wrap">
                                                    <ul>
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Buy">
                                                            <a href="javascript:void(0)" class="addtocart-btn"
                                                                data-bs-toggle="modal" data-bs-target="#addtocart">
                                                                <i data-feather="shopping-cart"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Quick View">
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="wishlist.php" class="wishlist">
                                                                <i data-feather="heart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="title-3 pb-4 title-border">
                        <h2>Most Popular</h2>
                        <h5 class="theme-color">Our Collection</h5>
                    </div>

                    <div class="product-slider round-arrow">
                        <div>
                            <div class="row g-3">
                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="product-image">
                                        <a href="product/details.html">
                                            <img src="{{ asset('cms/assets/images/furniture-images/product/1.jpg') }}"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                        <div class="product-details">
                                            <a href="product/details.html">
                                                <h6 class="font-light">Fully Confirtable</h6>
                                                <h3>Latest wood handle chair 7854</h3>
                                                <h4 class="font-light mt-1"><del>$49.00</del> <span
                                                        class="theme-color">$35.50</span>
                                                </h4>
                                                <div class="cart-wrap">
                                                    <ul>
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Buy">
                                                            <a href="javascript:void(0)" class="addtocart-btn"
                                                                data-bs-toggle="modal" data-bs-target="#addtocart">
                                                                <i data-feather="shopping-cart"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Quick View">
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="wishlist.php" class="wishlist">
                                                                <i data-feather="heart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="product-image">
                                        <a href="product/details.html">
                                            <img src="{{ asset('cms/assets/images/furniture-images/product/2.jpg') }}"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                        <div class="product-details">
                                            <a href="product/details.html">
                                                <h6 class="font-light">Fully Confirtable</h6>
                                                <h3>Latest wood handle chair 7854</h3>
                                                <h4 class="font-light mt-1"><del>$49.00</del> <span
                                                        class="theme-color">$35.50</span>
                                                </h4>
                                                <div class="cart-wrap">
                                                    <ul>
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Buy">
                                                            <a href="javascript:void(0)" class="addtocart-btn"
                                                                data-bs-toggle="modal" data-bs-target="#addtocart">
                                                                <i data-feather="shopping-cart"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Quick View">
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="wishlist.php" class="wishlist">
                                                                <i data-feather="heart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="product-image">
                                        <a href="product/details.html">
                                            <img src="{{ asset('cms/assets/images/furniture-images/product/3.jpg') }}"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                        <div class="product-details">
                                            <a href="product/details.html">
                                                <h6 class="font-light">Fully Confirtable</h6>
                                                <h3>Latest wood handle chair 7854</h3>
                                                <h4 class="font-light mt-1"><del>$49.00</del> <span
                                                        class="theme-color">$35.50</span>
                                                </h4>
                                                <div class="cart-wrap">
                                                    <ul>
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Buy">
                                                            <a href="javascript:void(0)" class="addtocart-btn"
                                                                data-bs-toggle="modal" data-bs-target="#addtocart">
                                                                <i data-feather="shopping-cart"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Quick View">
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="wishlist.php" class="wishlist">
                                                                <i data-feather="heart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="product-image">
                                        <a href="product/details.html">
                                            <img src="{{ asset('cms/assets/images/furniture-images/product/4.jpg') }}"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                        <div class="product-details">
                                            <a href="product/details.html">
                                                <h6 class="font-light">Fully Confirtable</h6>
                                                <h3>Latest wood handle chair 7854</h3>
                                                <h4 class="font-light mt-1"><del>$49.00</del> <span
                                                        class="theme-color">$35.50</span>
                                                </h4>
                                                <div class="cart-wrap">
                                                    <ul>
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Buy">
                                                            <a href="javascript:void(0)" class="addtocart-btn"
                                                                data-bs-toggle="modal" data-bs-target="#addtocart">
                                                                <i data-feather="shopping-cart"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Quick View">
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="wishlist.php" class="wishlist">
                                                                <i data-feather="heart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </a>
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
<style>
    .products-c .bg-size {
        background-position: center 0 !important;
    }
</style>

<section class="ratio_asos overflow-hidden pb-5">
    <div class="px-0 container-fluid p-sm-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="title-3 text-center">
                    <h2>Fashion Top Deals</h2>
                    <h5 class="theme-color">Our Collection</h5>
                </div>
            </div>

            <div class="our-product products-c">
                <div>
                    <div class="product-box">
                        <div class="img-wrapper">
                            <a href="product/details.html">
                                <img src="{{ asset('cms/assets/images/fashion/product/front/25.jpg') }}"
                                    class="w-100 bg-img blur-up lazyload" alt="">
                            </a>
                            <div class="circle-shape"></div>
                            <span class="background-text">Fashion</span>
                            <div class="label-block">
                                <span class="label label-theme">30% Off</span>
                            </div>
                            <div class="cart-wrap">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)" class="addtocart-btn" data-bs-toggle="modal"
                                            data-bs-target="#addtocart">
                                            <i data-feather="shopping-cart"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#quick-view">
                                            <i data-feather="eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="wishlist.php" class="wishlist">
                                            <i data-feather="heart"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-style-3 product-style-chair">
                            <div class="product-title d-block mb-0">
                                <div class="r-price">
                                    <div class="theme-color">$21</div>
                                    <div class="main-price">
                                        <ul class="rating mb-1 mt-0">
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
                                </div>
                                <p class="font-light mb-sm-2 mb-0">Multicolor Dress</p>
                                <a href="product/details.html" class="font-default">
                                    <h5>Skater Multicolor Dress</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="product-box">
                        <div class="img-wrapper">
                            <a href="product/details.html">
                                <img src="{{ asset('cms/assets/images/fashion/product/front/26.jpg') }}"
                                    class="w-100 bg-img blur-up lazyload" alt="">
                            </a>
                            <div class="circle-shape"></div>
                            <span class="background-text">Fashion</span>
                            <div class="label-block">
                                <span class="label label-theme">30% Off</span>
                            </div>
                            <div class="cart-wrap">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)" class="addtocart-btn" data-bs-toggle="modal"
                                            data-bs-target="#addtocart">
                                            <i data-feather="shopping-cart"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#quick-view">
                                            <i data-feather="eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="wishlist.php" class="wishlist">
                                            <i data-feather="heart"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-style-3 product-style-chair">
                            <div class="product-title d-block mb-0">
                                <div class="r-price">
                                    <div class="theme-color">$21</div>
                                    <div class="main-price">
                                        <ul class="rating mb-1 mt-0">
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
                                </div>
                                <p class="font-light mb-sm-2 mb-0">Multicolor Dress</p>
                                <a href="product/details.html" class="font-default">
                                    <h5>Skater Multicolor Dress</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="product-box">
                        <div class="img-wrapper">
                            <a href="product/details.html">
                                <img src="{{ asset('cms/assets/images/fashion/product/front/27.jpg') }}"
                                    class="w-100 bg-img blur-up lazyload" alt="">
                            </a>
                            <div class="circle-shape"></div>
                            <span class="background-text">Fashion</span>
                            <div class="label-block">
                                <span class="label label-theme">30% Off</span>
                            </div>
                            <div class="cart-wrap">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)" class="addtocart-btn" data-bs-toggle="modal"
                                            data-bs-target="#addtocart">
                                            <i data-feather="shopping-cart"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#quick-view">
                                            <i data-feather="eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="wishlist.php" class="wishlist">
                                            <i data-feather="heart"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-style-3 product-style-chair">
                            <div class="product-title d-block mb-0">
                                <div class="r-price">
                                    <div class="theme-color">$21</div>
                                    <div class="main-price">
                                        <ul class="rating mb-1 mt-0">
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
                                </div>
                                <p class="font-light mb-sm-2 mb-0">Multicolor Dress</p>
                                <a href="product/details.html" class="font-default">
                                    <h5>Skater Multicolor Dress</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="product-box">
                        <div class="img-wrapper">
                            <a href="product/details.html">
                                <img src="{{ asset('cms/assets/images/fashion/product/front/28.jpg') }}"
                                    class="w-100 bg-img blur-up lazyload" alt="">
                            </a>
                            <div class="circle-shape"></div>
                            <span class="background-text">Fashion</span>
                            <div class="label-block">
                                <span class="label label-theme">30% Off</span>
                            </div>
                            <div class="cart-wrap">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)" class="addtocart-btn" data-bs-toggle="modal"
                                            data-bs-target="#addtocart">
                                            <i data-feather="shopping-cart"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#quick-view">
                                            <i data-feather="eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="wishlist.php" class="wishlist">
                                            <i data-feather="heart"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-style-3 product-style-chair">
                            <div class="product-title d-block mb-0">
                                <div class="r-price">
                                    <div class="theme-color">$21</div>
                                    <div class="main-price">
                                        <ul class="rating mb-1 mt-0">
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
                                </div>
                                <p class="font-light mb-sm-2 mb-0">Multicolor Dress</p>
                                <a href="product/details.html" class="font-default">
                                    <h5>Skater Multicolor Dress</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="product-box">
                        <div class="img-wrapper">
                            <a href="product/details.html">
                                <img src="{{ asset('cms/assets/images/fashion/product/front/29.jpg') }}"
                                    class="w-100 bg-img blur-up lazyload" alt="">
                            </a>
                            <div class="circle-shape"></div>
                            <span class="background-text">Fashion</span>
                            <div class="label-block">
                                <span class="label label-theme">30% Off</span>
                            </div>
                            <div class="cart-wrap">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)" class="addtocart-btn" data-bs-toggle="modal"
                                            data-bs-target="#addtocart">
                                            <i data-feather="shopping-cart"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#quick-view">
                                            <i data-feather="eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="wishlist.php" class="wishlist">
                                            <i data-feather="heart"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-style-3 product-style-chair">
                            <div class="product-title d-block mb-0">
                                <div class="r-price">
                                    <div class="theme-color">$21</div>
                                    <div class="main-price">
                                        <ul class="rating mb-1 mt-0">
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
                                </div>
                                <p class="font-light mb-sm-2 mb-0">Multicolor Dress</p>
                                <a href="product/details.html" class="font-default">
                                    <h5>Skater Multicolor Dress</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="product-box">
                        <div class="img-wrapper">
                            <a href="product/details.html">
                                <img src="{{ asset('cms/assets/images/fashion/product/front/30.jpg') }}"
                                    class="w-100 bg-img blur-up lazyload" alt="">
                            </a>
                            <div class="circle-shape"></div>
                            <span class="background-text">Fashion</span>
                            <div class="label-block">
                                <span class="label label-theme">30% Off</span>
                            </div>
                            <div class="cart-wrap">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)" class="addtocart-btn" data-bs-toggle="modal"
                                            data-bs-target="#addtocart">
                                            <i data-feather="shopping-cart"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#quick-view">
                                            <i data-feather="eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="wishlist.php" class="wishlist">
                                            <i data-feather="heart"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-style-3 product-style-chair">
                            <div class="product-title d-block mb-0">
                                <div class="r-price">
                                    <div class="theme-color">$21</div>
                                    <div class="main-price">
                                        <ul class="rating mb-1 mt-0">
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
                                </div>
                                <p class="font-light mb-sm-2 mb-0">Multicolor Dress</p>
                                <a href="product/details.html" class="font-default">
                                    <h5>Skater Multicolor Dress</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="product-box">
                        <div class="img-wrapper">
                            <a href="product/details.html">
                                <img src="{{ asset('cms/assets/images/fashion/product/front/31.jpg') }}"
                                    class="w-100 bg-img blur-up lazyload" alt="">
                            </a>
                            <div class="circle-shape"></div>
                            <span class="background-text">Fashion</span>
                            <div class="label-block">
                                <span class="label label-theme">30% Off</span>
                            </div>
                            <div class="cart-wrap">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)" class="addtocart-btn" data-bs-toggle="modal"
                                            data-bs-target="#addtocart">
                                            <i data-feather="shopping-cart"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#quick-view">
                                            <i data-feather="eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="wishlist.php" class="wishlist">
                                            <i data-feather="heart"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-style-3 product-style-chair">
                            <div class="product-title d-block mb-0">
                                <div class="r-price">
                                    <div class="theme-color">$21</div>
                                    <div class="main-price">
                                        <ul class="rating mb-1 mt-0">
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
                                </div>
                                <p class="font-light mb-sm-2 mb-0">Multicolor Dress</p>
                                <a href="product/details.html" class="font-default">
                                    <h5>Skater Multicolor Dress</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="product-box">
                        <div class="img-wrapper">
                            <a href="product/details.html">
                                <img src="{{ asset('cms/assets/images/fashion/product/front/32.jpg') }}"
                                    class="w-100 bg-img blur-up lazyload" alt="">
                            </a>
                            <div class="circle-shape"></div>
                            <span class="background-text">Fashion</span>
                            <div class="label-block">
                                <span class="label label-theme">30% Off</span>
                            </div>
                            <div class="cart-wrap">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)" class="addtocart-btn" data-bs-toggle="modal"
                                            data-bs-target="#addtocart">
                                            <i data-feather="shopping-cart"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#quick-view">
                                            <i data-feather="eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="wishlist.php" class="wishlist">
                                            <i data-feather="heart"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-style-3 product-style-chair">
                            <div class="product-title d-block mb-0">
                                <div class="r-price">
                                    <div class="theme-color">$21</div>
                                    <div class="main-price">
                                        <ul class="rating mb-1 mt-0">
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
                                </div>
                                <p class="font-light mb-sm-2 mb-0">Multicolor Dress</p>
                                <a href="product/details.html" class="font-default">
                                    <h5>Skater Multicolor Dress</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<div id="qvmodal"></div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const clickableLinks = document.querySelectorAll('a.cate-click');

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

    document.querySelectorAll('.wishlistEffect').forEach((element) => {
        element.addEventListener('click', function(event) {
            event.preventDefault();

            let productId = this.getAttribute('data-product-id');
            let messageDiv = document.getElementById('wishlistMessage-' + productId);

            fetch("{{ route('shop.wishlist.addWishlist') }}", {
                    method: 'POST',
                    body: JSON.stringify({
                        product_id: productId
                    }),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
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
                    }, 500);
                }, 2000);
            }

        });
    });
</script>
@endsection