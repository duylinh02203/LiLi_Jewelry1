@extends('cms.layouts.app')
@section('content')
    @push('styles')
        <style>
            .quantity-control {
                display: flex;
                align-items: center;
                border: 1px solid #ccc;
                border-radius: 6px;
                overflow: hidden;
                width: fit-content;
                /* Thêm để chắc chắn không bị bung */
                gap: 4px;
                /* hoặc margin giữa các phần tử */
            }

            .quantity-control button {
                background-color: #f0f0f0;
                border: none;
                padding: 6px 12px;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.2s ease;
                flex-shrink: 0;
                /* tránh button bị co nhỏ */
                height: 36px;
                /* cố định chiều cao */
            }

            .quantity-control input.quantity-input {
                width: 50px;
                text-align: center;
                font-size: 16px;
                border: none;
                outline: none;
                padding: 6px 0;
                height: 36px;
                /* chiều cao bằng button */
                flex-shrink: 0;
            }
        </style>
    @endpush
    <section class="breadcrumb-section section-b-space" style="padding-top:20px;padding-bottom:20px;">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>Giỏ hàng</h3>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">
                                    <i class="fas fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="cart-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="title title1 title-effect mb-1 title-left" style="margin-bottom: 40px !important;">
                    <h2>Giỏ hàng</h2>
                </div>
                <div class="col-md-12 text-center">
                    <table class="table cart-table">
                        <thead>
                            <tr class="table-head">
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Giá tiền</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Kích thước</th>
                                <th scope="col">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($cartItems->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <h4 style="color:#ccc">Không có sản phẩm nào trong giỏ hàng</h4>
                                    </td>
                                </tr>
                            @endif
                            @foreach ($cartItems as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('shop.product.details', ['slug' => $item->product->slug]) }}">
                                            <img src="{{ asset('images/' . $item->product->firstImage?->image) }}"
                                                class="blur-up lazyloaded" alt="">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../product/details.html">{{ $item->product->name }}</a>
                                        <div class="mobile-cart-content row">
                                            <div class="col">
                                                <div class="qty-box">
                                                    <div class="input-group">
                                                        <input type="text" name="quantity"
                                                            class="form-control input-number" value="1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <!-- <h2>$18</h2> -->
                                                <span>$18</span>
                                            </div>
                                            <div class="col">
                                                <h2 class="td-color">
                                                    <a href="javascript:void(0)">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </h2>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{ number_format($item->product->price, 0, ',', '.') }} VNĐ</span>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm justify-content-center"
                                            style="max-width: 120px;">
                                            <button type="button" class="btn btn-outline-secondary qty-decrease"
                                                data-cart-item-id="{{ $item->id }}">−</button>

                                            <input type="text" name="quantity"
                                                class="form-control text-center input-number" value="{{ $item->quantity }}"
                                                data-cart-item-id="{{ $item->id }}" style="max-width: 50px;" />

                                            <button type="button" class="btn btn-outline-secondary qty-increase"
                                                data-cart-item-id="{{ $item->id }}">+</button>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($item->product && $item->product->sizes && $item->product->sizes->count() > 0)
                                            <select class="form-select select-size" data-cart-item-id="{{ $item->id }}">
                                                @foreach ($item->product->sizes as $size)
                                                    <option value="{{ $size->size }}"
                                                        {{ $item->size == $size->size ? 'selected' : '' }}>
                                                        {{ $size->size }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <span>Không có kích thước</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="javascript:void(0)" class="remove-cart-item"
                                            data-cart-item-id="{{ $item->id }}">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12 mt-md-5 mt-4">
                    <div class="row">
                        <div class="col-sm-7 col-5 order-1">
                            <div class="left-side-button text-end d-flex d-block justify-content-end">
                                <a href="javascript:void(0)"
                                    class="text-decoration-underline theme-color d-block text-capitalize remove-all-cart-item">
                                    Xóa tất cả sản phẩm trong giỏ hàng
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-5 col-7">
                            <div class="left-side-button float-start">
                                <a href="{{ route('shop') }}" class="btn btn-solid-default btn fw-bold mb-0 ms-0">
                                    <i class="fas fa-arrow-left"></i> Quay lại cửa hàng</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cart-checkout-section">
                    <div class="row g-4">
                        <div class="col-lg-4 col-sm-6">
                        </div>
                        <div class="col-lg-4 col-sm-6 ">
                        </div>
                        <div class="col-lg-4">
                            <div class="cart-box">
                                <div class="cart-box-details">
                                    <div class="total-details">
                                        <div class="top-details">
                                            <h2>Tổng tiền
                                                <span>{{ number_format($totalPrice, 0, '.', ',') }} VNĐ</span>
                                            </h2>
                                        </div>
                                        @if($totalPrice > 0)
                                        <div class="bottom-details submit-payment">
                                            <a href="{{ route('checkout') }}">Thanh toán</a>
                                        </div>
                                        @else
                                         <div class="bottom-details submit-payment" disabled>
                                            <a href="javascript:void(0)">Thanh toán</a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        //  Popup Confirm 
        function showConfirmPopup(message, onConfirm, onCancel = null) {
            const overlay = document.createElement('div');
            overlay.classList.add('popup-overlay');
            overlay.innerHTML = `
                <div class="popup-box">
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
                if (typeof onCancel === 'function') {
                    onCancel();
                }
                overlay.remove();
            });
        }

        //  Notification 
        function showNotification(type, message) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            Object.assign(notification.style, {
                position: 'fixed',
                top: '20px',
                right: '20px',
                padding: '10px 20px',
                borderRadius: '8px',
                color: 'white',
                backgroundColor: type === 'success' ? 'green' : 'red',
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
            }, 2000);
        }

        //  Remove 1 cart item 
        document.querySelectorAll('.remove-cart-item').forEach((element) => {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                const cartItemId = this.getAttribute('data-cart-item-id');

                showConfirmPopup('Bạn có chắc chắn muốn xoá sản phẩm này khỏi giỏ hàng?', () => {
                    fetch("{{ route('cart.removeCartItem') }}", {
                            method: 'POST',
                            body: JSON.stringify({
                                id: cartItemId
                            }),
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            showNotification(data.status === 'success' ? 'success' :
                                'error',
                                data.message);
                            if (data.status === 'success') location.reload();
                        })
                        .catch(err => {
                            console.error(err);
                            showNotification('error', 'Đã có lỗi xảy ra!');
                        });
                });
            });
        });

        //  Remove all cart items 
        document.querySelector('.remove-all-cart-item')?.addEventListener('click', function(event) {
            event.preventDefault();

            showConfirmPopup('Bạn có chắc chắn muốn xoá toàn bộ sản phẩm trong giỏ hàng?', () => {
                fetch("{{ route('cart.removeAllCartItem') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        showNotification(data.status === 'success' ? 'success' : 'error', data
                            .message);
                        if (data.status === 'success') {
                            location.reload();
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        showNotification('error', 'Đã có lỗi xảy ra!');
                    });
            });
        });

        //  Popup styles 
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

        // update cart item quantity
        function updateCartItemQuantity(cartItemId, quantity) {
            quantity = parseInt(quantity);
            if (isNaN(quantity) || quantity < 0) return;

            if (quantity === 0) return; // Không xử lý tại đây nữa (handled riêng khi nhập = 0)

            fetch("{{ route('cart.updateCart') }}", {
                    method: 'POST',
                    body: JSON.stringify({
                        id: cartItemId,
                        quantity: quantity
                    }),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    showNotification(data.status === 'success' ? 'success' : 'error', data.message);
                    if (data.status === 'success') location.reload();
                })
                .catch(() => showNotification('error', 'Đã có lỗi xảy ra!'));
        }

        // Xử lý nút +
        document.querySelectorAll('.qty-increase').forEach(button => {
            button.addEventListener('click', () => {
                const cartItemId = button.getAttribute('data-cart-item-id');
                const input = document.querySelector(
                    `input[name="quantity"][data-cart-item-id="${cartItemId}"]`);
                let quantity = parseInt(input.value) || 0;
                quantity++;
                input.value = quantity;
                updateCartItemQuantity(cartItemId, quantity);
            });
        });

        // Xử lý nút -
        document.querySelectorAll('.qty-decrease').forEach(button => {
            button.addEventListener('click', () => {
                const cartItemId = button.getAttribute('data-cart-item-id');
                const input = document.querySelector(
                    `input[name="quantity"][data-cart-item-id="${cartItemId}"]`);
                let quantity = parseInt(input.value) || 0;
                const oldValue = quantity;
                quantity--;
                if (quantity <= 0) {
                    input.value = 0;
                    showConfirmPopup('Bạn có chắc chắn muốn xoá sản phẩm này khỏi giỏ hàng?', () => {
                        fetch("{{ route('cart.removeCartItem') }}", {
                                method: 'POST',
                                body: JSON.stringify({
                                    id: cartItemId
                                }),
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute(
                                        'content'),
                                    'Content-Type': 'application/json',
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                showNotification(data.status === 'success' ? 'success' :
                                    'error', data.message);
                                if (data.status === 'success') location.reload();
                            })
                            .catch(() => showNotification('error', 'Đã có lỗi xảy ra!'));
                    }, () => {
                        input.value = oldValue;
                    });
                } else {
                    input.value = quantity;
                    updateCartItemQuantity(cartItemId, quantity);
                }
            });
        });

        // Xử lý nhập số trực tiếp
        document.querySelectorAll('input[name="quantity"]').forEach(input => {
            let oldValue = input.value;

            input.addEventListener('focus', () => {
                oldValue = input.value;
            });

            input.addEventListener('change', () => {
                const cartItemId = input.getAttribute('data-cart-item-id');
                let quantity = parseInt(input.value) || 0;
                if (quantity < 0) quantity = 0;
                input.value = quantity;

                if (quantity === 0) {
                    showConfirmPopup('Bạn có chắc chắn muốn xoá sản phẩm này khỏi giỏ hàng?', () => {
                        fetch("{{ route('cart.removeCartItem') }}", {
                                method: 'POST',
                                body: JSON.stringify({
                                    id: cartItemId
                                }),
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute(
                                        'content'),
                                    'Content-Type': 'application/json',
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                showNotification(data.status === 'success' ? 'success' :
                                    'error', data.message);
                                if (data.status === 'success') location.reload();
                            })
                            .catch(() => showNotification('error', 'Đã có lỗi xảy ra!'));
                    }, () => {
                        input.value = oldValue;
                    });
                } else {
                    updateCartItemQuantity(cartItemId, quantity);
                }
            });
        });

        // Cập nhật size
        document.querySelectorAll('.select-size').forEach(select => {
            select.addEventListener('change', function() {
                const cartItemId = this.getAttribute('data-cart-item-id');
                const newSize = this.value;

                fetch("{{ route('cart.updateCart') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            id: cartItemId,
                            size: newSize
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        showNotification(data.status === 'success' ? 'success' : 'error', data
                            .message);
                        if (data.status === 'success') location.reload();
                    })
                    .catch(() => showNotification('error', 'Đã có lỗi xảy ra khi cập nhật size!'));
            });
        });
    </script>
@endsection
