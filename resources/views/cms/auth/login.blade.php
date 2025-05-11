@extends('cms.layouts.app')
@section('content')
    <div class="login-section">
        <div class="materialContainer">
            <div class="box">
                <form method="POST" action="{{ route('auth.login') }}">
                    @csrf
                    <div class="login-title">
                        <h2>Đăng nhập</h2>
                    </div>
                    <div class="input">
                        <label for="name" style="line-height: 60px; font-weight: 300; top: 10px;">Email
                            @error('email')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                            @enderror
                            @error('infor')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                            @enderror
                        </label>
                        <input type="text" id="name" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="input">
                        <label for="pass">Mật khẩu
                            @error('password')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                            @enderror
                        </label>
                        <input type="password" id="pass" class="block mt-1 w-full" name="password">
                    </div>
                    <a href="javascript:void(0)" class="pass-forgot">Quên mật khẩu ?</a>
                    <div class="button login">
                        <button type="submit">
                            <span>Đăng Nhập</span>
                            <i class="fa fa-check"></i>
                        </button>
                    </div>
                    <p>Chưa có tài khoản ? <a href="{{ route('auth.register') }}" class="theme-color">Đăng ký ngay !</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
