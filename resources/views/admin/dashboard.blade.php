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

        .shadow:hover {
            background-color: black;
        }
    </style>
    <div class="row">
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-muted font-weight-normal mb-1">Tổng số sản phẩm</h6>
                        </div>
                        <div>
                            <img src="{{asset('images/product.png')}}" alt="Sản phẩm" style="width: 40px; height: 40px;">
                        </div>
                    </div>
                    <ul class="list-unstyled mb-0" style="font-size: 14px;">

                        <li class="mb-1">
                            <h3>{{ $productsCount}}</h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-muted font-weight-normal mb-1">Tổng người dùng</h6>
                        </div>
                        <div>
                            <img src="{{asset('images/User_icon_2.png')}}" alt="" style="width: 40px; height: 40px;">
                        </div>
                    </div>
                    <ul class="list-unstyled mb-0" style="font-size: 14px;">

                        <li class="mb-1">
                            <h3>{{ $usersCount}}</h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-muted font-weight-normal mb-1">Tổng sản phẩm đã bán</h6>
                        </div>
                        <div>
                            <img src="{{asset('images/icon-3.png')}}" alt="Sản phẩm" style="width: 40px; height: 40px;">
                        </div>
                    </div>
                    <ul class="list-unstyled mb-0" style="font-size: 14px;">

                        <li class="mb-1">
                            <h3>{{ $ordersCount}}</h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-muted font-weight-normal mb-1">Tổng số danh mục sản phẩm</h6>
                        </div>
                        <div>
                            <img src="{{asset('images/danh-muc.png')}}" alt="Sản phẩm" style="width: 40px; height: 40px;">
                        </div>
                    </div>
                    <ul class="list-unstyled mb-0" style="font-size: 14px;">
                        <h3>{{ $categories->count()}}</h3>

                        <li class="mb-1">
                            <ul class="list-unstyled mb-0" style="font-size: 14px;">
                                @foreach($totalCate as $cat)
                                <li class="mb-1">
                                    <i class="mdi mdi-circle-medium text-primary align-middle me-1"></i>
                                    <span>{{ $cat->name }}</span>
                                    <span class="text-muted small">({{ $cat->product_count }} sản phẩm)</span>
                                </li>
                                @endforeach
                            </ul>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-muted font-weight-normal mb-1">Top giảm giá</h6>
                        </div>
                        <div>
                            <img src="{{asset('images/danh-muc.png')}}" alt="Sản phẩm" style="width: 40px; height: 40px;">
                        </div>
                    </div>
                    <ul class="list-unstyled mb-0" style="font-size: 14px;">


                        <li class="mb-1">
                            <ul class="list-unstyled mb-0" style="font-size: 14px;">
                                @foreach($topDiscountProducts as $product)
                                <li class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('images/' . ($product->firstImage->image ?? 'default.jpg')) }}" alt="{{ $product->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; margin-right: 10px;">
                                        <div>
                                            <div>{{ $product->name }}</div>
                                            <div class="text-muted small">Giảm {{ $product->discount_percent }}%</div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-muted font-weight-normal mb-1">Top danh mục bán chạy</h6>
                        </div>
                        <div>
                            <img src="{{asset('images/danh-muc.png')}}" alt="Sản phẩm" style="width: 40px; height: 40px;">
                        </div>
                    </div>
                    <ul class="list-unstyled mb-0" style="font-size: 14px;">
                        @forelse($topCategories as $cat)
                        <li class="mb-1">
                            <i class="mdi mdi-circle-medium text-primary align-middle me-1"></i>
                            <span>{{ $cat->name }}</span>
                            <span class="text-muted small">({{ $cat->total_sold }} đã bán)</span>
                        </li>
                        @empty
                        <li>Chưa có dữ liệu</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h6 class="text-muted font-weight-normal mb-0">Trung bình đánh giá</h6>
                            <h3 class="font-weight-bold mb-0 d-flex align-items-center" style="margin-left: 30px;">
                                {{ $averageRating }}
                                <i class="mdi mdi-star text-warning ms-1"></i>
                                <!-- <i class="fas fa-star-half-alt text-warning ms-1" style="font-size: 12px;"></i> -->
                            </h3>
                        </div>

                    </div>
                    <ul class="list-unstyled mb-0" style="font-size: 14px;">
                        @for ($i = 5; $i >= 1; $i--)
                        <li class="mb-1 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="mdi mdi-star text-warning"></i>
                                {{ $i }} sao
                            </span>
                            <span class="text-muted small">{{ $ratingCounts[$i] ?? 0 }} lượt</span>
                        </li>
                        @endfor
                    </ul>
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