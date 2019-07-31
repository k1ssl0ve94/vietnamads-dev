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
                            <h6>Làm nhà tài trợ của vietnamads.vn</h6>
                            <p>
                                Vietnamads.vn là kênh thông tin về các dịch vụ quảng cáo và marketing đầu tiên của Việt
                                Nam với mong muốn xây dựng một kênh thông tin hữu hiệu, tiết kiệm thời gian và chi phí khi
                                tìm kiếm các địa điểm, giải pháp, phương thức, dịch vụ quảng cáo và marketing.</p>
                            <p>
                                Vietnamads.vn luôn mong muốn hợp tác với các đơn vị đầu ngành của quảng cáo và marketing.
                                Nhà tài trợ cho vietnamads.vn sẽ được giảm giá 50% tất cả các dịch vụ trong vòng 1 năm.
                                Vietnamads.vn chân thành mong muốn hợp tác với các đơn vị lâu đời, uy tín và lớn mạnh
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