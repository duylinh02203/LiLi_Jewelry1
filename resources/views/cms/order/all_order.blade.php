@extends('cms.layouts.app')

@section('content')
<style>
    h2 {
        text-align: center;
        margin-bottom: 40px;
        margin-top: 40px;
    }

    h3 {
        text-align: center;
        margin: 20px 0;
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
        background-color: #007bff;
        color: white !important;
        padding: 6px 12px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        line-height: 1.5;
    }

    .details-link:hover {
        background-color: #0056b3;
    }

    .received-btn {
        background-color: #28a745;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-left: 8px;
        font-size: 14px;
        line-height: 1.5;
    }

    .received-btn:hover {
        background-color: #218838;
    }

    .tab-btn {
        padding: 10px 20px;
        margin: 10px 5px 20px 5px;
        border: none;
        border-radius: 5px;
        background-color: #e0e0e0;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    .tab-btn:hover {
        background-color: #ccc;
    }

    .tab-btn.active {
        background-color: #007bff;
        color: white;
    }

    .no-orders {
        text-align: center;
        padding: 20px;
        color: #666;
        font-style: italic;
    }
</style>

<h2>Danh sách đơn hàng của bạn</h2>

@if ($allOrders->count() > 0 || $allOrdersCancelled->count() > 0)
<div style="text-align: center;">
    <button onclick="showTab('active')" id="tab-active" class="tab-btn active">Đơn hàng đã đặt</button>
    <button onclick="showTab('cancelled')" id="tab-cancelled" class="tab-btn">Đơn hàng đã huỷ</button>
</div>

{{-- Đơn hàng đã đặt --}}
<div id="tab-content-active">
    @if ($allOrders->count() > 0)
    <h3>Đơn hàng đã đặt</h3>
    <table>
        <thead>
            <tr>
                <th style="padding-left: 40px;">Mã đơn</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($allOrders as $order)
            <tr>
                <td style="padding-left: 40px;">JL00{{ $order->id }}</td>
                <td>{{ $order->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}</td>
                <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                <td>
                    <span class="status status-{{ $order->status }}">
                        {{ $order->status == 'pending'
                                            ? 'Đang chờ xác nhận'
                                            : ($order->status == 'shipping'
                                                ? 'Đang giao hàng'
                                                : ($order->status == 'completed'
                                                    ? 'Nhận hàng thành công'
                                                    : ucfirst($order->status))) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('detailOrder', $order->id) }}" class="details-link">Xem</a>

                    @if (in_array($order->status, ['pending', 'accepted']))
                    <form action="{{ route('cancelOrder') }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <button type="submit" class="btn btn-sm btn-danger"
                            style="border-radius:10px; margin-left: 8px;"
                            onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                            Hủy
                        </button>
                    </form>
                    @endif

                    @if ($order->status == 'shipping' )
                    <form action="{{ route('completeOrder') }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <button type="submit" class="received-btn"
                            onclick="return confirm('Bạn xác nhận đã nhận được hàng?')">
                            Đã nhận hàng
                        </button>
                    </form>

                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-orders">Bạn không có đơn hàng nào.</div>
    @endif
</div>

{{-- Đơn hàng đã huỷ --}}
<div id="tab-content-cancelled" style="display: none;">
    @if ($allOrdersCancelled->count() > 0)
    <h3>Đơn hàng đã huỷ</h3>
    <table>
        <thead>
            <tr>
                <th style="padding-left: 40px;">Mã đơn</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($allOrdersCancelled as $order)
            <tr>
                <td style="padding-left: 40px;">JL00{{ $order->id }}</td>
                <td>{{ $order->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}</td>
                <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                <td>
                    <span class="status status-cancelled">Đã huỷ</span>
                </td>
                <td>
                    <a href="{{ route('detailOrder', $order->id) }}" class="details-link">Xem</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-orders">Bạn không có đơn hàng nào đã bị huỷ.</div>
    @endif
</div>
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
<script>
    function showTab(tab) {
        document.getElementById('tab-content-active').style.display = 'none';
        document.getElementById('tab-content-cancelled').style.display = 'none';

        document.getElementById('tab-active').classList.remove('active');
        document.getElementById('tab-cancelled').classList.remove('active');

        document.getElementById('tab-content-' + tab).style.display = 'block';
        document.getElementById('tab-' + tab).classList.add('active');
    }
</script>
@endsection