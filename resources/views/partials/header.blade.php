<header>
    <div id="topbar">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <ul class="social-links">
                        <li class="separator"></li>
                        <li><a href="https://www.facebook.com/Vietnamadsvn-322884915019527/" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                        <li><a href="https://twitter.com/vietnamadsvn" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
                        <li><a href="https://www.youtube.com/channel/UCvL6h2DavCAzBNqQfrEB6dw" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                        <li class="separator"></li>
                        <li><a href="#subscribe-bar" class="show-modal-subscribe">{{ __('msg.subscribe_newsletter') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-9 text-right">
                    <ul>
                        <li><a href="/gioi-thieu">{{ __('msg.about') }}</a></li>
                        <li><a href="/huong-dan/dang-ky-tai-khoan-thanh-vien">{{ __('msg.guide') }}</a></li>
                        <li><a href="/bao-gia">{{ __('msg.pricing') }}</a></li>
                        <li><a href="{{ route('contact') }}">{{ __('msg.contact') }}</a></li>
                        <li><a href="tel:02439992996"><i class="fa fa-phone-square" aria-hidden="true"></i> {{ __('msg.tel_bussiness') }}</a></li>
                        <li><a href="tel:02439992997"><i class="fa fa-phone-square" aria-hidden="true"></i> {{ __('msg.tel_vip') }}</a></li>
                        {{-- @if (\App::isLocale('en'))
                        <li><a href="{{ route('locale', ['locale' => 'vi']) }}">Vietnamese</a></li>
                        @else
                        <li><a href="{{ route('locale', ['locale' => 'en']) }}">English</a></li>
                        @endif --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="header-content">
        <div class="container">
            <div class="row">
                <div class="col-4 col-md-2">
                    @if(request()->route()->getName() == 'home')
                    <h1>
                    @endif                        
                        <a href="{{ route('home') }}" class="logo" alt="vietnamads.vn">
                            <img src="/imgs/logo.png" alt="kênh thông tin dịch vụ quảng cáo số 1">
                        </a>
                    @if(request()->route()->getName() == 'home')
                    </h1>                
                    @endif   
                </div>
                <div class="d-none col-md-5 col-lg-7  d-sm-block">
                    @if (!empty($banners['banner_top']))
                    <a href="{{ $banners['banner_top']['url'] }}" class="banner-img">
                        <img src="{{ $banners['banner_top']['image_url'] }}" alt="logo">
                    </a>
                    @endif
                </div>
                <div class="col-8 col-md-5 col-lg-3 text-right user-profile-block">
                    @if (auth()->check())
                        @php
                            $user = auth()->user();
                            $isActivated = !!$user->activated;
                        @endphp
                        <div class="mb-1">
                            <a class="" href="{{route('message-box')}}"
                               aria-label="Bạn có {{number_format($user->unread_message)}} tin mới">
                                @if($user->unread_message)
                                    <span class="badge badge-danger">
                                        <i class="fa fa-envelope" aria-hidden="true"
                                           title="Bạn có {{number_format($user->unread_message)}} tin mới"></i></span>
                                @else
                                    <span class="badge badge-info"><i class="fa fa-envelope"
                                       aria-hidden="true"></i></span>
                                @endif
                            </a>
                            <a href="{{ route('profile') }}">{{ $user->name }}
                                <span class="wrap-avatar">
                                    <img class="user-avatar avatar-blue img-circle" src="{{ $user->getAvatarUrl() }}">
                                    @if($user->type == \App\User::TYPE_AGENCY)
                                        <span class="badge badge-primary badge-avatar">Agency</span>
                                    @elseif($user->type == \App\User::TYPE_NORMAL)
                                        @if($user->level == \App\User::LEVEL_VIP)
                                            <span class="badge badge-danger badge-avatar">VIP</span>
                                        @endif
                                    @endif
                                </span>
                            </a>
                            <a href="{{ route('logout') }}" class="fa fa-sign-out" title="Đăng xuất"></a>
                            <br>
                            <span class="badge badge-success" title="Tiền khả dụng">{{number_format($user->remain_point) }} vnđ</span>
                            <span class="badge badge-primary" title="Tiền khuyến mại">KM: {{number_format($user->promotion_point) }} vnđ</span>
                        </div>
                        @if ($isActivated)
                        <a class="btn btn-primary btn-sm fa fa-plus-circle" data-toggle="modal" href="#" style="display: inline-flex;"
                                @if($user->isVerifiedPhone())
                                data-target="#modal-ask-post-type"
                                @else
                                data-target="#modal-verify-phone"
                                @endif
                        > &nbsp;Đăng tin rao</a>
                        <a href="{{route('pointGuide')}}" class="btn btn-warning btn-sm
                                fa fa-plus-circle"> Nạp tiền</a>
                        @else
                        <div>Bạn chưa kích hoạt tài khoản</div>
                        @endif
                    @else
                        <p><button class="btn btn-primary" data-toggle="modal" data-target="#modal-login">{{ __('msg.login') }}</button></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="main-menu" data-toggle="sticky-onscroll">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link home-link" href="{{ route('home') }}"><i class="fa fa-home" aria-hidden="true"></i></a>
                    </li>
                    @php
                        $cat = $productConfig['category'][0];
                        $catSlug = $cat['slug'];
                    @endphp
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('category', ['slug'=> $catSlug]) }}" id="navbarDropdown1" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ $cat['name'] }}
                            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                            <div class="row">
                                <div class="col-sm-5 sub-info">
                                    <img src="/imgs/menu/img_menu1.png" alt="">
                                    <h5>{{ $cat['name'] }}</h5>
                                    <div>{{ $cat['description'] }}</div>
                                </div>
                                <div class="col-sm-7 sub-menu">
                                    <h4>{{ __('msg.category') }} {{ $cat['name'] }}</h4>
                                    @foreach ($catData[1] as $c)
                                    <a class="dropdown-item" href="{{ route('subcat', ['catSlug'=> $catSlug, 'slug' => $c['slug']]) }}">
                                        {{ $c['name'] }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </li>
                    @php
                        $cat = $productConfig['category'][1];
                        $catSlug = $cat['slug'];
                    @endphp
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('category', ['slug'=> $catSlug]) }}" id="navbarDropdown2" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ $cat['name'] }}
                            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                            <div class="row">
                                <div class="col-sm-5 sub-info">
                                    <img src="/imgs/menu/img_menu2.png" alt="">
                                    <h5>{{ $cat['name'] }}</h5>
                                    <div>{{ $cat['description'] }}</div>
                                </div>
                                <div class="col-sm-7 sub-menu">
                                    <h4>{{ __('msg.category') }} {{ $cat['name'] }}</h4>
                                    @foreach ($catData[2] as $c)
                                    <a class="dropdown-item" href="{{ route('subcat', ['catSlug'=> $catSlug, 'slug' => $c['slug']]) }}">
                                        {{ $c['name'] }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </li>
                    @php
                        $cat = $productConfig['category'][2];
                        $catSlug = $cat['slug'];
                    @endphp
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('category', ['slug'=> $catSlug]) }}" id="navbarDropdown3" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ $cat['name'] }}
                            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown3">
                            <div class="row">
                                <div class="col-sm-5 sub-info">
                                    <img src="/imgs/menu/img_menu3.png" alt="">
                                    <h5>{{ $cat['name'] }}</h5>
                                    <div>{{ $cat['description'] }}</div>
                                </div>
                                <div class="col-sm-7 sub-menu">
                                    <h4>{{ __('msg.category') }} {{ $cat['name'] }}</h4>
                                    @foreach ($catData[3] as $c)
                                    <a class="dropdown-item" href="{{ route('subcat', ['catSlug'=> $catSlug, 'slug' => $c['slug']]) }}">
                                        {{ $c['name'] }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </li>
                    @php
                        $cat = $productConfig['category'][3];
                        $catSlug = $cat['slug'];
                    @endphp
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('category', ['slug'=> $catSlug]) }}" id="navbarDropdown5" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ $cat['name'] }}
                            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown5">
                            <div class="row">
                                <div class="col-sm-5 sub-info">
                                    <img src="/imgs/menu/img_menu4.png" alt="">
                                    <h5>{{ $cat['name'] }}</h5>
                                    <div>{{ $cat['description'] }}</div>
                                </div>
                                <div class="col-sm-7 sub-menu">
                                    <h4>{{ __('msg.category') }} {{ $cat['name'] }}</h4>
                                    @foreach ($catData[4] as $c)
                                    <a class="dropdown-item" href="{{ route('subcat', ['catSlug'=> $catSlug, 'slug' => $c['slug']]) }}">
                                        {{ $c['name'] }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </li>
                    @php
                        $cat = $productConfig['category'][4];
                        $catSlug = $cat['slug'];
                    @endphp
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('category', ['slug'=> $catSlug]) }}" id="navbarDropdown5" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ $cat['name'] }}
                            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown5">
                            <div class="row">
                                <div class="col-sm-5 sub-info">
                                    <img src="/imgs/menu/img_menu5.png" alt="">
                                    <h5>{{ $cat['name'] }}</h5>
                                    <div>{{ $cat['description'] }}</div>
                                </div>
                                <div class="col-sm-7 sub-menu">
                                    <h4>{{ __('msg.category') }} {{ $cat['name'] }}</h4>
                                    @foreach ($catData[5] as $c)
                                    <a class="dropdown-item" href="{{ route('subcat', ['catSlug'=> $catSlug, 'slug' => $c['slug']]) }}">
                                        {{ $c['name'] }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </li>
                    @php
                        $cat = $productConfig['category'][5];
                        $catSlug = $cat['slug'];
                    @endphp
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('category', ['slug'=> $catSlug]) }}" id="navbarDropdown5" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ $cat['name'] }}
                            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown5">
                            <div class="row">
                                <div class="col-sm-5 sub-info">
                                    <img src="/imgs/menu/img_menu6.png" alt="">
                                    <h5>{{ $cat['name'] }}</h5>
                                    <div>{{ $cat['description'] }}</div>
                                </div>
                                <div class="col-sm-7 sub-menu">
                                    <h4>{{ __('msg.category') }} {{ $cat['name'] }}</h4>
                                    @foreach ($catData[6] as $c)
                                    <a class="dropdown-item" href="{{ route('subcat', ['catSlug'=> $catSlug, 'slug' => $c['slug']]) }}">
                                        {{ $c['name'] }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('news') }}" id="navbarDropdown6" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ __('msg.news') }}
                            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown6">
                            <div class="row">
                                <div class="col-sm-5 sub-info">
                                    <img src="/imgs/menu/img_menu6.png" alt="">
                                    <h5>{{ __('msg.news') }}</h5>
                                    <div></div>
                                </div>
                                <div class="col-sm-7 sub-menu">
                                    <h4>{{ __('msg.news') }}</h4>
                                    <a class="dropdown-item" href="{{ route('phan-tich') }}">{{ __('msg.news_phan_tich') }}</a>
                                    <a class="dropdown-item" href="{{ route('su-kien') }}">{{ __('msg.news_su_kien') }}</a>
                                    <a class="dropdown-item" href="{{ route('kinh-nghiem') }}">{{ __('msg.news_chia_se') }}</a>
                                    <a class="dropdown-item" href="{{ route('thuong-hieu') }}">{{ __('msg.news_thuong_hieu') }}</a>
                                    <a class="dropdown-item" href="{{ route('chinh-sach') }}">{{ __('msg.news_chinh_sach') }}</a>
                                    <a class="dropdown-item" href="{{ route('thong-bao') }}">{{ __('msg.news_thong_bao') }}</a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>