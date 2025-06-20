<nav class="navbar p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg"
                alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{ asset('assets/images/9169934.png') }}"
                alt="logo" style="height:auto;" /></a>
    </div>
    <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                    data-toggle="dropdown">
                    @php
                        $contacts = \App\Models\Contact::where('status', 'active')->count();
                        $contactUsers = \App\Models\Contact::where('status', 'active')
                            ->orderBy('created_at', 'desc')
                            ->get();
                        $CountReviews = \App\Models\ProductReview::where('status', 'active')->count();
                        $productReviews = \App\Models\ProductReview::where('status', 'active')
                            ->orderBy('created_at', 'desc')
                            ->get();
                        $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
                        $pendingOrders = \App\Models\Order::with('orderItems.product')
                            ->where('status', 'pending')
                            ->orderBy('created_at', 'desc')
                            ->get();

                        $total = $contacts + $CountReviews + $pendingOrdersCount;
                    @endphp
                    <i class="mdi mdi-bell"></i>
                    <strong><span class="count"
                            style="color:red; margin-top:-7px;">{{ $total }}+</span></strong>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                    aria-labelledby="notificationDropdown">
                    <h6 class="p-3 mb-0">Tất cả thông báo</h6>
                    @if ($total > 0)
                        <div style="max-height: 200px; overflow-y: auto;">
                            @if ($contacts > 0)
                                @foreach ($contactUsers as $contactUser)
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item preview-item"
                                        href="{{ route('admin.contact.detail', $contactUser->id) }}">
                                        <div class="preview-thumbnail">
                                            <div class="preview-icon bg-dark rounded-circle">
                                                <i class="mdi mdi-calendar text-success"></i>
                                            </div>
                                        </div>
                                        <div class="preview-item-content">
                                            <p class="preview-subject mb-1">Liên hệ</p>
                                            <p class="text-muted ellipsis mb-0"> {{ $contactUser->name }} đã gửi liên
                                                hệ !</p>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                            @if ($CountReviews > 0)
                                @foreach ($productReviews as $productReview)
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item preview-item"
                                        href="{{ route('admin.review.detail', $productReview->id) }}">
                                        <div class="preview-thumbnail">
                                            <div class="preview-icon bg-dark rounded-circle">
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="preview-item-content">
                                            <p class="preview-subject mb-1">Đánh giá sản phẩm</p>
                                            <p class="text-muted ellipsis mb-0"> {{ $productReview->user->name }} đã
                                                đánh giá {{ $productReview->product->name }}
                                                {{ $productReview->rating }} !</p>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                            @if ($pendingOrdersCount > 0)
                                @foreach ($pendingOrders as $pendingOrder)
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item preview-item"
                                        href="{{ route('admin.order.detail', $pendingOrder->id) }}">
                                        <div class="preview-thumbnail">
                                            <div class="preview-icon bg-dark rounded-circle">
                                                <i class="fa-solid fa-box"></i>
                                            </div>
                                        </div>
                                        <div class="preview-item-content">
                                            <p class="preview-subject mb-1">{{ $pendingOrder->user->name }} đặt hàng
                                            </p>
                                            <p class="text-muted ellipsis mb-0"> Mã SP: DL00{{ $pendingOrder->id }}
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    @endif

                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                    <div class="navbar-profile">
                        <img class="img-xs rounded-circle" src="{{ asset('assets/images/user.png') }}" alt="">
                        <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ session('userData')->name }}</p>
                        <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                    aria-labelledby="profileDropdown">
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item" href="{{ route('admin.logout') }}">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-logout text-danger"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Đăng xuất</p>
                        </div>
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-format-line-spacing"></span>
        </button>
    </div>
</nav>
