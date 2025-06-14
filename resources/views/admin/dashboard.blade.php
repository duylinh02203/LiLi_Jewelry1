@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{$productsCount}}</h3>
                                <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div>
                                <img src="{{asset('images/product.png')}}" alt="Sản phẩm" style="width: 50px; height: 50px;">
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Số lượng sản phẩm</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{$usersCount}}</h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <div>
                                <img src="{{asset('images/User_icon_2.png')}}" alt="" style="width: 50px; height: 50px;">
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Số lượng người dùng</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{$ordersCount}}</h3>
                                <p class="text-danger ml-2 mb-0 font-weight-medium"></p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div>
                                <img src="{{asset('images/icon-3.png')}}" alt="Sản phẩm" style="width: 50px; height: 50px;">

                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Số lượng đơn hàng</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{ number_format($totalPrice, 0, ',', '.') }} VNĐ</h3>
                                <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div>
                                <img src="{{asset('images/doanh-thu.png')}}" alt="Sản phẩm" style="width: 50px; height: 50px;">

                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Tổng doanh thu</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    @php
                    $statusMap = [
                    'pending' => 'Chờ xác nhận',
                    'accepted' => 'Đã xác nhận',
                    'shipping' => 'Đang giao hàng',
                    'completed' => 'Đã giao',
                    'cancelled' => 'Đã hủy',
                    ];
                    @endphp
                    <p style="text-align: center;">Thống kê đơn hàng</p>
                    <canvas id="orderStatusChart"
                        width="400"
                        height="400"
                        data-labels='@json($labels)'
                        data-data='@json($data)'>
                    </canvas>
                </div>
            </div>
        </div>
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4 d-flex align-items-center gap-3">
                        <div>
                            <label for="start_date">Từ ngày:</label>
                            <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}">
                        </div>
                        <div>
                            <label for="end_date">Đến ngày:</label>
                            <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Lọc kết quả</button>
                    </form>

                    <div class="d-flex flex-row justify-content-between">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/js/order-chart.js') }}"></script>
@endsection