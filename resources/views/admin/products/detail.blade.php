@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Chi tiết sản phẩm</h3>
        <nav aria-label="breadcrumb">
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                <span>Hình ảnh sản phẩm:</span><br><br>
                                <img src="{{ asset('/images/' . optional($product->firstImage)->image ?? 'default.png') }}"
                                    alt="Hình ảnh sản phẩm"
                                    style="width: 90%; height: auto; object-fit: cover; border-radius: 5px;">
                            </div>
                            <div class="col-md-6 " style="padding-top: 15px;">
                                <br>
                                <div class="mb-3">
                                    <span>Tên sản phẩm:</span> {{ $product->name }}
                                </div>
                                <div class="mb-3">
                                    <span>Giá bán:</span> {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                </div>
                                <div class="mb-3">
                                    <span>Kích thước:</span>
                                    @if ($product->is_free_size)
                                    Free Size
                                    @else
                                    @foreach ($product->sizes as $mee)
                                    {{ $mee->size }}
                                    @endforeach
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <span>Mô tả sản phẩm:</span> {{ $product->description ?? 'No description available' }}
                                </div>
                                <div class="mb-3">
                                    <span>Số lượng hàng:</span> {{ $product->quantity ?? 'N/A' }}
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-primary">Chỉnh sửa</a>
                                    <form action="{{ route('admin.product.remove', $product->id) }}" method="GET" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                    </form>
                                    <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Quay lại</a>
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