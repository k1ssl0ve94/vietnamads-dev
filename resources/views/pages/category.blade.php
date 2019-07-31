@extends('master')
@php
    $p_r = $products[0];    
    $img_cat_link ='';
    if($p_r){
        $img_cat_link = $p_r->thumb_url;
    }    
    $title = '';
    $meta_title = '';
    $description = '';
    $metaTitle = 'VietnamAds';
    $metaKeys = 'VietnamAds';
    $metaDescription = 'VietnamAds';
    $metaCanonical = \Illuminate\Support\Facades\Request::url();
    $topdescription = '';
    $bottomdescription = '';
    $isClassCategory = false;
    if (!empty($subCat) && !empty($subCat->name)){
        $topdescription = $subCat->description;
        $bottomdescription = $subCat->content;  
    }else{
        $topdescription = $cat['topdescription'];
        $bottomdescription = $cat['bottomdescription']; 

    }

    if (!empty($subCat)){
        $meta_title = $subCat->meta_title;    
    }
    if ($cat && isset($cat['name'])) {
        $title .= $cat['name'];
        $description = $cat['description'];
        $metaDescription = $description;
        $metaKeys = $cat['keywords'];          
    }
    if (!empty($subCat) && !empty($subCat->name)){

 
        $title .=  strtolower(' ' . $subCat->name);
        if ($subCat->description) {
            $description = $subCat->description;
        }
        $metaKeys = $subCat->meta_keywords ? : $metaKeys;
        $metaDescription = $subCat->meta_description ? : $metaDescription;
        $metaCanonical = $subCat->meta_canonical ? : $metaCanonical;
        $topdescription = $subCat->description;
        $bottomdescription = $subCat->content;                
    } else {
        $subCat = null;
    }   
    
    if(!$_GET){    
        if ($city !='null' && $district =='null' && $check !='Yes') {
            $scity = json_decode($city);           
            $title .= ' tại '.$scity->name;
            $metaDescription .= ' tại '.$scity->name;
            $metaKeys .= ' tại '.$scity->name;          
          
        }
        if ($district !='null' && $check !='Yes') {
            $scity = json_decode($city);           
            $sdistrict = json_decode($district);
            $title .= ' tại '.$sdistrict->name.', '.$scity->name;
            $metaDescription .= ' tại '.$sdistrict->name.', '.$scity->name;
            $metaKeys .= ' tại '.$sdistrict->name.', '.$scity->name;         
          
        }  
    }else{
        if(!empty($_GET['district'])){
            $c = \App\Lib\Location::getCity($_GET['city']);
            $d = \App\Lib\Location::getDistrict($_GET['district']);
            if ($c && isset($cat['name'])) {
                $title .= ' tại ' . $d['name'].', '.$c['name'];
            }
        }
       if(!empty($_GET['city']) && empty($_GET['district'])){
            $c = \App\Lib\Location::getCity($_GET['city']);
            if ($c && isset($cat['name'])) {
                $title .= ' tại ' . $c['name'];
            }
        }        
    }  
      
    if(!empty($classCategory) && $classCategory) {        
        $title = $classCategory->name;
        $isClassCategory = true;
        if ($classCategory->description) {
            $description = $classCategory->description;
        }
        $metaKeys = $classCategory->meta_keywors ? : $metaKeys;
        $metaDescription = $classCategory->meta_description ? : $metaDescription;
        $metaCanonical = $classCategory->meta_canonical ? : $metaCanonical;
    }  
    
    $title = trim($title);
    $heading = trim($title);

    if (!empty($subCat->meta_title) && empty($subCat)){
        $title = $cat['title'];    
    }elseif(!empty($meta_title)){
       $title = $meta_title;
    } else{
       $title = trim($title);  
    }    
@endphp
@section('meta-tags')    
    <meta name="keywords" content="{{$metaKeys}}">
    <meta name="description" content="{{$metaDescription}}">
@endsection

@section('meta-canonical')
    <link rel="canonical"  href="{{$metaCanonical}}">
@endsection

@section('breadcrumb')
    @if(isset($classCategory))
        {{ Breadcrumbs::render('class_category', $cat, $subCat, $classCategory) }}
    @elseif (!empty($subCat))
        {{ Breadcrumbs::render('subcategory', $cat, $subCat) }}
    @elseif($cat)
        {{ Breadcrumbs::render('category', $cat) }}
    @endif
@endsection
@section('title')
    @if (!empty($cat))
    <title>{{ $title }} | VietnamAds</title>
    @else
    <title>Tin rao | VietnamAds</title>
    @endif
    <meta property="og:title" content="{{ $title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{\Illuminate\Support\Facades\Request::url()}}" />
    <meta property="og:image" content="{{ $img_cat_link }}" />
    <meta property="og:site_name" content="VietnamAds | Kênh thông tin quảng cáo và marketing của Việt Nam" />
    <meta property="og:description" content="{{$metaDescription}}" />
    <meta property="og:image:secure_url" content="{{ $img_cat_link }}" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="{{ $title }}" />
    <meta name="twitter:description" content="{{$metaDescription}}" />
    <meta name="twitter:image" content="{{ $img_cat_link }}" />        
@endsection

@section('main')
<div class="row">
    <div class="col-12">
        <div class="box-search-text">
            {{--@if (isset($tag) || $isSearch)--}}
            <form class="form-inline form-search" method="GET" action="{{ URL::current() }}">
            {{--@else--}}
            {{--<form class="form-inline form-search" method="GET" action="{{ route('category', ['slug'=> $cat['slug']]) }}">--}}
            {{--@endif--}}
                <img src="/imgs/icons/icon_search.png" class="icon-search">
                <input type="text" class="form-control" placeholder="Nhập từ khóa" name="s" value="{{ $keyword }}">
                <button type="submit" class="btn btn-primary">{{ __('search') }}</button>
                <input type="hidden" name="order" value="{{ $order }}">
                <input type="hidden" name="has_image" value="{{ $has_image }}">
                <input type="hidden" name="has_video" value="{{ $has_video }}">
                <input type="hidden" name="city" value="{{ $city }}">
                <input type="hidden" name="district" value="{{ $district }}">
                <input type="hidden" name="ward" value="{{ $ward }}">
                <input type="hidden" name="street" value="{{ $street }}">
                <input type="hidden" name="provider" value="{{ $provider }}">
                <input type="hidden" name="price_range" value="{{ $price_range }}">
                <input type="hidden" name="sub_cat" value="{{ isset($subCat) && isset($subCat['id']) ? $subCat['id'] : '' }}">
                {{-- @if ($cat) --}}
                    {{-- @if ($cat['id'] == 1) --}}
                        <input type="hidden" name="pano_type" value="{{ isset($pano_type)  ? $pano_type  : ''}}" >
                        <input type="hidden" name="pano_size" value="{{ isset($pano_size) ? $pano_size : '' }}">
                        <input type="hidden" name="pano_border" value="{{ isset($pano_border) ? $pano_border : '' }}">
                        <input type="hidden" name="pano_light" value="{{ isset($pano_light) ? $pano_light : '' }}">
                    {{-- @elseif ($cat['id'] == 3) --}}
                        <input type="hidden" name="social_type" value="{{ isset($social_type) ? $social_type : '' }}">
                        <input type="hidden" name="social_follow" value="{{ isset($social_follow) ? $social_follow : '' }}">
                    {{-- @elseif ($cat['id'] == 4) --}}
                        <input type="hidden" name="web_type" value="{{ isset($web_type) ? $web_type : '' }}">
                        <input type="hidden" name="web_position" value="{{ isset($web_position) ? $web_position : '' }}">
                    {{-- @endif --}}
                {{-- @endif --}}
            </form>
        </div>
        
        <div class="card card-primary">
            @if (!empty($cat))
            <div class="card-header"><h1>{{ $heading }}</h1></div>
            @else
            <div class="card-header"><h2>Kết quả tìm kiếm</h2></div>            
            @endif
            @if(!empty($topdescription))
                <div class="alert alert-light">
                    {!!$topdescription!!}
                </div>
            @endif
            <div class="card-body">
                @if (!empty($cat))
                <div class="product-filter">
                    <form action="" class="form-inline">
                        <span>Sắp xếp theo: </span>
                        <select class="form-control" name="order">
                            <option value="" @if ($order == 'default' || $order == '') selected @endif>Thông thường</option>
                            <option value="newest" @if ($order == 'newest') selected @endif>Tin mới nhất</option>
                            <option value="no_price" @if ($order=='no_price' ) selected @endif>Giá thỏa thuận</option>
                            <option value="lowest_price" @if ($order == 'lowest_price') selected @endif>Giá thấp nhất</option>
                            <option value="highest_price" @if ($order=='highest_price' ) selected @endif>Giá cao nhất</option>
                        </select>
                        <div class="form-check ml-3">
                            <input type="checkbox" class="form-check-input" name="has_image" id="productHasImage" @if ($has_image) checked @endif>
                            <label class="form-check-label" for="productHasImage">Tin rao có ảnh</label>
                        </div>
                        <div class="form-check ml-3">
                            <input type="checkbox" class="form-check-input" name="has_video" id="productHasVideo" @if ($has_video) checked @endif>
                            <label class="form-check-label" for="productHasVideo">Tin rao có video</label>
                        </div>
                        @if(!$isClassCategory)
                        <a href="{{ $viewMapUrl }}" class="btn btn-link">Xem trên bản đồ</a>
                        @endif
                    </form>
                </div>
                @endif
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
        {!! $products->appends(Illuminate\Support\Facades\Input::except('page'))->links() !!}
        @if(empty($_GET['page']) || $_GET['page'] <= 1)
        @if(!empty($bottomdescription))
        <div class="card card-primary">
            <div class="alert alert-light">
                {!! $bottomdescription !!}                        
            </div>
        </div>
        @endif            
        @endif            
    </div>
</div>
@endsection

@section('advanced_search')
    @include('partials.advanced-search')
    @include('partials.class-category')
@endsection