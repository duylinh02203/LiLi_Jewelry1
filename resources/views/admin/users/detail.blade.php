@extends('admin.layouts.app')
@section('content')
<style>
    .mb-6 {
        margin-bottom: 1.5rem;
    }
</style>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Chi tiết {{$user->role === 1 ? 'quản trị viên': 'người dùng'}}</h3>
        <nav aria-label="breadcrumb">
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div>
                        <div class="row">
                            <div class="col-md-12 wrap" style="padding-top: 15px;">
                                <br>
                                <div class="mb-6">
                                    <span>Tên tài khoản: </span> {{ $user->username }}
                                </div>
                                <div class="mb-6">
                                    <span>Địa chỉ Email: </span> {{ $user->email }}
                                </div>
                                <div class="mb-6">
                                    <span>Mật khẩu: </span> {{ $user->password }}
                                </div>
                                <div class="mb-6">
                                    <span>Thời gian tạo: </span>{{ $user->created_at }}
                                </div>
                                <div class="mb-6">
                                    <span>Thời gian chỉnh sửa: </span>{{ $user->updated_at }}
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