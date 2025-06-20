@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">TẤT CẢ ĐƠN HÀNG</h3>
        <div class="link-wrap">
            <a class="none-a" href="{{ route('admin.dashboard') }}">Thống kê </a>
            <p class="rev">></p>
            @if (request()->routeIs('admin.order.orderAll'))
            <span style="color: #333; cursor: not-allowed;">Đơn hàng đang và đã giao</span>
            @endif
        </div>
        @if ($message = Session::get('success'))
        <div id="alert" class="alert alert-success" style="position: absolute; width: 80.5%;">
            {{ $message }}
        </div>
        @elseif ($message = Session::get('error'))
        <div id="alert" class="alert alert-danger" style="position: absolute; width: 80.5%;">
            {{ $message }}
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="search-add-wrapper"
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div class="card-tools">
                            <div class="input-group input-group search-bar " style="width: 250px;">
                                <form class="nav-link mt-2 mt-md-0 d-lg-flex search"
                                    action="{{ route('admin.order.orderAll') }}" method="GET">
                                    <input type="text" style="padding: 15;" class="form-control" name="search"
                                        value="{{ request()->input('search') }}" placeholder="Tìm kiếm đơn hàng">
                                    <input type="hidden" name="status" value="{{ request('status') }}">
                                </form>
                            </div>
                        </div>
                        <form method="GET" action="{{ route('admin.order.orderAll') }}" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="hidden" style="padding: 15;" class="form-control" name="search"
                                        value="{{ request()->input('search') }}" placeholder="Tìm kiếm đơn hàng">
                                    <select name="status" class="form-select" onchange="this.form.submit()" style="background-color: #cce5ff; padding: 5px; color: #004085; border: none; border-radius: 5px;">
                                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Tất cả trạng thái</option>
                                        @foreach($statusMap as $key => $label)
                                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Email</th>
                                    <th>Hình thức thanh toán</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if (count($orders) > 0)
                                @foreach ($orders as $key => $order)
                                <tr>
                                    <td>JL00{{ $order->id }}</td>
                                    <td>{{ $order->email }}</td>
                                    <td>{{ $order->payment == 'cod' ? 'Thanh toán khi nhận hàng' : 'Thanh toán qua VNPay' }}
                                    </td>
                                    <td>{{ number_format($order->total_price, 0, '.', ',') }} VNĐ</td>
                                    <td style="color: {{ $order->status == 'shipping' ? 'orange' : 'green' }};">
                                        {{ $order->status == 'shipping' ? 'Đang giao...' : ($order->status == 'completed' ? 'Đã giao' : $order->status) }}
                                    </td>


                                    <td>
                                        <div style="display: flex; gap: 8px; justify-content: center;">
                                            <a href="{{ route('admin.order.detail', $order->id) }}">
                                                <button type="button" class="btn btn-primary">Chi tiết</button>
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8" style="text-align: center; color: white;">Không tìm thấy
                                        đơn hàng nào.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pagination-container"
                    style="display: flex; width:100%;justify-content: center; margin-bottom: -10px;">
                    {{ $orders->appends(request()->query())->links('admin.pagination.default') }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        let alert = document.getElementById('alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 500);
        }
    }, 3000);
</script>
@endsection