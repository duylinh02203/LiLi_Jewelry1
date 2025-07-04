@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">QUẢN LÍ LIÊN HỆ</h3>
        <div class="link-wrap">
            <a class="none-a" href="{{route('admin.dashboard')}}">Thống kê </a>
            <p class="rev">></p>
            @if (request()->routeIs('admin.contact.index'))
            <span style="color: #333; cursor: not-allowed;">Liên hệ</span>
            @else
            <a href="">Danh mục</a>
            @endif
        </div>
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
                            <form class="nav-link mt-2 mt-md-0 d-lg-flex search" action="{{ route('admin.contact.search') }}" method="GET">
                                <input type="text" style="padding: 15;" class="form-control" name="search"
                                    value="{{ request()->input('search') }}" placeholder="Tìm kiếm liên hệ">
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên người dùng</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Bình luận</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($contacts) > 0)
                                @foreach ($contacts as $index => $contact)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{$contact->name}}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($contact->comment, 60, '...') }}</td>
                                    <td>
                                        @if($contact->status == 'active')
                                        <a href="{{ route('admin.contact.detail', $contact->id) }}">
                                            <button type="button" class="btn btn-edit">Chi tiết</button>
                                        </a>
                                        @else
                                        <a href="{{ route('admin.contact.detail', $contact->id) }}">
                                            <button type="button" class="btn btn-edit" style="background-color: gray; border-color: gray;">
                                                Chi tiết
                                            </button>
                                        </a>
                                        @endif

                                        <a href="{{ route('admin.contact.remove', $contact->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-delete">Xóa</button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="12" style="text-align: center;">Không tìm thấy liên hệ nào.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pagination-container" style="display: flex; width:100%;justify-content: center; margin-bottom: -10px;">
                    {{ $contacts->links('admin.pagination.default') }}
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