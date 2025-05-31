@extends('cms.layouts.app')
@section('content')
<style>
    .btn-solid-default::before{
        border-radius: 10px !important;
    }
</style>
    <section class="contact-section" style="margin-bottom: 30px;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="materialContainer">
                        <div class="material-details">
                            <div class="title title1 title-effect mb-1 title-left">
                                <h2>Thông tin tài khoản</h2>
                            </div>
                        </div>
                        <form action="#" method="POST">
                            @csrf
                            <div class="row g-4 mt-md-1 mt-2">
                                <div class="col-md-12">
                                    <label for="emaibtn btn-solid-defaultl" class="form-label">Email
                                        @error('email')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="email" class="form-control" id="email"
                                        placeholder="Nhập địa chỉ Email của bạn" value="{{ $user->email }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="first" class="form-label">Tên
                                        @error('first_name')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="first_name" class="form-control" id="first"
                                        placeholder="Nhập tên của bạn" value="{{ $user->name }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="email2" class="form-label">Điện thoại
                                        @error('phone')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="phone" class="form-control" id="email2"
                                        placeholder="Nhập số điện thoại của bạn" value="{{ $userInfor->phone }}">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-solid-default" type="submit" style="border-radius:10px;">Chỉnh sửa thông tin</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
