@extends('cms.layouts.app')
@section('content')
@push('styles')
<style>
    .category-price ul li a {
        display: block;
        padding: 5px 0;
        color: #000;
        text-decoration: none;
    }

    .category-price ul li a:hover {
        color: orange;
    }
</style>
@endpush
<!-- breadcrumb section start -->
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
                <h3>Shop</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.htm">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Shop</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- Shop Section start -->
<section class="section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 category-side col-md-4">
                <div class="category-option">
                    <div class="button-close mb-3">
                        <button class="btn p-0"><i data-feather="arrow-left"></i> Close</button>
                    </div>
                    <div class="accordion category-name" id="accordionExample">

                        <div class="accordion-item category-rating">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix">
                                    Category
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse show"
                                aria-labelledby="headingOne">
                                <div class="accordion-body category-scroll">
                                    <!-- <ul class="category-list">
                                        
                                        <li>
                                            <div class="form-check ps-0 custome-form-check">
                                                <label class="form-check-label">Qui Ut</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check ps-0 custome-form-check">
                                                <label class="form-check-label">Qui Ut</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check ps-0 custome-form-check">
                                                <label class="form-check-label">Qui Ut</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check ps-0 custome-form-check">
                                                <label class="form-check-label">Qui Ut</label>
                                            </div>
                                        </li>
                                    </ul> -->
                                    <ul class="category-list">
                                        @forelse ($categories as $category)
                                        <li>
                                            <div class="form-check ps-0 custome-form-check">
                                                <input class="checkbox_animated check-it"
                                                    id="category-{{ $category->id }}"
                                                    name="categories[]"
                                                    type="checkbox"
                                                    value="{{ $category->id }}">
                                                <label class="form-check-label" for="category-{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                        </li>
                                        @empty
                                        <li>Không có danh mục nào</li>
                                        @endforelse
                                    </ul>

                                </div>
                                <!-- <li>
                                    <div class="form-check ps-0 custome-form-check">
                                        <input class="checkbox_animated check-it" id="ct2" name="categories"
                                            type="checkbox" value="2">
                                        <label class="form-check-label">Blanditiis Error</label>
                                        <p class="font-light">(8)</p>
                                    </div>
                                </li> -->
                            </div>
                        </div>

                        <div class="accordion-item category-price">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour">KHOẢNG GIÁ</button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse show"
                                aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul class="list-unstyled" style="display: flex; flex-direction: column;">
                                        <li>
                                            <a href="{{ request()->fullUrlWithQuery(['prange' => '0,1000000']) }}"
                                                class="{{ ($from == 0 && $to == 1000000) ? 'fw-bold text-primary' : '' }}">
                                                Dưới 1.000.000
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ request()->fullUrlWithQuery(['prange' => '1000000,2000000']) }}"
                                                class="{{ ($from == 1000000 && $to == 1500000 ) ? 'fw-bold text-primary' : '' }}">
                                                1.000.000 - 2.000.000
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ request()->fullUrlWithQuery(['prange' => '3000000,5000000']) }}"
                                                class="{{ ($from == 3000000 && $to == 5000000) ? 'fw-bold text-primary' : '' }}">
                                                2.000.000 - 5.000.000
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ request()->fullUrlWithQuery(['prange' => '5000000,500000000']) }}"
                                                class="{{ ($from == 5000000) ? 'fw-bold text-primary' : '' }}">
                                                Trên 5.000.000
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSeven">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSeven">
                                    Discount Range
                                </button>
                            </h2>
                            <div id="collapseSeven" class="accordion-collapse collapse show"
                                aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul class="category-list">
                                        <li>
                                            <div class="form-check ps-0 custome-form-check">
                                                <input class="checkbox_animated check-it" type="checkbox"
                                                    id="flexCheckDefault19">
                                                <label class="form-check-label" for="flexCheckDefault19">5% and
                                                    above</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check ps-0 custome-form-check">
                                                <input class="checkbox_animated check-it" type="checkbox"
                                                    id="flexCheckDefault20">
                                                <label class="form-check-label" for="flexCheckDefault20">10% and
                                                    above</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check ps-0 custome-form-check">
                                                <input class="checkbox_animated check-it" type="checkbox"
                                                    id="flexCheckDefault21">
                                                <label class="form-check-label" for="flexCheckDefault21">20% and
                                                    above</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="category-product col-lg-9 col-12 ratio_30">

                <div class="row g-4">
                    <!-- label and featured section -->
                    <div class="col-md-12">
                        <ul class="short-name">


                        </ul>
                    </div>

                    <div class="col-12">
                        <div class="filter-options">
                            <div class="select-options">
                                <form method="GET" action="{{ route('shop') }}" class="mb-4 d-flex gap-2 align-items-center">
                                    @if(request()->has('prange'))
                                    <input type="hidden" name="prange" value="{{ request('prange') }}">
                                    @endif
                                    <select name="sort" onchange="this.form.submit()" class="form-select w-auto">
                                        <option value="">-- Sắp xếp --</option>
                                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                    </select>
                                    <select name="size" onchange="this.form.submit()" class="form-select w-auto">
                                        <option value="5" {{ request('size', 5) == 5 ? 'selected' : '' }}>Hiển thị 5</option>
                                        <option value="10" {{ request('size') == 10 ? 'selected' : '' }}>Hiển thị 10</option>
                                        <option value="20" {{ request('size') == 20 ? 'selected' : '' }}>Hiển thị 20</option>
                                        <option value="50" {{ request('size') == 50 ? 'selected' : '' }}>Hiển thị 50</option>
                                    </select>
                                </form>

                            </div>
                            <div class="grid-options d-sm-inline-block d-none">
                                <ul class="d-flex">
                                    <li class="two-grid">
                                        <a href="javascript:void(0)">
                                            <img src="{{asset('cms/assets/svg/grid-2.svg')}}" class="img-fluid blur-up lazyload"
                                                alt="">
                                        </a>
                                    </li>
                                    <li class="three-grid d-md-inline-block d-none">
                                        <a href="javascript:void(0)">
                                            <img src="{{asset('cms/assets/svg/grid-3.svg')}}" class="img-fluid blur-up lazyload"
                                                alt="">
                                        </a>
                                    </li>
                                    <li class="grid-btn active d-lg-inline-block d-none">
                                        <a href="javascript:void(0)">
                                            <img src="{{asset('cms/assets/svg/grid.svg')}}" class="img-fluid blur-up lazyload"
                                                alt="">
                                        </a>
                                    </li>
                                    <li class="list-btn">
                                        <a href="javascript:void(0)">
                                            <img src="{{asset('cms/assets/svg/list.svg')}}" class="img-fluid blur-up lazyload"
                                                alt="">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- label and featured section -->

                <!-- Prodcut setion -->
                <!-- <div class="row g-sm-4 g-3 row-cols-lg-4 row-cols-md-3 row-cols-2 mt-1 custom-gy-5 product-style-2 ratio_asos product-list-section">
                    <div>
                        <div class="product-box">
                            <div class="img-wrapper">
                                <div class="back">
                                    <a href="#">
                                        <img src="{{asset('cms/assets/images/fashion/product/back/12.jpg')}}"
                                            class="bg-img blur-up lazyload" alt="">
                                    </a>
                                </div>
                                <div class="cart-wrap">
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)" class="addtocart-btn">
                                                <i data-feather="shopping-cart"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
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
                                    <span class="font-light grid-content">Cupiditate Minus</span>
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
                                    <a href="product/nihil-beatae-sit-sed.html" class="font-default">
                                        <h5 class="ms-0">Nihil Beatae Sit Sed</h5>
                                    </a>
                                    <div class="listing-content">
                                        <span class="font-light">Cupiditate Minus</span>
                                        <p class="font-light">Aut et dolores ipsam dolores aspernatur. Id nostrum
                                            itaque maxime ea at inventore nam. Repudiandae dolor recusandae sint
                                            magnam praesentium.</p>
                                    </div>
                                    <h3 class="theme-color">$19</h3>
                                    <button class="btn listing-content">Add To Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="row g-sm-4 g-3 row-cols-lg-4 row-cols-md-3 row-cols-2 mt-1 custom-gy-5 product-style-2 ratio_asos product-list-section">
                    @foreach ($products as $product)
                    <div>
                        <div class="product-box">
                            <div class="img-wrapper">
                                <div class="back">
                                    <a href="{{ route('shop.product.details', ['id' => $product->id]) }}">
                                        @if ($product->images->first())
                                        <img src="{{ asset('images/' . $product->images->first()->image) }}"
                                            class="bg-img blur-up lazyload"
                                            alt="{{ $product->name }}">
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
                                            <a href="javascript:void(0)" class="addtocart-btn">
                                                <i data-feather="shopping-cart"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
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
                                    <span class="font-light grid-content">{{ $product->name }}</span>
                                    <ul class="rating mt-0">
                                        <li><i class="fas fa-star theme-color"></i></li>
                                        <li><i class="fas fa-star theme-color"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                    </ul>
                                </div>
                                <div class="main-price">
                                    <a href="{{ route('shop.product.details', ['id' => $product->id]) }}" class="font-default">
                                        <h5 class="ms-0">{{ $product->name }}</h5>
                                    </a>
                                    <div class="listing-content">
                                        <span class="font-light">{{ $product->name }}</span>
                                        <p class="font-light">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                                    </div>
                                    <h3 class="theme-color">{{ number_format($product->price, 0, ',', '.') }} VNĐ</h3>
                                    <button class="btn listing-content">Add To Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{ $products->links('cms.pagination.default') }}
            </div>
        </div>
    </div>
</section>
<!-- Shop Section end -->
<!-- Subscribe Section Start -->
<section class="subscribe-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-6">
                <div class="subscribe-details">
                    <h2 class="mb-3">Subscribe Our News</h2>
                    <h6 class="font-light">Subscribe and receive our newsletters to follow the news about our fresh
                        and fantastic Products.</h6>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mt-md-0 mt-3">
                <div class="subsribe-input">
                    <div class="input-group">
                        <input type="text" class="form-control subscribe-input" placeholder="Your Email Address">
                        <button class="btn btn-solid-default" type="button">Button</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Subscribe Section End -->
<div id="qvmodal"></div>
@endsection