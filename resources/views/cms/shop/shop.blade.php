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

    .list-unstyled li {
        margin-bottom: 10px;
    }

    .description {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .accordion-button {
        background-color: #fff !important;
        color: #222222;
        border-radius: 5px !important;
        padding-left: 2px !important;
    }

    .star {
        color: #ccc;
        font-size: 20px;
    }
</style>
@endpush
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
                            <a href="{{route('home')}}">
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
<section class="section-b-space">
    <div class="container">
        <div class="row">
            <div class="title title1 title-effect mb-1 title-left" style="margin-bottom: 40px !important;">
                <h2>Cửa hàng</h2>
            </div>
            <div class="col-lg-3 category-side col-md-4">
                <form id="filterForm" method="GET" action="{{ route('shop') }}">

                    <div class="category-option">
                        <div class="button-close mb-3">
                            <button class="btn p-0"><i data-feather="arrow-left"></i> Close</button>
                        </div>
                        <div style="display: flex; align-items: center; padding: 10px; background-color:#e87316; border-radius: 5px; height:44px;justify-content: center;">
                            <i class="fa-solid fa-filter"></i>
                            <h3 style="padding:10px; font-weight:bold;">BỘ LỌC TÌM KIẾM </h3>
                        </div>
                        <div class="accordion category-name" id="accordionExample">
                            <div class="accordion-item category-rating " style="background-color:#fff;">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo">
                                        DANH MỤC
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse show">
                                    <div class="accordion-body category-scroll">
                                        <ul class="category-list">
                                            @foreach ($categories as $category)
                                            <li>
                                                <div class="form-check ps-0 custom-form-check">
                                                    <input class="checkbox_animated check-it"
                                                        id="category_{{$category->id}}"
                                                        name="category[]"
                                                        value="{{$category->slug}}"
                                                        type="checkbox"
                                                        {{ (is_array(request('category')) && in_array($category->slug, request('category'))) ? 'checked' : '' }}>
                                                    <label style="margin-bottom: -3px;" class="form-check-label" for="category_{{$category->slug}}">{{$category->name}}</label>
                                                    <p class="font-light">({{$category->products->count()}})</p>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item category-price" style="background-color: #fff;">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">KHOẢNG GIÁ</button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse show"
                                    aria-labelledby="headingFour">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled" style="display: flex; flex-direction: column; padding-left: 10px;">
                                            <li>
                                                <div class="form-check ps-0 custom-form-check">
                                                    <input class="radio_animated check-it" id="price1" name="price[]" type="radio" value="0,1000000"
                                                        {{ (is_array(request('price')) && in_array('0,1000000', request('price'))) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="price1">Dưới 1.000.000</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 custom-form-check">
                                                    <input class="radio_animated check-it" id="price2" name="price[]" type="radio" value="1000000,2000000"
                                                        {{ (is_array(request('price')) && in_array('1000000,2000000', request('price'))) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="price2">1.000.000 - 2.000.000</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 custom-form-check">
                                                    <input class="radio_animated check-it" id="price3" name="price[]" type="radio" value="2000000,5000000"
                                                        {{ (is_array(request('price')) && in_array('2000000,5000000', request('price'))) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="price3">2.000.000 - 5.000.000</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 custom-form-check">
                                                    <input class="radio_animated check-it" id="price4" name="price[]" type="radio" value="0,6000000"
                                                        {{ (is_array(request('price')) && in_array('0,6000000', request('price'))) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="price4">Tất cả giá</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item category-gender" style="background-color: #fff;">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true">
                                        GIỚI TÍNH
                                    </button>
                                </h2>

                                <div id="collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingFive" style="">
                                    <div class="accordion-body">
                                        <ul class="category-list">
                                            <li>
                                                <div class="form-check ps-0 custom-form-check">
                                                    <input class="checkbox_animated check-it" id="gender1" name="gender[]" type="checkbox" value="male"
                                                        {{ (is_array(request('gender') ?? []) && in_array('male', request('gender') ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="gender1">Nữ</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 custom-form-check">
                                                    <input class="checkbox_animated check-it" id="gender2" name="gender[]" type="checkbox" value="female"
                                                        {{ (is_array(request('gender')) && in_array('female', request('gender'))) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="gender2">Nam</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 custom-form-check">
                                                    <input class="checkbox_animated check-it" id="gender3" name="gender[]" type="checkbox" value="unisex"
                                                        {{ (is_array(request('gender')) && in_array('unisex', request('gender'))) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="gender3">Unisex</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style=" background-color: #e87316; border-radius: 5px; text-align: center;">
                            <a href="{{ route('shop') }}"
                                style="color: black; text-decoration: none; padding: 10px 20px; font-size: 16px; font-weight: bold; display: inline-block; background-color: #e87316; border-radius: 5px; text-align: center;">
                                XÓA BỘ LỌC
                            </a>
                        </div>

                    </div>
            </div>

            <div class="category-product col-lg-9 col-12 ratio_30">

                <div class="row g-4">
                    <div class="col-md-12">
                        <ul class="short-name">
                        </ul>
                    </div>

                    <div class="col-12">
                        <div class="filter-options">
                            <div class="select-options">
                                <div class="mb-4 d-flex gap-2 align-items-center">
                                    <select name="sort" onchange="this.form.submit()" class="form-select w-auto">
                                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                    </select>
                                    <select name="size" onchange="this.form.submit()" class="form-select w-auto">
                                        <option value="5" {{ request('size', 5) == 5 ? 'selected' : '' }}>Hiển thị 5 sản phẩm</option>
                                        <option value="10" {{ request('size') == 10 ? 'selected' : '' }}>Hiển thị 10 sản phẩm</option>
                                        <option value="20" {{ request('size') == 20 ? 'selected' : '' }}>Hiển thị 20 sản phẩm</option>
                                        <option value="50" {{ request('size') == 50 ? 'selected' : '' }}>Hiển thị 50 sản phẩm</option>
                                    </select>
                                </div>

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
                <div class="row g-sm-4 g-3 row-cols-lg-4 row-cols-md-3 row-cols-2 mt-1 custom-gy-5 product-style-2 ratio_asos product-list-section">
                    @if(count($products) > 0)
                    @foreach ($products as $product)
                    @php
                    $tbRating = \App\Models\ProductReview::where('product_id', $product->id)->avg('rating');
                    $tbRating = round($tbRating);
                    $countReview = \App\Models\ProductReview::where('product_id', $product->id)->count();
                    @endphp
                    <div>
                        <div class="product-box">
                            <div class="img-wrapper">
                                <div class="back">
                                    <a href="{{ route('shop.product.details', ['slug' => $product->slug]) }}">
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
                            <div class="product-details">
                                <div class="rating-details">
                                    <span class="font-light grid-content description">{{ $product->category->name }}</span>
                                    <a href="{{ route('shop.product.details', ['slug' => $product->slug]) }}" class="font-default " tabindex="0">
                                        <h5 class="ms-0">{{ $product->name }}</h5>
                                    </a>
                                    <h3 class="theme-color">{{ number_format($product->price, 0, ',', '.') }} VNĐ</h3>
                                    <div style="display:flex; justify-content: space-between;">
                                        <ul class="rating mt-0">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="star {{ $i <= $tbRating ? 'theme-color' : '' }} " data-value="1">★</span>
                                                @endfor
                                        </ul>
                                        <p style="padding-top: 7px; color:#333;">{{$countReview}} đánh giá </p>
                                    </div>
                                </div>
                                <div class="main-price">
                                    <div class="listing-content">
                                        <span class="font-light">{{$product->category->name}}</span>
                                        <p class="font-light">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                                    </div>
                                    <button class="btn listing-content">Add To Cart</button>
                                </div>
                            </div>
                            <form id="addWishlist" class="wishlist" action="{{route('shop.wishlist.addWishlist')}}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
                            </form>
                            <div id="wishlistMessage-{{ $product->id }}" style="display: none;"></div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="col-md-12" style="text-align: center;">
                        <h4>Không có sản phẩm nào.</h4>
                    </div>


                    @endif
                </div>
                {{ $products->links('cms.pagination.default') }}
            </div>
        </div>
    </div>
</section>
<section class="subscribe-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-6">
                <div class="subscribe-details">
                    <h2 class="mb-3">Đăng ký để nhận tin tức mới</h2>
                    <h6 class="font-light">Hãy đăng ký để theo dõi những tin tức mới nhất về các sản phẩm độc đáo và hấp dẫn mà chúng tôi mang đến.</h6>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mt-md-0 mt-3" style="border-radius: 10p;">
                <div class="subsribe-input">
                    <div class="input-group">
                        <input type="text" style="border-radius: 10px 0 0 10px;" class="form-control subscribe-input" placeholder="Địa chỉ Email của bạn">
                        <span class="input-group-text" id="basic-addon4" style="width:47.6px; border-radius:0 10px 10px 0; background-color:#e87316; color:#ffffff"><i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="qvmodal"></div>
@endsection
@push('scripts')
<script>
    document.querySelectorAll('#filterForm input[type="checkbox"]').forEach(input => {
        input.addEventListener('change', () => {
            document.getElementById('filterForm').submit();
        });
    });
    document.querySelectorAll('#filterForm input[type="radio"]').forEach(input => {
        input.addEventListener('change', () => {
            document.getElementById('filterForm').submit();
        });
    });
    // 
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
                    }, 200);
                }, 2000);
            }
        });
    });
</script>
@endpush