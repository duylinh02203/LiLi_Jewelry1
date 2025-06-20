@extends('admin.layouts.app')
@section('content')
<style>
    .mb-6 {
        margin-bottom: 1.5rem;
    }
</style>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">QUẢN LÍ ĐÁNH GIÁ</h3>
        <div class="link-wrap">
            <a class="none-a" href="{{route('admin.dashboard')}}">Thống kê </a>
            <p class="rev">></p>
            @if (request()->routeIs('admin.review.ProductReview'))
            <span style="color: #333; cursor: not-allowed;">Đánh giá</span>
            @else
            <a class="none-a2" href="{{route('admin.review.ProductReview')}}">Đánh giá</a>
            @endif
            <p class="rev">></p>
            @if (request()->routeIs('admin.review.detail'))
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
                                <h3>CHI TIẾT ĐÁNH GIÁ</h3>
                                <br>
                                <div class="mb-6">
                                    <span>Tên sản phẩm: </span> {{ $productReview->product->name }}
                                </div>
                                <div class="mb-6">
                                    <span>Người đánh giá: </span> {{ $productReview->user->name }}
                                </div>
                                <div class="mb-6">
                                    <span>Số sao : </span> {{ $productReview->rating }} sao
                                </div>
                                <div class="mb-6">
                                    <span>Nhận xét: </span>{{ $productReview->comment }}
                                </div>
                                <div class="mb-6">
                                    <span>Thời gian đánh giá: </span>{{$productReview->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s')}}
                                </div>
                                <div class="mt-4">
                                    <form action="{{ route('admin.review.destroy', $productReview->id) }}" method="GET" style="display: inline-block;">
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