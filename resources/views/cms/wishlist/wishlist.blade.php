@extends('cms.layouts.app')
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
                <h3>Yêu thích</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Yêu thích</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="wish-list-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="title title1 title-effect mb-1 title-left" style="margin-bottom: 40px !important;">
                <h2>Yêu thích</h2>
            </div>
            <div class="col-sm-12 table-responsive">
                <table class="table cart-table wishlist-table">
                    <thead>
                        <tr class="table-head">
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá tiền</th>
                            <th scope="col">Sẵn có</th>
                            <th scope="col">Hoạt động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($wishlists->count()>0)
                        @foreach($wishlists as $wishlist)

                        <tr>
                            <td>
                                <a href="{{route('shop.product.details',$wishlist->product->slug)}}">
                                    <img src="{{ asset('/images/' . optional($wishlist->product->firstImage)->image ?? 'default.png') }}"
                                        alt="Hình ảnh sản phẩm"
                                        style="width: 80px; height: 100px; object-fit: cover; border-radius: 5px;">
                                </a>
                            </td>
                            <td>
                                <a href="{{route('shop.product.details',$wishlist->product->slug)}}" class="font-light">{{$wishlist->product->name}}</a>
                                <div class="mobile-cart-content row">
                                    <div class="col">
                                        <p>In Stock</p>
                                    </div>
                                    <div class="col">
                                        <p class="fw-bold">$6</p>
                                    </div>
                                    <div class="col">
                                        <h2 class="td-color">
                                            <a href="javascript:void(0)" class="icon">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </h2>
                                        <h2 class="td-color">
                                            <a href="cart.php" class="icon">
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="fw-bold">{{$wishlist->product->price}} VNĐ</p>
                            </td>
                            <td>
                                @if($wishlist->product->quantity > 0)
                                <p>Còn hàng</p>
                                @else
                                <p>Hết hàng</p>
                                @endif
                            </td>
                            <td>

                                <a href="javascript:void(0)" class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <a href="{{route('shop.wishlist.remove',$wishlist->id)}}" class="icon" data-wishlist-id="{{ $wishlist->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="col-12">
                            <td colspan="5" style="text-align: center;">Không có sản phẩm yêu thích nào!</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection