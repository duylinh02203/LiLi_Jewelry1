@extends('admin.layouts.app')
@section('content')
<style>
    input[readonly] {
        background-color: #2a3038 !important;
        cursor: not-allowed;
    }
</style>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Quản lí tài khoản</h3>
        <div class="link-wrap">
            <a class="none-a" href="{{route('admin.dashboard')}}">Thống kê </a>
            <p class="rev">></p>
            @if (request()->routeIs('admin.user.listUser') && $userUpdate->role == 2)
            <span style="color: #333; cursor: not-allowed;">Người dùng</span>
            @elseif (request()->routeIs('admin.user.listAdmin')&& $userUpdate->role == 1)
            <span style="color: #333; cursor: not-allowed;">Quản trị viên</span>
            @else
            @if ($userUpdate->role == 1)
            <a class="none-a2" href="{{ route('admin.user.listAdmin') }}">Quản trị viên</a>
            @else
            <a class="none-a2" href="{{ route('admin.user.listUser') }}">Người dùng</a>
            @endif
            @endif
            <p class="rev">></p>
            @if (request()->routeIs('admin.user.edit'))
            <span style="color: #333; cursor: not-allowed;">Sửa</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Chỉnh sửa</h4>
                    <form class="forms-sample" method="POST" action="{{ route('admin.user.edit',$userUpdate->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Tên người dùng
                                @error('name')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ $userUpdate->name }}" type="text" class="form-control" name="name"
                                placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label>Email
                                @error('email')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ $userUpdate->email }}" type="email" class="form-control" name="email"
                                placeholder="Địa chủ email" readonly>
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu
                                @error('password')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ $userUpdate->password }}" type="password" class="form-control"
                                placeholder="Mật khẩu" name="password">
                        </div>
                        <div class="form-group">
                            <label>Vai trò
                                @error('role')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <select class="form-control" name="role">
                                <option value="1" {{$userUpdate->role == '1' ? 'selected' : ''}}>Quản trị viên</option>
                                <option value="2" {{$userUpdate->role == '2' ? 'selected' : ''}}>Người dùng</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Chỉnh sửa</button>
                        <button class="btn btn-dark" type="button"><a href="{{ url()->previous() }}" style="text-decoration: none; color:white;">Quay lại</a></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection