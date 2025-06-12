@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Quản lí danh mục</h3>
        <div class="link-wrap">
            <a class="none-a" href="{{route('admin.dashboard')}}">Thống kê </a>
            <p class="rev">></p>
            @if (request()->routeIs('admin.category.index'))
            <span style="color: #333; cursor: not-allowed;">Danh mục</span>
            @else
            <a class="none-a2" href="{{route('admin.category.index')}}">Danh mục</a>
            @endif
            <p class="rev">></p>
            @if (request()->routeIs('admin.category.edit'))
            <span style="color: #333; cursor: not-allowed;">Sửa</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Chỉnh sửa danh mục</h4>
                    <form action="{{ route('admin.category.edit', $categoryUpdate->id) }}" class="forms-sample"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Name
                                @error('name')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input class="form-control" value="{{ $categoryUpdate->name }}" name="name"
                                type="text" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label>Tải lên tập tin</label>
                            <input type="file" name="image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Tải hình ảnh lên">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Tải tệp</button>
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Gửi</button>
                        <button class="btn btn-dark" type="button"><a href="{{ url()->previous() }}"
                                style="text-decoration: none; color:white;">Quay lại</a></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>
@endsection