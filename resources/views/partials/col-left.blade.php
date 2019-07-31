<div class="row">
    <div class="col-md-6">
        @include('partials.box-search')
    </div>
    <div class="col-md-6">
        <div class="box-search-text">
            <form class="form-inline" action="{{ route('search') }}" method="GET">
                <img src="/imgs/icons/icon_search.png" class="icon-search">
                <input type="text" class="form-control" placeholder="{{ __('msg.enter_keyword') }}" name="s">
                <button type="submit" class="btn btn-primary">{{ __('msg.search') }}</button>
            </form>
        </div>
        @include('partials.box-top-content')
    </div>
    <div class="col-12">
        @if (!empty($banners['banner_1']))
        <a href="{{ $banners['banner_1']['url'] }}" class="banner-box" target="_blank">
            <img src="{{ $banners['banner_1']['image_url'] }}" alt="">
        </a>
        @endif
    </div>
    <div class="col-md-6">
        @php
            $cat = $productConfig['category'][0]
        @endphp
        <div class="card card-primary">
            <div class="card-header"><h2><a href="{{ route('category', ['slug'=> $cat['slug']]) }}">{{ $cat['name'] }}</a></h2></div>
            <div class="card-body">
                @foreach($panoProducts as $p)
                    @product_home(['p' => $p, 'cat' => $cat, 'badge' => $cat['name']])
                    @endproduct_home
                @endforeach
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 1]) }}">1</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 2]) }}">2</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 3]) }}">3 ...</a></li>
            </ul>
        </nav>
    </div>
    <div class="col-md-6">
        @php
        $cat = $productConfig['category'][1]
        @endphp
        <div class="card card-primary">
            <div class="card-header"><h2><a href="{{ route('category', ['slug'=> $cat['slug']]) }}">{{ $cat['name'] }}</a></h2></div>
            <div class="card-body">
                @foreach($adProducts as $p)
                    @product_home(['p' => $p, 'cat' => $cat, 'badge' => $cat['name']])
                    @endproduct_home
                @endforeach
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 1]) }}">1</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 2]) }}">2</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 3]) }}">3 ...</a></li>
            </ul>
        </nav>
    </div>
    <div class="col-12">
        @if (!empty($banners['banner_2']))
        <a href="{{ $banners['banner_2']['url'] }}" class="banner-box" target="_blank">
            <img src="{{ $banners['banner_2']['image_url'] }}" alt="">
        </a>
        @endif
    </div>
    <div class="col-md-6">
        @php
            $cat = $productConfig['category'][2]
        @endphp
        <div class="card card-primary">
            <div class="card-header"><h2><a href="{{ route('category', ['slug'=> $cat['slug']]) }}">{{ $cat['name'] }}</a></h2></div>
            <div class="card-body">
                @foreach($socialProducts as $p)
                    @product_home(['p' => $p, 'cat' => $cat, 'badge' => $cat['name']])
                    @endproduct_home
                @endforeach
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 1]) }}">1</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 2]) }}">2</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 3]) }}">3 ...</a></li>
            </ul>
        </nav>
    </div>
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header"><h2><a href="{{ route('phan-tich') }}">{{ __('msg.news_phan_tich') }}</a></h2></div>
            <div class="card-body p-0">
                <ul class="link-list pb-0 mb-0">
                    @foreach ($phanTich as $p)
                    <li><h3><a href="{{ $p->getPostURL() }}">{{ str_limit($p->title, 60) }}</a></h3></li>
                    @endforeach
                    <li><a href="{{ route('phan-tich') }}">{{ __('msg.view_more') }}...</a></li>
                </ul>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header"><h2><a href="{{ route('su-kien') }}">{{ __('msg.news_su_kien') }}</a></h2></div>
            <div class="card-body p-0">
                <ul class="link-list  pb-0 mb-0">
                    @foreach ($suKien as $p)
                    <li><h3><a href="{{ $p->getPostURL() }}">{{ str_limit($p->title, 60) }}</a></h3></li>
                    @endforeach
                    <li><a href="{{ route('su-kien') }}">{{ __('msg.view_more') }}...</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12">
        @if (!empty($banners['banner_3']))
        <a href="{{ $banners['banner_3']['url'] }}" class="banner-box" target="_blank">
            <img src="{{ $banners['banner_3']['image_url'] }}" alt="">
        </a>
        @endif
    </div>
    <div class="col-md-6">
        @php
            $cat = $productConfig['category'][3]
        @endphp
        <div class="card card-primary">
            <div class="card-header"><h2><a href="{{ route('category', ['slug'=> $cat['slug']]) }}">{{ $cat['name'] }}</a></h2></div>
            <div class="card-body">
                @foreach($webProducts as $p)
                    @product_home(['p' => $p, 'cat' => $cat, 'badge' => $cat['name']])
                    @endproduct_home
                @endforeach
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 1]) }}">1</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 2]) }}">2</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 3]) }}">3</a></li>
                {{--<li class="page-item"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 4]) }}">4</a></li>--}}
                {{--<li class="page-item"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 5]) }}">5 ...</a></li>--}}
            </ul>
        </nav>
    </div>
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header"><h2><a href="{{ route('kinh-nghiem') }}">{{ __('msg.news_chia_se') }}</a></h2></div>
            <div class="card-body p-0">
                <ul class="link-list  pb-0 mb-0">
                    @foreach ($kinhNghiem as $p)
                    <li><h3><a href="{{ $p->getPostURL() }}">{{ str_limit($p->title, 60) }}</a></h3></li>
                    @endforeach
                    <li><a href="{{ route('kinh-nghiem') }}">{{ __('msg.view_more') }}...</a></li>
                </ul>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header"><h2><a href="{{ route('thuong-hieu') }}">{{ __('msg.news_thuong_hieu') }}</a></h2></div>
            <div class="card-body p-0">
                <ul class="link-list  pb-0 mb-0">
                    @foreach ($thuongHieu as $p)
                    <li><h3><a href="{{ $p->getPostURL() }}">{{ str_limit($p->title, 60) }}</a></h3></li>
                    @endforeach
                    <li><a href="{{ route('thuong-hieu') }}">{{ __('msg.view_more') }}...</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12">
        @if (!empty($banners['banner_4']))
        <a href="{{ $banners['banner_4']['url'] }}" class="banner-box" target="_blank">
            <img src="{{ $banners['banner_4']['image_url'] }}" alt="">
        </a>
        @endif
    </div>
    <div class="col-md-6">
        @php
            $cat = $productConfig['category'][4]
        @endphp
        <div class="card card-primary">
            <div class="card-header"><h2><a href="{{ route('category', ['slug'=> $cat['slug']]) }}">{{ $cat['name'] }}</a></h2></div>
            <div class="card-body">
                @foreach($otherProducts as $p)
                    @product_home(['p' => $p, 'cat' => $cat, 'badge' => $cat['name']])
                    @endproduct_home
                @endforeach
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 1]) }}">1</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 2]) }}">2</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 3]) }}">3 ...</a></li>
            </ul>
        </nav>
    </div>
    <div class="col-md-6">
        @php
            $cat = $productConfig['category'][5]
        @endphp
        <div class="card card-primary">
            <div class="card-header"><h2><a href="{{ route('category', ['slug'=> $cat['slug']]) }}">{{ $cat['name'] }}</a></h2></div>
            <div class="card-body">
                @foreach($findProducts as $p)
                    @product_home(['p' => $p, 'cat' => $cat, 'badge' => $cat['name']])
                    @endproduct_home
                @endforeach
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 1]) }}">1</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 2]) }}">2</a></li>
                <li class="page-item"><a class="page-link" href="{{ route('category', ['slug'=> $cat['slug'], 'page' => 3]) }}">3 ...</a></li>
            </ul>
        </nav>
    </div>
</div>