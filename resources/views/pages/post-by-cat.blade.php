@extends('master')
@php
    $title = 'Tin tức';
    switch ($cat) {
        case config('post.category.su_kien'):
            $title = 'Sự kiện';
            break;
        case config('post.category.phan_tich'):
            $title = 'Phân tích nhận định';
            break;
        case config('post.category.kinh_nghiem'):
            $title = 'Chia sẻ kinh nghiệm';
            break;
        case config('post.category.thuong_hieu_san_pham'):
            $title = 'Thương hiệu sản phẩm';
            break;
        case config('post.category.chinh_sach_quan_ly'):
            $title = 'Chính sách quản lý';
            break;
        case config('post.category.thong_bao'):
            $title = 'Thông báo';
            break;
        default:
            break;
    }
    $description = config('post.meta')[$cat]['description'];
@endphp

@section('title')
    <title>{{ $title }} | VietnamAds</title>
@endsection
@section('meta-tags')
    <meta name="description" content="{{$description}}">
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('sub_news', config('post.breadcrumb')[$cat]) }}
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
            <div class="card-header">{{ $title }}</div>
            <div class="card-body">
                <div class="row">
                @foreach($posts as $post)
                    <div class="col-md-6">
                    @post_listing(['post' => $post])
                    @endpost_listing
                    </div>
                @endforeach
                </div>
                @if (count($posts) == 0)
                <p class="text-center">Không tìm thấy kết quả nào</p>
                @endif
            </div>
        </div>
        {!! $posts->links() !!}
    </div>
</div>
@endsection
