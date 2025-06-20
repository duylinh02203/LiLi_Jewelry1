@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">QUẢN LÍ SẢN PHẨM</h3>
            <div class="link-wrap">
                <a class="none-a" href="{{ route('admin.dashboard') }}">Thống kê </a>
                <p class="rev">></p>
                @if (request()->routeIs('admin.product.index'))
                    <span style="color: #333; cursor: not-allowed;">Sản phẩm</span>
                @else
                    <a class="none-a2" href="{{ route('admin.product.index') }}">Sản phẩm</a>
                @endif
                <p class="rev">></p>
                @if (request()->routeIs('admin.product.create'))
                    <span style="color: #333; cursor: not-allowed;">Thêm sản phẩm</span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('admin.product.create') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tên sản phẩm
                                    @error('name')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input value="{{ old('name') }}" type="text" class="form-control" name="name"
                                    placeholder="Tên sản phẩm">
                            </div>
                            <div class="form-group">
                                <label>Giá tiền
                                    @error('price')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input value="{{ old('price') }}" type="text" class="form-control" name="price"
                                    placeholder="Giá tiền sản phẩm">
                            </div>
                            <div class="form-group">
                                <label>Giá niêm yết
                                    @error('listed_price')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input value="{{ old('listed_price') }}" type="text" class="form-control"
                                    name="listed_price" placeholder="Giá niêm yết">
                            </div>
                            <div class="form-group">
                                <label>Danh mục sản phẩm
                                    @error('category_id')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <select class="form-control" name="category_id">
                                    <option value="" hidden>Chọn danh mục sản phẩm</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Giới tính
                                    @error('gender')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <select class="form-control" name="gender">
                                    <option value="male">Nam</option>
                                    <option value="female">Nữ</option>
                                    <option value="unisex">Cặp đôi</option>
                                </select>
                            </div>
                            <div class="form-group" id="sizes-wrapper">
                                <label>Kích thước (Nhập cách nhau dấu phẩy):
                                    @error('sizes')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input type="text" class="form-control" name="sizes"
                                    placeholder="Ví dụ: 6, 7, 8 hoặc S, M, L" value="{{ old('sizes') }}">
                            </div>
                            <div class="form-group">
                                <label>Ảnh sản phẩm
                                    @error('image')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input type="file" name="image[]" class="file-upload-default" multiple
                                    style="display: none;">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled
                                        placeholder="Tải ảnh sản phẩm">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">Tải ảnh</button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Mô tả sản phẩm
                                    @error('description')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <textarea class="form-control" id="exampleTextarea1" rows="4" name="description">{{ old('description') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Thêm</button>
                            <button type="button" class="btn btn-dark" onclick="history.back()">Quay lại</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
