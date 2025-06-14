@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Quản lí đơn hàng chưa xác nhận</h3>
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
                                        action="{{ route('admin.order.search') }}" method="GET">
                                        <input type="text" style="padding: 15;" class="form-control" name="search"
                                            value="{{ request()->input('search') }}" placeholder="Tìm kiếm đơn hàng">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <style>
                                /* Căn chỉnh bảng */
                                .table-responsive {
                                    margin: 20px 0;
                                }

                                /* Định dạng nút */
                                .btn {
                                    border: none;
                                    border-radius: 5px;
                                    padding: 5px 10px;
                                    font-size: 14px;
                                    cursor: pointer;
                                    transition: all 0.3s ease;
                                }

                                /* Nút sửa */
                                .btn-edit {
                                    background-color: #4CAF50;
                                    /* Màu xanh lá */
                                    color: white;
                                    margin-right: 5px;
                                }

                                .btn-edit:hover {
                                    background-color: #45a049;
                                }

                                /* Nút xóa */
                                .btn-delete {
                                    background-color: #f44336;
                                    /* Màu đỏ */
                                    color: white;
                                }

                                .btn-delete:hover {
                                    background-color: #d32f2f;
                                }

                                /* Hình ảnh */
                                .table img {
                                    border-radius: 5px;
                                    width: 50px;
                                    height: 50px;
                                    object-fit: cover;
                                }

                                th,
                                td {
                                    text-align: center;
                                    color: white;
                                }
                            </style>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên người dùng</th>
                                        <th>Mã đơn hàng</th>
                                        <th>Email</th>
                                        <th>Hình thức thanh toán</th>
                                        <th>Tổng tiền</th>
                                        <th>Hành động</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($orders) > 0)
                                        @foreach ($orders as $key => $order)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $order->name }}</td>
                                                <td>JL00{{ $order->id }}</td>
                                                <td>{{ $order->email }}</td>
                                                <td>{{ $order->payment == 'cod' ? 'thanh toán khi nhận hàng' : 'thanh toán qua VNPay' }}
                                                </td>
                                                <td>{{ number_format($order->total_price, 0, '.', ',') }} VNĐ</td>
                                                <td>
                                                    <form action="{{ route('admin.order.acceptOrder') }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                        <button class="btn btn-success">Xác nhận</button>
                                                    </form>
                                                </td>
                                                @if ($order->payment == 'cod')
                                                    <td>
                                                        <form action="{{ route('admin.order.cancelOrder') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="order_id"
                                                                value="{{ $order->id }}">
                                                            <button class="btn btn-danger">Hủy</button>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <input style="color: #000" type="button" class="btn btn-secondary"
                                                            value="Hủy" readonly>
                                                    </td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('admin.order.detail', $order->id) }}"><button
                                                            type="button" class="btn btn-primary">Chi
                                                            tiết</button></a>
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
