@if (count($hotPosts) > 0)
<div id="box-top-content">
    @php
        $post = $hotPosts[0];
        $hotPostData = [];
        foreach ($hotPosts as $p) {
            $hotPostData[] = [
                'id' => $p->id,
                'title' => $p->title,
                'title_short' => str_limit($p->title, 60),
                'url' => $post->getPostURL(),
                'image_url' => $p->image_url,
                'sapo_short' => str_limit($p->sapo, 130),
            ];
        }
    @endphp
    <script>
        window.hot_post_data = {!! json_encode($hotPostData) !!};
    </script>
    <div class="top-post clearfix">
        <a href="{{ $post->getPostURL() }}" class="image rounded" title="{{ $post->title }}">
            @if ($post->image_url)
            <img src="{{ $post->image_url }}" class="img-fluid" alt="{{ $post->image_alt ? : $post->title }}">
            @else
            <img src="/imgs/img_placeholder.png" class="img-fluid " alt="{{ $post->title }}">
            @endif
        </a>
        <div class="content">
            <a href="{{ $post->getPostURL() }}" class="title" title="{{ $post->title }}">{{ str_limit($post->title, 60) }}</a>
            <p>{{ str_limit($post->sapo, 130) }}</p>
        </div>
    </div>
    <div class="box-top-titles">
        @foreach ($hotPosts as $p)
        <a href="{{ $p->getPostURL() }}" class="title" title="{{ $p->title }}">
            {{ str_limit($p->title, 55) }}
        </a>
        @endforeach
    </div>
</div>
@endif