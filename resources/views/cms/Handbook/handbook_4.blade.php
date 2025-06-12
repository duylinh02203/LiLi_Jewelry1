@extends('cms.layouts.app')
@section('content')
<div class="col-12">
    <div class="cloth-review">
        <div class="tab-content" id="nav-tabContent" style="border-bottom:1px solid #ccc;">
            <div class="tab-pane fade show active" id="desc" style="padding-bottom: 0px !important;">
                <div class="shipping-chart" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <div class="col-md-7" style="padding:0px 10px;">
                        <div class="col-md-10">
                            <h2 style="text-decoration: underline;">Tác dụng khi đeo bạc đối với sức khỏe và tâm linh</h2>
                        </div>
                        <br><br><br>
                        <h4 style=" margin-bottom: 20px; line-height:30px;">
                            CBạn có biết tại sao nhiều người giàu lại chọn đeo trang sức bạc thay vì đeo vàng, bạch kim? Đó là vì khi đeo vòng bạc, dây chuyền bạc, nhẫn bạc…
                            sẽ có những tác dụng đặc biệt mà các kim loại khác không có. Hãy cùng LiLi khám phá xem khi đeo bạc có tác dụng gì nhé:
                        </h4>
                        <br>
                        <strong>
                            <h2>1. Tác dụng của bạc đối với sức khỏe</h2>
                        </strong>
                        <br>
                        <strong>
                            <h2>1.1. Bạc giúp tránh gió, chống cảm gió</h2>
                        </strong>
                        <br>
                        <div style="margin: 10px;">
                            <img src="{{asset('cms/assets/images/Cam-gio-768x768.png')}}" class="img-fluid blur-up lazyloaded"
                                alt="Nguyễn Tran"
                                style="max-width: 100%; max-height: auto; object-fit: cover; border-radius: 10px;">
                        </div>
                        <br>
                        <h4 style=" margin-bottom: 20px; line-height:30px;">
                            Trang sức bạc sẽ hút lượng khí độc này, bằng phản ứng tạo kết tủa Ag2S có màu đen bám trên bạc.
                            <br>
                            Vậy nên khi đeo trang sức bạc bị xỉn màu là chuyển bình thường mà có khi còn là tốt cho bạn đó.
                            Nếu là bạc chuẩn thì làm trắng lại đơn giản theo hướng dẫn trên kênh trang sức LiLi nhé.
                            <br>
                            Ngoài ra, Theo công bố trên tạp chí uy tín về sức khỏe “We heart“.
                        </h4>
                        <br>
                        <strong>
                            <h2>1.2. Các nghiên cứu đã chỉ ra, bạc còn có tác dụng diệt khuẩn, kháng khuẩn và virus rất tốt.</h2>
                        </strong>
                        <br>

                        <div style="margin: 10px;">
                            <img src="{{asset('cms/assets/images/bac-con-co-tac-dung-diet-khuan-khang-khuan-va-virus-rat-tot-1024x1024.png')}}" class="img-fluid blur-up lazyloaded"
                                alt="Nguyễn Tran"
                                style="max-width: 100%; max-height: auto; object-fit: cover; border-radius: 10px;">
                        </div>

                        <br>
                        <h4 style=" margin-bottom: 20px; line-height:30px;"><strong>
                                <h2>1.3. Trang sức bạc thúc đẩy quá trình điều tiết và lưu thông nhiệt bên trong cơ thể người đeo.</h2>
                            </strong></h4>
                        <br>

                        <h4 style=" margin-bottom: 20px; line-height:30px;"><strong>
                                <h2>1.4. Bạc giúp duy trì cân bằng cảm xúc, thúc đẩy sức khỏe tinh thần và ngăn ngừa việc tâm trạng thất thường, trầm cảm</h2><br>
                            </strong>
                            <div style="margin: 10px;">
                                <img src="{{asset('cms/assets/images/Bac-giup-duy-tri-can-bang-cam-xuc-1024x1024.png')}}" class="img-fluid blur-up lazyloaded"
                                    alt="Nguyễn Tran"
                                    style="max-width: 100%; max-height: auto; object-fit: cover; border-radius: 10px;">
                            </div>
                            <br>
                            <h4 style=" margin-bottom: 20px; line-height:30px;"><strong>
                                    <h2>2. Tác dụng của bạc trong tâm linh</h2><br>
                                </strong>Từ cổ xưa, bạc đã là kim loại được các nền văn minh từ Châu Âu đến Châu Á coi là có sức mạnh trừ tà ma vô cùng mạnh.
                                <br>
                                Như chúng ta đã biết, theo truyền thuyết Phương Tây, ma cà rồng có thể bị giết bởi vũ khi làm từ bạc.
                                Khi tiếp xúc với bạc, chúng sẽ bị thiêu đốt và không thể phục hồi. Viên đạn bạc cũng là vũ khí hữu hiệu để giết người sói.
                                Và không phải ngẫu nhiên, các nền văn minh Phương Đông cũng có chung quan điểm này về bạc.
                                 Người Trung Quốc từ ngàn năm trước đã dùng bạc để chế tác trang sức và các vật dụng phong thủy giúp xua đuổi tà ma và mang lại thịnh vượng.
                                <div style="margin: 10px;">
                                    <img src="{{asset('cms/assets/images/Vien-dan-bac-giet-nguoi-soi-1024x1024.png')}}" class="img-fluid blur-up lazyloaded"
                                        alt="Nguyễn Tran"
                                        style="max-width: 100%; max-height: auto; object-fit: cover; border-radius: 10px;">
                                </div>
                                <br>
                                <h4 style=" margin-bottom: 20px; line-height:30px;"><strong>
                                        <h2>3. Kết luận</h2><br>
                                    </strong>Kết luận: Trên đây, LiLi đã giới thiệu với bạn 10 tác dụng khi đeo bạc đối với sức khỏe và tâm linh, phong thủy. 
                                    Giúp bạn có câu trả lời cho câu hỏi: đeo bạc có tác dụng gì?
                                     Trang sức bạc nói riêng, hay bạc nói chung có thật nhiều tác dụng hữu ích phải không bạn. 

                                    <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection