
<a class="btn btn-success btn-block" id="btn-tu-van" href="tel:19000127">
    Hỗ trợ dịch vụ
    <div><i class="fa fa-phone" aria-hidden="true"></i> 1900 0127</div>
    <div class="note">(1000đ/phút T2 - sáng T7 giờ hành chính)</div>
</a>
@yield('advanced_search')
{{--@if (!empty($banners['banner_5']))--}}
{{--<a href="{{ $banners['banner_5']['url'] }}" class="banner-box banner-box-sidebar" target="_blank">--}}
    {{--<img src="{{ $banners['banner_5']['image_url'] }}" alt="">--}}
{{--</a>--}}
{{--@endif--}}
@if (request()->path() == "/")
<div class="card card-muted">
    <div class="card-header"><h2>Nhà cung cấp hàng đầu</h2></div>
    <div class="card-body" id="top-brands">
        <div class="row">
            @foreach ($brands as $b)
            <div class="col brand col-4" data-img="{{$b->logo_url}}">
                <a href="{{ $b->url }}">
                    <img class="image img-fluid"
                            src="{{ $b->logo_url }}" alt="{{ $b->name }}">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@foreach($keywordData as $data)
<div class="card card-muted">
    <div class="card-header">{{ $data['title'] }}</div>
    <div class="card-body">
        <ul class="link-list">
            @foreach ($data['keywords'] as $row)
            @php 
    
        if( strpos($row['url'], '?city=') !== false){
        
                    $city_id = explode("=", $row['url']);
                    if( !is_numeric($city_id[1]) ){
                        $row['url'] = str_replace('?city=', '/', $row['url']);
                    }
        } 
                @endphp
                <h3 class="link-add-broad"><a href="{{ $row['url'] }}" title="{{ $row['text'] }}">{{ $row['text'] }}</a></h3>
            @endforeach
        </ul>
    </div>
</div>
@endforeach
{{--@if (!empty($banners['banner_6']))--}}
{{--<a href="{{ $banners['banner_6']['url'] }}" class="banner-box banner-box-sidebar" target="_blank">--}}
    {{--<img src="{{ $banners['banner_6']['image_url'] }}" alt="">--}}
{{--</a>--}}
{{--@endif--}}