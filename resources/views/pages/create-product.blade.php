@extends('master_one_column')
@section('title')
    <title>Đăng tin rao | VietnamAds</title>
@endsection
@section('meta-tags')
    <meta name="description" content="Đăng tin rao">
@endsection
@section('main')
<div class="row">
    <script type="text/javascript">
        var currentProductId;
        var allowImgNb = 12;
    </script>
    <div class="col">
        <p class="text-red font-weight-bold">
            Hãy thoải mái sử dụng chức năng đăng tin của vietnamads.vn miễn phí.
            Vui lòng không spam tiêu đề và nội dung tin rao vì nếu cố tình chúng tôi sẽ khóa tài khoản của bạn
            vình viễn không báo trước!
            Khi đăng tin hãy khai báo chính xác để được ban kiểm duyệt thông qua
            nhanh nhất(thời gian kiểm duyệt 15 phút đến 3 tiếng). Trân trọng!</p>
        <ul class="nav nav-tabs" role="tablist" id="tab-create-product">
            <li class="nav-item">
                <a class="nav-link @if ($tab == 1) active @endif" id="pano-tab" data-toggle="tab" href="#create-pano" role="tab" aria-controls="pano" aria-selected="true">Pano, biển quảng cáo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if ($tab == 2) active @endif" id="qctt-tab" data-toggle="tab" href="#create-qctt" role="tab" aria-controls="ad" aria-selected="false">Quảng cáo truyền thông</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if ($tab == 3) active @endif" id="social-tab" data-toggle="tab" href="#create-social" role="tab" aria-controls="social" aria-selected="false">Digital marketing</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if ($tab == 4) active @endif" id="web-tab" data-toggle="tab" href="#create-web" role="tab" aria-controls="web" aria-selected="false">Ads Banner</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if ($tab == 5) active @endif" id="other-tab" data-toggle="tab" href="#create-other" role="tab" aria-controls="other" aria-selected="false">Nghiệp vụ khác</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if ($tab == 6) active @endif" id="find-tab" data-toggle="tab" href="#create-find" role="tab" aria-controls="find" aria-selected="false">Cần thuê dịch vụ</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade @if ($tab == 1) show active @endif" id="create-pano" role="tabpanel" aria-labelledby="pano-tab">
                <div class="card card-tab">
                    <div class="card-body">
                        @include('partials.create-pano')
                    </div>
                </div>
            </div>
            <div class="tab-pane fade @if ($tab == 2) show active @endif" id="create-qctt" role="tabpanel" aria-labelledby="qctt-tab">
                <div class="card card-tab">
                    <div class="card-body">
                        @include('partials.create-ad')
                    </div>
                </div>
            </div>
            <div class="tab-pane fade @if ($tab == 3) show active @endif" id="create-social" role="tabpanel" aria-labelledby="social-tab">
                <div class="card card-tab">
                    <div class="card-body">
                        @include('partials.create-social')
                    </div>
                </div>
            </div>
            <div class="tab-pane fade @if ($tab == 4) show active @endif" id="create-web" role="tabpanel" aria-labelledby="web-tab">
                <div class="card card-tab">
                    <div class="card-body">
                        @include('partials.create-web')
                    </div>
                </div>
            </div>
            <div class="tab-pane fade @if ($tab == 5) show active @endif" id="create-other" role="tabpanel" aria-labelledby="other-tab">
                <div class="card card-tab">
                    <div class="card-body">
                        @include('partials.create-other')
                    </div>
                </div>
            </div>
            <div class="tab-pane fade @if ($tab == 6) show active @endif" id="create-find" role="tabpanel" aria-labelledby="find-tab">
                <div class="card card-tab">
                    <div class="card-body">
                        @include('partials.create-find')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection