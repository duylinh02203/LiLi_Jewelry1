@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <style>
        form {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 10px;
            background-color: #2d2d2d;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: white;
        }

        form label {
            font-size: 16px;
            font-weight: 500;
            color: #fff;
        }

        form input[type="month"] {
            padding: 8px 12px;
            border: 1px solid #444;
            border-radius: 4px;
            background-color: #3b3b3b;
            color: #fff;
            font-size: 14px;
        }

        form input[type="month"]::placeholder {
            color: #888;
        }

        form input[type="month"]:focus {
            outline: none;
            border-color: #4a90e2;
            background-color: #333;
        }

        form .doanhthu {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            background-color: #4a90e2;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form .doanhthu:hover {
            background-color: #357ab8;
        }

        form .doanhthu:disabled {
            background-color: #555;
            cursor: not-allowed;
            color: #ccc;
        }
        .shadow:hover{
            background-color: black;
        }
    </style>
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
                                <h3 class="mb-0">{{$categories->count()}}</h3>
                                <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div>
                                <img src="{{asset('images/danh-muc.png')}}" alt="Sản phẩm" style="width: 50px; height: 50px;">

                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Số lượng danh mục</h6>
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
                    <div class="p-4 bg-gray-100 rounded-lg shadow" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="wrap">
                            <h3 class="text-xl font-bold text-gray-800" style="color:#6c7293 !important">Doanh thu hôm nay</h3>
                            <h4 class="text-2xl text-blue-600 font-semibold">
                                {{ number_format($todayRevenue, 0, ',', '.') }} VNĐ
                            </h4>
                        </div>
                        <div>
                            <img src="{{asset('images/doanh-thu.png')}}" alt="Sản phẩm" style="width: 50px; height: 50px;">
                        </div>
                    </div>
                    <div class="p-4 bg-gray-100 rounded-lg shadow" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="wrap">
                            <h3 class="text-xl font-bold text-gray-800" style="color:#6c7293 !important">Tổng doanh thu</h3>
                            <h4 class="text-2xl text-blue-600 font-semibold">
                                {{ number_format($totalPrice, 0, ',', '.') }} VNĐ
                            </h4>
                        </div>
                        <div>
                            <img src="{{asset('images/doanh-thu.png')}}" alt="Sản phẩm" style="width: 50px; height: 50px;">
                        </div>
                    </div>
                    <div class="p-4 bg-gray-100 rounded-lg shadow">
                        <form action="{{ route('admin.dashboard') }}" method="GET" class="mb-4 flex flex-wrap items-center gap-2">
                            <label for="month" class="whitespace-nowrap">Tháng:</label>
                            <input
                                type="month"
                                id="month"
                                name="month"
                                value="{{ request('month', date('Y-m')) }}"
                                placeholder="Chọn tháng"
                                class="flex-1 min-w-[150px] max-w-full border border-gray-300 rounded px-2 py-1">
                            <button type="submit" class="doanhthu px-3 py-1 bg-blue-500 text-white rounded">Xem doanh thu</button>
                        </form>

                        <div class="contai" style="display: flex; justify-content: space-between; align-items: center;">
                            <div class="wrap">
                            <h3 class="text-xl font-bold text-gray-800" style="color:#6c7293 !important">Doanh thu tháng {{ date('m-Y', strtotime($selectedMonth)) }}</h3>
                            <h4 class="text-2xl text-blue-600 font-semibold">
                                {{ number_format($monthlyRevenueTotal, 0, ',', '.') }} VNĐ
                            </h4>
                        </div>
                        <div>
                            <img src="{{asset('images/doanh-thu.png')}}" alt="Sản phẩm" style="width: 50px; height: 50px;">
                        </div>
                        </div>
                    </div>
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