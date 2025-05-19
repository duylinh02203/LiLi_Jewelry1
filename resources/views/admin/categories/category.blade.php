@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Quản lí danh mục</h3>
        <nav>
        </nav>
        @if ($message = Session::get('success'))
        <div id="alert" class="alert alert-success" style="position: absolute; width: 80%;">
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
                        <div class="search-bar col-lg-3" style="width: 250px; flex: 1;">
                            <form class="nav-link mt-2 mt-md-0 d-lg-flex" action="{{ route('admin.category.searchCategory') }}" method="GET">
                                <input type="text" style="padding: 15px;" class="form-control" name="search"
                                    value="{{ request()->input('search') }}" placeholder="Tìm kiếm danh mục">
                            </form>
                        </div>
                        <a href="{{ route('admin.category.create') }}" style="text-decoration: none;">
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
                                    <th>Tên danh mục</th>
                                    <th>Hình ảnh</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($cats) > 0)
                                @foreach ($cats as $index => $cat)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $cat->name }}</td>
                                    <td>
                                        <img src="{{ asset('images/categories/' . ($cat->image ?? 'default.png')) }}" alt="Category Image"

                                            style="width: 80px; height: 100px; object-fit: cover; border-radius: 5px;">
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.category.edit', $cat->id)}}"><button
                                                type="button" class="btn btn-edit">Sửa</button></a>
                                        <a href="{{ route('admin.category.detail', $cat->id)}}"><button
                                                type="button" class="btn btn-primary">Chỉnh tiết</button></a>
                                        <a href="{{ route('admin.category.destroy', $cat->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-delete">Xóa</button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">Không tìm thấy danh mục nào.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>
                    <div class="pagination-container" style="display: flex; width:100%;justify-content: end; margin-bottom: -25px; padding-right: 0px !important;">
                        {{ $cats->links('admin.pagination.default') }}
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