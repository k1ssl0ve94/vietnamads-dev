@extends('master')

@section('title')
    <title>Từ khóa {{ $tag->name }} } | VietnamAds</title>
@endsection
@section('meta-tags')
    <meta name="description" content="Tìm theo từ khóa, {{$tag->name}}">
@endsection
@section('main')
<div class="row">
    <div class="col-12">
        <div class="box-search-text">
            <form class="form-inline form-search" method="GET" action="{{ route('search') }}">
                <img src="/imgs/icons/icon_search.png" class="icon-search">
                <input type="text" class="form-control" placeholder="Nhập từ khóa" name="s" value="">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                <input type="hidden" name="order" value="">
                <input type="hidden" name="has_image" value="">
                <input type="hidden" name="has_video" value="">
                <input type="hidden" name="city" value="">
                <input type="hidden" name="district" value="">
                <input type="hidden" name="ward" value="">
                <input type="hidden" name="street" value="">
                <input type="hidden" name="provider" value="">
                <input type="hidden" name="price_range" value="">
                <input type="hidden" name="sub_cat" value="">
                <input type="hidden" name="pano_type" value="">
                <input type="hidden" name="pano_size" value="">
                <input type="hidden" name="pano_border" value="">
                <input type="hidden" name="pano_light" value="">
                <input type="hidden" name="social_type" value="">
                <input type="hidden" name="social_follow" value="">
                <input type="hidden" name="web_type" value="">
                <input type="hidden" name="web_position" value="">
            </form>
        </div>
        <div class="card card-primary">
            <div class="card-header">Từ khóa: {{ $tag->name }}</div>
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

@section('advanced_search')
    @include('partials.advanced-search')
@endsection