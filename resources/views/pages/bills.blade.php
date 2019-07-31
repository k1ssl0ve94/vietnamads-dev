@extends('master')
@section('title')
    <title>Lịch sử giao dịch | VietnamAds</title>
@endsection
@section('meta-tags')
    <meta name="description" content="Lịch sử giao dịch cá nhân">
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
            @include('partials.user_info')

            <div class="card card-muted nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="nav-item {{$activeTab == 'products' ? 'active': ''}}">
                        <a class="nav-link {{$activeTab == 'products' ? 'active': ''}}" href="{{route('profile')}}">Tin đã đăng</a>
                    </li>
                    <li class="nav-item {{$activeTab == 'bills' ? 'active': ''}}">
                        <a class="nav-link {{$activeTab == 'bills' ? 'active': ''}}" href="{{route('bills')}}">Lịch sử giao dịch</a>
                    </li>
                </ul>
                {{--<div class="card-header">Lịch sử giao dịch</div>--}}
                <div class="card-body" style="overflow: scroll;">
                    <table class="table table-bordered">
                        <thead class="table-header">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Type</th>
                            <th scope="col">Mode</th>
                            <th scope="col">Số tiền</th>
                            <th scope="col" title="Tiền khuyến mại">Tiền KM</th>
                            <th scope="col">Ghi chú</th>
                            <th scope="col">Trạng thái</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bills as  $item)
                            <tr>
                                <th scope="row">{{ $item->id }}</th>
                                <td>
                                    {{$item->getTypeLabel()}}
                                </td>
                                <td>{{ $item->getModeLabel()}}</td>
                                <td class="text-right">
                                   {{number_format($item->point)}}
                                </td>
                                <td class="text-right">
                                    {{number_format($item->promotion_point)}}
                                </td>
                                <td class="text-left">
                                    @if ($item->service_id && $item->service)
                                        Gói: {{$item->service}}
                                        @if($item->option_id && $item->option)
                                            ( {{$item->option}})
                                        @endif
                                    @endif
                                    @if($item->product_id && $item->product)
                                        <br/>Tin rao:
                                        {{$item->product}}
                                    @endif
                                    <p>{{$item->note}}</p>
                                    <small>Tạo lúc: {{$item->created_at->format('H:i d/m/Y')}}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{$item->getStatusClass()}}">{{$item->getStatusLabel()}}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $bills->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection