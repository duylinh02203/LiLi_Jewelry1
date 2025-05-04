@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Quản lí sản phẩm</h3>
        <nav aria-label="breadcrumb">
            @if ($message = Session::get('success'))
            <div id="alert" class="alert alert-success" style="position: absolute; width: 80%;">
                {{ $message }}
            </div>
            @endif
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="search-add-wrapper"
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div class="search-bar col-lg-3" style="width: 250px; flex: 1;">
                            <form class="nav-link mt-2 mt-md-0 d-lg-flex search">
                                <input type="text" style="padding: 15;" class="form-control"
                                    placeholder="Search products">
                            </form>
                        </div>
                        <!-- Nút Add New -->
                        <a href="{{ route('admin.product.create') }}" style="text-decoration: none;">
                            <button class="btn btn-primary"
                                style="border-radius: 20px; font-size: 14px; padding: 10px 20px; display: flex; align-items: center;">
                                <span style="margin-right: 5px;">+</span> Add New
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
                                    <th>Mô tả</th>
                                    <th>Giá tiền</th>
                                    <th>Giá ưu đãi</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{ ++$key ?? 'null' }}</td>
                                    <td>{{ $product->name ?? 'null' }}</td>
                                    <td>
                                        <!-- Hiển thị hình ảnh -->
                                        <img src="{{ asset('/images/' . optional($product->firstImage)->image ?? 'default.png') }}"
                                            alt="Hình ảnh sản phẩm"
                                            style="width: 80px; height: 100px; object-fit: cover; border-radius: 5px;">
                                    </td>
                                    <td>{{ $product->category->name ?? 'null' }}</td>
                                    <td>{{ $product->description ?? 'null' }}</td>
                                    <td>{{ $product->price ?? 'null' }}</td>
                                    <td>{{ $product->listed_price ?? 'null' }}</td>
                                    <td>
                                        <a href="{{ route('admin.product.edit', $product->id) }}">
                                            <button type="button" class="btn btn-edit">Sửa</button></a>
                                        <a href="{{ route('admin.product.remove', $product->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-delete">Xóa</button></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <!-- css -->
                        </table>
                        <style>
                            .table-container {
                                max-width: 100%;
                                margin: 20px auto;
                                background-color: #1e1e2d;
                                /* Màu nền */
                                color: #ffffff;
                                /* Màu chữ */
                                padding: 20px;
                                border-radius: 12px;
                                /* Bo góc mềm mại */
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                                /* Đổ bóng */
                                position: relative;
                                /* Định vị cho các phần tử con */
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
                                /* Màu nền header */
                            }

                            .custom-table tbody tr:hover {
                                background-color: #333344;
                            }

                            /* Phân trang */
                            .pagination-container {
                                position: absolute;
                                bottom: 10px;
                                /* Cách đáy bảng */
                                right: 20px;
                                /* Cách góc phải */
                            }

                            .pagination {
                                display: flex;
                                gap: 8px;
                            }

                            .page-btn,
                            .page-number {
                                padding: 8px 14px;
                                border-radius: 8px;
                                /* Bo góc mềm mại */
                                background-color: #2d2d44;
                                /* Màu nền */
                                color: #ffffff;
                                /* Màu chữ */
                                font-size: 14px;
                                font-weight: 500;
                                text-align: center;
                                border: 1px solid #444;
                                transition: all 0.3s ease;
                            }

                            .page-number.active {
                                background-color: #007bff;
                                /* Màu nổi bật */
                                border: 1px solid #0056b3;
                            }

                            .page-btn:hover,
                            .page-number:hover {
                                background-color: #444;
                                /* Màu hover */
                            }

                            .page-btn:disabled {
                                background-color: #2d2d44;
                                /* Màu tối hơn cho nút không kích hoạt */
                                color: #666;
                                cursor: not-allowed;
                            }
                        </style>
                        <!--css  -->
                        <div class="pagination-container">
                            <div class="pagination">
                                <button class="page-btn">Previous</button>
                                <button class="page-number ">1</button>
                                <button class="page-number">2</button>
                                <button class="page-number">3</button>
                                <button class="page-btn">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection