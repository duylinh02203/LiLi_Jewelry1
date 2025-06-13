@extends('cms.layouts.app')
@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 60px 20px;
            /* Tăng margin trên & dưới */
        }

        .container {
            max-width: 1000px;
            /* Tăng chiều rộng container */
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
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
            padding: 4px 10px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: bold;
            color: white;
            display: inline-block;
        }

        .delivered {
            background-color: #28a745;
        }

        .pending {
            background-color: #ffc107;
            color: #333;
        }

        .cancelled {
            background-color: #dc3545;
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
                    <th>Mã đơn</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allOrders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                        <td><span
                                class="status delivered {{ $order->status == 'pending' ? 'pending' : 'delivered' }}">{{ $order->status == 'accepted' ? 'Đã giao' : 'Đang chờ xác nhận' }}</span>
                        </td>
                        <td><a href="/orders/{{ $order->id }}" class="details-link">Xem</a></td>
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
@endsection
