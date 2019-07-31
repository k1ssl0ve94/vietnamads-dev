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
                        <h4>Chế độ làm mới tin đăng</h4>
                        <div>
                            <h6>1. Chế độ làm mới tin đăng thủ công</h6>
                            <p>
                                Khi tin của bạn bị trôi, bạn có thể truy cập trang cá nhân và làm mới thủ công lại bằng nút
                                &nbsp;&nbsp;<a class="fa fa-refresh fa-2x" href="#"></a>&nbsp;&nbsp; Để làm mới lại tin rao của bạn
                                <br/>
                                Khi chưa làm mới:
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/top/step1.png')}}"/>
                            <br/>
                            <p>
                                Sau khi làm mới bạn phải đợi hết thời gian mà gói tin của bạn cho phép mới được làm mới ở mốc thời gian kế tiếp
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/top/step2.png')}}"/>
                        </div>
                        <br/>
                        <div>
                            <h6>2. Chế độ làm mới tin đăng tự động</h6>
                            <p>
                                Đội ngũ vietnamads.vn đã thiết kế hệ thống làm mới tin tự động cho quý vị<br/>
                                Đơn giản là chỉ cần click <strong>kích hoạt</strong> ở phần làm mới tự động
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/top/step3.png')}}"/>
                            <p>
                                Bảng làm mới tự động sẽ hiện ra và bạn chọn số lần làm mới tự động
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/top/step4.png')}}"/>
                            <br/>
                            <div class="alert alert-warning">
                                Điều kiện cần là tài khoản chính của bạn phải có đủ số tiền làm mới.
                                <strong>Mỗi 8 tiếng</strong> tin đăng sẽ được làm mới và tự động trừ tiền vào tài khoản chính  của bạn
                                ( mỗi lần 5000đ Tài khoản khuyến mãi ko được tính). <strong>Lưu ý rằng 1 khi đã kích hoạt bạn sẽ
                                không thể dừng cơ chế này cho đến khi hết số lần làm mới. Nếu tài khoản chính của bạn ko
                                    đủ thì tin đăng sẽ ko được làm mới</strong>
                            </div>
                            <img class="image img-thumbnail" src="{{url('/images/guide/top/step5.png')}}"/>
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