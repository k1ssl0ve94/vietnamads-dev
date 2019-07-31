<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\PostRepository;

class LatestNewsComposer
{
    protected $postRepo;

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function compose(View $view)
    {
        $hotPosts = $this->postRepo->getByOption([
            'status' => config('post.status.active'),
            'hot' => 1,
        ], 10);

        $view->with('hotPosts', $hotPosts);
    }
}