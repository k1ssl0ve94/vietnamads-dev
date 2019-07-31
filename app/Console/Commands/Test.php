<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\Location;
use Carbon\Carbon;
use App\Repositories\UserRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PostRepository;
use Image;
use Storage;
use App\Lib\IImage;
use App\Category;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $userRepo;
    protected $productRepo;
    protected $postRepo;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepo, ProductRepository $productRepo, PostRepository $postRepo)
    {
        parent::__construct();
        $this->userRepo = $userRepo;
        $this->productRepo = $productRepo;
        $this->postRepo = $postRepo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (Category::all() as $cat) {
            if ($cat->slug_en == '') {
                $cat->slug_en = str_slug($cat->name_en);
                $cat->save();
            }
        }
    }
}
