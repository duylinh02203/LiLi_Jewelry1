<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="{{ route('admin.dashboard') }}"><img
                src="{{ asset('cms/assets/images/LiLi_logo.png') }}" alt="logo" /></a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle " src="{{ asset('assets/images/user.png') }}" alt="">
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">{{ session('userData')->name }}</h5>
                    </div>
                </div>
                <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list"
                    aria-labelledby="profile-dropdown">
                    <a href="{{ route('admin.account.information') }}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-account-card-details" style="color:blue"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Thông tin tài khoản</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.account.formChangePass') }}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-onepassword  text-info"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Đổi mật khẩu</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Điều hướng</span>
        </li>
        <li class="nav-item menu-items {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <span class="menu-icon">
                    <i class="fa-solid fa-chart-simple"></i>
                </span>
                <span class="menu-title">Thống kê</span>
            </a>
        </li>
        <li
            class="nav-item menu-items {{ request()->routeIs('admin.category.index') || request()->routeIs('admin.category.detail') || request()->routeIs('admin.category.edit') || request()->routeIs('admin.category.create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.category.index') }}">
                <span class="menu-icon">
                    <i class="fa-solid fa-layer-group"></i>
                </span>
                <span class="menu-title">Danh mục</span>
            </a>
        </li>
        <li class="nav-item menu-items {{ request()->routeIs('admin.product.*') ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic-1"
                aria-expanded="{{ request()->routeIs('admin.product.*') ? 'true' : 'false' }}"
                aria-controls="ui-basic">
                <span class="menu-icon">
                    <i class="fa-solid fa-boxes-packing"></i>
                </span>
                <span class="menu-title">Quản lí sản phẩm</span>
                <i class="menu-arrow"></i>
            </a>

            <div class="collapse {{ request()->routeIs('admin.product.*') ? 'show' : '' }}" id="ui-basic-1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.product.index') ? 'active' : '' }}"
                            href="{{ route('admin.product.index') }}">
                            Sản phẩm còn hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.product.soldOut') ? 'active' : '' }}"
                            href="{{ route('admin.product.soldOut') }}">
                            Sản phẩm đã hết hàng
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li
            class="nav-item menu-items {{ request()->routeIs('admin.review.ProductReview') || request()->routeIs('admin.review.detail') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.review.ProductReview') }}">
                <span class="menu-icon">
                    <i class="fa-solid fa-star"></i>
                </span>
                <span class="menu-title">Đánh giá sản phẩm</span>
            </a>
        </li>
        <li
            class="nav-item menu-items {{ request()->routeIs('admin.contact.index') || request()->routeIs('admin.contact.detail') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.contact.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-playlist-play"></i>
                </span>
                <span class="menu-title">Liên hệ</span>
            </a>
        </li>
        <li class="nav-item menu-items {{ request()->routeIs('admin.order.*') ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic"
                aria-expanded="{{ request()->routeIs('admin.order.*') ? 'true' : 'false' }}" aria-controls="ui-basic">
                <span class="menu-icon">
                    <i class="mdi mdi-file-document-box"></i>
                </span>
                <span class="menu-title">Quản lí đơn hàng</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.order.*') ? 'show' : '' }}" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.order.newOrder') ? 'active' : '' }}"
                            href="{{ route('admin.order.newOrder') }}">
                            Đơn hàng chưa xác nhận
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.order.orderAll') ? 'active' : '' }}"
                            href="{{ route('admin.order.orderAll') }}">
                            Tất cả đơn hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.order.orderCancelled') ? 'active' : '' }}"
                            href="{{ route('admin.order.orderCancelled') }}">
                            Đơn hàng đã bị hủy
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items {{ request()->is('admin/user*') ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#auth"
                aria-expanded="{{ request()->is('admin/user*') ? 'true' : 'false' }}" aria-controls="auth">
                <span class="menu-icon">
                    <i class="fa-solid fa-user"></i>
                </span>
                <span class="menu-title">Quản lý tài khoản</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.user.listUser', 'admin.user.listAdmin') ? 'show' : '' }}"
                id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item "> <a
                            class="nav-link {{ request()->routeIs('admin.user.listUser') ? 'active' : '' }}"
                            href="{{ route('admin.user.listUser') }}"> Người
                            dùng </a></li>
                    <li class="nav-item "> <a class="nav-link" href="{{ route('admin.user.listAdmin') }}"> Quản
                            trị viên </a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
