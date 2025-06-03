@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Quản lí danh mục</h3>
        <div class="link-wrap">
            <a class="none-a" href="{{route('admin.dashboard')}}">Thống kê </a>
            <p class="rev">></p>
            @if (request()->routeIs('admin.category.index'))
            <span style="color: #333; cursor: not-allowed;">Danh mục sản phẩm</span>
            @else
            <a class="none-a2" href="{{route('admin.category.index')}}" >Danh mục sản phẩm</a>
            @endif
            <p class="rev">></p>
            @if (request()->routeIs('admin.category.create'))
            <span style="color: #333; cursor: not-allowed;">Thêm danh mục</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thêm danh mục</h4>
                    <form action="{{ route('admin.category.store') }}" class="forms-sample" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputName1">Tên danh mục
                                @error('name')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input name="name" type="text" class="form-control" placeholder="Tên danh mục" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label>Tải lên tập tin
                                @error('image')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </label>
                            <input type="file" name="image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" name="image" disabled placeholder="Tải hình ảnh lên">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Tải tệp</button>
                                </span>
                            </div>
                        </div>
                        <button class="btn btn-primary mr-2">Gửi</button>
                        <button class="btn btn-dark" type="button"><a href="{{ route('admin.category.index') }}" style="text-decoration: none; color:white;">Quay lại</a></button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection