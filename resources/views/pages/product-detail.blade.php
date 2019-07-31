@extends('master')
@php
    $description = $product->title.', '.$product->content;    
@endphp  
@section('title')
    <title>{{ $product->title }} | VietnamAds</title>  
    <meta property="og:title" content="{{ $product->title }}" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="{{\Illuminate\Support\Facades\Request::url()}}" />
    <meta property="og:image" content="{{ $product->thumb_url}}" />
    <meta property="og:site_name" content="VietnamAds | Kênh thông tin quảng cáo và marketing của Việt Nam" />
    <meta property="og:description" content="{{str_limit($description,149)}}" />
    <meta property="og:image:secure_url" content="{{ $product->thumb_url}}" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="{{ $product->title }}" />
    <meta name="twitter:description" content="{{str_limit($description,149)}}" />
    <meta name="twitter:image" content="{{ $product->thumb_url }}" />    
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('product_detail', $product) }}
@endsection
@section('meta-tags')  
    <meta name="description" content="{{str_limit($description,149)}}">
@endsection
@section('main')

<div class="row product-detail">
    <div class="col-12">
        <div class="box-search-text">
            <form class="form-inline form-search" method="GET" action="{{ route('search') }}">
                <img src="/imgs/icons/icon_search.png" class="icon-search">
                <input type="text" class="form-control" placeholder="{{ __('msg.enter_keyword') }}" name="s">
                <button type="submit" class="btn btn-primary">{{ __('msg.search') }}</button>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card card-post">
            @php                
                $c = \App\Lib\Location::getCity($product->city);
                $d = \App\Lib\Location::getDistrict($product->district);
                $header_slug = $product->cat()['slug'].'/'.$product->subCat->slug.'/'.str_slug($c['name']).'/'.str_slug($d['name']);                
                $header = $product->cat()['name'];
                $header .=  strtolower(' ' . $product->subCat->name);
                $header .= ' tại '.$d['name'].', '. $product->cityText();
                $header = trim($header);
            @endphp
            <div class="card-header"><h1 class="text-left">{{ $product->title }}</h1></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="product-cat">
                            <span>Khu vực:</span>
                            <h2><a href="/{{$header_slug}}">{{$header}}</a></h2>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="img-thumb">
                            <img src="{{ $product->thumbImage() }}" class="img-fluid rounded">
                        </div>
                    </div>
                    @if ($product->category_parent == 1)
                    <div class="col-md-4">
                        <ul class="meta">
                            <li style="color: {{$product->price_color}};"><img src="/imgs/icons/ic_giatien.svg" class="meta-icon"> {{ $product->priceText() }}</li>
                            <li style="color: {{$product->parameter_color}};"><img src="/imgs/icons/ic_diachi.svg" class="meta-icon"> {{ $product->locationText() }}</li>
                            <li style="color: {{$product->parameter_color}};"><img src="/imgs/icons/ic_hinhthuc.svg" class="meta-icon"> {{ $product->getTextAttr('pano_type') }}</li>
                            @if($product->user && $product->user->verified_by_admin)
                                <li><span class="badge-success badge">Đã xác minh người đăng</span></li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="meta">
                            <li style="color: {{$product->parameter_color}};"><img src="/imgs/icons/ic_date.svg" class="meta-icon"> {{ $product->created_at->format('d/m/Y') }}</li>
                            <li style="color: {{$product->parameter_color}};"><img src="/imgs/icons/ic_ten.svg" class="meta-icon"> {{ $product->subCat->name }}</li>
                            <li style="color: {{$product->parameter_color}};"><img src="/imgs/icons/ic_hinhthuc.svg" class="meta-icon"> {{ $product->getTextAttr('pano_size') }}</li>
                        </ul>
                    </div>
                    @endif
                    @if ($product->category_parent == 2 || $product->category_parent == 3 || $product->category_parent == 4)
                    <div class="col-md-4">
                        <ul class="meta">
                            <li style="color: {{$product->price_color}};"><img src="/imgs/icons/ic_giatien.svg" class="meta-icon"> {{ $product->priceText() }}</li>
                            <li style="color: {{$product->parameter_color}};"><img src="/imgs/icons/ic_diachi.svg" class="meta-icon"> {{ $product->locationText() }}</li>
                            <li style="color: {{$product->parameter_color}};"><img src="/imgs/icons/ic_hinhthuc.svg" class="meta-icon"> {{ $product->link }}</li>
                            @if($product->user && $product->user->verified_by_admin)
                                <li><span class="badge-success badge">Đã xác minh người đăng</span></li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="meta">
                            <li style="color: {{$product->parameter_color}};"><img src="/imgs/icons/ic_date.svg" class="meta-icon"> {{ $product->created_at->format('d/m/Y') }}</li>
                            <li style="color: {{$product->parameter_color}};"><img src="/imgs/icons/ic_hinhthuc.svg" class="meta-icon"> {{ $product->subCat->name }}</li>
                        </ul>
                    </div>
                    @endif
                    @if ($product->category_parent == 5 || $product->category_parent == 6)
                    <div class="col-md-4">
                        <ul class="meta">
                            <li style="color: {{$product->price_color}};"><img src="/imgs/icons/ic_giatien.svg" class="meta-icon"> {{ $product->priceText() }}</li>
                            <li style="color: {{$product->parameter_color}};"><img src="/imgs/icons/ic_diachi.svg" class="meta-icon"> {{ $product->locationText() }}</li>
                            @if($product->user && $product->user->verified_by_admin)
                                <li><span class="badge-success badge">Đã xác minh người đăng</span></li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="meta">
                            <li style="color: {{$product->parameter_color}};"><img src="/imgs/icons/ic_date.svg" class="meta-icon"> {{ $product->created_at->format('d/m/Y') }}</li>
                            <li style="color: {{$product->parameter_color}};"><img src="/imgs/icons/ic_hinhthuc.svg" class="meta-icon"> {{ $product->subCat->name }}</li>
                        </ul>
                    </div>
                    @endif

                </div>
                <div class="content">
                    @if ($product->tags && count($product->tags) > 0)
                    <p>Từ khóa tìm kiếm:
                        @foreach ($product->tags as $index => $tag)
                        <a href="{{ route('tag', ['slug' => str_slug($tag->name), 'id' => $tag->id]) }}">{{ $tag->name }}</a>@if ($index < count($product->tags) - 1) , @endif
                        @endforeach
                    </p>
                    @endif
                    {!!  nl2br($product->content) !!}

                </div>           
                @if ($product->direct_link)                    
                    <div class="content">
                        <label>Links: </label><br/>
                        @foreach($product->direct_link as $link)
                            @if($link)
                                <p class="">
                                    @if($product->allow_direct_link)
                                    <a href="{{$link}}" rel="nofollow" target="_blank">
                                       <i class="fa fa-angle-double-right"></i> {{$link}}
                                    </a>
                                    @else
                                        <i class="fa fa-angle-double-right"></i> {{$link}}
                                    @endif
                                </p>
                            @endif
                        @endforeach
                    </div>
                @endif
                @if ($product->youtube_link)
                    <div class="row text-center youtube-link">
                        <div style="margin: auto">
                            {!! Youtube::iFrame($product->youtube_link); !!}
                        </div>
                    </div>
                @endif
                <div class="mb-3 share">
                    <div class="addthis_inline_share_toolbox_t3om"></div>
                </div>                  
                @if (count($product->getImageURLs()) > 0)
                <div class="product-image">
                    <br/>
                    <h6>{{ __('msg.product_images') }}</h6>
                    <div class="slider slider-for">
                        @foreach($product->getImageURLs() as $img)
                        <div class="product-img-box">
                            <img src="{{ $img }}" class="rounded">
                        </div>
                        @endforeach
                    </div>
                    <div class="slider slider-nav">
                        @foreach($product->getThumbURLs() as $img)
                        <div class="product-thumb-box">
                            <img src="{{ $img }}" class="rounded">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif   
            </div>
        </div>
    </div>
    @if ($product->hasPosition())
    <div class="col-12">
        <div class="card card-muted">
            <div class="card-header"><h2>{{ __('msg.view_on_map') }}</h2></div>
            <div class="card-body">
                <div id="map-detail-product" v-cloak data-lat="{{ $product->lat }}" data-lng="{{ $product->long }}">
                    <gmap-map
                        :center="position"
                        :zoom="14"
                        map-type-id="roadmap"
                        style="width: 100%; height: 440px"
                    >
                        <gmap-marker :position="position" />
                    </gmap-map>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="col-md-6">
        <div class="card card-muted">
            <div class="card-header"><h2>{{ __('msg.base_info') }}</h2></div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">{{ __('msg.product_category') }}:</th>
                            <td class="text-right">{{ $product->cat()['name'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('msg.product_sub_cat') }}:</th>
                            <td class="text-right">{{ $product->subCat->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Địa chỉ:</th>
                            <td class="text-right">{{ $product->fullLocationText() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card card-muted">
            <div class="card-header"><h2>{{ __('msg.misc') }}</h2></div>
            <div class="card-body">
                @if ($product->category_parent == 1)
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">{{ __('msg.product_provider') }}:</th>
                            <td class="text-right">{{ $product->provider_text }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('msg.frame') }}:</th>
                            <td class="text-right">{{ $product->getTextAttr('pano_border') }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('msg.light') }}:</th>
                            <td class="text-right">{{ $product->getTextAttr('pano_light') }}</td>
                        </tr>
                    </tbody>
                </table>
                @endif
                @if ($product->category_parent == 2)
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">{{ __('msg.product_provider') }}:</th>
                            <td class="text-right">{{ $product->provider_text }}</td>
                        </tr>
                        {{--<tr>--}}
                            {{--<th scope="row">{{ __('msg.channel_type') }}:</th>--}}
                            {{--<td class="text-right">{{ $product->getTextAttr('ad_channel') }}</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<th scope="row">{{ __('msg.coverage') }}:</th>--}}
                            {{--<td class="text-right">{{ $product->getTextAttr('ad_coverage') }}</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<th scope="row">{{ __('msg.ad_time') }}:</th>--}}
                            {{--<td class="text-right">{{ $product->getTextAttr('ad_time') }}</td>--}}
                        {{--</tr>--}}
                    </tbody>
                </table>
                @endif
                @if ($product->category_parent == 3)
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">{{ __('msg.product_provider') }}:</th>
                            <td class="text-right">{{ $product->provider_text }}</td>
                        </tr>
                        {{--<tr>--}}
                            {{--<th scope="row">{{ __('msg.page_type') }}:</th>--}}
                            {{--<td class="text-right">{{ $product->getTextAttr('social_type') }}</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<th scope="row">{{ __('msg.follow') }}:</th>--}}
                            {{--<td class="text-right">{{ $product->getTextAttr('social_follow') }}</td>--}}
                        {{--</tr>--}}
                    </tbody>
                </table>
                @endif
                @if ($product->category_parent == 4)
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">{{ __('msg.product_provider') }}:</th>
                            <td class="text-right">{{ $product->provider_text }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('msg.page_type') }}:</th>
                            <td class="text-right">{{ $product->getTextAttr('web_type') }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('msg.page_type') }}:</th>
                            <td class="text-right">{{ $product->getTextAttr('web_position') }}</td>
                        </tr>
                    </tbody>
                </table>
                @endif
                @if ($product->category_parent == 5 || $product->category_parent == 6)
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">{{ __('msg.product_provider') }}:</th>
                            <td class="text-right">{{ $product->provider_text }}</td>
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-muted contact-box">
            <div class="card-header"><h2>{{ __('msg.contact') }}</h2></div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">{{ __('msg.fullname') }}:</th>
                            <td class="text-right">
                                {{ $product->contact_name }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('msg.phone_number') }}:</th>
                            <td class="text-right">{{ $product->contact_phone }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('msg.email') }}:</th>
                            <td class="text-right">{{ $product->contact_email }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ __('msg.address') }}:</th>
                            <td class="text-right">{{ $product->contact_address }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    @if(\Illuminate\Support\Facades\Auth::user())
                        @if($product->user_id && $product->user_id != \Illuminate\Support\Facades\Auth::user()->id)
                            <a href="#" class="btn btn-danger btn-send-message mb-4"
                               data-toggle="modal" data-target="#modal-send-message"
                               data-to-user="{{$product->user_id}}"
                               data-from-product="{{$product->id}}"
                               title="Gửi tin cho người đăng">{{ __('msg.send_mess_to_author') }}</a>
                        @endif
                    @endif
                    @if ($product->user_id != 0)
                    <a href="{{ route('user-product', ['id' => $product->user_id]) }}" class="btn btn-success mb-4">{{ __('msg.view_product_by_author') }}</a>
                    @endif
                    <a href="#" class="btn btn-primary mb-4">{{ __('msg.view_same_kind') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 text-muted">
        <strong>{{ __('msg.product_id') }}:</strong> {{ $product->id }}
    </div>
    <div class="col-md-3 text-muted">
        <strong>{{ __('msg.product_post_type') }}:</strong> {{ $product->levelText() }}
    </div>
    <div class="col-md-3 text-muted">
        <strong>{{ __('msg.product_created') }}:</strong> {{ $product->from_date_text }}
    </div>
    <div class="col-md-3 text-muted">
        <strong>{{ __('msg.product_expired') }}:</strong> {{ $product->to_date_text }}
    </div>
    <div class="col-md-12 mt-3">
        <h6 class="text-muted">{{ __('msg.note') }}:</h6>
        <p class="text-muted">
            {!! __('msg.product_detail_note', ['title' => $product->title]) !!}
        </p>
    </div>
    <div class="col-12">
        @include('partials.related-products')
    </div>
</div>
@endsection

@section('advanced_search')
    @include('partials.advanced-search')
    @include('partials.class-category')
@endsection