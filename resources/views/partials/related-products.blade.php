<div class="card card-primary">
    <div class="card-header"><h2>{{ __('msg.product_same_cat') }}</h2></div>
    <div class="card-body">
        <div class="row">
            @foreach ($relatedProducts as $p)
            <div class="col-md-6">
                @product_home(['p' => $p])
                @endproduct_home
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="text-right">
    <a href="{{ route('subcat', ['catSlug'=> $product->cat(\App::getLocale())['slug'], 'slug' => $product->subCatSlug(), 'city' => $product->city]) }}"
       class="btn btn-flat btn-primary">{{ __('msg.view_more') }} <i class="fa fa-angle-double-right"></i></a>
</div>