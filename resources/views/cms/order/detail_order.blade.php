@extends('cms.layouts.app')
@section('content')
<section class="pt-0">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-12 col-md-8 col-lg-6 p-4">
                <h5 class="fw-bold">LILI JEWELRY</h5>
                <p>Liên hệ: 0397326216</p>
                <h4 class="fw-bold mt-3 mb-3">THÔNG TIN ĐƠN HÀNG</h4>
                <div class="d-flex justify-content-between" style="font-size: 14px;">
                    <span>Ngày: {{ $order->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
                    </span>
                </div>
                <div class="d-flex justify-content-between mb-3" style="font-size: 14px;">
                    <span>Mã đơn hàng: JL00{{ $order->id }}</span>
                    <span>In lúc: {{ $order->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('H:i:s') }}
                    </span>
                </div>
                <div class="text-start" style="font-size: 15px;">
                    <p><strong>Khách hàng:</strong> {{ $order->name }}</p>
                    <p><strong>SĐT :</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ Email :</strong> {{ $order->email }}</p>
                    <p><strong>Địa chỉ nhận hàng :</strong> {{ $order->address }}</p>
                    <p><strong>Phương thức thanh toán :</strong>
                        {{ $order->payment == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : ($order->payment == 'vnpay' ? 'Thanh toán online qua VNPAY' : 'Hình thức thanh toán không xác định') }}
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
                            {{ $userCancel->name }} ({{ $userCancel->role == 1 ? 'admin' : 'user' }})</span></p>
                    @else
                    <p><strong>Trạng thái đơn hàng:</strong> {{ $statusText }}</p>
                    @endif

                </div>
                <table class="table table-bordered table-sm mt-3" style="font-size: 14px;">
                    <thead class="table-warning text-center">
                        <tr>
                            <th>Mặt hàng</th>
                            <th>SL</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($order->orderItems as $item)
                        <tr>
                            <td class="text-start">{{ $item->product->name ?? 'Không có tên' }} @if (!empty($item->size))
                                - Size {{ $item->size }}
                                @endif
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->product->price ?? 0,0, ',', '.') }} đ</td>
                            <td class="fw-bold">
                                {{ number_format(($item->product->price ?? 0) * $item->quantity, 0, ',', '.') }} đ
                            </td>

                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Tổng cộng</td>
                            <td class="fw-bold">{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                        </tr>
                    </tbody>
                </table>

                <p class="fw-bold">Xin cảm ơn Quý khách!</p>
                <a href="{{ route('allOrders') }}">Quay lại</a>
            </div>
        </div>
    </div>
</section>
@endsection