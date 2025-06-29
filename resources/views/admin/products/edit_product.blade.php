@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">QUẢN LÍ SẢN PHẨM</h3>
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
                        <div class="form-group" id="freesize-quantity-group" style="display: {{ $productUpdate->is_free_size ? 'block' : 'none' }};">
                            <label>Số lượng sản phẩm
                                @error('quantity')
                                    <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input type="number" class="form-control" name="quantity" value="{{ old('quantity', $productUpdate->quantity) }}" placeholder="Số lượng sản phẩm">
                        </div>

                        <div class="form-group" id="size-list-group" style="display: {{ $productUpdate->is_free_size ? 'none' : 'block' }};">
                            <label>Kích thước & Số lượng:</label>
                            <div id="size-list">
                                @if (!empty($productSizes))
                                    @foreach ($productSizes as $size)
                            <div class="d-flex gap-2 mb-2">
                                <input type="text" class="form-control w-25" placeholder="Size" value="{{ $size->size }}" style="margin-right:7px;">
                                <input type="number" class="form-control w-25" placeholder="Số lượng" min="0" value="{{ $size->quantity }}" style="margin-right:7px;">
                                <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">X</button>
                            </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addSizeRow()">+ Thêm size</button>
                            <input type="hidden" name="sizes" id="sizes-json">
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
<script>
    function addSizeRow() {
        const container = document.getElementById('size-list');
        const row = document.createElement('div');
        row.classList.add('d-flex', 'gap-2', 'mb-2');
        row.innerHTML = `
            <input type="text" class="form-control w-25" placeholder="Size" style="margin-right:7px;"/>
            <input type="number" class="form-control w-25" placeholder="Số lượng" min="0" style="margin-right:7px;"/>
            <button type="button" class="btn btn-danger btn-sm" style="margin-right:7px;" onclick="this.parentElement.remove()">X</button>
        `;
        container.appendChild(row);
    }

    document.querySelector('.forms-sample3').addEventListener('submit', function (e) {
        const rows = document.querySelectorAll('#size-list > div');
        const sizes = [];
        rows.forEach(row => {
            const size = row.children[0].value.trim();
            const qty = parseInt(row.children[1].value);
            if (size && !isNaN(qty)) {
                sizes.push({ size, quantity: qty });
            }
        });
        document.getElementById('sizes-json').value = JSON.stringify(sizes);
    });
</script>

@endsection