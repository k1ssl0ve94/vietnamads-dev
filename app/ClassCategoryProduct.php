<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class ClassCategoryProduct extends Model
{
    protected $table = 'class_categories_products';

    protected $fillable = [
        'class_category_id', 'product_id',
    ];

}