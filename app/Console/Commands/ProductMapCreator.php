<?php

namespace App\Console\Commands;


use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProductMapCreator extends Command
{

    protected $signature = 'map_generate:product {page?}';

    protected $description = 'Auto generate sitemap file for product';

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
        $page = $this->argument('page');
        $page = $page ? : 1;
        $sitemap = \Illuminate\Support\Facades\App::make('sitemap');
        // Product
        $productArray = $this->productRepo->paginate([
            'status' => config('product.status.active'),
        ], 200, $page);


        if ($productArray && count($productArray)) {
            foreach ($productArray as $product) {
                /** @var $item App\Product */
                $url = route('product-detail', [
                    'catSlug' => $product->cat()['slug'],
                    'slug' => $product->subCat->slug,
                    'id' => $product->id,
                ]);
                $sitemap->add($url, Carbon::now(), '0.6', 'daily');
            }
        }
        $fileName = 'sitemap/product_'.$page;
        if (!is_file(public_path($fileName. '.xml'))) {
            $f = fopen(public_path($fileName. '.xml'), 'a+');
            fclose($f);
        }
        $sitemap->store('xml', $fileName);
        if ($productArray->hasMorePages()) {
            $this->call('map_generate:product', [
                'page' => $page + 1,
            ]);
        }
    }
}