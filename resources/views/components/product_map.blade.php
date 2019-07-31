@php
if (!isset($cat)) {
    $cat = $p->cat();
}
$link = $p->detailLink();
@endphp
<div class="post clearfix product-map">
    <h3>
        <a href="{{ $link }}" class="title d-block"
            style="color: {{$p->title_color}}"
            title="{{ $p->title }}">
            @if($p->icon)
                <span class="badge badge-danger"><i class="fa fa-diamond"></i></span>
            @endif
            {{ str_limit($p->title, 80) }}</a>
    </h3>
    <div class="thumb rounded">
        <a href="{{ $link }}" title="{{ $p->title }}">
            <img src="{{ $p->thumbImage() }}" class="img-fluid" alt="{{ $p->title }}">
        </a>
        @if (!empty($badge))
        <span class="badge badge-danger">{{ $badge }}</span>
        @endif
    </div>
    <div class="info">
        <ul class="meta">
            <li style="color: {{$p->price_color}}"><img src="/imgs/icons/meta_icon_4.png" class="meta-icon"> {{ $p->priceText() }}</li>
            <li style="color: {{$p->parameter_color}}"><img src="/imgs/icons/meta_icon_1.png" class="meta-icon"> {{ $p->created_at->format('d/m/Y') }}</li>
            <li style="color: {{$p->parameter_color}}"><img src="/imgs/icons/meta_icon_3.png" class="meta-icon"> {{ $p->locationText() }}</li>
        </ul>
    </div>
</div>