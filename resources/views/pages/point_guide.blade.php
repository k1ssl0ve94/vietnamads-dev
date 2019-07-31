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
                    <div class="card-header">Hướng dẫn nạp tiền</div>
                    <div class="card-body">
                        <h4>Hướng dẫn thanh toán</h4>
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