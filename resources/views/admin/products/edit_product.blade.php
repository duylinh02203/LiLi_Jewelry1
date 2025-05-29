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
                            <label>Name
                                @error('name')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ $productUpdate->name }}" type="text" class="form-control" name="name"
                                placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label>Price
                                @error('price')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ $productUpdate->price }}" type="text" class="form-control"
                                name="price" placeholder="Price">
                        </div>
                        <div class="form-group">
                            <label>Listed price
                                @error('listed_price')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input value="{{ $productUpdate->listed_price }}" type="text" class="form-control"
                                placeholder="Listed price" name="listed_price">
                        </div>
                        <div class="form-group">
                            <label>Category
                            </label>
                            <select class="form-control" name="category_id">
                                <option value="" hidden>Chọn danh mục sản phẩm</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{$category->id == $productUpdate->category_id ? 'selected' : ''}}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Gender
                                @error('gender')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <select class="form-control" name="gender">
                                <option value="unisex" {{ $productUpdate->gender == 'unisex' ? 'selected' : '' }}>Unisex</option>
                                <option value="male" {{ $productUpdate->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $productUpdate->gender == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="margin-bottom:0px !important;">Có Freesize?</label>
                            <input style="margin-top: -10px !important;" type="checkbox" name="is_free_size" id="is_free_size" value="1"
                                {{ $productUpdate->is_free_size == 1 ? 'checked' : '' }}>
                        </div>
                        <div class="form-group" id="sizes-wrapper" style="display: none;">
                            <label>Kích thước (Nhập cách nhau dấu phẩy):
                                @error('sizes')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input type="text" class="form-control" name="sizes" placeholder="Ví dụ: 6, 7, 8 hoặc S, M, L"
                                value="{{ old('sizes', isset($productSizes) ? implode(', ', $productSizes) : '') }}">
                        </div>

                        <div class="form-group">
                            <label>Images
                            </label>
                            <input type="file" name="image[]" class="file-upload-default" multiple
                                style="display: none;">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                    placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="text" class="form-control" placeholder="Quantity" name="quantity"
                                value="{{ $productUpdate->quantity }}">
                        </div>
                        <div class="form-group">
                            <label>Description
                                @error('description')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <textarea class="form-control" id="exampleTextarea1" rows="4" name="description">{{ $productUpdate->description }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-dark" type="button"><a href="{{ url()->previous() }}"
                                style="text-decoration: none; color:white;">Cancel</a></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const isFreeSizeCheckbox = document.getElementById('is_free_size');
    const sizesWrapper = document.getElementById('sizes-wrapper');

    function toggleSizesInput() {
        if (isFreeSizeCheckbox.checked) {
            sizesWrapper.style.display = 'none';
        } else {
            sizesWrapper.style.display = 'block';
        }
    }
    isFreeSizeCheckbox.addEventListener('change', toggleSizesInput);
    toggleSizesInput();
</script>
@endsection