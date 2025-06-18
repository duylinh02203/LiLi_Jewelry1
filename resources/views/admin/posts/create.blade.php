@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Quản lý bài viết</h3>
            <div class="link-wrap">
                <a class="none-a" href="{{ route('admin.dashboard') }}">Thống kê </a>
                <p class="rev">></p>
                @if (request()->routeIs('admin.posts.index'))
                    <a class="none-a2" href="{{ route('admin.posts.index') }}"> Bài viết</a>
                @else
                    <span style="color: #333; cursor: not-allowed;">Bài viết</span>
                @endif
                <p class="rev">></p>
                @if (request()->routeIs('admin.posts.create'))
                    <span style="color: #333; cursor: not-allowed;">Thêm bài viết</span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('admin.posts.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tiêu đề
                                    @error('title')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input value="{{ old('title') }}" type="text" class="form-control" name="title"
                                    placeholder="Tiêu đề bài viết">
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh
                                    @error('image')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input type="file" name="image" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" name="image" disabled
                                        placeholder="Tải hình ảnh lên">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">Tải tệp</button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nội dung
                                    @error('content')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <textarea placeholder='Các đoạn cách nhau bằng dấu  " . "  và xuống dòng' class="form-control" name="content"
                                    rows="6">{{ old('content') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Thêm</button>
                            <button type="button" class="btn btn-dark" onclick="history.back()">Quay lại</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
