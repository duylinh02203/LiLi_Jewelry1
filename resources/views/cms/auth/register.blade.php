@extends('cms.layouts.app')
@section('content')
    <div class="login-section">
        <style>
            .underline-input {
        border: none;
        border-bottom: 0.5px solid #ccc;
        padding: 8px 4px;
        outline: none;
        font-size: 16px;
    }
    .wrap-regis{
        display: flex;
        flex-direction: column;
    }
    .wrap-regis label{
        color: rgba(33, 37, 41, 0.4);
        font-weight: 100;
        font-size: 18px;
    }
        </style>
        <div class="materialContainer">
            <div class="box">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="login-title">
                        <h2>Đăng ký</h2>
                    </div>

                    <div class="wrap-regis">
                        <label for="name" style="line-height: 60px; font-weight: 300;">Tên tài khoản
                            @error('name')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                            @enderror
                        </label>
                        <input class="underline-input" type="text" id="name" class="block mt-1 w-full" name="name" 
                            value="{{ old('name') }}">
                    </div>

                    <div class="wrap-regis">
                        <label  style="line-height: 60px; font-weight: 300;">Số điện
                            thoại
                            @error('phone')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                            @enderror
                        </label>
                        <input class="underline-input" type="text" id="phone" class="block mt-1 w-full" name="phone"
                            value="{{ old('phone') }}">
                    </div>

                    <div class="wrap-regis">
                        <label style="line-height: 60px; font-weight: 300;">Email
                            @error('email')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                            @enderror
                        </label>
                        <input class="underline-input" type="email" id="emailname" class="block mt-1 w-full" name="email"
                            value="{{ old('email') }}">
                    </div>

                    <div class="wrap-regis">
                        <label style="line-height: 60px; font-weight: 300;">Mật khẩu
                            @error('password')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                            @enderror
                        </label>
                        <input class="underline-input" type="password" id="pass" class="block mt-1 w-full" name="password">
                    </div>

                    <div class="wrap-regis">
                        <label style="line-height: 60px; font-weight: 300;" >Xác nhận mật khẩu
                            @error('password_confirmation')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                            @enderror
                        </label>
                        <input class="underline-input" type="password" id="compass" class="block mt-1 w-full" name="password_confirmation">
                    </div>

                    <div class="button login">
                        <button type="submit">
                            <span>Đăng Ký</span>
                            <i class="fa fa-check"></i>
                        </button>
                        <p><a href="{{ route('login') }}" class="theme-color">Bạn đã có tài khoản?</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
