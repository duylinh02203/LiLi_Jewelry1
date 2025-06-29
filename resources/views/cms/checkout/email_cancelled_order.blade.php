<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hóa đơn mua hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .invoice-container {
            background-color: #fff;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .invoice-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .invoice-header h2 {
            margin: 0;
            color: #333;
        }

        .invoice-details {
            margin-bottom: 20px;
        }

        .invoice-details p {
            margin: 5px 0;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .product-table th {
            background-color: #f2f2f2;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 13px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h2 style="color: red">Đơn hàng của bạn đã được hủy</h2>
        </div>

        <div class="invoice-details">
            <p><strong>Tên khách hàng:</strong> {{ $order->name }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('H:i:s d/m/Y') }}</p>
            <p><strong>Mã đơn hàng:</strong> JL00{{ $order->id }}</p>
        </div>

        <table class="product-table">
            <thead>
                <tr>
                    <th>Mặt hàng</th>
                    <th>SL</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                <tr>
                    <td class="text-start">{{ $item->product->name ?? 'Không có tên' }} @if (!empty($item->size))
                        - Size {{ $item->size }}
                        @endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->product->price ?? 0) }}</td>
                    <td class="fw-bold">{{ number_format(($item->product->price ?? 0) * $item->quantity) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">Tổng tiền: {{ number_format($order->total_price, 0, ',', '.') }} đ</p>

        <div class="footer">
            <p>ShopDemo - Địa chỉ: Vân Nam - Phúc Thọ - Hà Nội</p>
            <p>Hotline: 0123 456 789 | Email: support@shopdemo.vn</p>
        </div>
    </div>
</body>

</html>