@extends('admin.layouts.app')
@section('content')
<style>
    .mb-6 {
        margin-bottom: 1.5rem;
    }
</style>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Quản lí tài khoản</h3>
        <div class="link-wrap">
            <a class="none-a" href="{{route('admin.dashboard')}}">Thống kê </a>
            <p class="rev">></p>
            @if (request()->routeIs('admin.user.listUser') && $user->role == 2)
            <span style="color: #333; cursor: not-allowed;">Người dùng</span>
            @elseif (request()->routeIs('admin.user.listAdmin')&& $user->role == 1)
            <span style="color: #333; cursor: not-allowed;">Quản trị viên</span>
            @else
            @if ($user->role == 1)
            <a class="none-a2" href="{{ route('admin.user.listAdmin') }}">Quản trị viên</a>
            @else
            <a class="none-a2" href="{{ route('admin.user.listUser') }}">Người dùng</a>
            @endif
            @endif
            <p class="rev">></p>
            @if (request()->routeIs('admin.user.detail'))
            <span style="color: #333; cursor: not-allowed;">Chi tiết</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div>
                        <div class="row">
                            <div class="col-md-12 wrap">
                                <h3>CHI TIẾT {{$user->role === 1 ? 'QUẢN TRỊ VIÊN': 'NGƯỜI DÙNG'}}</h3>
                                <br>
                                <div class="mb-6">
                                    <span>Tên tài khoản: </span> {{ $user->name }}
                                </div>
                                <div class="mb-6">
                                    <span>Địa chỉ Email: </span> {{ $user->email }}
                                </div>
                                <div class="mb-6">
                                    <span>Mật khẩu: </span> {{ $user->password }}
                                </div>
                                <div class="mb-6">
                                    <span>Thời gian tạo: </span>{{ $user->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}
                                </div>
                                <div class="mb-6">
                                    <span>Thời gian chỉnh sửa: </span>{{ $user->updated_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-primary">Chỉnh sửa</a>
                                    <form action="{{ route('admin.user.destroy', $user->id) }}" method="GET" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                    </form>
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Quay lại</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection