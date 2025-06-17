@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Đơn hàng chưa xác nhận</h3>
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
                                    action="{{ route('admin.order.newOrder') }}" method="GET">
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
                                    <td>{{ $order->payment == 'cod' ? 'Thanh toán khi nhận hàng' : 'Thanh toán qua VNPay' }}
                                    </td>
                                    <td>{{ number_format($order->total_price, 0, '.', ',') }} VNĐ</td>
                                    @php
                                    $statusText = match ($order->status) {
                                    'pending' => 'Đang chờ xác nhận',
                                    'shipping' => 'Đang giao hàng',
                                    'completed' => 'Đã giao',
                                    default => 'Không rõ',
                                    };
                                    @endphp
                                    <td style="color: yellow;">{{ $statusText }}
                                    </td>
                                    <td>
                                        <div style="display: flex; justify-content: center; gap: 8px;">
                                            <form action="{{ route('admin.order.acceptOrder') }}" method="POST" style="display: none;" id="confirm-form-{{ $order->id }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            </form>
                                            <button type="submit" class="btn btn-success confirm-success" data-order-id="{{ $order->id }}">Xác nhận</button>

                                            @if ($order->payment == 'cod')
                                            <form action="{{ route('admin.order.cancelOrder') }}" method="POST" style="display: none;" id="cancelled-form-{{ $order->id }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            </form>
                                            <button type="submit" class="btn btn-sm btn-danger confirm-cancelled" data-order-id="{{ $order->id }}"
                                                style="border-radius:10px; margin-left: 8px;">
                                                Hủy
                                            </button>
                                            @else
                                            <button class="btn btn-secondary" style="color: #000; border-radius:10px; margin-left: 8px;" disabled>Hủy</button>
                                            @endif

                                            <a href="{{ route('admin.order.detail', $order->id) }}">
                                                <button type="button" class="btn btn-primary">Chi tiết</button>
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
   
    //confirm success
    document.querySelectorAll('.confirm-success').forEach((button) => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');

            showConfirmPopup1('Bạn xác nhận đơn hàng ?', () => {
                const form = document.getElementById('confirm-form-' + orderId);
                if (form) form.submit();
            });
        });
    });
    // showConfirmPopup1 the active tab by default
    function showConfirmPopup1(message, onConfirm, onCancel = null) {
        const overlay = document.createElement('div');
        overlay.classList.add('popup-overlay');
        overlay.innerHTML = `
        <div class="popup-box" style="background-color: #f8f9fa; color: black;">
            <p>${message}</p>
            <div class="popup-actions">
                <button class="popup-confirm">Đồng ý</button>
                <button class="popup-cancel">Huỷ</button>
            </div>
        </div>
    `;
        document.body.appendChild(overlay);

        overlay.querySelector('.popup-confirm').addEventListener('click', () => {
            onConfirm();
            overlay.remove();
        });

        overlay.querySelector('.popup-cancel').addEventListener('click', () => {
            if (typeof onCancel === 'function') onCancel();
            overlay.remove();
        });
    }
     //confirm cancelled
    document.querySelectorAll('.confirm-cancelled').forEach((button) => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');

            showConfirmPopup('Bạn xác nhận muốn hủy đơn hàng ?', () => {
                const form = document.getElementById('cancelled-form-' + orderId);
                if (form) form.submit();
            });
        });
    });
    // Show the active tab by default
    function showConfirmPopup(message, onConfirm, onCancel = null) {
        const overlay = document.createElement('div');
        overlay.classList.add('popup-overlay');
        overlay.innerHTML = `
        <div class="popup-box" style="background-color: #f8f9fa; color: black;">
            <p>${message}</p>
            <div class="popup-actions">
                <button class="popup-confirm">Đồng ý</button>
                <button class="popup-cancel">Huỷ</button>
            </div>
        </div>
    `;
        document.body.appendChild(overlay);

        overlay.querySelector('.popup-confirm').addEventListener('click', () => {
            onConfirm();
            overlay.remove();
        });

        overlay.querySelector('.popup-cancel').addEventListener('click', () => {
            if (typeof onCancel === 'function') onCancel();
            overlay.remove();
        });
    }
    const style = document.createElement('style');
    style.textContent = `
            .popup-overlay {
                position: fixed;
                top: 0; left: 0;
                width: 100vw; height: 100vh;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 2000;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .popup-box {
                background: white;
                padding: 20px 30px;
                border-radius: 10px;
                max-width: 400px;
                text-align: center;
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            }
            .popup-box p {
                margin-bottom: 20px;
                font-size: 16px;
            }
            .popup-actions {
                display: flex;
                justify-content: space-around;
            }
            .popup-actions button {
                padding: 8px 16px;
                font-weight: bold;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            .popup-confirm {
                background-color: #d9534f;
                color: white;
            }
            .popup-cancel {
                background-color: #6c757d;
                color: white;
            }
        `;
    document.head.appendChild(style);
</script>
@endsection