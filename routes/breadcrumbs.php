<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Support\Facades\App;

Breadcrumbs::for('home', function ($trail) {
    $trail->push(__('Home', [], App::getLocale()), route('home'));
});

Breadcrumbs::for('category', function ($trail, $cat) {
    $trail->parent('home');
    $trail->push($cat['name'], route('category', [
        'slug' => $cat['slug'],
    ]));
});

Breadcrumbs::for('subcategory', function ($trail, $cat, $category) {
    $trail->parent('category', $cat);
    $trail->push($category->name, route('subcat', [
        'catSlug' => $cat['slug'],
        'slug' => $category->slug,
    ]));
});

Breadcrumbs::for('class_category', function ($trail, $cat, $category, $classCategory) {
    if ($category) {
        $trail->parent('subcategory', $cat, $category);
    } else {
        $trail->parent('category', $cat);
    }
    $trail->push($classCategory->name, route('class-category', [
        'slug' => $classCategory->slug,
        'id' => $classCategory->id,
    ]));
});

Breadcrumbs::for('product_detail', function ($trail, $product) {
    $trail->parent('subcategory', $product->cat(), $product->subCat);
    $trail->push($product->title, route('product-detail', [
        'catSlug' => $product->cat()['slug'],
        'slug' => $product->subCat->slug,
        'id' => $product->id,
    ]));
});

// News
Breadcrumbs::for('news', function ($trail) {
    $trail->parent('home');
    $trail->push('Tin tức', route('news'));
});

Breadcrumbs::for('sub_news', function ($trail, $postCateConfig) {
    $trail->parent('news');
    $trail->push($postCateConfig['name'], route($postCateConfig['route']));
});

Breadcrumbs::for('news_detail', function ($trail, $post) {
    $postCateConfig = config('post.breadcrumb')[$post->cat];
    $trail->parent('sub_news', $postCateConfig);
    $trail->push($post->title, route('post-detail', [
        'slug' => $post->slug,
        'id' => $post->id,
    ]));
});

// Static page

Breadcrumbs::for('about', function ($trail, $pageName, $slug) {
    $trail->parent('home');
    $trail->push($pageName, route('about', [
        'page' => $slug,
    ]));
});
Breadcrumbs::for('guide', function ($trail, $pageName, $slug) {
    $trail->parent('home');
    $trail->push($pageName, route('about', [
        'page' => $slug,
    ]));
});


Breadcrumbs::for('hoat-dong', function ($trail) {
    $trail->parent('home');
    $trail->push('Quy chế hoạt động', route('hoatDong'));
});

Breadcrumbs::for('baoMat', function ($trail) {
    $trail->parent('home');
    $trail->push('Chính sách bảo mật', route('baoMat'));
});

Breadcrumbs::for('tranhChap', function ($trail) {
    $trail->parent('home');
    $trail->push('Giải quyết tranh chấp', route('tranhChap'));
});

Breadcrumbs::for('baogia', function ($trail) {
    $trail->parent('home');
    $trail->push('Báo giá', route('pricing'));
});

Breadcrumbs::for('baogia-sub', function ($trail, $name, $slug) {
    $trail->parent('baogia');
    $trail->push($name, route('sub-bao-gia', ['page' => $slug]));
});

Breadcrumbs::for('contact', function ($trail) {
    $trail->parent('home');
    $trail->push('Liên hệ', route('contact'));
});