@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Quản lí danh mục</h3>
        <nav aria-label="breadcrumb">
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Basic Table</h4>
                    <div class="search-add-wrapper" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <!-- Thanh tìm kiếm -->
                        <!-- <div class="search-bar col-lg-3" style="width: 250px; flex: 1;">
                            <form class="nav-link mt-2 mt-md-0 d-lg-flex search">
                                <input type="text" style="padding: 0;" class="form-control" placeholder="Search products">
                            </form>
                        </div> -->
                        <div class="card-tools">
                            <div class="input-group input-group search-bar " style="width: 250px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Nút Add New -->
                        <a href="{{route('addCategory')}} " style="text-decoration: none;">
                            <button class="btn btn-primary" style="border-radius: 20px; font-size: 14px; padding: 10px 20px; display: flex; align-items: center;">
                                <span style="margin-right: 5px;">+</span> Add New
                            </button>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <style>
                            /* Căn chỉnh bảng */
                            .table-responsive {
                                margin: 20px 0;
                            }

                            /* Định dạng nút */
                            .btn {
                                border: none;
                                border-radius: 5px;
                                padding: 5px 10px;
                                font-size: 14px;
                                cursor: pointer;
                                transition: all 0.3s ease;
                            }

                            /* Nút sửa */
                            .btn-edit {
                                background-color: #4CAF50;
                                /* Màu xanh lá */
                                color: white;
                                margin-right: 5px;
                            }

                            .btn-edit:hover {
                                background-color: #45a049;
                            }

                            /* Nút xóa */
                            .btn-delete {
                                background-color: #f44336;
                                /* Màu đỏ */
                                color: white;
                            }

                            .btn-delete:hover {
                                background-color: #d32f2f;
                            }

                            /* Hình ảnh */
                            .table img {
                                border-radius: 5px;
                                width: 50px;
                                height: 50px;
                                object-fit: cover;
                            }

                            th,
                            td {
                                text-align: center;
                                color: white;
                            }
                        </style>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ và tên</th>
                                    <th>Email</th>
                                    <th>Hình thức thanh toán</th>
                                    <th>Mã sản phẩm</th>
                                    <th>Trạng thái</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Sản phẩm A</td>
                                    <td>Mô tả về sản phẩm A</td>
                                    <td>COD</td>
                                    <td>330M</td>
                                    <td>Đang xử lí</td>
                                    <td>
                                        <button type="button" class="btn btn-edit">Sửa</button>
                                        <button type="button" class="btn btn-delete">Xóa</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- <div class="card-footer clearfix">
                        <ul class="pagination pagination m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                        </ul>
                    </div> -->