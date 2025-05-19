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
                                <span>Hình ảnh danh mục:</span><br><br>
                                <img
                                    src="{{ asset('/images/categories/' . ($cat->image ?: 'default.png')) }}"
                                    alt="Hình ảnh danh mục"
                                    style="width: 90%; height: auto; object-fit: cover; border-radius: 5px;">
                            </div>
                            <div class="col-md-6 " style="padding-top: 15px;">
                                <br>
                                <div class="mb-3">
                                    <span>Tên danh mục: </span> {{ $cat->name }}
                                </div>
                                <div class="mb-3">
                                    <span>Thời gian thêm: </span> {{ $cat->created_at }}
                                </div>
                                <div class="mb-3">
                                    <span>Thời gian sửa: </span> {{ $cat->updated_at }}
                                </div>
                                <div class="mb-3">
                                    <span>Slug: </span>{{ $cat->slug }}
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('admin.category.edit', $cat->id) }}" class="btn btn-primary">Chỉnh sửa</a>
                                    <form action="{{ route('admin.category.destroy', $cat->id) }}" method="GET" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                    </form>
                                    <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Quay lại</a>
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