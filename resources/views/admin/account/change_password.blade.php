@extends('admin.layouts.app')
@section('content')
<style>
    .wrap-change div {
        padding-bottom: 15px;
    }
</style>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">CÀI ĐẶT TÀI KHOẢN</h3>
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
                    <h2 style="text-align: center;">ĐỔI MẬT KHẨU</h2>
                    <form action="{{route('admin.account.changePass')}}"  method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-4 mt-md-1 mt-2 wrap-change" style="display:flex ;justify-content: center;align-items: center;">
                            <div class="col-md-8">
                                <label for="first" class="form-label">Mật khẩu cũ
                                    @error('old_password')
                                    <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Điền mật khẩu cũ">
                            </div>
                            <div class="col-md-8">
                                <label for="email2" class="form-label">Mật khẩu mới
                                    @error('new_password')
                                    <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror

                                </label>
                                <input type="password" name="new_password" class="form-control" id="new_password"
                                    placeholder="Điền mật khẩu mới">
                            </div>
                            <div class="col-md-8">
                                <label for="email2" class="form-label">Xác nhận mật khẩu
                                    @error('new_password_confirmation')
                                    <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                     @error('infor')
                                    <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation"
                                    placeholder="Xác nhận lại mật khẩu">
                            </div>
                            <div class="col-md-8" style="display:flex;">
                                <div class="">
                                    <button class="btn btn-solid-default" type="submit" style="border-radius:10px; background-color:brown; height:40px;">Đổi mật khẩu</button>
                                </div>
                                <div class="">
                                    <button class="btn btn-solid-default cancel" type="button" style="border-radius:10px; background-color:#ccc; height:40px; margin-left:15px; color:#333">Quay lại</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelector('.cancel').addEventListener('click', function() {
        window.location.href = '/admin/dashboard'
    });
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
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', (e) => e.stopPropagation());
    });
</script>
@endsection