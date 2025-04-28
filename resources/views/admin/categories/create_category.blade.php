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
                    <h4 class="card-title">Thêm danh</h4>
                    <form action="{{route('category.store')}}" class="forms-sample" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputName1" >Name</label>
                            <input name="category_name" type="text" class="form-control" id="exampleInputName1" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea1">Textarea</label>
                            <textarea name="category_description" class="form-control" id="exampleTextarea1" rows="8"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-dark"><a href="{{route('category.index')}}" style="text-decoration: none; color:white;" >Cancel</a></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection