<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\CategoryRepository;
use App;

class HeaderComposer
{
    protected $catRepo;

    public function __construct(CategoryRepository $catRepo)
    {
        $this->catRepo = $catRepo;
    }

    public function compose(View $view)
    {
        $cats = $this->catRepo->allByOrder();
        $catData = [];
        foreach ($cats as $c) {
            if (!isset($catData[$c->parent_id])) {
                $catData[$c->parent_id] = [];
            }
            $d = $c->toArray();
            if (App::isLocale('en')) {
                $d['name'] = $d['name_en'];
                $d['slug'] = $d['slug_en'];
            }
            $catData[$c->parent_id][] = $d;
        }
        $view->with('catData', $catData);
    }
}