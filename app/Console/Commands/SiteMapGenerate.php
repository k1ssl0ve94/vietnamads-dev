<?php

namespace App\Console\Commands;


use App\ClassCategory;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;
use Spatie\Sitemap\SitemapIndex;

class SiteMapGenerate extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Auto generate sitemap file';

    protected $productRepo;
    protected $userRepository;
    protected $settingRepository;
    protected $catRepo;
    protected $postRepo;

    public function __construct(ProductRepository $productRepository,
                                UserRepository $userRepository,
                                SettingRepository $settingRepository,
                                CategoryRepository $catRepo,
                                PostRepository $postRepo)
    {
        parent::__construct();
        $this->productRepo = $productRepository;
        $this->userRepository = $userRepository;
        $this->settingRepository = $settingRepository;
        $this->catRepo = $catRepo;
        $this->postRepo = $postRepo;
    }

    public function handle()
    {
        $this->generateSiteMap();
    }
    public function generateSiteMap() {
        $sitemap = \Illuminate\Support\Facades\App::make('sitemap');
        /** @var Sitemap $sitemap */
        $sitemap->add(URL::to('/'), Carbon::now(), '1.0', 'daily');
        $sitemap->add(route('pricing'), Carbon::now(), '0.8', 'monthly');
        $sitemap->add(route('guide'), Carbon::now(), '0.8', 'monthly');
        $sitemap->add(route('baoMat'), Carbon::now(), '0.8', 'monthly');
        $sitemap->add(route('hoatDong'), Carbon::now(), '0.8', 'monthly');
        $sitemap->add(route('tranhChap'), Carbon::now(), '0.8', 'monthly');
        $sitemap->add(route('about'), Carbon::now(), '0.8', 'monthly');

        // Main cate
        $cateList = config('product.category');
        foreach ($cateList as $cat) {
            $url = route('category', [
                'catSlug' => $cat['slug'],
            ]);
            $sitemap->add($url, Carbon::now(), '0.8', 'daily');
        }
        // Cate in english
        $cateList = config('product_en.category');
        foreach ($cateList as $cat) {
            $url = route('category', [
                'catSlug' => $cat['slug'],
            ]);
            $sitemap->add($url, Carbon::now(), '0.8', 'daily');
        }
        // Sub category
        $categories = $this->catRepo->paginate([], 500);
        foreach ($categories as $category) {
            /** @var $category App\Category */
            $url = route('subcat', [
                'catSlug' => $category->cat()['slug'],
                'slug' => $category->slug,
            ]);
            $sitemap->add($url, Carbon::now(), '0.8', 'daily');
        }
        // Class category
        $classCategories = $this->catRepo->getClassCategoryPagination([
            'type' => ClassCategory::TYPE_ADVISER,
        ], 1, 200);
        foreach ($classCategories as $classCategory) {
            /** @var  App\ClassCategory $classCategory */
            $url = route('class-category', [
                'slug' => str_slug($classCategory->name),
                'id' => $classCategory->id,
            ]);
            $sitemap->add($url, Carbon::now(), '0.8', 'daily');
        }
        $sitemap->store('xml','sitemap/category');
        $siteMapIndex = new SitemapIndex();
        $sPath = 'sitemap/';
        foreach (scandir(public_path('sitemap')) as $file) {
            if (is_file(public_path($sPath.$file))) {
                $siteMapIndex->add(URL::route('home').'/'.$sPath.$file, Carbon::now());
            }
        }
        if (!is_file(public_path('sitemap.xml'))) {
            $f = fopen(public_path('sitemap.xml'), 'a+');
            fclose($f);
        }
        $siteMapIndex->writeToFile(public_path('sitemap.xml'));
    }
}