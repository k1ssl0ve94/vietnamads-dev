@extends('master')
@section('title')
    <title>Nạp tiền vào tài khoản | VietnamAds</title>
@endsection
@section('meta-tags')
    <meta name="description" content="Nạp tiền vào tài khoản">
@endsection
@section('main')
    <div class="row" id="profile">
        @php $user = auth()->user();
        @endphp
        <div class="col">
            @if (Session::has('msg'))
                <div class="alert alert-success">
                    {{ Session::get('msg') }}
                </div>
            @endif
            @if (Session::has('msg_err'))
                <div class="alert alert-danger">
                    {{ Session::get('msg_err') }}
                </div>
            @endif
            {{--@include('partials.user_info')--}}
            <div class="card card-primary">
                <div class="card-header">
                    <span class="card-title">Nạp tiền qua cổng thanh toán VNPay</span>
                </div>
                <div class="card-body">
                    <form action="{{route('add_point_post')}}" method="post" id="fAddPoint" class="form form-horizontal">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Số lượng tiền *:</label>
                                <select class="form-control" name="amount" id="amount">
                                    <option value="0">- Chọn số tiền -</option>
                                    @foreach($amountList as $amount)
                                        <option value="{{$amount}}">{{number_format($amount)}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="row col-md-12 form-group bank_list" style="display: none;">
                            @foreach($banks as $code => $label)
                                <div class="col-md-4 bank_block form-check">
                                    <div class="bank-title">
                                        <input type="radio" name="bank"  value="{{$code}}"
                                               id="bank_{{$code}}" class="form-check-input"/>
                                        <label for="bank_{{$code}}">{{$label}}</label>
                                    </div>
                                    <label for="bank_{{$code}}" class="form-check-label">
                                    <img src="{{asset('images/banks/'.strtolower($code).'_logo.png' )}}"
                                        class="img-rounded img-thumbnail bank_logo">
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="clear"></div>
                        {{--<div class="form-group btn-group">--}}
                            <button type="submit" class="btn btn-default btn-primary" id="btnSubmitPoint">Nạp tiền</button>
                        {{--</div>--}}
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
        #profile .bank_block {
            height: 90px;
            margin-bottom: 8px;
        }
        #profile .bank_block .bank-title {
            height: 40px;
        }
        #profile .bank_block .bank_logo {

        }
    </style>
@endsection
@section('other_scripts')
        <script type="text/javascript">
            $(function () {
                hideBank();
                $('#amount').on('change', function (e) {
                    if ($(this).val()) {
                        showBank();
                    } else {
                        hideBank();
                    }
                });
            });
            function showBank() {
                $('.bank_list').show();
                $('#btnSubmitPoint').show();
            }
            function hideBank() {
                $('.bank_list').hide();
                $('#btnSubmitPoint').hide();
            }
        </script>

@endsection