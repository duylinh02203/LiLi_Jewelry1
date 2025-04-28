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
                        <h4 class="card-title">Thêm danh mục</h4>
                        <form action="{{ route('admin.category.store') }}" class="forms-sample" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputName1">Name
                                    @error('name')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input name="name" type="text" class="form-control" placeholder="Name"
                                    value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Textarea
                                    @error('description')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <textarea name="description" class="form-control" rows="8">{{ old('description') }}</textarea>
                            </div>
                            <button class="btn btn-primary mr-2">Submit</button>
                            <button class="btn btn-dark"><a href="{{ route('admin.category.index') }}"
                                    style="text-decoration: none; color:white;">Cancel</a></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
