@php
if (!isset($cat)) {
    $cat = $p->cat();
}
$subCat = json_decode($p->subCat, true);
$link = $p->detailLink();
@endphp
<div class="post clearfix">
    <div class="thumb rounded">
        <a href="{{ $link }}" title="{{ $p->title }}">
            <img src="{{ $p->thumbImage() }}" class="img-fluid" alt="{{ $p->title }}">
        </a>
        @if (!empty($badge))
        <span class="badge badge-danger">{{ $badge }}</span>
        @endif
    </div>
    <div class="info">
        <h3>
            <a href="{{ $link }}" class="title d-block"
               style="color: {{$p->title_color}}"
               title="{{ $p->title }}">
                @if($p->icon)
                    <span class="badge badge-danger"><i class="fa fa-diamond"></i></span>
                @endif
                {{ str_limit($p->title, 60) }}</a>
        </h3>
        <ul class="meta">
            <li style="color: {{$p->parameter_color}}"><img src="/imgs/icons/ic_date.svg" class="meta-icon"> {{ $p->created_at->format('d/m/Y') }}</li>
            <li style="color: {{$p->parameter_color}}"><img src="/imgs/icons/ic_hinhthuc.svg" class="meta-icon">{{ $subCat['name']}}</li>
            <li style="color: {{$p->parameter_color}}"><img src="/imgs/icons/ic_diachi.svg" class="meta-icon"> {{ $p->locationText() }}</li>
            <li style="color: {{$p->price_color}}"><img src="/imgs/icons/ic_giatien.svg" class="meta-icon"> {{ $p->priceText() }}</li>
            @if($p->verified_by_admin)
                <li><span class="badge-success badge">Đã xác minh người đăng</span></li>
            @endif
        </ul>
    </div>
</div>