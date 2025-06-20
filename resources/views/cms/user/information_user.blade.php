@extends('cms.layouts.app')
@section('content')
    <style>
        .btn-solid-default::before {
            border-radius: 10px !important;
        }

        .change-pass::before {
            background-color: brown;
            border: brown;
        }

        .back::before {
            background-color: gray;
        }
    </style>
    <section class="contact-section" style="margin-bottom: 30px;">
        <div class="container">
            <div class="row g-4">
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
                <div class="col-lg-6">
                    <div class="materialContainer">
                        <div class="material-details">
                            <div class="title title1 title-effect mb-1 title-left">
                                <h2>Thông tin tài khoản</h2>
                            </div>
                        </div>
                        <form action="{{ route('changeUserInfor') }}" class="form-changeUserInfor" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row g-4 mt-md-1 mt-2">
                                <div class="col-md-12">
                                    <label for="emaibtn btn-solid-defaultl" class="form-label">Email
                                        @error('email')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="email" class="form-control" id="email"
                                        placeholder="Nhập địa chỉ Email của bạn" value="{{ $user->email ?? '' }}"
                                        readonly>
                                </div>
                                <div class="col-md-12">
                                    <label for="first" class="form-label">Tên tài khoản
                                        @error('name')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="name" class="form-control" id="first"
                                        placeholder="Nhập tên của bạn" value="{{ $user->name ?? '' }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="email2" class="form-label">Điện thoại
                                        @error('phone')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="phone" class="form-control" id="email2"
                                        placeholder="Nhập số điện thoại của bạn"
                                        value="{{ $userInfor->phone ?? '' }}">
                                </div>
                                <div class="col-md-12" style="display:none;">
                                    <label for="first" class="form-label">Mật khẩu
                                        @error('password')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="password" name="password" class="form-control" id="first"
                                        value="{{ $user->password }}" readonly>
                                </div>
                                <div class="col-md-12">
                                    <label for="email2" class="form-label">Xác nhận mật khẩu
                                        @error('confirmPass')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="password" name="confirmPass" class="form-control" id="email2"
                                        placeholder="Xác nhận lại mật khẩu">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-solid-default submit-form" type="submit"
                                        style="border-radius:10px;">Chỉnh sửa thông tin</button>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-solid-default change-pass" type="button"
                                        style="border-radius: 10px ; border-color: brown;">Đổi mật khẩu</button>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-solid-default back" type="button"
                                        style="border-radius:10px; border-color: gray;">Quay lại</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.querySelector('.back').addEventListener('click', function() {
            window.location.href = '/home';
        });
        document.querySelector('.change-pass').addEventListener('click', function() {
            window.location.href = '/nguoi-dung/doi-mat-khau';
        });
    </script>
@endsection
