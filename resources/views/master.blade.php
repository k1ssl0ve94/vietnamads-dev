<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="SiY3rxs81xpi7JKDyYyaqLJJwYAOKoJBF59TKr0neeI" />
    @section('title')
    <title>{{$seos['meta_title']}}</title>
    @show
    @section('meta-tags')
    <meta name="description" content="{{$seos['meta_description']}}">
    <meta name="keywords" content="{{$seos['meta_keywords']}}">
    @show
    @section('meta-canonical')
    <link rel="canonical"  href="{{\Illuminate\Support\Facades\Request::url()}}">
    @show
    <meta name="author" content="vietnamads.vn">
    <meta name="robots" content="index, follow" />
    <meta name="geo.region" content="VN" />
    <meta name="geo.placename" content="Ha Noi, Ho Chi Minh" />
    <meta name="geo.position" content="21.02945;105.854444" />
    <meta name="ICBM" content="21.02945, 105.854444" />
    <link rel="shortcut icon" href="/imgs/icon.ico" />

    {{--<link rel="alternate" href="{{\Illuminate\Support\Facades\Request::url()}}"--}}
          {{--hreflang="vi-vn"--}}
    {{--/>--}}

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i&amp;subset=latin-ext,vietnamese">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    {{--<script src="https://www.google.com/recaptcha/api.js?onload=recaptchaApiLoaded&render=explicit" async defer></script>--}}
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131416354-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-131416354-1');
    </script>
</head>
<body>
    @include('partials.header')
    <div id="main">
        <div class="container">
            {{--@if (!empty($banners['banner_7']))--}}
            {{--<a href="{{ $banners['banner_7']['url'] }}" class="banner-slide left d-none d-md-block" target="_blank"><img src="{{ $banners['banner_7']['image_url'] }}" alt=""></a>--}}
            {{--@endif--}}
            {{--@if (!empty($banners['banner_8']))--}}
            {{--<a href="{{ $banners['banner_8']['url'] }}" class="banner-slide right d-none d-md-block" target="_blank"><img src="{{ $banners['banner_8']['image_url'] }}" alt=""></a>--}}
            {{--@endif--}}
            <div class="row">
                <div class="col-md-12 col-12">
                    @yield('breadcrumb')
                </div>
                <div class="col-lg-9">
                    @yield('main')
                </div>
                <div class="col-lg-3">
                    @section('col-right')
                        @include('partials.col-right')
                    @show
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer')
    @include('partials.modals')
    <script src="/js/location.js"></script>
    {!! NoCaptcha::renderJs() !!}
    <script>
        window.all_settings = {!! json_encode($allSettings) !!};
        window.app_url = {!! json_encode(url('/')) !!};
    </script>
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('other_scripts')
</body>
</html>