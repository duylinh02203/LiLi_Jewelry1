@extends('cms.layouts.app')
@section('content')
<section class="pt-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <div class="fail-icon bg-white py-4 px-3 rounded shadow-sm text-center">
                    <div class="main-container d-flex justify-content-center">
                        <div class="check-container">
                            <div class="check-background bg-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 65px; height: 65px;">
                                <svg viewBox="0 0 24 24" fill="none" width="30" height="30" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 9v4m0 4h.01M12 2a10 10 0 1 0 0 20a10 10 0 0 0 0-20Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="fail-contain mt-4">
                        <h4 class="text-danger">Gửi thất bại</h4>
                        <h5 class="font-light">Đã có lỗi xảy ra khi xử lý đơn hàng!</h5>
                        <a href="{{route('cart')}}" class="btn btn-outline-danger mt-3" style="border-radius: 10px;">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
