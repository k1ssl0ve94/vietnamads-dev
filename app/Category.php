<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'categories';

    protected $fillable = [
        'name', 'name_en', 'slug', 'slug_en', 'description','content', 'parent_id',
        'meta_title', 'meta_description', 'meta_keywords', 'meta_canonical',
    ];

    public function cat($locale = '')
    {
        if ($locale == 'en') {
            $config = config('product_en');
        } else {
            $config = config('product');
        }

        foreach ($config['category'] as $cat) {
            if ($cat['id'] == $this->parent_id) {
                return $cat;
            }
        }

        return [
            'id' => 0,
            'name' => 'category',
            'slug' => 'category-slug',
            'name_en' => 'category',
            'slug_en' => 'category-slug',
        ];
    }
}
