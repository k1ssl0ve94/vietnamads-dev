<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Validators\RegexRuleCommon;
use Illuminate\Http\Request;
use App\Repositories\PostRepository;
use App\Lib\IImage;

class PostController extends Controller
{

    protected $postRepo;

    public function __construct(PostRepository $postRepo)
    {
        $this->middleware('auth:api');

        $this->postRepo = $postRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('api')->user();
        if (!$user->can('view post')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        $params = request()->only('keyword', 'status', 'cat', 'lang');
        $posts = $this->postRepo->paginate($params, 20);

        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth('api')->user();
        if (!$user->can('manage post')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        $request->validate([
            'title' => 'required|between:10,1000',
            'sapo' => 'required|between:10,1000',
            'content' => 'required|between:10,20000',
            'cat' => 'required|in:1,2,3,4,5,6',
            'hot' => 'required|in:0,1',
            'lang' => 'required|in:'.implode(',', array_values(config('user.lang'))),
        ]);

        $data = $request->only('title', 'sapo', 'content', 'status', 'image', 'cat', 'hot', 'lang',
            'meta_title', 'meta_description', 'meta_keywords', 'meta_canonical', 'image_alt', 'slug'
            );
        if (!$request->input('slug')) {
            $data['slug'] = str_slug($data['title']);
        } else {
            $this->validate($request, [
                'slug' => 'regex:'.RegexRuleCommon::REGEX_SLUG.'|unique:posts',
            ]);
        }
        if ($data['image'] && isset($data['image']['filename'])) {
            $data['image'] = $data['image']['filename'];
            IImage::makeThumb($data['image'], 'posts');
        } else {
            $data['image'] = '';
        }

        if ($data['status']) {
            $data['status'] = config('post.status.active');
        } else {
            $data['status'] = config('post.status.inactive');
        }

        $data['user_id'] = $user->id;

        if ($post = $this->postRepo->add($data)) {
            event(new \App\Events\AdminLog([
                'admin_id' => $user->id,
                'action' => 'add_post',
                'metadata' => [
                    'id' => $post->id,
                ]
            ]));
            return response()->json([
                'post' => $post,
            ]);
        }

        return response()->json(['post' => null]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $user = auth('api')->user();

        if (!$user->can('view post')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        return response()->json(['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $user = auth('api')->user();

        if (!$user->can('manage post')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        $request->validate([
            'title' => 'required|between:10,1000',
            'sapo' => 'required|between:10,1000',
            'content' => 'required|between:10,10000',
            'cat' => 'required|in:1,2,3,4,5,6',
            'hot' => 'required|in:0,1',
            'lang' => 'required|in:'.implode(',', array_values(config('user.lang'))),
        ]);

        $data = $request->only('title', 'sapo', 'content', 'status', 'image', 'cat', 'hot', 'lang',
            'meta_title', 'meta_description', 'meta_keywords', 'meta_canonical', 'image_alt', 'slug'
        );
        if (!$request->input('slug')) {
            $data['slug'] = str_slug($data['title']);
        } else {
            $this->validate($request, [
                'slug' => 'regex:'.RegexRuleCommon::REGEX_SLUG.'|unique:posts,slug,'.$post->id,
            ]);
        }

        $oldImage = $post->image;
        if (is_array($data['image']) && isset($data['image']['filename'])) {
            $data['image'] = $data['image']['filename'];

            if ($oldImage != $data['image']) {
                $thumbData = IImage::makeThumb($data['image'], 'posts');
            }
        }

        if ($data['status']) {
            $data['status'] = config('post.status.active');
        } else {
            $data['status'] = config('post.status.inactive');
        }

        if ($this->postRepo->update($post, $data)) {
            event(new \App\Events\AdminLog([
                'admin_id' => $user->id,
                'action' => 'update_post',
                'metadata' => [
                    'id' => $post->id,
                ]
            ]));
            return response()->json([
                'success' => 1,
            ]);
        }

        return response()->json(['success' => 0]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $user = auth('api')->user();
        if (!$user->can('manage post')) {

            return response()->json(['errors' => ['unauthorized']]);
        }
        $post->delete();

        event(new \App\Events\AdminLog([
            'admin_id' => $user->id,
            'action' => 'delete_post',
            'metadata' => [
                'id' => $post->id,
            ]
        ]));

        return response()->json(['success' => true]);
    }
}
