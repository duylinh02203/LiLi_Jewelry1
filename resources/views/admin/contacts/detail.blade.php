@extends('admin.layouts.app')
@section('content')
<style>
    .mb-6{
        margin-bottom: 1.5rem;
    }
    .card-body{
        padding-top:0px !important;
    }
</style>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Chi tiết liên hệ</h3>
        <nav aria-label="breadcrumb">
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div>
                        <div class="row"  >
                            <div class="col-md-12 wrap" style="padding-top: 15px;">
                                <br>
                                <div class="mb-6">
                                    <span>Tên: </span> {{ $contact->first_name }}
                                </div>
                                <div class="mb-6">
                                    <span>Họ: </span> {{ $contact->last_name }}
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