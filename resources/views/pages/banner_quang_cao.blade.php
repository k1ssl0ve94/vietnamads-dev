@extends('master_fluid')
@section('breadcrumb')
    {{ Breadcrumbs::render('baogia-sub', $page, $slug) }}
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
                        <div class="">
                            <h6>Các chú ý cơ bản:</h6>
                            <p>
                                - Một khi bạn đăng Banner để quảng cáo sẽ được hiển thị trên tất cả các phiên bản desktop,
                                phiên bản table và phiên bản mobile tại trang chủ của vietnamads.vn
                            </p>
                            <p>
                                - Liên hệ: <strong>0934828881</strong>
                            </p>
                            <p>
                                - Tổng đài: <strong class="red">1900 0127</strong> để nhân viên vietnamads.vn hỗ trợ cho bạn
                            </p>
                            <p>
                                - Email: admin@vietnamads.vn or contact@vietnamads.vn
                            </p>
                            <div class="alert alert-warning">
                                <strong>Lưu ý:</strong> <br/>
                                + Giá thuê chưa bao gồm VAT<br/>
                                + Banner động phải sử dụng ảnh GIF hoặc ảnh thường<br/>
                                + Banner được đặt link trỏ về trang của bạn (no folllow)<br/>
                                + Phần dành cho đối tác và nhà tài trợ đặt logo là miễn phí<br/>
                                + Mỗi vị trí banner kí hợp đồng tối hiểu 3 tháng<br/>
                            </div>
                            <h6>Vietnamads.vn support:</h6>
                            <p>
                                + Nếu bạn ko có designer chúng tôi sẽ hỗ trợ liên kết designer cho bạn (200.000đ/banner)<br/>
                                Bạn có thể xem demo bên dưới :<br/>
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/baogia/banner1.png')}}"/>
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