@extends('cms.layouts.app')
@section('content')
    <section class="pt-0">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="success-icon" style="padding: 10px 0 0 0; background-color:#fff;">
                    <div class="main-container">
                        <div class="check-container">
                            <div class="check-background">
                                <svg viewBox="0 0 65 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 25L27.3077 44L58.5 7" stroke="white" stroke-width="13"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <div class="check-shadow"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8 col-lg-6 p-4">
                    <h5 class="fw-bold">LILI JEWELRY</h5>
                    <p>Liên hệ: 0397326216</p>
                    <h4 class="fw-bold mt-3 mb-3">HÓA ĐƠN BÁN HÀNG</h4>
                    <div class="d-flex justify-content-between" style="font-size: 14px;">
                        <span>Ngày: {{ $orderWithItems->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
                        </span>
                        <span>Mã đơn hàng: DL00{{ $orderWithItems->id }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3" style="font-size: 14px;">
                        <span>Thu ngân: Hệ thống</span>
                        <span>In lúc: {{ date('H:i:s', strtotime($orderWithItems->created_at)) }}</span>
                    </div>
                    <div class="text-start" style="font-size: 15px;">
                        <p><strong>Khách hàng:</strong> {{ $orderWithItems->name }}</p>
                        <p><strong>SĐT :</strong> {{ $orderWithItems->phone }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $orderWithItems->address }}</p>
                        <p><strong>Phương thức thanh toán :</strong>
                            {{ $orderWithItems->payment == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : ($order->payment == 'vnpay' ? 'Thanh toán online qua VNPAY' : 'Hình thức thanh toán không xác định') }}
                        </p>
                        @php
                            $statusText = match ($orderWithItems->status) {
                                'pending' => 'Đang chờ xác nhận',
                                'shipping' => 'Đang giao hàng',
                                'completed' => 'Đã giao',
                                'cancelled' => 'Đã hủy',
                            };
                        @endphp

                        <p><strong>Trạng thái đơn hàng:</strong> {{ $statusText }}</p>
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
                            @foreach ($orderWithItems->orderItems as $item)
                                <tr>
                                    <td class="text-start">{{ $item->product->name ?? 'Không có tên' }} @if (!empty($item->size))
                                            - Size {{ $item->size }}
                                        @endif
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->product->price ?? 0) }}</td>
                                    <td class="fw-bold">{{ number_format(($item->product->price ?? 0) * $item->quantity) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Tổng cộng</td>
                                <td class="fw-bold">{{ number_format($orderWithItems->total_price) }} VNĐ</td>
                            </tr>
                        </tbody>
                    </table>

                    <p class="fw-bold">Xin cảm ơn Quý khách!</p>
                    <a href="{{ route('cart') }}">Quay lại</a>
                </div>
            </div>
        </div>
    </section>
@endsection
