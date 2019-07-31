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
                        <h4>Hướng dẫn trang quản trị</h4>
                        <div>
                            <h6>1. Điều hướng</h6>
                            <p>
                                Các thông số và điều hướng tải khoản của bạn luôn xuất hiện bên phía góc phải của website
                                vietnamads.vn gồm:
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/manage/step1.png')}}"/>
                            <br/>
                            <p>
                                + Hòm thư<br/>
                                + Số dư còn lại và số dư khuyến mãi<br/>
                                + Chế độ tài khoản<br/>
                                + Nút đăng tin rao<br/>
                                + Nút nạp tiền
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>2. Trang cá nhân</h6>
                            <p>
                                Tại trang cá nhân có 1 số điều cần lưu ý sau:<br/>
                                + Số tiền đã nạp : Tổng số dư bạn đã nạp vào tài khoản từ lúc khởi tạo
                                ( chúng tôi căn cứ điều này để đưa tài khoản của bạn lên tài khoản VIP nếu bạn
                                cán mốc 10,000,000)<br/>
                                + Số tiền đã dùng : Tổng số dư mà bạn đã sử dụng<br/>
                                + Số tiền còn lại : Tổng số dư mà bạn còn trong tài khoản<br/>
                                + Số tiền khuyến mãi : Tổng số tiền khuyến mãi ( chỉ dùng để đăng tin)
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/manage/step2.png')}}"/>
                            <p>
                                Các thông tin tài khoản về email và số điện thoại nếu có thay đổi bạn phải liên hệ với
                                ban quản trị qua số điện thoại <strong class="text-danger">1900 0127</strong> (giờ hành chính)<br/>
                                Tại dashboard trang cá nhân bạn có thể:<br/>
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/manage/step3.png')}}"/>
                            <br/>
                            <p>
                                + Sửa tin ( lưu ý số lần mỗi gói )<br/>
                                + Làm mới tin<br/>
                                + Xem trang thái các tin rao<br/>
                                + Tra cứu lại lịch sử giao dịch
                            </p>
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