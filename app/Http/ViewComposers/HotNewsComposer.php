<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\PostRepository;

class HotNewsComposer
{
    protected $postRepo;

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function compose(View $view)
    {
        $hotNews = $this->postRepo->getByOption([
            'status' => config('post.status.active'),
        ], 10);
        $view->with('hotNews', $hotNews);
    }
}