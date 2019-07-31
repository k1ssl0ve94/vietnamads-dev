<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Repositories\PostRepository;
use App\Repositories\ProductRepository;

class PostController extends Controller
{
    protected $postRepo;
    protected $productRepo;

    public function __construct(PostRepository $postRepo, ProductRepository $productRepo)
    {
        $this->postRepo = $postRepo;
        $this->productRepo = $productRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latestPosts = $this->postRepo->getByOption([
            'status' => config('post.status.active'),
            'lang' => $this->getLang(),
        ], 5);
        $suKien = $this->postRepo->paginate([
            'cat' => config('post.category.su_kien'),
            'status' => config('post.status.active'),
            'lang' => $this->getLang(),
        ], 6);
        $phanTich = $this->postRepo->paginate([
            'cat' => config('post.category.phan_tich'),
            'status' => config('post.status.active'),
            'lang' => $this->getLang(),
        ], 6);
        $kinhNghiem = $this->postRepo->paginate([
            'cat' => config('post.category.kinh_nghiem'),
            'status' => config('post.status.active'),
            'lang' => $this->getLang(),
        ], 6);

        $thuongHieu = $this->postRepo->paginate([
            'cat' => config('post.category.thuong_hieu_san_pham'),
            'status' => config('post.status.active'),
            'lang' => $this->getLang(),
        ], 6);

        $chinhSach = $this->postRepo->paginate([
            'cat' => config('post.category.chinh_sach_quan_ly'),
            'status' => config('post.status.active'),
            'lang' => $this->getLang(),
        ], 6);

        $thongBao = $this->postRepo->paginate([
            'cat' => config('post.category.thong_bao'),
            'status' => config('post.status.active'),
            'lang' => $this->getLang(),
        ], 6);

        $description = 'Toàn bộ các tin tức được cập nhật 24/7 liên quan đến quảng cáo và marketing của Việt Nam cũng như thế giới';

        return view('pages.news', compact('latestPosts', 'suKien', 'phanTich',
            'kinhNghiem', 'thuongHieu', 'chinhSach', 'thongBao', 'description'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $id)
    {
        $id = intval($id);
        $post = $this->postRepo->getById($id);
        if ($post == null || !$post->isActive()) {
            abort(404);
        }

        $postSlug = $post->slug ? $post->slug : str_slug($post->title);

        if ($postSlug != $slug) {
            return redirect()->away($post->getPostURL(), 301);
        }

        $relatedPosts = $this->postRepo->getRandom(5, $this->getLang());

        return view('pages.new-detail', compact('post', 'relatedPosts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    public function phanTich(Request $request)
    {
        $cat = config('post.category.phan_tich');
        $posts = $this->postRepo->paginate([
            'cat' => $cat,
            'status' => config('post.status.active'),
        ], 20);
        $subName = 'Phân tích, nhận định';
        $subRoute = 'phan-tich';
        return view('pages.post-by-cat', compact('posts', 'cat',
            'subName', 'subRoute'));
    }

    public function suKien(Request $request)
    {
        $cat = config('post.category.su_kien');
        $posts = $this->postRepo->paginate([
            'cat' => $cat,
            'status' => config('post.status.active'),
        ], 20);
        $subName = 'Sự kiện';
        $subRoute = 'su-kien';
        return view('pages.post-by-cat', compact('posts', 'cat', 'subName', 'subRoute'));
    }

    public function kinhNghiem(Request $request)
    {
        $cat = config('post.category.kinh_nghiem');
        $posts = $this->postRepo->paginate([
            'cat' => $cat,
            'status' => config('post.status.active'),
        ], 20);
        $subName = 'Chia sẻ kinh nghiệm';
        $subRoute = 'kinh-nghiem';
        return view('pages.post-by-cat', compact('posts', 'cat', 'subName', 'subRoute'));
    }

    public function thuongHieu(Request $request)
    {
        $cat = config('post.category.thuong_hieu_san_pham');
        $posts = $this->postRepo->paginate([
            'cat' => $cat,
            'status' => config('post.status.active'),
        ], 20);
        $subName = 'Thương hiệu, sản phẩm';
        $subRoute = 'thuong-hieu';
        return view('pages.post-by-cat', compact('posts', 'cat', 'subName', 'subRoute'));
    }

    public function chinhSach(Request $request)
    {
        $cat = config('post.category.chinh_sach_quan_ly');
        $posts = $this->postRepo->paginate([
            'cat' => $cat,
            'status' => config('post.status.active'),
        ], 20);
        $subName = 'Chính sách, quản lý';
        $subRoute = 'chinh-sach';
        return view('pages.post-by-cat', compact('posts', 'cat', 'subName', 'subRoute'));
    }

    public function thongBao(Request $request)
    {
        $cat = config('post.category.thong_bao');
        $posts = $this->postRepo->paginate([
            'cat' => $cat,
            'status' => config('post.status.active'),
        ], 20);
        $subName = 'Thông báo';
        $subRoute = 'thong-bao';
        return view('pages.post-by-cat', compact('posts', 'cat', 'subName', 'subRoute'));
    }

}
