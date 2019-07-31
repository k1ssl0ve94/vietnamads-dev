<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @section('title')
        <title>VietnamAds</title>
    @show
    <link rel="shortcut icon" href="/imgs/icon.ico" />
    @section('meta-tags')
        <meta name="description" content="Vietnamads.vn, vietnamads, quang cao, marketing">
        <meta name="keywords" content="Vietnamads.vn, vietnamads, quang cao, marketing">
    @show
    @section('meta-canonical')
        <link rel="canonical"  href="{{\Illuminate\Support\Facades\Request::url()}}">
    @show
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
            <div class="row">
                <div class="col-md-12 col-12">
                    @yield('breadcrumb')
                </div>
            </div>
        </div>
        @yield('main')
    </div>
    @include('partials.footer')
    @include('partials.modals')
    <script src="/js/location.js"></script>
    {!! NoCaptcha::renderJs() !!}
    <script>
        window.all_settings = {!! json_encode($allSettings) !!};
    </script>
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>