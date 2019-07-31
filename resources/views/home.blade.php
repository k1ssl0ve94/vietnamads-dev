@extends('master')

@section('title')
    <title>{{$seos['meta_title']}}</title>
@show
@section('breadcrumb')
    {{ Breadcrumbs::render('home') }}
@endsection
@section('meta-tags')
    <meta name="description" content="{{$seos['meta_description']}}">
    <meta name="keywords" content="{{$seos['meta_keywords']}}">
    <meta property="og:url"           content="{{\Illuminate\Support\Facades\Request::url()}}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="{{$seos['fb_meta_title']}}" />
    <meta property="og:description"   content="{{$seos['fb_meta_description']}}" />
    <meta property="og:image"         content="{{$seos['fb_image_url']}}" />    
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type" : "Organization",
        "name": "Vietnam Ads",
        "url": "https://www.vietnamads.vn/",
        "description": "Vietnamads là kênh thông tin về dịch vụ quảng cáo và marketing hàng đầu tại Việt Nam. Người dùng có thể dễ dàng tra cứu, tìm kiếm hoặc đăng tải các thông tin về các dịch vụ quảng cáo và marketing trên vietnamads với khối lượng tin tức lớn,đầy đủ và luôn được cập nhật liên tục 24/7",
        "address": "Tầng 8, tòa nhà 315 Trường Chinh, Thanh Xuân, Hà Nội",
        "email": "mailto:vietnamadsdotvn@gmail.com",
        "sameAs" :
        [
            "https://twitter.com/vietnamadsvn",
            "https://www.instagram.com/vietnamads/",
            "https://www.linkedin.com/company/vietnamads/about/",
            "https://about.me/vietnamads/",
            "https://www.youtube.com/channel/UCTWgeGSUC_Fh5_YBNteussQ/about",
            "https://soundcloud.com/vietnamads",
            "https://vietnamads.tumblr.com/",
            "https://myspace.com/vietnamads",
            "https://www.pinterest.com/vietnamadsvn/",
            "https://trello.com/vietnamads",
            "https://www.reddit.com/user/vietnamadsvn/",
            "https://www.scoop.it/u/vietnamads",
            "https://www.quora.com/profile/Long-Anh-5",
            "https://github.com/vietnamads",
            "https://medium.com/@vietnamads",
            "https://www.behance.net/vietnamads"
        ],
         "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+84919562247",
            "contactType": "customer service",
            "areaServed": "Việt Nam"
        }
    }
</script>

@endsection
@section('main')
    @include('partials.col-left')
@endsection