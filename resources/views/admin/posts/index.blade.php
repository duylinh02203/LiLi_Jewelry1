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

    .form-select {
        border-radius: 5px;
        background-color: #ccc;
    }
</style>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Quản lí bài viết</h3>
        <div class="link-wrap">
            <a class="none-a" href="{{route('admin.dashboard')}}">Thống kê</a>
            <p class="rev">></p>
            <span style="color: #333; cursor: not-allowed;">Bài viết</span>
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
                        <div class="search-bar col-lg-3" style="width: 250px; flex: 1; margin-left: -10px;">
                            <form class="nav-link mt-2 mt-md-0 d-lg-flex" action="{{ route('admin.category.index') }}" method="GET">
                                <input type="text" style="padding: 15px;" class="form-control" name="search"
                                    value="{{ request()->input('search') }}" placeholder="Tìm kiếm danh mục">
                            </form>
                        </div>
                        <a href="{{ route('admin.posts.create') }}" style="text-decoration: none;">
                            <button class="btn btn-primary"
                                style="border-radius: 20px; font-size: 14px; padding: 10px 20px; display: flex; align-items: center;">
                                <span style="margin-right: 5px;">+</span> Thêm mới
                            </button>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tiêu đề</th>
                                    <th>Ảnh tiêu đề</th>
                                    <th>Trạng thái</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($posts->count() > 0)
                                @foreach ($posts as $key => $post)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>
                                        <img src="{{ asset('images/posts/' . ($post->image ?? 'default.png')) }}" alt="Post Image"

                                            style="width: 80px; height: 100px; object-fit: cover; border-radius: 5px;">
                                    </td>
                                    <td>{{ $post->status == 'published' ? 'Đã xuất bản' : 'Bản nháp' }}</td>
                                    <td>
                                        <a href="">
                                            <button type="button" class="btn btn-edit">Sửa</button></a>
                                        <a href="">
                                            <button type="button" class="btn btn-primary">Chi tiết</button></a>
                                        <form action="" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">Không tìm thấy bài viết nào.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-container">
                        {{ $posts->appends(request()->query())->links('admin.pagination.default') }}
                    </div>
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