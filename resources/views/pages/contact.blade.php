@extends('master_fluid')
@section('title')
    <title>Liên hệ | VietnamAds</title>
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('contact') }}
@endsection
@section('meta-tags')
    <meta name="description" content="Liên hệ">
@endsection
@section('main')
<div id="page-contact" class="container">
    <div class="hero content col-md-12">
        <h1>Tham gia và liên hệ Vietnamads.vn </h1>
        <p>Để tham gia hàng nghìn dịch vụ quảng cáo & marketing từ nhà cung cấp dịch vụ khắp Việt Nam</p>
    </div>
    <div class="col-md-12" id="box-map">
        <div class="col">
            <div class="company-info">
                <p>
                    <a href="{{ route('home') }}" class="logo" alt="vietnamads.vn">
                        <img src="/imgs/logo.png" alt="logo">
                    </a>
                </p>
                Công ty cổ phần đầu tư và công nghệ Long Anh<br>
                ĐKKD số : 0108435119 ngày cấp 17/9/2018 bởi sở KH&ĐT tp Hà Nội<br>
                Tầng 8, tòa nhà 315 Trường Chinh, Thanh Xuân, Hà Nội<br>
                Chịu trách nhiệm nội dung : Bà Nguyễn Hoàng Phương Anh<br>
                Vietnamads phát triển bởi Long Anh Group : <a href="http://www.longanhgroup.com/">http://www.longanhgroup.com/</a><br>
                Ghi rõ nguồn "vietnamads.vn" khi phát hành lại thông tin từ website<br>
                <span class="text-danger">Vietnamads không cho thuê, mua bán dịch vụ quảng cáo mà chỉ cho đăng tin từ người cung cấp dịch vụ, vui lòng liên hệ trực tiếp người đăng tin</span><br>
                Số điện thoại : 1900 0127<br>
                Email: contact@vietnamads.vn<br>
            </div>
        </div>
        <div class="col">
            <div class="mapouter">
                <div class="gmap_canvas">
                    <iframe width="100%" height="500" id="gmap_canvas"
                            src="https://maps.google.com/maps?q=315%20Tr%C6%B0%E1%BB%9Dng%20Chinh%2C%20Thanh%20Xu%C3%A2n%2C%20H%C3%A0%20N%E1%BB%99i&t=&z=15&ie=UTF8&iwloc=&output=embed"
                        frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-8 offset-md-2">
            <form action="">
                <h5>Bạn cần hợp tác với vietnamads.vn?</h5>
                <p>Nếu bạn có ý đinh hợp tác hãy gửi thư và thông tin. Chúng tôi sẽ liên hệ lại ngay với bạn.</p>
                <div class="form-group">
                    <input type="text" class="form-control" name="" placeholder="Nhập tên">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="" placeholder="Nhập email">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="" placeholder="Số điện thoại">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="" placeholder="Nhập công ty">
                </div>
                <div class="form-group">
                    <textarea name="" class="form-control" rows="6" placeholder="Nhập lời nhắn"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block">Gửi tin nhắn</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection