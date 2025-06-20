@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">QUẢN LÍ ĐÁNH GIÁ</h3>
        <div class="link-wrap">
            <a class="none-a" href="{{route('admin.dashboard')}}">Thống kê </a>
            <p class="rev">></p>
            @if (request()->routeIs('admin.review.ProductReview'))
            <span style="color: #333; cursor: not-allowed;">Đánh giá</span>
            @else
            <a href="">Đánh giá</a>
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
                    <h4 class="card-title" style="padding-left: 20px;">Đánh giá sản phẩm</h4>
                    <div class="search-add-wrapper"
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div class="search-bar col-lg-3" style="width: 250px; flex: 1; margin-left: -10px;">
                            <form class="nav-link mt-2 mt-md-0 d-lg-flex" action="{{ route('admin.review.search') }}" method="GET">
                                <input type="text" style="padding: 15px;" class="form-control" name="search"
                                    value="{{ request()->input('search') }}" placeholder="Tìm kiếm đánh giá">
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Tền người dùng</th>
                                    <th>Đánh giá</th>
                                    <th>Nhận xét</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($productReviews)>0)
                                @foreach ($productReviews as $index => $productReview)
                                <tr>
                                    <td>{{++$index}}</td>
                                    <td>{{$productReview->product->name}}</td>
                                    <td>{{$productReview->user->name}}</td>
                                    <td>{{$productReview->rating}} sao</td>
                                    <td style="max-width: 30ch; word-wrap: break-word; white-space: normal; text-align: left;">{{$productReview->comment}}</td>
                                    <td>
                                        @if($productReview->status == 'active')
                                        <a href="{{route('admin.review.detail',$productReview->id)}}"><button
                                                type="button" class="btn btn-primary">Chỉnh tiết</button></a>
                                        @else
                                        <a href="{{route('admin.review.detail',$productReview->id)}}"><button
                                                type="button" class="btn btn-primary" style="background-color: gray; border-color: gray;">Chỉnh tiết</button></a>
                                        @endif
                                        <a href="{{ route('admin.review.destroy', $productReview->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-delete">Xóa</button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="12" class="text-center">Không có đánh giá nào.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-container" style="display: flex; width:100%;justify-content: end; margin-bottom: -25px; padding-right: 0px !important;">
                        {{ $productReviews->links('admin.pagination.default') }}
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
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', (e) => e.stopPropagation());
    });
</script>
@endsection