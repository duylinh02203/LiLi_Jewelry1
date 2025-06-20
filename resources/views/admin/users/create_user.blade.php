@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">QUẢN LÍ TÀI KHOẢN</h3>
        <div class="link-wrap">
            <a class="none-a" href="{{route('admin.dashboard')}}">Thống kê </a>
            <p class="rev">></p>
            @if (request()->routeIs('admin.user.index'))
            <span style="color: #333; cursor: not-allowed;">Tài khoản</span>
            @else
            <a class="none-a2" href="{{route('admin.user.listUser')}}">Tài khoản</a>
            @endif
            <p class="rev">></p>
            @if (request()->routeIs('admin.user.create'))
            <span style="color: #333; cursor: not-allowed;">Thêm</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thêm tài khoản</h4>
                    <p class="card-description">Thêm tài khoản</p>
                    <form class="forms-sample" method="POST" action="{{ route('admin.user.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>UserName
                                @error('name')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ old('name') }}" type="text" class="form-control" name="name"
                                placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label>Email
                                @error('email')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ old('email') }}" type="email" class="form-control" name="email"
                                placeholder="Địa chủ email">
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại
                                @error('phone')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ old('phone') }}" type="phone" class="form-control" name="phone"
                                placeholder="Số điện thoại">
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu
                                @error('password')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ old('password') }}" type="password" class="form-control"
                                placeholder="Mật khẩu" name="password">
                        </div>
                        <div class="form-group">
                            <label>Xác nhận mật khẩu
                                @error('confirm_password')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ old('confirm_password') }}" type="password" class="form-control"
                                placeholder="Xác nhận mật khẩu" name="confirm_password">
                        </div>
                        <div class="form-group">
                            <label>Vai trò
                                @error('role')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <select class="form-control" name="role">
                                <option value="1">Quản trị viên</option>
                                <option value="2">Người dùng</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Gửi</button>
                        <button class="btn btn-dark" type="button"><a href="{{ url()->previous() }}" style="text-decoration: none; color:white;">Quay lại</a></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection