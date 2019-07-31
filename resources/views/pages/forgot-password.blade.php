@extends('master')
@section('title')
    <title>Lấy lại mật khẩu | VietnamAds</title>
@endsection
@section('meta-tags')
    <meta name="description" content="Quên mật khẩu, lấy lại mật khẩu">
@endsection
@section('main')
<div class="col">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Đổi mật khẩu</h3>
            </div>
            <div class="card-body p-3">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                @if ($errors->count())
                <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
                @if ($token)
                <form action="{{ route('forgot-password') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Mật khẩu mới</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nhập lại mật khẩu</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="col-md-4" style="padding-top:28px">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection