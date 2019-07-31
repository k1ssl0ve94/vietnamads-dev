<?php
namespace App\Repositories;

use App\Post;

Class PostRepository
{

    public function all()
    {
        return Post::all();
    }

    public function getById($id)
    {
        return Post::find($id);
    }

    public function getByIds($ids)
    {
        return Post::whereIn('id', $ids)->get();
    }

    public function paginate($params = [], $take = 20, $page = null)
    {
        $query = Post::query();

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

        if (isset($params['lang']) && $params['lang'] !== '') {
            $query->where('lang', $params['lang']);
        }
        if (!empty($page)) {
            return $query->orderBy('id', 'desc')->paginate($take, ['*'], 'page', $page);
        }
        return $query->orderBy('id', 'desc')->paginate($take);
    }

    public function add($data)
    {
        $post = new Post;
        $post->fill($data);

        if (isset($data['lang'])) {
            $post->lang = intval($data['lang']);
        } else {
            $post->lang = config('user.lang.vi');
        }

        if ($post->save()) {
            return $post;
        }

        return null;
    }

    public function update($post, $data)
    {
        $post->fill($data);

        if (isset($data['lang'])) {
            $post->lang = intval($data['lang']);
        }

        return $post->save();
    }

    public function getByCat($cat, $take = 5)
    {
        return Post::where('cat', $cat)->orderBy('id', 'desc')
                    ->take($take)->get();
    }

    public function getByOption($options, $take = 5)
    {
        $query = Post::query();

        if (isset($options['hot'])) {
            $query->where('hot', intval($options['hot']));
        }

        if (isset($options['cat'])) {
            $query->where('cat', $options['cat']);
        }

        if (isset($options['lang']) && $options['lang'] !== '') {
            $query->where('lang', $options['lang']);
        }

        return $query->orderBy('id', 'desc')->take($take)->get();
    }

    public function getRandom($take = 10, $lang = '')
    {
        $query = Post::inRandomOrder();
        if ($lang !== '') {
            $query->where('lang', $lang);
        }

        return $query->take($take)->get();
    }

    public function count()
    {
        return Post::count();
    }

    public function countByRange($from = null, $to = null)
    {
        $query = Post::query();
        if ($from) {
            $query->where('created_at', '>=', $from);
        }

        if ($to) {
            $query->where('created_at', '<=', $to);
        }

        return $query->count();
    }
}
?>