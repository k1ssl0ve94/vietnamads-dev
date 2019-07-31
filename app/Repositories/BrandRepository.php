<?php

namespace App\Repositories;

use App\Brand;

class BrandRepository
{
    public function all()
    {
        return Brand::orderBy('order', 'asc')->orderBy('id', 'desc')->get();
    }

    public function add($data)
    {
        $b = new Brand;

        $b->name  = $data['name'];
        $b->logo = $data['logo'];
        $b->url = $data['url'];
        $b->order = 0;

        if ($b->save()) {
            return $b;
        }
        return null;
    }

    public function update($brand, $data)
    {
        if (isset($data['name'])) {
            $brand->name = $data['name'];
        }
        if (isset($data['order'])) {
            $brand->order = $data['order'];
        }
        if (isset($data['url'])) {
            $brand->url = $data['url'];
        }
        return $brand->save();
    }

    public function getById($id)
    {
        return Brand::find($id);
    }

    public function delete($brand)
    {
        return $brand->delete();
    }
}