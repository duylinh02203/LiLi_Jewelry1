@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Người dùng</h3>
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
                            <form class="nav-link mt-2 mt-md-0 d-lg-flex search" action="{{route('admin.user.searchUser')}}" method="GET">
                                <input type="text" style="padding: 15;" class="form-control"
                                    placeholder="Tìm kiếm người dùng" name="search" aria-label="Search" value="{{ request('search') }}">
                            </form>
                        </div>
                        <a href="{{ route('admin.user.create') }}" style="text-decoration: none;">
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
                                    <th>No</th>
                                    <th>Tên người dùng</th>
                                    <th>Email</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($users) > 0)
                                @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <a href="{{ route('admin.user.edit', $user->id)}}"><button
                                                type="button" class="btn btn-edit">Sửa</button></a>
                                        <a href="{{ route('admin.user.detail', $user->id)}}"><button
                                                type="button" class="btn btn-primary">Chi tiết</button></a>
                                        <a href="{{ route('admin.user.destroy', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-delete">Xóa</button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">Không có dữ liệu</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pagination-container" style="display: flex; width:100%;justify-content: center; margin-bottom: -10px;">
                    {{ $users->links('admin.pagination.default') }}
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