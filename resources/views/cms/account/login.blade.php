@extends('cms.layouts.app')
@section('content')
<div class="login-section">
    <div class="materialContainer">
        <div class="box">
            <form method="POST" action="http://localhost:8000/login">
                <input type="hidden" name="_token" value="MkRqEzTGuoSx6LqJUm0OAKxSgNUYt26wTT7RMUZY">
                <div class="login-title">
                    <h2>Login</h2>
                </div>
                <div class="input">
                    <label for="name" style="line-height: 60px; font-weight: 300; top: 10px;">Username</label>
                    <input type="email" id="name" name="email" :value="old('email')" required="" autofocus="" autocomplete="name">
                </div>

                <div class="input">
                    <label for="pass">Password</label>
                    <input type="password" id="pass" class="block mt-1 w-full" name="password" required="" autocomplete="current-password">
                </div>

                <a href="javascript:void(0)" class="pass-forgot">Forgot your password?</a>

                <div class="button login">
                    <button type="submit">
                        <span>Log In</span>
                        <i class="fa fa-check"></i>
                    </button>
                </div>

                <p>Not a member? <a href="register.html" class="theme-color">Sign up now</a></p>
            </form>
        </div>
    </div>
</div>
@endsection