@extends('cms.layouts.app')
@section('content')
    <div class="login-section">
        <div class="materialContainer">
            <div class="box">
                <form method="POST" action="{{ route('forgot-password') }}">
                    @csrf
                    <div class="login-title">
                        <h2>Quên mật khẩu</h2>
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
                    <div class="button login">
                        <button type="submit">
                            <span>Gửi mật khẩu</span>
                            <i class="fa fa-check"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
