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

        #provinceList {
            z-index: 1000;
            max-height: 200px;
            overflow-y: auto;
            display: none;
        }

        #provinceList li {
            cursor: pointer;
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

                <form action="{{ route('changeUserInfor') }}" class="form-changeUserInfor" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row g-4 mt-md-1 mt-2">
                        {{-- CỘT TRÁI --}}
                        <div class="col-lg-6">
                            <div class="materialContainer">
                                <div class="material-details">
                                    <div class="title title1 title-effect mb-1 title-left">
                                        <h2>Thông tin tài khoản</h2>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="email" class="form-label">Email
                                        @error('email')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="email" class="form-control" id="email"
                                        placeholder="Nhập địa chỉ Email của bạn" value="{{ $user->email ?? '' }}"
                                        readonly>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="name" class="form-label">Tên tài khoản
                                        @error('name')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Nhập tên của bạn" value="{{ $user->name ?? '' }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="phone" class="form-label">Điện thoại
                                        @error('phone')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="phone" class="form-control" id="phone"
                                        placeholder="Nhập số điện thoại của bạn"
                                        value="{{ $userInfor->phone ?? '' }}">
                                </div>

                                <div class="col-md-12" style="display:none;">
                                    <label for="password" class="form-label">Mật khẩu
                                        @error('password')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="password" name="password" class="form-control" id="password"
                                        value="{{ $user->password }}" readonly>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="confirmPass" class="form-label">Xác nhận mật khẩu
                                        @error('confirmPass')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="password" name="confirmPass" class="form-control" id="confirmPass"
                                        placeholder="Xác nhận lại mật khẩu">
                                </div>
                            </div>
                        </div>

                        {{-- CỘT PHẢI --}}
                        <div class="col-lg-6">
                            <div class="materialContainer">
                                <div class="material-details">
                                    <div class="title title1 title-effect mb-1 title-left" style="visibility: hidden;">
                                        <h2>Thông tin liên hệ</h2>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3 position-relative">
                                    <label for="province" class="form-label">Tỉnh/Thành phố
                                        @error('province')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="province" id="province" class="form-control"
                                        placeholder="Nhập hoặc chọn tỉnh" autocomplete="off"
                                        value="{{ $userInfor->province ?? '' }}">
                                    <ul id="provinceList" class="list-group position-absolute w-100"></ul>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="district" class="form-label">Quận/Huyện
                                        @error('district')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="district" class="form-control" id="district"
                                        placeholder="Nhập quận/huyện" value="{{ $userInfor->district ?? '' }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="address" class="form-label">Địa chỉ chi tiết
                                        @error('address')
                                            <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input type="text" name="address" class="form-control" id="address"
                                        placeholder="Nhập địa chỉ" value="{{ $userInfor->address ?? '' }}">
                                </div>
                            </div>
                        </div>

                        {{-- NÚT --}}
                        <div class="col-12 d-flex gap-2 mt-3">
                            <button class="btn btn-solid-default submit-form" type="submit"
                                style="border-radius:10px;">Chỉnh sửa thông tin</button>
                            <button class="btn btn-solid-default change-pass" type="button"
                                style="border-radius: 10px ; border-color: brown;">Đổi mật khẩu</button>
                            <button class="btn btn-solid-default back" type="button"
                                style="border-radius:10px; border-color: gray;">Quay lại</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        const provinces = [
            "Hà Nội", "Hồ Chí Minh", "Đà Nẵng", "Hải Phòng", "Cần Thơ", "An Giang", "Bà Rịa - Vũng Tàu",
            "Bắc Giang", "Bắc Kạn", "Bạc Liêu", "Bắc Ninh", "Bến Tre", "Bình Định", "Bình Dương", "Bình Phước",
            "Bình Thuận", "Cà Mau", "Cao Bằng", "Đắk Lắk", "Đắk Nông", "Điện Biên", "Đồng Nai", "Đồng Tháp",
            "Gia Lai", "Hà Giang", "Hà Nam", "Hà Tĩnh", "Hải Dương", "Hậu Giang", "Hòa Bình", "Hưng Yên",
            "Khánh Hòa", "Kiên Giang", "Kon Tum", "Lai Châu", "Lâm Đồng", "Lạng Sơn", "Lào Cai", "Long An",
            "Nam Định", "Nghệ An", "Ninh Bình", "Ninh Thuận", "Phú Thọ", "Phú Yên", "Quảng Bình", "Quảng Nam",
            "Quảng Ngãi", "Quảng Ninh", "Quảng Trị", "Sóc Trăng", "Sơn La", "Tây Ninh", "Thái Bình", "Thái Nguyên",
            "Thanh Hóa", "Thừa Thiên Huế", "Tiền Giang", "Trà Vinh", "Tuyên Quang", "Vĩnh Long", "Vĩnh Phúc", "Yên Bái"
        ];

        const provinceInput = document.getElementById("province");
        const provinceList = document.getElementById("provinceList");

        provinceInput.addEventListener("input", function() {
            const keyword = this.value.toLowerCase();
            provinceList.innerHTML = "";
            if (keyword === "") {
                provinceList.style.display = "none";
                return;
            }

            const filtered = provinces.filter(p => p.toLowerCase().includes(keyword));
            if (filtered.length === 0) {
                provinceList.style.display = "none";
                return;
            }

            filtered.forEach(p => {
                const li = document.createElement("li");
                li.textContent = p;
                li.classList.add("list-group-item", "list-group-item-action");
                li.addEventListener("click", () => {
                    provinceInput.value = p;
                    provinceList.innerHTML = "";
                    provinceList.style.display = "none";
                });
                provinceList.appendChild(li);
            });

            provinceList.style.display = "block";
        });

        document.addEventListener("click", function(e) {
            if (!provinceInput.contains(e.target) && !provinceList.contains(e.target)) {
                provinceList.style.display = "none";
            }
        });
    </script>

    <script>
        document.querySelector('.back').addEventListener('click', function() {
            window.location.href = '/home';
        });
        document.querySelector('.change-pass').addEventListener('click', function() {
            window.location.href = '/nguoi-dung/doi-mat-khau';
        });
    </script>
@endsection
