@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Quản lí đơn hàng chưa duyệt</h3>
            <nav aria-label="breadcrumb">
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Basic Table</h4>
                        <div class="search-add-wrapper"
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <div class="card-tools">
                                <div class="input-group input-group search-bar " style="width: 250px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
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
                                        <th>Trạng thái</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $order)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->payment == 'cod' ? 'thanh toán khi nhận hàng' : 'thanh toán qua VNPay' }}
                                            </td>
                                            <td>{{ number_format($order->total_price, 0, '.', ',') }} VNĐ </td>
                                            <td style="color: coral">
                                                {{ $order->status == 'pending' ? 'Đang chờ xác nhận' : '' }}
                                            </td>
                                            <td>
                                                <!-- FORM đặt ngoài button -->
                                                <form id="form_accept_order_{{ $order->id }}"
                                                    action="{{ route('admin.order.acceptOrder') }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                </form>

                                                <!-- NÚT đặt bên ngoài form -->
                                                <button type="button" class="btn btn-edit btn-accept-order"
                                                    data-id="{{ $order->id }}">Xác nhận</button>
                                                <button type="button" class="btn btn-delete">Hủy</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.btn-accept-order').forEach(function(button) {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-id');
                const form = document.getElementById('form_accept_order_' + orderId);
                form.submit();
            });
        });
    </script>
@endsection
