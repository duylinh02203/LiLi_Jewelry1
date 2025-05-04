@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Tạo mới sản phẩm</h3>
            <nav aria-label="breadcrumb">
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="forms-sample" method="POST"
                            action="{{ route('admin.product.edit', $productUpdate->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Name
                                    @error('name')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input value="{{ $productUpdate->name }}" type="text" class="form-control" name="name"
                                    placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label>Price
                                    @error('price')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input value="{{ $productUpdate->price }}" type="text" class="form-control"
                                    name="price" placeholder="Price">
                            </div>
                            <div class="form-group">
                                <label>Listed price
                                    @error('listed_price')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input value="{{ $productUpdate->listed_price }}" type="text" class="form-control"
                                    placeholder="Listed price" name="listed_price">
                            </div>
                            <div class="form-group">
                                <label>Category
                                </label>
                                <select class="form-control" name="category_id">
                                    <option value="" hidden>Chọn danh mục sản phẩm</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Gender
                                    @error('gender')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <select class="form-control" name="gender">
                                    <option value="unisex">Unisex</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Images
                                </label>
                                <input type="file" name="image[]" class="file-upload-default" multiple
                                    style="display: none;">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled
                                        placeholder="Upload Image">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" class="form-control" placeholder="Slug" name="slug"
                                    value="{{ $productUpdate->slug }}">
                            </div>
                            <div class="form-group">
                                <label>Description
                                    @error('description')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <textarea class="form-control" id="exampleTextarea1" rows="4" name="description">{{ $productUpdate->description }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button class="btn btn-dark">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
