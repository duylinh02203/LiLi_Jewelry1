@extends('cms.layouts.app')
@section('content')
    @push('styles')
        <style>
            .btn.btn-solid-default,
            .btn.btn-solid-default::before {
                border-radius: 10px !important;
            }

            .contact-details {
                border-radius: 10px;
            }
        </style>
    @endpush
    <section class="breadcrumb-section section-b-space" style="padding-top:20px;padding-bottom:20px;">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>Liên hệ</h3>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">
                                    <i class="fas fa-home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-section" style="margin-bottom: 25px;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="materialContainer">
                        <div class="material-details">
                            <div class="title title1 title-effect mb-1 title-left">
                                <h2>Liên hệ với chúng tôi</h2>
                                <p class="ms-0 w-100">Địa chỉ email của bạn sẽ không được công bố. Các trường bắt buộc được
                                    đánh dấu *</p>
                            </div>
                        </div>
                        <form action="{{ route('contact.create') }}" method="POST">
                            @csrf
                            <div class="row g-4 mt-md-1 mt-2">
                                <div class="col-md-10">
                                    <label for="first" class="form-label">Tên người gửi
                                        @error('name')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="name" class="form-control" id="first"
                                        placeholder="Nhập tên của bạn"
                                        value="{{ old('first_name') }}{{ session('userData')['name'] ?? '' }}">
                                </div>
                                <div class="col-md-10">
                                    <label for="email" class="form-label">Email
                                        @error('email')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="email" class="form-control" id="email"
                                        placeholder="Nhập địa chỉ Email của bạn"
                                        value="{{ session('userData')['email'] ?? '' }}" disabled>
                                </div>
                                <div class="col-md-10">
                                    <label for="email2" class="form-label">Điện thoại
                                        @error('phone')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="phone" class="form-control" id="email2"
                                        placeholder="Nhập số điện thoại của bạn"
                                        value="{{ $userData['phone'] ?? '' }}">
                                </div>

                                <div class="col-12">
                                    <label for="comment" class="form-label">Bình luận
                                        @error('comment')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <textarea class="form-control" name="comment" id="comment" rows="8">{{ old('comment') }}</textarea>
                                </div>

                                <div class="col-10">
                                    <button class="btn btn-solid-default" type="submit">Gửi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="contact-details" style="background-color:rgb(236, 239, 244);">
                        <div>
                            <h2>Hãy liên lạc với chúng tôi</h2>
                            <h5 class="font-light">Chúng tôi sẵn sàng lắng nghe mọi đề xuất hoặc chỉ để trò chuyện</h5>
                            <div class="contact-box">
                                <div class="contact-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                </div>
                                <div class="contact-title">
                                    <h4>Địa chỉ :</h4>
                                    <p>149 Khương Thượng, Đống Đa, Hà Nội</p>
                                </div>
                            </div>

                            <div class="contact-box">
                                <div class="contact-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone">
                                        <path
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="contact-title">
                                    <h4>Số điện thoại :</h4>
                                    <p>+84 397326216</p>
                                </div>
                            </div>

                            <div class="contact-box">
                                <div class="contact-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail">
                                        <path
                                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                        </path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                </div>
                                <div class="contact-title">
                                    <h4>Địa chỉ Email :</h4>
                                    <p>dangduylinh@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const notification = document.createElement('div');
                    notification.innerText = "{{ session('error') }}";

                    Object.assign(notification.style, {
                        position: 'fixed',
                        top: '120px',
                        right: '20px',
                        padding: '10px 20px',
                        borderRadius: '8px',
                        color: 'white',
                        backgroundColor: 'orange',
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
    </section>
@endsection
