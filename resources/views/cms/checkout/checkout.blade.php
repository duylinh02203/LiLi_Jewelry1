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
                    <h3>Thanh toán</h3>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">
                                    <i class="fas fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Cart Section Start -->
    <section class="section-b-space">
        @if (session('userData'))
            <form action="{{ route('payment.orders') }}" method="POST">
                @csrf
                <div class="container">
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div id="billingAddress" class="row g-4">
                                <h3 class="mb-3 theme-color">Địa chỉ nhận hàng</h3>
                                <div class="col-md-6">

                                    <label for="name" class="form-label">Tên
                                        @error('name')
                                            <span style="color: red; font-size: 14px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ session('userData')['name'] }}" placeholder="Nhập tên của bạn">
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Số điện thoại
                                        @error('phone')
                                            <span style="color: red; font-size: 14px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" class="form-control" name="phone"
                                        placeholder="Nhập số điện thoại" value="">
                                </div>
                                <div class="col-md-12">
                                    <label for="email" class="form-label">Email
                                        @error('email')
                                            <span style="color: red; font-size: 14px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="email" class="form-control" name="email" placeholder="Nhập email"
                                        value="{{ session('userData')['email'] }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="address" class="form-label">Địa chỉ
                                        @error('address')
                                            <span style="color: red; font-size: 14px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <textarea class="form-control" id="address" name="address"></textarea>
                                </div>
                            </div>
                            <hr class="my-lg-5 my-4">

                            <h3 class="mb-3">Phương thức thanh toán</h3>

                            <div class="d-block my-3">
                                <div class="form-check custome-radio-box">
                                    <input class="form-check-input" type="radio" name="payment" checked=""
                                        id="cod" value="cod">
                                    <label class="form-check-label" for="cod">Thanh toán khi nhận hàng</label>
                                </div>
                                <div class="form-check custome-radio-box">
                                    <input class="form-check-input" type="radio" name="payment" id="paypal"
                                        value="vnpay">
                                    <label class="form-check-label" for="paypal">Thanh toán qua VNPay</label>
                                </div>
                            </div>
                            <button class="btn btn-solid-default mt-4">Thanh toán</button>
                        </div>

                        <div class="col-lg-4">
                            <div class="your-cart-box">
                                <h3 class="mb-3 d-flex text-capitalize">Giỏ hàng của bạn
                                </h3>
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed active">
                                        <div class="text-dark">
                                            <h6 class="my-0">Thuế 0%</h6>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex lh-condensed justify-content-between">
                                        <span class="fw-bold">Tổng tiền</span>
                                        <input type="hidden" value="{{ $totalPrice }}" name="total_price">
                                        <strong>{{ number_format($totalPrice, 0, '.', ',') }} VNĐ</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </section>
@endsection
