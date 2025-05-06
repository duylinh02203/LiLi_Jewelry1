@extends('cms.layouts.app')
@section('content')
<div class="login-section">
    <div class="materialContainer">
        <div class="box">
            <form method="POST" action="http://localhost:8000/register">
                <input type="hidden" name="_token" value="MkRqEzTGuoSx6LqJUm0OAKxSgNUYt26wTT7RMUZY">
                <div class="login-title">
                    <h2>Đăng ký</h2>
                </div>

                <div class="input">
                    <label for="name" style="line-height: 60px; font-weight: 300; top: 10px;">Tên</label>
                    <input type="text" id="name" class="block mt-1 w-full" name="name" :value="old('name')" required="" autofocus="" autocomplete="name">
                </div>

                <div class="input">
                    <label for="phone" style="line-height: 60px; font-weight: 300; top: 10px;">Số điện thoại</label>
                    <input type="text" id="phone" class="block mt-1 w-full" name="phone" :value="old('phone')" required="" autofocus="" autocomplete="phone">
                </div>

                <div class="input">
                    <label for="emailname" style="line-height: 60px; font-weight: 300; top: 10px;">Email</label>
                    <input type="email" id="emailname" class="block mt-1 w-full" name="email" :value="old('email')" required="" autocomplete="username">
                </div>

                <div class="input">
                    <label for="pass" style="line-height: 60px; font-weight: 300; top: 10px;">Mật khẩu</label>
                    <input type="password" id="pass" class="block mt-1 w-full" name="password" required="" autocomplete="new-password">
                </div>

                <div class="input">
                    <label for="compass">Xác nhận mật khẩu</label>
                    <input type="password" id="compass" class="block mt-1 w-full" name="password_confirmation" required="" autocomplete="new-password">
                </div>

                <div class="button login">
                    <button type="submit">
                        <span>Đăng Ký</span>
                        <i class="fa fa-check"></i>
                    </button>
                    <p><a href="{{route('login')}}" class="theme-color">Bạn đã có tài khoản?</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection