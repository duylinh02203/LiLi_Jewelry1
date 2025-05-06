@extends('cms.layouts.app')
@section('content')
<div class="login-section">
    <div class="materialContainer">
        <div class="box">
            <form method="POST" action="http://localhost:8000/login">
                <input type="hidden" name="_token" value="MkRqEzTGuoSx6LqJUm0OAKxSgNUYt26wTT7RMUZY">
                <div class="login-title">
                    <h2>Đăng nhập</h2>
                </div>
                <div class="input">
                    <label for="name" style="line-height: 60px; font-weight: 300; top: 10px;">Email</label>
                    <input type="email" id="name" name="email" :value="old('email')" required="" autofocus="" autocomplete="name">
                </div>

                <div class="input">
                    <label for="pass">Mật khẩu</label>
                    <input type="password" id="pass" class="block mt-1 w-full" name="password" required="" autocomplete="current-password">
                </div>

                <a href="javascript:void(0)" class="pass-forgot">Quên mật khẩu ?</a>

                <div class="button login">
                    <button type="submit">
                        <span>Đăng Nhập</span>
                        <i class="fa fa-check"></i>
                    </button>
                </div>

                <p>Chưa có tài khoản ? <a href="register.html" class="theme-color">Đăng ký ngay !</a></p>
            </form>
        </div>
    </div>
</div>
@endsection