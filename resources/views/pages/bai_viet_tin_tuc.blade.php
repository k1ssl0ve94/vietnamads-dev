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
                            <div class="alert-warning alert">
                                Vietnamads.vn đang trong thời gian ưu đãi miễn phí cho các đơn vị muốn đặt bài viết
                                quảng cáo, xã luận, thông cáo trên các chuyên mục tin tức của vietnamads.vn.
                            </div>
                            <h6>Điều kiện đặt bài viết miễn phí</h6>
                            <p>
                                + Là các bên hoạt động của ngành quảng cáo hoặc marketing.
                            </p>
                            <h6>Liên hệ</h6>
                            <p>
                                - Hotline call: <strong>0934828881</strong> (Manager) <strong>0919562247</strong> (Saler)
                                hoặc tổng đài <strong class="red">1900 0127</strong> (giờ hành chính)
                            </p>
                            <p>
                                - Email: admin@vietnamads.vn or contact@vietnamads.vn
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