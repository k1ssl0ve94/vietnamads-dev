@extends('master')

@section('title')
    <title>Tin rao của người dùng {{ $user->fullname }} | VietnamAds</title>
@endsection
@section('meta-tags')
    <meta name="description" content="Tin rao của người dùng {{ $user->fullname . ' ' . $user->id }}">
@endsection
@section('main')
<div class="row">
    <div class="col-12">
        <div class="box-search-text">
            <form class="form-inline form-search" method="GET" action="{{ route('search') }}">
                <img src="/imgs/icons/icon_search.png" class="icon-search">
                <input type="text" class="form-control" placeholder="Nhập từ khóa" name="s" value="">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>
        <div class="card card-primary">
            <div class="card-header">Tin rao của người dùng: {{ $user->fullname }}</div>
            <div class="card-body">
                <div class="total-item">Có {{ $products->total() }} tin đang rao</div>
                @foreach($products as $p)
                    @product_category(['p' => $p])
                    @endproduct_category
                @endforeach
                @if (count($products) == 0)
                <p class="text-center">Không tìm thấy kết quả nào</p>
                @endif
            </div>
        </div>
        {!! $products->links() !!}
    </div>
</div>
@endsection