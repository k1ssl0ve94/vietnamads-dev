<?php

namespace App\Console\Commands;


use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PostMapCreator extends Command
{

    protected $signature = 'map_generate:post {page?}';

    protected $description = 'Auto generate sitemap file for post';

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
        // News
        $postList = $this->postRepo->paginate([
            'status' => config('post.status.active')
        ], 200, $page);
        foreach ($postList as $post) {
            /** @var App\Post $post */
            $url = route('post-detail', [
                'slug' => $post->slug ? : str_slug($post->title),
                'id' => $post->id,
            ]);
            $sitemap->add($url, Carbon::now(), '0.6', 'daily');
        }
        $fileName = 'sitemap/post_'.$page;
        if (!is_file(public_path($fileName. '.xml'))) {
            $f = fopen(public_path($fileName. '.xml'), 'a+');
            fclose($f);
        }
        $sitemap->store('xml', $fileName);
        if ($postList->hasMorePages()) {
            $this->call('map_generate:post', [
                'page' => $page + 1,
            ]);
        }
    }
}