@php
$link = $p->detailLink();
$subCat = json_decode($p->subCat, true);
@endphp
<div class="post clearfix big-post">
    <h3>
        <a href="{{ $link }}" class="title d-block" style="color: {{$p->title_color}}" title="{{ $p->title }}">
            @if($p->icon)
                <span class="badge badge-danger"><i class="fa fa-diamond"></i></span>
            @endif
            {{ $p->title }}</a>
    </h3>
    <div class="thumb rounded">
        <a href="{{ $link }}" title="{{ $p->title }}">
            <img src="{{ $p->thumbImage() }}" class="img-fluid" alt="{{ $p->title }}">
        </a>
    </div>
    <div class="info">
        <p>{{ str_limit($p->content, 330) }}</p>
        <div class="row">
            <div class="col-sm-4">
                <ul class="meta">
                    <li style="color: {{$p->price_color}}"><img src="/imgs/icons/ic_giatien.svg" class="meta-icon"> {{ $p->priceText() }}</li>
                    <li style="color: {{$p->parameter_color}}"><img src="/imgs/icons/ic_diachi.svg" class="meta-icon"> {{ $p->locationText() }}</li>
                </ul>
            </div>
            <div class="col-sm-4">
                <ul class="meta">
                    <li style="color: {{$p->parameter_color}}"><img src="/imgs/icons/ic_diachi.svg" class="meta-icon"> {{ $p->contact_address }}</li>
                    <li style="color: {{$p->parameter_color}}"><img src="/imgs/icons/ic_ten.svg" class="meta-icon"> {{ $p->contact_name }}</li>
                </ul>
            </div>
            <div class="col-sm-4">
                <ul class="meta">
                    <li style="color: {{$p->parameter_color}}"><img src="/imgs/icons/ic_hinhthuc.svg" class="meta-icon"> {{ $subCat['name']}}</li>
                    <li style="color: {{$p->parameter_color}}">
                        <img src="/imgs/icons/ic_date.svg" class="meta-icon"> {{ $p->created_at->format('d/m/Y') }}
                    </li>
                </ul>
            </div>
            @if($p->user && $p->user->verified_by_admin) 
            <div class="col-sm-4">
                <ul class="meta">
                    <li><span class="badge-success badge">Đã xác minh người đăng</span></li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>