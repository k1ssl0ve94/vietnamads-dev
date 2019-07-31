@extends('master_fluid')
@section('title')
    <title>Liên hệ với chúng tôi | VietnamAds</title>
@endsection
@section('meta-tags')
    <meta name="description" content="Liên hệ với chúng tôi">
@endsection
@section('main')
<div id="page-demo">
    <div class="hero">
        <h1>Liên hệ với VietnamAds</h1>
    </div>
    <div class="row" id="box-map">
        <div class="col">
            <div class="company-info">
                <p>
                    <a href="{{ route('home') }}" class="logo" alt="vietnamads.vn">
                        <img src="/imgs/logo.png" alt="logo">
                    </a>
                </p>
                Công ty Cổ phần dịch vụ và thương mại VietnamAds <br>
                Số 14, ngõ 165, Cầu Giấy, Hà Nội <br>
                Đại diện pháp luật: Bùi Anh Tuấn - Giám đốc công ty <br>
                Giấy phép số 4524524 Bộ Công Thương 20/10/2018 <br>
                Số điện thoại: 40292928228 <br>
                Email: support@vietnamads.vn <br>
                Website: vietnamads.vn
            </div>
        </div>
        <div class="col">
            <div class="mapouter">
                <div class="gmap_canvas">
                    <iframe width="100%" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=hanoi&t=&z=15&ie=UTF8&iwloc=&output=embed"
                        frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="container pt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="">
                    <h5>Want to work with us?</h5>
                    <p>Please don't hesitate to contact us for more information about work</p>
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
</div>
@endsection