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
                           <div class="form-group">
                                <label>Kích thước & Số lượng:
                                    @error('sizes')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <div id="size-list">
                                    {{-- Các dòng nhập sẽ thêm ở đây --}}
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addSizeRow()">+ Thêm size</button>

                                <input type="hidden" name="sizes" id="sizes-json">
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
                                <label>Số lượng sản phẩm
                                    @error('quantity')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input type="number" class="form-control" id="quantity-input" name="quantity" placeholder="Số lượng sản phẩm">
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
<script>
    function addSizeRow() {
        const container = document.getElementById('size-list');
        const row = document.createElement('div');
        row.classList.add('d-flex', 'gap-2', 'mb-2');
        row.innerHTML = `
            <input type="text" class="form-control w-25" placeholder="Size" style="margin-right:7px;" />
            <input type="number" class="form-control w-25" placeholder="Số lượng" min="0"  style="margin-right:7px;"/>
            <button type="button" class="btn btn-danger btn-sm" style="margin-right:7px;" onclick="this.parentElement.remove(); toggleQuantityField()">X</button>
        `;
        container.appendChild(row);
        toggleQuantityField(); // Kiểm tra sau mỗi lần thêm
    }

    function toggleQuantityField() {
        const sizeRows = document.querySelectorAll('#size-list > div');
        const quantityInput = document.getElementById('quantity-input');
        const quantityGroup = quantityInput.closest('.form-group');
        if (sizeRows.length > 0) {
            quantityGroup.style.display = 'none';
            quantityInput.value = ''; // Reset nếu có size
        } else {
            quantityGroup.style.display = 'block';
        }
    }

    // Gọi toggle khi load lại form (ví dụ khi submit lỗi)
    window.addEventListener('DOMContentLoaded', toggleQuantityField);

    document.querySelector('form').addEventListener('submit', function (e) {
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

