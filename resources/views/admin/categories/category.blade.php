@extends('admin.layouts.app')
@section('content')
@if($message=Session::get('success'))
<div class="alert alert-success">
    {{$message}}
</div>

@endif
<div class="content-wrapper">
    <!-- css -->
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
    <!-- css -->
    <div class="page-header">
        <h3 class="page-title">Quản lí danh mục</h3>
        <nav aria-label="breadcrumb">
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="search-add-wrapper" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <!-- Thanh tìm kiếm -->
                        <div class="search-bar col-lg-3" style="width: 250px; flex: 1;">
                            <form class="nav-link mt-2 mt-md-0 d-lg-flex search">
                                <input type="text" style="padding: 15;" class="form-control" placeholder="Search products">
                            </form>
                        </div>
                        <!-- Nút Add New -->
                        <a href="{{route('category.create')}}" style="text-decoration: none;">
                            <button class="btn btn-primary" style="border-radius: 20px; font-size: 14px; padding: 10px 20px; display: flex; align-items: center;">
                                <span style="margin-right: 5px;">+</span> Add New
                            </button>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên danh mục</th>
                                    <th>Mô tả</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($cats) > 0)
                                @foreach($cats as $cat)
                                <tr>
                                    <td>{{$cat->category_id}}</td>
                                    <td>{{$cat->category_name}}</td>
                                    <td>{{$cat->category_description}}</td>
                                    <td>
                                        <a href="{{route('category.edit',$cat->category_id)}}"><button type="button" class="btn btn-edit">Sửa</button></a>
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{route('category.destroy',$cat->category_id)}}"> <button type="button" class="btn btn-delete">Xóa</button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">No data found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
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