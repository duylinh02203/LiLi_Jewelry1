@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Quản lí sản phẩm</h3>
        <nav aria-label="breadcrumb">
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="search-add-wrapper" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <!-- Thanh tìm kiếm -->
                        <!-- <div class="card-tools">
                            <div class="input-group input-group search-bar " style="width: 250px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="mdi mdi-yeast"></i>
                                    </button>
                                </div>
                            </div>
                        </div> -->
                        <div class="search-bar col-lg-3" style="width: 250px; flex: 1;">
                            <form class="nav-link mt-2 mt-md-0 d-lg-flex search">
                                <input type="text" style="padding: 0;" class="form-control" placeholder="Search products">
                            </form>
                        </div>
                        <!-- Nút Add New -->
                        <a href="{{route('addCategory')}} " style="text-decoration: none;">
                            <button class="btn btn-primary" style="border-radius: 20px; font-size: 14px; padding: 10px 20px; display: flex; align-items: center;">
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
                                    <th>Số lượng</th>
                                    <th>Mô tả</th>
                                    <th>Giá tiền</th>
                                    <th>Giá ưu đãi</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>2</td>
                                    <td>Sản phẩm B</td>
                                    <td>
                                        <!-- Hiển thị hình ảnh -->
                                        <img src="{{ asset('assets/images/samples/Login_bg.jpg') }}" alt="Hình ảnh sản phẩm"
                                            style="width: 80px; height: 100px; object-fit: cover; border-radius: 5px;">
                                    </td>
                                    <td>2</td>
                                    <td>Mô tả về sản phẩm B</td>
                                    <td>500.000 VNĐ</td>
                                    <td>300.000 VNĐ</td>
                                    <td>
                                        <button type="button" class="btn btn-edit">Sửa</button>
                                        <button type="button" class="btn btn-delete">Xóa</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Sản phẩm B</td>
                                    <td>
                                        <!-- Hiển thị hình ảnh -->
                                        <img src="{{ asset('assets/images/samples/Login_bg.jpg') }}" alt="Hình ảnh sản phẩm"
                                            style="width: 80px; height: 100px; object-fit: cover; border-radius: 5px;">
                                    </td>
                                    <td>2</td>
                                    <td>Mô tả về sản phẩm B</td>
                                    <td>500.000 VNĐ</td>
                                    <td>300.000 VNĐ</td>
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