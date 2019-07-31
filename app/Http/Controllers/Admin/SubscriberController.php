<?php

namespace App\Http\Controllers\Admin;

use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SubscriberRepository;
use App\Repositories\PostRepository;

class SubscriberController extends Controller
{
    protected $subRepo;
    protected $postRepo;

    public function __construct(SubscriberRepository $subRepo, PostRepository $postRepo)
    {
        $this->middleware('auth:api');

        $this->subRepo = $subRepo;
        $this->postRepo = $postRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth('api')->user()->can('view subscriber')) {
            return response()->json(['errors' => ['unauthorized']]);
        }
        $subscribers = $this->subRepo->paginate(15);

        return response()->json($subscribers);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        if (!auth('api')->user()->can('manage subscriber')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        if ($this->subRepo->delete($subscriber)) {
            event(new \App\Events\AdminLog([
                'admin_id' => $user->id,
                'action' => 'delete_subscriber',
                'metadata' => [
                    'id' => $post->id,
                ]
            ]));

            return ['status' => 1];
        }
        return ['status' => 0];
    }


    public function sendEmailNewsletter(Request $request)
    {
        $request->validate([
            'subject' => 'required',
        ]);

        $postIds = $request->post_ids;
        $posts = $this->postRepo->getByIds($postIds);
        if ($posts->count() == 0) {
            return ['status' => 0, 'msg' => 'Invalid posts'];
        }

        $postData = [];
        foreach ($posts as $post) {
            $postData[] = [
                'title' => $post->title,
                'url' => route('post-detail', ['id' => $post->id, 'slug' => str_slug($post->title)]),
                'image' => $post->image_url,
                'sapo' => $post->sapo,
            ];
        }

        $subs = $this->subRepo->all();
        foreach ($subs as $sub) {
            if (empty($sub->email)) {
                continue;
            }
            \App\Lib\Email::send([
                'template_id' => 'd-89931223f46f42f28d11adf1be69e029',
                'to_email' => $sub->email,
                'to_name' => '',
                'data' => [
                    'subject' => $request->subject,
                    'posts' => $postData,
                    'view_more_url' => route('news'),
                ],
            ]);
        }

        return ['status' => 1];
    }
}
