<div class="card card-primary">
    <div class="card-header">Tin Tức nổi bật</div>
    <div class="card-body">
        <div class="row">
            @foreach ($hotNews as $post)
            <div class="col-md-6">
                <div class="post clearfix">
                    <div class="thumb rounded">
                        <a href="{{ $post->getPostURL() }}" alt="">
                            @if ($post->image_url)
                            <img src="{{ $post->image_url }}" class="img-fluid"
                                alt="{{ $post->image_alt ? : $post->title }}">
                            @else
                            <img src="/imgs/img_placeholder.png" class="img-fluid"
                                alt="VietnamAds">
                            @endif
                        </a>
                    </div>
                    <div class="info">
                        <a href="{{ $post->getPostURL() }}" class="title d-block">{{ str_limit($post->title, 70) }}</a>
                        <p>{{ str_limit($post->sapo, 100) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>