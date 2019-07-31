<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
use App\Lib\IImage;

class Post extends Model
{
    protected $fillable = [
        'title', 'sapo', 'image', 'content', 'user_id', 'status', 'publish_at', 'cat',
        'hot', 'lang', 'image_alt', 'meta_title', 'meta_description', 'meta_keywords', 'meta_canonical',
        'slug',
    ];
    protected $appends = [
        'image_url',
        'lang_text'
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image == '') {
            return asset('imgs/img_placeholder.png');
        }

        $thumb = IImage::toThumbName($this->image);
        return Storage::disk('public')->url('uploads/posts/' . $thumb);
    }

    public function getImageUrlFull()
    {
        if ($this->image == '') {
            return asset('imgs/img_placeholder.png');
        }

        return Storage::disk('public')->url('uploads/posts/' . $this->image);
    }

    public function isActive()
    {
        return $this->status == config('post.status.active');
    }

    public function getCatName()
    {
        if ($this->cat == config('post.category.su_kien')) {
            return 'Sự kiện';
        }
        if ($this->cat == config('post.category.phan_tich')) {
            return 'Phân tích, nhận định';
        }
        if ($this->cat == config('post.category.kinh_nghiem')) {
            return 'Chia sẻ kinh nghiệm';
        }
        if ($this->cat == config('post.category.thuong_hieu_san_pham')) {
            return 'Thương hiệu, sản phẩm';
        }
        if ($this->cat == config('post.category.chinh_sach_quan_ly')) {
            return 'Chính sách, quản lý';
        }
        if ($this->cat == config('post.category.thong_bao')) {
            return 'Thông báo';
        }
        return 'Tin tức';
    }

    public function getLangTextAttribute()
    {
        if ($this->lang == config('user.lang.vi')) {
            return 'Vietnamese';
        } else if ($this->lang == config('user.lang.en')) {
            return 'English';
        }
        return 'N/A';
    }

    public function getPostURL()
    {
        $slug = $this->slug;

        if (empty($slug)) {
            $slug = str_slug($this->title);
        }

        return route('post-detail', ['id' => $this->id, 'slug' => $slug]);
    }
}
