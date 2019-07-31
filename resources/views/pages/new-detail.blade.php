@extends('master')

@php
    $metaCanonical = \Illuminate\Support\Facades\Request::url();
    if ($post->meta_canonical) {
        $metaCanonical = $post->meta_canonical;
    }
@endphp

@section('meta-tags')
    <meta name="keywords" content="{{$post->meta_keywords}}">
    <meta name="description" content="{{$post->meta_description}}">
    <link rel="canonical"  href="{{$post->meta_canonical}}">

    <meta property="fb:app_id" content="{{config('services.facebook.client_id')}}" />
    <meta property="og:url" content="{{$post->getPostURL()}}" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="{{$post->getImageUrlFull()}}" />
    <meta property="og:image:alt" content="{{$post->title}}" />

    @if ($post->meta_description)
    <meta property="og:description" content="{{$post->meta_description}}" />
    @else
    <meta property="og:description" content="{{$post->meta_description}}" />
    @endif

    @if ($post->meta_title)
    <meta property="og:title" content="{{$post->meta_title}}" />
    @else
    <meta property="og:title" content="{{$post->title}}" />
    @endif
@endsection

@section('meta-canonical')
    <link rel="canonical"  href="{{$metaCanonical}}">
@endsection

@section('title')
    @if ($post->meta_title)
        <title>{{ $post->meta_title }} | VietnamAds</title>
    @else
        <title>{{ $post->title }} | VietnamAds</title>
    @endif
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('news_detail', $post) }}
@endsection

@section('main')
<div class="row">
    <div class="col-12">
        <div class="box-search-text">
            <form class="form-inline">
                <img src="/imgs/icons/icon_search.png" class="icon-search">
                <input type="text" class="form-control" placeholder="Nhập từ khóa">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card card-post">
            <div class="card-header" style="color: #ffffff"><h1>{{ $post->title }}</h1></div>
            <div class="card-body">                
                <div class="mb-3 content">
                    {!! $post->content !!}
                </div>
                <div class="mb-3 share">
                    <div class="addthis_inline_share_toolbox_t3om"></div>
                </div>
                <div class="row">
                    <h6 class="col-12">Các tin liên quan</h6>
                    <ul class="col-12 list-group">
                        @foreach ($relatedPosts as $p)
                            <li class="list-group-item-light">
                                <a href="{{ $p->getPostURL() }}">{{ $p->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @include('partials.hot-news') 
    </div>
</div>
@endsection