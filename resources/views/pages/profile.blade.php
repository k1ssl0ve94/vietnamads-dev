@extends('master')
@section('title')
    <title>Thông tin cá nhân | VietnamAds</title>
@endsection
@section('meta-tags')
    <meta name="description" content="Thông tin cá nhân {{ auth()->user()->id}}">
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
        @if (Session::has('message_active'))
            <div class="alert alert-success active_message_box">
                {{ Session::get('message_active') }}
                <a class="fa fa-close" onclick="closeActiveMessageBox()" style="float: right; margin-right: 12px;"></a>
            </div>
        @endif
        @include('partials.user_info')
        <div class="card card-muted">
            <ul class="nav nav-tabs">
                <li class="nav-item {{$activeTab == 'products' ? 'active': ''}}">
                    <a class="nav-link {{$activeTab == 'products' ? 'active': ''}}"
                       href="{{route('profile')}}">Tin đã đăng</a>
                </li>
                <li class="nav-item {{$activeTab == 'bills' ? 'active': ''}}">
                    <a class="nav-link {{$activeTab == 'bills' ? 'active': ''}}"
                       href="{{route('bills')}}">Lịch sử giao dịch</a>
                </li>
            </ul>
            {{--<div class="card-header">Danh sách tin đã đăng</div>--}}
            <div class="card-body" style="overflow: scroll;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tin đăng</th>
                            <th scope="col">Hình thức</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Làm mới</th>
                            <th scope="col">Làm mới tự động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as  $p)
                        @php
                            $link = $p->detailLink();
                        @endphp
                        <tr>
                            <th scope="row">
                                {{ $p->id }}
                                @if($p->edit_times > 0 && $p->status != config('product.status.disabled'))
                                    <a href="{{route('user_product_edit', ['id' => $p->id])}}"
                                        class="fa fa-edit" title="Còn {{$p->edit_times}} lần chỉnh sửa"></a>
                                @endif
                            </th>
                            <td>
                                <a href="{{ $link }}" target="_blank">{{ $p->title }}</a>
                                <p><small>Hiệu lực từ {{$p->from->format('d/m/Y')}}
                                        tới {{$p->to->format('d/m/Y')}}</small></p>
                            </td>
                            <td>{{ $p->service? $p->service->name: ''}}</td>
                            <td class="text-center">
                                @if ($p->status == config('product.status.active'))
                                <span class="badge badge-success">Active</span>
                                @elseif ($p->status == config('product.status.pending'))
                                <span class="badge badge-secondary">Pending</span>
                                @elseif ($p->status == config('product.status.disabled'))
                                <span class="badge badge-dark">Disabled</span>
                                @endif
                                @if (!empty($p->note))
                                <div>{{ $p->note }}</div>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($p->status == config('product.status.active'))
                                    Làm mới lúc: {{$p->last_refresh->format('H:i d/m/Y')}}<br/>

                                    @if ($p->canRefresh(\Illuminate\Support\Facades\Auth::user(), false))
                                    <a href="{{ route('refresh', ['product'=> $p->id]) }}" class="fa fa-refresh"
                                       title="Làm mới"></a>
                                    @else
                                        @if($p->status == config('product.status.active'))
                                            Kế tiếp: {{ $p->nextRefreshTime()}}
                                        @endif
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($p->status == config('product.status.active'))
                                    @if($p->auto_refresh == 0)
                                        <a href="#" class="btn-auto-setting"
                                           data-toggle="modal" data-target="#modal-auto-setting"
                                           data-target-id="{{$p->id}}"
                                           title="">Kích hoạt</a>
                                    @else
                                        Còn {{$p->auto_refresh}} lần. (Giá:
                                            {{number_format(5000)}}vnđ)
                                        @if($p->status == config('product.status.active'))
                                            <br/>Kế tiếp: {{ $p->nextRefreshTime($autoTime)}}
                                        @endif
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $products->links() !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-auto-setting" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="modal-dialog" role="document">
        <form action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kích hoạt làm mới tự động</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="box" style="color: red;">
                        Note: Mỗi 8 tiếng tin rao của bạn sẽ được làm mới và được trừ 5000 vào tài khoản chính, điều kiện cần là số dư chính
                        của bạn phải đủ. Không áp dụng cho số dư khuyến mại. Trâng trọng.
                    </div>
                    <div class="alert result"></div>
                    <div class="form-group">
                        <label>Số lần làm mới</label>
                        <input type="hidden" name="target_id" value="" id="target_id">
                        <input name="refresh_times" type="number" id="refresh_times"
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Giá làm mới tự động: </label>
                        <strong class="right">{{number_format(5000)}}vnđ/ lần</strong>
                    </div>
                    <div class="form-group">
                        <label>Tổng tiền: </label>
                        <strong class="totalRefreshPrice right"></strong> vnđ
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Kích hoạt</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('other_scripts')
    @if(!empty($isNeedActiveSms))
    <script type="text/javascript">
        $(function () {
            var modalActiveCode = $('#modal-active-account');
            var modalActiveErr = modalActiveCode.find('.alert-danger').first();
            var modalActiveInfo = modalActiveCode.find('.alert-info').first();
            modalActiveCode.modal('show');
        });
    </script>
    @endif
    <script type="text/javascript">
        function closeActiveMessageBox() {
            $('.active_message_box').remove();
        }
    </script>
@endsection