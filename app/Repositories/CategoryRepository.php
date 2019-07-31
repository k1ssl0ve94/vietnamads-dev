<?php
namespace App\Repositories;

use App\Category;
use App\ClassCategory;
use App\ClassCategoryProduct;
use Illuminate\Support\Facades\Cache;
use App\Lib\Location;

Class CategoryRepository
{

    public function all()
    {
        return Category::all();
    }

    public function allByOrder()
    {
        $key = 'categories';
        if (Cache::get($key)) {
            return Cache::get($key);
        }
        $categories = Category::orderBy('order', 'asc')->get();
        Cache::put($key, $categories, 60 * 24);
        return $categories;
    }

    public function getById($id)
    {
        return Category::find($id);
    }

    public function paginate($params = [], $take = 20)
    {
        $query = Category::query();

        if (!empty($params['keyword'])) {
            $query->where('title', 'like', '%'.$params['keyword'].'%')
                ->orWhere('sapo', 'like', '%' . $params['keyword'] . '%')
                ->orWhere('content', 'like', '%' . $params['keyword'] . '%');
        }

        if (isset($params['status']) && $params['status'] !== '') {
            $query->where('status', $params['status']);
        }

        if (isset($params['cat']) && $params['cat'] !== '') {
            $query->where('cat', $params['cat']);
        }

        return $query->orderBy('id', 'desc')->paginate($take);
    }

    public function paginate2($params = [], $take = 20)
    {
        $query = Category::query();

        if (!empty($params['keyword'])) {
            $query->where('name', 'like', '%'.$params['keyword'].'%')
                ->orWhere('slug', 'like', '%' . $params['keyword'] . '%')
                ->orWhere('description', 'like', '%' . $params['keyword'] . '%');
        }

        if (isset($params['parent_id']) && $params['parent_id']) {
            $query->where('parent_id', $params['parent_id']);
        }

        $list = $query->orderBy('id', 'desc')->paginate($take);
        foreach ($list as $item) {
            $item->parentCate = $this->getParentCategoryByID($item->parent_id);
        }
        return $list;
    }

    public function add($data)
    {
        $cat = new Category();
        $cat->fill($data);
        if ($cat->save()) {
            return $cat;
        }
        return null;
    }

    public function update($cat, $data)
    {
        $cat->fill($data);
        return $cat->save();
    }

    public function getBySlug($slug)
    {
        if (is_numeric($slug)) {
            return Category::find($slug);
        }
        return Category::where('slug', $slug)->orWhere('slug_en', $slug)->first();
    }



    public function getParentCategoryByID($id)
    {
        foreach (config('product.category') as $cat) {
            if ($cat['id'] == $id) {
                return $cat;
            }
        }
        return null;
    }

    public function getParentCategoryBySlug($locale, $slug)
    {
        if ($locale == 'en') {
            $config = config('product_en');
        } else {
            $config = config('product');
        }
        foreach ($config['category'] as $cat) {
            if ($cat['slug'] == $slug) {
                return $cat;
            }
        }

        return null;
    }

    public function addClassCategory($data)
    {
        $classCategory = new ClassCategory();
        $classCategory->fill($data);

        $isExisted = ClassCategory::query()
            ->where('type', $classCategory->type)
            ->where('category_id', $classCategory->category_id)
            ->where('sub_category_id', $classCategory->sub_category_id)
            ->where('name', $classCategory->name)
            ->first();
        if ($isExisted) {
            return [false, 'Class category is existed.'];
        }
        if ($classCategory->status == ClassCategory::STATUS_ACTIVE) {
            $totalActive = ClassCategory::query()
                ->where('type', $classCategory->type)
                ->where('category_id', $classCategory->category_id)
                ->where('sub_category_id', $classCategory->sub_category_id)
                ->where('status', ClassCategory::STATUS_ACTIVE)
                ->count();
            if ($totalActive >= 15) {
                return [false, 'The number of ' . $classCategory->getTypeLabel() . ' Category cannot over 15 items.'];
            }
        }
        $classCategory->total_products =  count(array_unique($data['productIds']));
        $classCategory->save();
        ClassCategoryProduct::query()->where('class_category_id', $classCategory->id)
            ->delete();
        if (!empty($data['productIds']) && count($data['productIds'])) {
            $data['productIds'] = array_unique($data['productIds']);
            foreach ($data['productIds'] as $productId) {
                $classCategoryProduct = new ClassCategoryProduct();
                $classCategoryProduct->fill([
                    'class_category_id' => $classCategory->id,
                    'product_id' => $productId,
                ]);
                $classCategoryProduct->save();
            }
        }

        return [true, null];
    }

    /**
     * @param $data
     * @param $classCategory ClassCategory
     * @return array
     */
    public function updateClassCategory($data, $classCategory)
    {
        $classCategory->fill($data);
        $isExisted = ClassCategory::query()
            ->where('type', $classCategory->type)
            ->where('id', '<>', $classCategory->id)
            ->where('category_id', $classCategory->category_id)
            ->where('sub_category_id', $classCategory->sub_category_id)
            ->where('name', $classCategory->name)
            ->first();
        if ($isExisted) {
            return [false, 'Class category is existed.'];
        }
        // If change status to active
        if ($classCategory->status == ClassCategory::STATUS_ACTIVE) {
            $totalActive = ClassCategory::query()
                ->where('type', $classCategory->type)
                ->where('id', '<>', $classCategory->id)
                ->where('category_id', $classCategory->category_id)
                ->where('sub_category_id', $classCategory->sub_category_id)
                ->where('status', ClassCategory::STATUS_ACTIVE)
                ->count();
            if ($totalActive >= 15) {
                return [false, 'The number of '.$classCategory->getTypeLabel().' Category cannot over 15 items.'];
            }
        }
        $classCategory->total_products =  count(array_unique($data['productIds']));
        $classCategory->save();
        ClassCategoryProduct::query()->where('class_category_id', $classCategory->id)
            ->delete();
        if (!empty($data['productIds']) && count($data['productIds'])) {
            $data['productIds'] = array_unique($data['productIds']);
            foreach ($data['productIds'] as $productId) {
                $classCategoryProduct = new ClassCategoryProduct();
                $classCategoryProduct->fill([
                    'class_category_id' => $classCategory->id,
                    'product_id' => $productId,
                ]);
                $classCategoryProduct->save();
            }
        }

        return [true, null];
    }

    public function addProductToClassCategory($productId, $classId)
    {
        $productClass = ClassCategoryProduct::query()
            ->where('class_category_id', $classId)
            ->where('product_id', $productId)
            ->firstOrCreate([
                'class_category_id' => $classId,
                'product_id' => $productId,
            ]);
        return $productClass->save();
    }

    public function removeProductClassCategory($productId, $classId)
    {
        $productClass = ClassCategoryProduct::query()
            ->where('class_category_id', $classId)
            ->where('product_id', $productId)
            ->first();
        if ($productClass) {
            $productClass->delete();
        }
        return ;
    }

    public function getClassCategoryPagination($options = [], $page = 1, $npp = 20)
    {
        $builder = ClassCategory::query();
        if (!empty($options['category_id'])) {
            $builder->where('category_id', $options['category_id']);
        }
        if (!empty($options['sub_category_id'])) {
            $builder->where('sub_category_id', $options['sub_category_id']);
        }
        if (!empty($options['user_id'])) {
            $builder->where('user_id', $options['user_id']);
        }
        if (!empty($options['type'])) {
            $builder->where('type', $options['type']);
        }
        if (!empty($options['key'])) {
            $builder->where(function ($query) use($options) {
                $likeStr = "%{$options['key']}%";
                $query->where('name', 'like', $likeStr)
                    ->orWhere('contact_name', 'like', $likeStr)
                    ->orWhere('contact_mobile', 'like', $likeStr);
            });
        }
        $items = $builder->paginate($npp, ['*'], 'page', $page);
        $categoryIds = [];
        foreach ($items as $item) {
            if ($item->sub_category_id) {
                $categoryIds[$item->sub_category_id] = $item->sub_category_id;
            }
        }
        $categoryArray = [];
        if (count($categoryIds)) {
            $categoryArray = Category::query()->whereIn('id', $categoryIds)
                ->pluck('name', 'id')->toArray();
        }
        foreach ($items as $item) {
            if ($item->sub_category_id && isset($categoryArray[$item->sub_category_id])) {
                $item->subCategory = $categoryArray[$item->sub_category_id];
            }
        }
        return $items;
    }

    public function getClassCategoryById($id, $loadDetail = false)
    {
        $item = ClassCategory::find($id);
        if ($loadDetail) {
            $products = ClassCategoryProduct::query()
                ->join('products',
                    'products.id', '=', 'class_categories_products.product_id')
                ->where('class_category_id', $id)
                ->get(['products.*']);
            $item->productArray = $products;
        }
        return $item;
    }

    public function getClassCategoryOf($type, $categoryId, $subCategoryId = null)
    {
        $builder = ClassCategory::query()
            ->where('type', $type);
        if ($categoryId) {
            $builder->where('category_id', $categoryId);
        }
        if ($subCategoryId) {
            $builder->where('sub_category_id', $subCategoryId);
        }
        $builder->where('status', ClassCategory::STATUS_ACTIVE);
        $items = $builder->take(15)->get()->toArray();
        shuffle($items);
        return $items;
    }

}
