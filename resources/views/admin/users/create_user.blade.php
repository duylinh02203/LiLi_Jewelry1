@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Thêm mới </h3>
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
                                @error('username')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ old('username') }}" type="text" class="form-control" name="username"
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
                            <label>Mật khẩu
                                @error('password')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ old('password') }}" type="password" class="form-control"
                                placeholder="Mật khẩu" name="password">
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
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-dark"><a href="{{ url()->previous() }}" style="text-decoration: none; color:white;">Cancel</a></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection