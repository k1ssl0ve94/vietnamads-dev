<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class ClassCategory extends Model
{
    protected $table = 'class_categories';

    protected $fillable = [
        'type', 'user_id', 'name', 'status', 'total_products',
        'contact_name', 'contact_mobile', 'note', 'category_id' , 'sub_category_id',
        'meta_title', 'meta_description', 'meta_keywords', 'meta_canonical', 'description',
    ];

    const TYPE_ADVISER = 1;
    const TYPE_SPONSOR = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    public $subCategory;
    public $category;
    public $productArray;

    protected $typeLabels = [
        self::TYPE_ADVISER => 'Adviser',
        self::TYPE_SPONSOR => 'Sponsor',
    ];

    protected $statusLabels = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public function getTypeLabel()
    {
        return isset($this->typeLabels[$this->type]) ? $this->typeLabels[$this->type] : '';
    }

    public function getStatusLabel()
    {
        return isset($this->statusLabels[$this->status]) ? $this->statusLabels[$this->status] : '';
    }

    public function getCategoryLabel()
    {
        $productCategory = config('product.category');
        foreach ($productCategory as $cate){
            if ($cate['id'] == $this->category_id) {
                return $cate['name'];
            }
        }
        return '';
    }

    public function toArray()
    {
        return parent::toArray() + [
                'typeLabel' => $this->getTypeLabel(),
                'statusLabel' => $this->getStatusLabel(),
                'category' => $this->getCategoryLabel(),
                'subCategory' => $this->subCategory,
                'productArray' => $this->productArray,
            ];
    }
}