@extends('cms.layouts.app')
@section('content')
<style>
    .underline-input-1 {
        border: none;
        border-bottom: 0.5px solid #ccc;
        padding: 8px 4px;
        outline: none;
        font-size: 16px;
        margin-bottom: 20px;
    }

    .underline-input-2 {
        border: none;
        border-bottom: 0.5px solid #ccc;
        padding: 8px 4px;
        outline: none;
        font-size: 16px;
    }

    .wrap-login {
        display: flex;
        flex-direction: column;
    }

    .wrap-login label {
        color: rgba(33, 37, 41, 0.4);
        font-weight: 100;
        font-size: 18px;
    }
</style>
<div class="login-section">
    <div class="materialContainer">
        <div class="box">
            <form method="POST" action="{{ route('login.action') }}">
                @csrf
                <div class="login-title">
                    <h2 style="margin-bottom: 20px;">Đăng nhập</h2>
                </div>
                <div class="wrap-login">
                    <label>Email
                        @error('email')
                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                        @enderror
                        @error('infor')
                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                        @enderror
                    </label>
                    <input type="text" id="name" class="underline-input-1" name="email" value="{{ old('email') }}">
                </div>
                <div class="wrap-login">
                    <label for="pass">Mật khẩu
                        @error('password')
                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                        @enderror
                    </label>
                    <input type="password" id="pass" class="underline-input-2" class="block mt-1 w-full" name="password">
                </div>
                <a href="{{ route('forgot-password') }}" class="pass-forgot">Quên mật khẩu ?</a>
                <div class="button login">
                    <button type="submit">
                        <span>Đăng Nhập</span>
                        <i class="fa fa-check"></i>
                    </button>
                </div>
                <p>Chưa có tài khoản ? <a href="{{ route('register') }}" class="theme-color">Đăng ký ngay !</a>
                </p>
            </form>
        </div>
    </div>
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.createElement('div');
            notification.innerText = "{{ session('success') }}";

            Object.assign(notification.style, {
                position: 'fixed',
                top: '120px',
                right: '20px',
                padding: '10px 20px',
                borderRadius: '8px',
                color: 'white',
                backgroundColor: 'green',
                zIndex: '1000',
                boxShadow: '0 4px 8px rgba(0, 0, 0, 0.2)',
                opacity: '1',
                transition: 'opacity 0.5s ease-out',
            });

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, 3000);
        });
    </script>
    @endif
</div>
@endsection