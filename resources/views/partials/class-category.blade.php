<div class="">
    @if(isset($cat) && $cat['classCategoryArray'])
    <div class="card card-muted">
        <div class="card-header"><h2>Nhóm tin nổi bật</h2></div>
        <div class="card-body">
            <ul class="link-list">
                @if($cat['classCategoryArray'])
                    @foreach($cat['classCategoryArray'] as $class)
                        <h3>
                            <a href="{{route('class-category', ['id' => $class['id'], 'slug' => str_slug($class['name'])])}}">
                                {{$class['name']}}
                            </a>
                        </h3>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    @endif
    @if(isset($subCat) && $subCat->classCategoryArray)
        <div class="card card-muted">
            <div class="card-header"><h2>Gợi ý tìm kiếm</h2></div>
            <div class="card-body">
                <ul class="link-list">
                    @if($subCat->classCategoryArray)
                        @foreach($subCat->classCategoryArray as $class)
                            <h3>
                                <a href="{{route('class-category', ['id' => $class['id'], 'slug' => str_slug($class['name'])])}}">
                                    {{$class['name']}} ({{number_format($class['total_products'])}})
                                </a>
                            </h3>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    @endif
</div>