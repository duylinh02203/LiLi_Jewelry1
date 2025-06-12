@extends('cms.layouts.app')
@section('content')
<style>
    .btn-solid-default::before {
        border-radius: 10px !important;
    }
    .submit-PasswordUser::before{
        background-color: brown;
    }
    .back::before{
        background-color: gray;
    }
</style>
<section class="contact-section" style="margin-bottom: 30px;">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="materialContainer">
                    <div class="material-details">
                        <div class="title title1 title-effect mb-1 title-left">
                            <h2>Đổi mật khẩu</h2>
                        </div>
                    </div>
                    <form action="{{route('changePassword')}}" class="form-changePasswordUser" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row g-4 mt-md-1 mt-2">
                            <div class="col-md-12">
                                <label for="emaibtn btn-solid-defaultl" class="form-label">Mật khẩu cũ
                                    @error('old_password')
                                    <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                    @error('infor')
                                    <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input type="password" name="old_password" class="form-control" id="old_password"
                                    placeholder="Nhập mật khẩu cũ">
                            </div>
                            <div class="col-md-12">
                                <label for="first" class="form-label">Mật khẩu mới
                                    @error('new_password')
                                    <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input type="password" name="new_password" class="form-control" id="new_password"
                                    placeholder="Nhập mật khẩu mới">
                            </div>
                            <div class="col-md-12">
                                <label for="email2" class="form-label">Xác nhận mật khẩu mới
                                    @error('new_password_confirmation')
                                    <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </label>
                                <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation"
                                    placeholder="Nhập lại mật khẩu mới">
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-solid-default submit-PasswordUser" type="submit" style="border-radius:10px; border-color: brown;">Đổi mật khẩu</button>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-solid-default back" type="button" style="border-radius:10px; border-color: gray;">Quay lại</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
</section>
<script>
    document.querySelector('.back').addEventListener('click', function() {
        window.location.href = '/information'
    });
</script>
@endsection