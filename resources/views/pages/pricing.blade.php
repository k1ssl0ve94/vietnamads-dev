@extends('master_fluid')
@section('breadcrumb')
    {{ Breadcrumbs::render('baogia') }}
@endsection
@section('title')
    <title>Báo giá tin rao | VietnamAds</title>
@endsection
@section('meta-tags')
    <meta name="description" content="Báo giá tin rao, bảng giá">
@endsection
@section('main')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-danger">
                <div class="card-header"><h1>Báo giá dịch vụ</h1></div>
                <div class="card-body">
                    {{--<table class="table table-bordered">--}}
                        {{--<thead class="table-header">--}}
                            {{--<tr>--}}
                                {{--<th style="width: 10%">Tên gói</th>--}}
                                {{--<th style="width: 10%">Độ ưu tiên</th>--}}
                                {{--<th style="width: 20%">Màu sắc</th>--}}
                                {{--<th>Tiện ích</th>--}}
                                {{--<th>Chi tiết giá</th>--}}
                            {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                            {{--@if(count($servicePackages))--}}
                                {{--@foreach($servicePackages as $service)--}}
                                    {{--<tr>--}}
                                        {{--<td>{{$service->name}}</td>--}}
                                        {{--<td>{{$service->priority}}</td>--}}
                                        {{--<td>--}}
                                            {{--<span style="color: {{$service->title_color}}">Tiêu đề</span><br/>--}}
                                            {{--<span style="color: {{$service->parameter_color}}">Thông số</span><br/>--}}
                                            {{--<span style="color: {{$service->price_color}}">Giá:--}}
                                                {{--{{number_format($service->fee_point)}} vnđ/ngày</span>--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<p>--}}
                                                {{--<i class="fa {{$service->allow_promotion ? 'fa-check-circle' : 'fa-minus-circle'}}"></i>--}}
                                                {{--Sử dụng khuyến mại--}}
                                            {{--</p>--}}
                                            {{--<p>--}}
                                                {{--<i class="fa {{$service->allow_sms ? 'fa-check-circle' : 'fa-minus-circle'}}"></i>--}}
                                                {{--Tích hợp SMS--}}
                                            {{--</p>--}}
                                            {{--<p>--}}
                                                {{--<i class="fa {{$service->auto_active ? 'fa-check-circle' : 'fa-minus-circle'}}"></i>--}}
                                                {{--Tự động duyệt bài--}}
                                            {{--</p>--}}
                                            {{--<p>--}}
                                                {{--<i class="fa {{$service->icon ? 'fa-check-circle' : 'fa-minus-circle'}}"></i>--}}
                                                {{--Hiển thị Icon <i class="fa fa-diamond"></i>--}}
                                            {{--</p>--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--@if($service->options)--}}
                                                {{--@foreach($service->options as $option)--}}
                                                    {{--<p>--}}
                                                        {{--<span class="">- {{$option->name}}( {{$option->days}} ngày): </span>--}}
                                                        {{--<span class="number" style="float: right;">--}}
                                                            {{--{{ number_format($service->fee_point * $option->days) }} vnđ</span>--}}
                                                    {{--</p>--}}
                                                {{--@endforeach--}}
                                            {{--@endif--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                    <img class="image img-thumbnail" src="{{url('/images/guide/baogia/price.png')}}"/>
                    <br/>
                    <h6 class="text-center">Hướng dẫn thanh toán</h6>
                    <div>
                        <img class="image img-thumbnail" src="{{url('/images/guide/payment/step1.png')}}"/>
                    </div>
                    <table class="table">
                        <tbody>
                        <tr>
                            <th class="text-center">
                                <img src="{{asset('images/vnpay_logo.png' )}}" width="120"
                                     class="img-rounded img-thumbnail bank_logo">
                                <div>Qua VNPay</div>
                            </th>
                            <td>
                                <a href="{{route('add_point')}}" class="btn btn-warning btn-md
                                            fa fa-plus-circle"> Nạp ngay</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div>
                        <img class="image img-thumbnail" src="{{url('/images/guide/payment/step3.png')}}"/>
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