@extends('master_fluid')
@section('breadcrumb')
    {{ Breadcrumbs::render('about', $page, $slug) }}
@endsection
@section('title')
    <title>{{ $page }} | VietnamAds</title>
@endsection
@section('meta-tags')
    <meta name="description" content="{{$page}}">
@endsection
@section('main')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-header">{{ $page }}</div>
                <div class="card-body">
                   <h4>Hướng dẫn</h4>
                    <div class="">
                        <h6>Bước 1: Click ô đăng nhập góc phải bên trên màn hình</h6>
                        <img class="image img-thumbnail" src="{{url('/images/guide/guide_register/step1.png')}}"/>
                    </div>
                    <br/>
                    <div>
                        <h6>Bước 2: Bảng đăng ký</h6>
                        <p>
                            + Ở đây bạn có thể đăng ký bằng cách thủ công chọn . chọn đăng ký
                        </p>
                        <img class="image img-thumbnail" src="{{url('/images/guide/guide_register/step2.png')}}"/>
                        <p>
                            + Hoặc bạn có thể đăng nhập bằng tài khoản facebook hoặc tài khoản google (được bảo mật)
                        </p>
                        <img class="image img-thumbnail" src="{{url('/images/guide/guide_register/step3.png')}}"/>
                        <p>
                            Lưu ý: Với cả 2 cách bạn chúng tôi đều lưu email và số điện thoại vào cơ sở dữ liệu.
                            <strong>Số điện thoại là duy nhất và bắt buộc bạn phải xác thực mới có thể sử dụng tài khoản để đăng tin</strong>
                        </p>
                        <p>
                            1. Email dùng để gửi <strong>các thông báo quan trọng</strong> về tài khoản.
                            <strong>Hãy lưu ý điền đúng</strong>
                            <br/>
                            2. Số điện thoại được dùng để <strong>nhận Gift code có trị giá quy đổi bằng số dư khuyến mãi.</strong>
                            Các chương trình <strong>quà tặng từ vietnamads.vn.</strong>
                            <strong>Cho nên bắt buộc bạn phải dùng số điện thoại thật</strong>
                        </p>

                    </div>
                    <div>
                        <h6>Bước 3: Kích hoạt/ xác nhận tài khoản</h6>
                        <p>
                            + Nếu bạn đăng kí thủ công thì bạn sẽ phải trải qua bước OTP.
                            Lưu ý tối đa 3 lần nếu bạn ko xác nhận qua OTP thì bạn sẽ phải kích hoạt bằng tay
                            bằng cách nhắn tin theo cú pháp
                        </p>
                        <div class="alert alert-warning text-center">
                            <strong>Vietnamads + Mã tài khoản</strong>
                        </div>
                        <p>
                            Nhắn đến số <strong class="text-danger">0919562247</strong> (sms only)
                            để nhân viên trực ban của vietnamads.vn có thể kích hoạt manual.
                            Hoặc gọi đến tổng đài <strong class="text-danger">1900 0127</strong> để nhân viên của chúng tôi hỗ trợ cho bạn
                        </p>
                        <p>
                            + Nếu bạn đăng nhập qua tài khoản facebook hoặc google thì bạn chỉ cần làm theo cách nhắn tin theo cú pháp
                        </p>
                        <div class="alert alert-warning text-center">
                            <strong>Vietnamads + Mã tài khoản</strong>
                        </div>
                        <p>
                            Nhắn đến số <strong class="text-danger">0919562247</strong> (sms only) để nhân viên trực ban của
                            vietnamads.vn có thể kích hoạt manual.
                            Hoặc gọi đến tổng đài <strong class="text-danger">1900 0127</strong> để nhân viên của chúng tôi hỗ trợ cho bạn
                        </p>
                        <p>
                            Mã tài khoản bạn có thể xem tại trang cá nhân là <strong>ID tài khoản</strong>
                            của bạn sau khi đã qua bước khai báo đăng kí
                        </p>
                        <img class="image img-thumbnail" src="{{url('/images/guide/guide_register/step4.png')}}"/>
                        <p>Sau khi hoàn tất bước xác thực số điện thoại bạn có thể đi vào sử dụng <strong>vietnamads.vn</strong></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            @include('partials.col-right-about')
        </div>
    </div>
</div>
@endsection