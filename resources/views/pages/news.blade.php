@extends('master')
@section('breadcrumb')
    {{ Breadcrumbs::render('news') }}
@endsection
@section('title')
    <title>Tin tức | VietnamAds</title>
@endsection
@section('meta-tags')
    <meta name="description" content="{{$description}}">
@endsection
@section('main')
<div class="row">
    <div class="col-12">
        <div class="box-search-text">
            <form class="form-inline" action="{{ route('search') }}" method="GET">
                <img src="/imgs/icons/icon_search.png" class="icon-search">
                <input type="text" class="form-control" placeholder="Nhập từ khóa">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        @include('partials.box-top-content')
    </div>
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                tin mới nhất
            </div>
            <div class="card-body">
                @foreach($latestPosts as $post)
                <div class="new clearfix">
                    <a href="{{ $post->getPostURL() }}" class="title d-block">{{ $post->title }}</a>
                    <p>{{ str_limit($post->sapo, 130) }} <a href="{{ $post->getPostURL() }}">Chi tiết</a> </p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">Phân tích, nhận định<a href="{{ route('phan-tich') }}" class="view-all">Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></div>
            <div class="card-body">
                <div class="row">
                    @foreach ($phanTich as $post)
                    <div class="col-md-6">
                        @post_listing(['post' => $post]) @endpost_listing
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @if ($phanTich->count() > 0)
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="{{ route('phan-tich', ['page' => 1]) }}">1</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('phan-tich', ['page' => 2]) }}">2</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('phan-tich', ['page' => 3]) }}">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="{{ route('phan-tich', ['page' => 2]) }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Trang sau</span>
                    </a>
                </li>
            </ul>
        </nav>
        @endif
    </div>
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">Sự kiện<a href="{{ route('su-kien') }}" class="view-all">Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></div>
            <div class="card-body">
                <div class="row">
                    @foreach ($suKien as $post)
                    <div class="col-md-6">
                        @post_listing(['post' => $post]) @endpost_listing
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @if ($suKien->count() > 0)
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="{{ route('su-kien', ['page' => 1]) }}">1</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('su-kien', ['page' => 2]) }}">2</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('su-kien', ['page' => 3]) }}">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="{{ route('su-kien', ['page' => 2]) }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Trang sau</span>
                    </a>
                </li>
            </ul>
        </nav>
        @endif
    </div>

    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">Chia sẻ kinh nghiệm<a href="{{ route('kinh-nghiem') }}" class="view-all">Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></div>
            <div class="card-body">
                <div class="row">
                    @foreach ($kinhNghiem as $post)
                        <div class="col-md-6">
                            @post_listing(['post' => $post])
                            @endpost_listing
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @if ($kinhNghiem->count() > 0)
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item active"><a class="page-link" href="{{ route('kinh-nghiem', ['page' => 1]) }}">1</a></li>
                    <li class="page-item"><a class="page-link" href="{{ route('kinh-nghiem', ['page' => 2]) }}">2</a></li>
                    <li class="page-item"><a class="page-link" href="{{ route('kinh-nghiem', ['page' => 3]) }}">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="{{ route('kinh-nghiem', ['page' => 2]) }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Trang sau</span>
                        </a>
                    </li>
                </ul>
            </nav>
        @endif
    </div>

    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">Thương hiệu, sản phẩm<a href="{{ route('thuong-hieu') }}" class="view-all">Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></div>
            <div class="card-body">
                <div class="row">
                    @foreach ($thuongHieu as $post)
                    <div class="col-md-6">
                        @post_listing(['post' => $post])
                        @endpost_listing
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @if ($thuongHieu->count() > 0)
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="{{ route('thuong-hieu', ['page' => 1]) }}">1</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('thuong-hieu', ['page' => 2]) }}">2</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('thuong-hieu', ['page' => 3]) }}">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="{{ route('thuong-hieu', ['page' => 2]) }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Trang sau</span>
                    </a>
                </li>
            </ul>
        </nav>
        @endif
    </div>
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">Chính sách quản lí<a href="{{ route('chinh-sach') }}" class="view-all">Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></div>
            <div class="card-body">
                <div class="row">
                    @foreach ($chinhSach as $post)
                    <div class="col-md-6">
                        @post_listing(['post' => $post])
                        @endpost_listing
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @if ($chinhSach->count() > 0)
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="{{ route('chinh-sach', ['page' => 1]) }}">1</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('chinh-sach', ['page' => 2]) }}">2</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('chinh-sach', ['page' => 3]) }}">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="{{ route('chinh-sach', ['page' => 2]) }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Trang sau</span>
                    </a>
                </li>
            </ul>
        </nav>
        @endif
    </div>
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">Thông báo từ vietnamads<a href="{{ route('thong-bao') }}" class="view-all">Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></div>
            <div class="card-body">
                <div class="row">
                    @foreach ($thongBao as $post)
                    <div class="col-md-6">
                        @post_listing(['post' => $post])
                        @endpost_listing
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @if ($thongBao->count() > 0)
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="{{ route('thong-bao', ['page' => 1]) }}">1</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('thong-bao', ['page' => 2]) }}">2</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('thong-bao', ['page' => 3]) }}">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="{{ route('thong-bao', ['page' => 2]) }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Trang sau</span>
                    </a>
                </li>
            </ul>
        </nav>
        @endif
    </div>

</div>
@endsection