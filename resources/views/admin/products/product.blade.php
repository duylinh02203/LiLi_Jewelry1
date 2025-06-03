@extends('admin.layouts.app')
@section('content')
<style>
    .table-container {
        max-width: 100%;
        margin: 20px auto;
        background-color: #1e1e2d;
        color: #ffffff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .custom-table th,
    .custom-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #444;
    }

    .custom-table thead th {
        font-weight: bold;
        background-color: #2d2d44;
    }

    .custom-table tbody tr:hover {
        background-color: #333344;
    }

    .page-btn,
    .page-number {
        padding: 8px 14px;
        border-radius: 8px;
        background-color: #2d2d44;
        color: #ffffff;
        font-size: 14px;
        font-weight: 500;
        text-align: center;
        border: 1px solid #444;
        transition: all 0.3s ease;
    }

    .page-number.active {
        background-color: #007bff;
        border: 1px solid #0056b3;
    }

    .page-btn:hover,
    .page-number:hover {
        background-color: #444;
    }

    .page-btn:disabled {
        background-color: #2d2d44;
        color: #666;
        cursor: not-allowed;
    }
</style>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Quản lí sản phẩm</h3>
        <div class="link-wrap">
            <a class="none-a" href="{{route('admin.dashboard')}}">Thống kê </a>
            <p class="rev">></p>
            @if (request()->routeIs('admin.product.index'))
            <span style="color: #333; cursor: not-allowed;">Sản phẩm</span>
            @endif
        </div>
        @if ($message = Session::get('success'))
        <div id="alert" class="alert alert-success" style="position: absolute; width: 80.5%;">
            {{ $message }}
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="search-add-wrapper"
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div class="search-bar col-lg-3" style="width: 250px; flex: 1;margin-left: -10px;">
                            <form class="nav-link mt-2 mt-md-0 d-lg-flex search" action="{{ route('admin.product.search') }}" method="GET">
                                <input type="text" style="padding: 15;" class="form-control"
                                    placeholder="Tìm kiếm sản phẩm" name="search"
                                    value="{{ request()->input('search') }}">
                            </form>
                        </div>
                        <a href="{{ route('admin.product.create') }}" style="text-decoration: none;">
                            <button class="btn btn-primary"
                                style="border-radius: 20px; font-size: 14px; padding: 10px 20px; display: flex; align-items: center;">
                                <span style="margin-right: 5px;">+</span>Thêm mới
                            </button>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Hình ảnh</th>
                                    <th>Danh mục</th>
                                    <th>Giới tính</th>
                                    <th>Mô tả</th>
                                    <th>Giá niêm yết</th>
                                    <th>Giá ưu đãi</th>
                                    <th>Số lượng</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($products->count() > 0)
                                @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{ ++$key ?? 'null' }}</td>
                                    <td>{{ $product->name ?? 'null' }}</td>
                                    <td>
                                        <img src="{{ asset('/images/' . optional($product->firstImage)->image ?? 'default.png') }}"
                                            alt="Hình ảnh sản phẩm"
                                            style="width: 80px; height: 100px; object-fit: cover; border-radius: 5px;">
                                    </td>
                                    <td>{{ $product->category->name ?? 'null' }}</td>
                                    <td>
                                        {{
                                            $product->gender === 'male' ? 'Nam' :
                                            ($product->gender === 'female' ? 'Nữ' :
                                            ($product->gender === 'unisex' ? 'Cặp đôi' : 'Không xác định'))
                                        }}
                                    </td>
                                    <td>{{ Str::limit($product->description ?? 'null', 60) }}</td>
                                    <td>{{ $product->listed_price ?? 'null' }}</td>
                                    <td>{{ $product->price ?? 'null' }}</td>
                                    <td>{{ $product->quantity ?? 'null' }}</td>
                                    <td>
                                        <a href="{{ route('admin.product.edit', $product->id) }}">
                                            <button type="button" class="btn btn-edit">Sửa</button></a>
                                        <a href="{{ route('admin.product.detail', $product->id) }}">
                                            <button type="button" class="btn btn-primary">Chi tiết</button></a>
                                        <a href="{{ route('admin.product.remove', $product->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-delete">Xóa</button></a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="12" class="text-center">Không tìm thấy sản phẩm nào.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pagination-container">
                    {{ $products->links('admin.pagination.default') }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        let alert = document.getElementById('alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 500);
        }
    }, 3000);
</script>
@endsection