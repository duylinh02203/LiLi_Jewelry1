@extends('cms.layouts.app')
@section('content')
<style>
    h2 {
        text-align: center;
        margin-bottom: 40px;
        margin-top: 40px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
    }

    th,
    td {
        padding: 14px 12px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #f0f0f0;
    }

    tr:hover {
        background-color: #f9f9f9;
    }

    .status {
        padding: 4px 8px;
        border-radius: 4px;
        font-weight: 500;
        display: inline-block;
    }

    /* Màu theo trạng thái */
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-accepted {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .status-shipping {
        background-color: #cce5ff;
        color: #004085;
    }

    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }

    .details-link {
        text-decoration: none;
        color: #007bff;
    }

    .details-link:hover {
        text-decoration: underline;
    }

    .no-orders {
        text-align: center;
        padding: 20px;
        color: #666;
        font-style: italic;
    }
</style>
<h2>Danh sách đơn hàng của bạn</h2>
@if ($allOrders->count() > 0)
<table>
    <thead>
        <tr>
            <th style="padding-left: 40px;">Mã đơn</th>
            <th>Ngày đặt</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Chức năng</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($allOrders as $order)
        <tr>
            <td style="padding-left: 40px;">{{ $order->id }}</td>
            <td>{{ $order->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s')}}</td>
            <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
            @php
            $statusClass = match($order->status) {
            'pending' => 'status-pending',
            'accepted' => 'status-accepted',
            'shipping' => 'status-shipping',
            'completed' => 'status-completed',
            'cancelled' => 'status-cancelled',
            default => '',
            };

            $statusText = match($order->status) {
            'pending' => 'Đang chờ xác nhận',
            'accepted' => 'Đã xác nhận',
            'shipping' => 'Đang giao hàng',
            'completed' => 'Đã giao',
            'cancelled' => 'Đã hủy',
            default => 'Không rõ',
            };
            @endphp

            <td>
                <span class="status {{ $statusClass }}">{{ $statusText }}</span>
            </td>

            <td style="align-items: center;">
                <a href="{{ route('detailOrder', $order->id) }}" class="details-link">Xem</a>

                @if (in_array($order->status, ['pending', 'accepted']))
                <form action="{{ route('cancelOrder') }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <button type="submit" class="btn btn-sm btn-danger" style="border-radius:10px; margin-left:5px;" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                        Hủy
                    </button>
                </form>
                @endif
            </td>

        </tr>
        @endforeach
        {{-- <tr>
                    <td>#123457</td>
                    <td>2025-06-10</td>
                    <td>320.000₫</td>
                    <td><span class="status pending">Chờ xử lý</span></td>
                    <td><a href="/orders/123457" class="details-link">Xem</a></td>
                </tr> --}}
    </tbody>
</table>
@else
<div class="no-orders">Bạn chưa có đơn hàng nào.</div>
@endif
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notification = document.createElement('div');
        notification.innerText = "{{ session('success') }}";

        Object.assign(notification.style, {
            position: 'fixed',
            top: '120px',
            right: '20px',
            padding: '10px 20px',
            borderRadius: '8px',
            color: 'white',
            backgroundColor: 'green',
            zIndex: '1000',
            boxShadow: '0 4px 8px rgba(0, 0, 0, 0.2)',
            opacity: '1',
            transition: 'opacity 0.5s ease-out',
        });

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.remove();
            }, 500);
        }, 3000);
    });
</script>
@endif
@endsection