<div class="card card-muted">
    <div class="card-header"><h2>Thông tin cá nhân</h2></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="{{ $user->getAvatarUrl() }}" class="avatar img-fluid">
                <button class="btn btn-link" id="change-avatar-btn">Đổi ảnh đại diện</button>
                <input type="file" id="avatar-file-input" class="d-none" accept="image/*">
            </div>
            <div class="col-md-5">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th scope="row">Mã tài khoản</th>
                        <td class="text-right">{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Họ và Tên</th>
                        <td class="text-right">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Số điện Thoại:</th>
                        <td class="text-right">{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Địa Chỉ Email:</th>
                        <td class="text-right">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Tỉnh/Thành Phố:</th>
                        <td class="text-right">{{ $user->city ? $user->city : '' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <p>Số tiền đã nạp: <span class="badge badge-success right number">
                                {{ number_format($user->point) }} VNĐ</span></p>
                <p><a href="{{route('bills')}}">
                        Số tiền đã dùng: <span class="badge badge-secondary right number">
                                    {{ number_format($user->used_point) }} vnđ</span></a></p>
                <p>Số tiền còn lại: <span class="badge badge-success right number">
                                {{ number_format($user->remain_point) }} vnđ</span></p>
                <p>Số tiền khuyến mại: <span class="badge badge-success right number">
                                {{ number_format($user->promotion_point) }} vnđ</span></p>
                @if($user->isVerifiedPhone())
                <button class="btn btn-default btn-lg btn-block btn-primary" data-toggle="modal"
                        data-target="#modal-change-password"
                >Đổi mật khẩu đăng nhập
                </button>
                @elseif($user->phone)
                <button class="btn btn-default btn-lg btn-block btn-primary" data-toggle="modal"
                        data-target="#modal-active-account"
                >Kích hoạt số ĐT
                </button>
                @endif
                <button class="btn btn-success btn-lg btn-block" data-toggle="modal"
                        @if($user->isVerifiedPhone())
                        data-target="#modal-update-profile"
                        @else
                        data-target="#modal-verify-phone"
                        @endif
                >Đổi thông tin cá nhân
                </button>
                <a href="{{route('pointGuide')}}" class="btn btn-warning btn-lg
                    btn-block fa fa-plus-circle"> Nạp tiền</a>
                <button class="btn btn-outline-primary btn-lg btn-block btn-use-gift-code" data-toggle="modal"
                        @if($user->isVerifiedPhone())
                        data-target="#modal-gift-code"
                        @else
                        data-target="#modal-verify-phone"
                        @endif
                >Nhập Gift code
                </button>
            </div>
        </div>
    </div>
</div>