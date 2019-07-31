@extends('master')
@section('main')
<div class="row">
    <div class="col">
        <ul class="nav nav-tabs" role="tablist" id="tab-create-product">
            <li class="nav-item">
                <a class="nav-link active" id="pano-tab" data-toggle="tab" href="#create-pano" role="tab" aria-controls="pano" aria-selected="true">Dân số/Đời sống</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="qctt-tab" data-toggle="tab" href="#create-qctt" role="tab" aria-controls="ad" aria-selected="false">Kinh Tế</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="social-tab" data-toggle="tab" href="#create-social" role="tab" aria-controls="social" aria-selected="false">Nông - Lâm - Thủy sản</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="web-tab" data-toggle="tab" href="#create-web" role="tab" aria-controls="web" aria-selected="false">Xem phân tích</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="create-pano" role="tabpanel" aria-labelledby="pano-tab">
                <div class="card card-tab">
                    <div class="card-body">
                        <p class="text-center">This feature is under development.</p>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="create-qctt" role="tabpanel" aria-labelledby="qctt-tab">
                <div class="card card-tab">
                    <div class="card-body">
                        <p class="text-center">This feature is under development.</p>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="create-social" role="tabpanel" aria-labelledby="social-tab">
                <div class="card card-tab">
                    <div class="card-body">
                        <p class="text-center">This feature is under development.</p>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="create-web" role="tabpanel" aria-labelledby="web-tab">
                <div class="card card-tab">
                    <div class="card-body">
                        <p class="text-center">This feature is under development.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">Các tin tức quảng cáo nổi bật</div>
            <div class="card-body">
                <div class="row">
                    @foreach ($products as $p)
                    <div class="col-md-6">
                        @product_home(['p' => $p])
                        @endproduct_home
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        {!! $products->links() !!}
    </div>
</div>
@endsection