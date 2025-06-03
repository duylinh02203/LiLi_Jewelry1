@extends('admin.layouts.app')
@section('content')
<style>
    .mb-6 {
        margin-bottom: 1.5rem;
    }

    .card-body {
        padding-top: 0px !important;
    }
</style>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Quản lí liên hệ</h3>
        <div class="link-wrap">
            <a class="none-a" href="{{route('admin.dashboard')}}">Thống kê</a>
            <p class="rev">></p>
            @if (request()->routeIs('admin.category.index'))
            <span style="color: #333; cursor: not-allowed;">Liên hệ</span>
            @else
            <a class="none-a2" href="{{route('admin.contact.index')}}">Liên hệ</a>
            @endif
            <p class="rev">></p>
            @if (request()->routeIs('admin.contact.detail'))
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
                            <div class="col-md-12 wrap" style="padding-top: 15px;">
                                <h3>CHI TIẾT LIÊN HỆ</h3>
                                <br>
                                <div class="mb-6">
                                    <span>Tên người dùng: </span> {{ $contact->name }}
                                </div>
                                <div class="mb-6">
                                    <span>Địa chỉ Email: </span> {{ $contact->email }}
                                </div>
                                <div class="mb-6">
                                    <span>Số điện thoại: </span> {{ $contact->phone }}
                                </div>
                                <div class="mb-6">
                                    <span>Bình luận: </span>{{ $contact->comment }}
                                </div>
                                <div class="mb-6">
                                    <span>Thời gian gửi: </span>{{ $contact->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s') }}
                                </div>

                                <div class="mt-4">
                                    <form action="{{ route('admin.contact.remove', $contact->id) }}" method="GET" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                    </form>
                                    <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary">Quay lại</a>
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