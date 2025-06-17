@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Quản lí sản phẩm</h3>
        <div class="link-wrap">
            <a class="none-a" href="{{route('admin.dashboard')}}">Thống kê </a>
            <p class="rev">></p>
            @if (request()->routeIs('admin.product.index'))
            <span style="color: #333; cursor: not-allowed;">Sản phẩm</span>
            @else
            <a class="none-a2" href="{{route('admin.product.index')}}">Sản phẩm</a>
            @endif
            <p class="rev">></p>
            @if (request()->routeIs('admin.product.edit'))
            <span style="color: #333; cursor: not-allowed;">Sửa</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample3" method="POST"
                        action="{{ route('admin.product.edit', $productUpdate->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Tên sản phẩm
                                @error('name')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ $productUpdate->name }}" type="text" class="form-control" name="name"
                                placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label>Giá tiền
                                @error('price')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ $productUpdate->price }}" type="text" class="form-control"
                                name="price" placeholder="Price">
                        </div>
                        <div class="form-group">
                            <label>Giá niêm yết
                                @error('listed_price')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ $productUpdate->listed_price }}" type="text" class="form-control"
                                placeholder="Listed price" name="listed_price">
                        </div>
                        <div class="form-group">
                            <label>Danh mục
                            </label>
                            <select class="form-control" name="category_id">
                                <option value="" hidden>Chọn danh mục sản phẩm</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{$category->id == $productUpdate->category_id ? 'selected' : ''}}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Giới tính
                                @error('gender')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <select class="form-control" name="gender">
                                <option value="unisex" {{ $productUpdate->gender == 'unisex' ? 'selected' : '' }}>Cặp đôi</option>
                                <option value="male" {{ $productUpdate->gender == 'male' ? 'selected' : '' }}>Nam</option>
                                <option value="female" {{ $productUpdate->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                            </select>
                        </div>
                        <div class="form-group" id="sizes-wrapper">
                            <label>Kích thước (Nhập cách nhau dấu phẩy):
                                @error('sizes')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input type="text" class="form-control" name="sizes" placeholder="Ví dụ: 6, 7, 8 hoặc S, M, L"
                                value="{{ old('sizes', isset($productSizes) ? implode(', ', $productSizes) : '') }}">
                        </div>

                        <div class="form-group">
                            <label>Hình ảnh sản phẩm
                            </label>
                            <input type="file" name="image[]" class="file-upload-default" multiple
                                style="display: none;">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                    placeholder="Tải hình ảnh">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Tải lên</button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Mô tả sản phẩm
                                @error('description')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <textarea class="form-control" id="exampleTextarea1" rows="4" name="description">{{ $productUpdate->description }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Gửi</button>
                       @if($productUpdate->status == 'active')
                        <button class="btn btn-dark" type="button"><a href="{{route('admin.product.index')}}"
                                style="text-decoration: none; color:white;">Quay lại</a></button>
                       @else
                        <button class="btn btn-dark" type="button"><a href="{{route('admin.product.soldOut')}}"
                                style="text-decoration: none; color:white;">Quay lại</a></button>
                       @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection