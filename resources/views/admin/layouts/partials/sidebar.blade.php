<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="{{ route('admin.dashboard') }}"><img src="{{asset('cms/assets/images/LiLi_logo.png')}}"
                alt="logo" style="height:auto;" /></a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle " src="assets/images/faces/face15.jpg" alt="">
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">Name Amin</h5>
                    </div>
                </div>
                <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list"
                    aria-labelledby="profile-dropdown">
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-settings text-primary"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-onepassword  text-info"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-calendar-today text-success"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                        </div>
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <span class="menu-icon">
                    <i class="fa-solid fa-chart-simple"></i>
                </span>
                <span class="menu-title">Thống kê</span>
            </a>
        </li>
        <li class="nav-item menu-items {{ request()->routeIs('admin.category.index')||request()->routeIs('admin.category.detail')||request()->routeIs('admin.category.edit')||request()->routeIs('admin.category.create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.category.index') }}">
                <span class="menu-icon">
                    <i class="fa-solid fa-layer-group"></i>
                </span>
                <span class="menu-title">Danh mục</span>
            </a>
        </li>
        <li class="nav-item menu-items {{ request()->routeIs('admin.product.index')||request()->routeIs('admin.product.detail')||request()->routeIs('admin.product.edit')||request()->routeIs('admin.product.create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.product.index') }}">
                <span class="menu-icon">
                    <i class="fa-solid fa-boxes-packing"></i>
                </span>
                <span class="menu-title">Sản phẩm</span>
            </a>
        </li>
        <li class="nav-item menu-items {{ request()->routeIs('admin.contact.index')||request()->routeIs('admin.contact.detail') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.contact.index') }}">
                <span class="menu-icon">
                    <i class="fa-solid fa-address-book"></i>
                </span>
                <span class="menu-title">Liên hệ</span>
            </a>
        </li>
        <li class="nav-item menu-items {{ request()->routeIs('admin.review.ProductReview') || request()->routeIs('admin.review.detail') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.review.ProductReview') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-file-document-box"></i>
                </span>
                <span class="menu-title">Quản lý đánh giá</span>
            </a>
        </li>
        <li class="nav-item menu-items {{ request()->is('admin/user*') ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="{{ request()->is('admin/user*') ? 'true' : 'false' }}" aria-controls="auth">
                <span class="menu-icon">
                    <i class="fa-solid fa-user"></i>
                </span>
                <span class="menu-title">Quản lý người dùng</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.user.listUser', 'admin.user.listAdmin') ? 'show' : '' }}" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.user.listUser') ? 'active' : '' }}" href="{{ route('admin.user.listUser') }}">
                            Người dùng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.user.listAdmin') ? 'active' : '' }}" href="{{ route('admin.user.listAdmin') }}">
                            Quản trị viên
                        </a>
                    </li>
                </ul>
            </div>

        </li>

    </ul>
</nav>