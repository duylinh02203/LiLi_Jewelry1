@extends('admin.layouts.app')
@section('content')
    <style>
        .mb-6 {
            margin-bottom: 1.5rem;
        }
    </style>
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">THÔNG TIN ĐƠN HÀNG</h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div style="text-align: center;">
                            <h5><strong>THÔNG TIN ĐƠN HÀNG</strong></h5>
                        </div>

                        <div style="display: flex; justify-content: space-between;">
                            <div>
                                <p><strong>Ngày:</strong> {{ now()->format('d/m/Y') }}</p>
                                <p><strong>Khách hàng:</strong> {{ $order->user->name }}</p>
                                <p><strong>SĐT:</strong> {{ $order->phone }}</p>
                                <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                                <p><strong>Phương thức thanh toán :</strong>
                                    {{ $order->payment == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản' }}
                                </p>
                                @php
                                    $statusText = match ($order->status) {
                                        'pending' => 'Đang chờ xác nhận',
                                        'shipping' => 'Đang giao hàng',
                                        'completed' => 'Đã giao',
                                        default => 'Không rõ',
                                    };
                                @endphp
                                @if ($order->deleted_at)
                                    <p><strong>Trạng thái đơn hàng:</strong> <span style="color: red"> Đã hủy bởi
                                            {{ $userCancel->name }} ({{ $userCancel->role == 1 ? 'admin' : 'user' }})
                                        </span></p>
                                @else
                                    <p><strong>Trạng thái đơn hàng:</strong> {{ $statusText }}</p>
                                @endif
                                @if ($order->status == 'pending')
                                    <form action="{{ route('admin.order.acceptOrder') }}" method="POST"
                                        id="confirm-form-{{ $order->id }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <button type="submit" class="btn btn-success">Xác nhận đơn
                                            hàng</button>
                                    </form>
                                    <form action="{{ route('admin.order.cancelOrder') }}" method="POST"
                                        id="cancelled-form-{{ $order->id }}" style="margin-top: 20px">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hủy đơn hàng
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div>
                                <p><strong>Mã đơn hàng:</strong> JL00{{ $order->id }}</p>
                                <p><strong>In lúc:</strong>
                                    {{ $order->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('H:i:s') }}</p>
                            </div>
                        </div>

                        <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color:rgb(227, 184, 65); text-align: center;">
                                    <th style="border: 1px solid #ccc; padding: 8px;">Mặt hàng</th>
                                    <th style="border: 1px solid #ccc; padding: 8px;">SL</th>
                                    <th style="border: 1px solid #ccc; padding: 8px;">Đơn giá</th>
                                    <th style="border: 1px solid #ccc; padding: 8px;">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr style="text-align: center;">
                                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $item->product->name }}
                                            @if (!empty($item->size))
                                                - Size {{ $item->size }}
                                            @endif
                                        </td>
                                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $item->quantity }}</td>
                                        <td style="border: 1px solid #ccc; padding: 8px;">
                                            {{ number_format($item->product->price, 0, ',', '.') }}
                                        </td>
                                        <td style="border: 1px solid #ccc; padding: 8px;">
                                            {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach

                                <tr style="text-align: center; font-weight: bold;">
                                    <td colspan="3" style="border: 1px solid #ccc; padding: 8px;">Tổng cộng</td>
                                    <td style="border: 1px solid #ccc; padding: 8px;">
                                        {{ number_format($order->total_price, 0, ',', '.') }} VNĐ
                                    </td>
                                </tr>
                            </tbody>

                        </table>

                        <p style="margin-top: 30px; text-align: center; font-weight: bold;">Xin cảm ơn Quý khách!</p>
                        <div style="text-align: center; margin-top: 10px;">
                            <a href="{{ url()->previous() }}" style="color: coral; text-decoration: underline;">Quay
                                lại</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
