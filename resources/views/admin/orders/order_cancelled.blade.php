@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Đơn hàng đã hủy</h3>
        <nav aria-label="breadcrumb">
        </nav>
        @if ($message = Session::get('success'))
        <div id="alert" class="alert alert-success" style="position: absolute; width: 80%;">
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
                                    action="{{ route('admin.order.orderCancelled') }}" method="GET">
                                    <input type="text" style="padding: 15;" class="form-control" name="search"
                                        value="{{ request()->input('search') }}" placeholder="Tìm kiếm đơn hàng">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Tên người dùng</th>
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
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->email }}</td>
                                    <td>{{ $order->payment == 'cod' ? 'thanh toán khi nhận hàng' : 'thanh toán qua VNPay' }}
                                    </td>
                                    <td>{{ number_format($order->total_price, 0, '.', ',') }} VNĐ</td>
                                    <td>
                                        @if ($order->deleted_at)
                                        <span style="color:red;">Đã hủy</span>
                                        @else
                                        <span>Không rõ</span>
                                        @endif
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