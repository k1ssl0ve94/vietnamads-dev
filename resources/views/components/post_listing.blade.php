<div class="post clearfix">
    <div class="thumb rounded">
        <a href="{{ $post->getPostURL() }}" title="{{ $post->title }}">
            @if ($post->image_url)
            <img src="{{ $post->image_url }}" class="img-fluid" alt="{{ $post->image_alt ? : $post->title }}">
            @else
            <img src="/imgs/img_placeholder.png" class="img-fluid" alt="{{ $post->title }}">
            @endif
        </a>
    </div>
    <div class="info">
        <a href="{{ $post->getPostURL() }}" class="title d-block" title="{{ $post->title }}">{{ str_limit($post->title, 70) }}</a>
        <p>{{ str_limit($post->sapo, 120) }}</p>
    </div>
</div>