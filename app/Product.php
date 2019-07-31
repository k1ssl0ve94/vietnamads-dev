<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Storage;
use App\Lib\Location;
use Carbon\Carbon;
use App\Lib\IImage;

class Product extends Model
{
    use SoftDeletes;

    const REFRESH_TYPE_AUTO = 1;
    const REFRESH_TYPE_MANUALLY = 2;

    protected $dates = ['deleted_at', 'from', 'to', 'last_refresh'];

    protected $fillable = [
        'user_id', 'title', 'city', 'district', 'ward', 'street', 'content', 'category', 'category_parent', 'status',
        'level', 'package_option', 'contact_name', 'contact_phone', 'contact_email', 'contact_address', 'keywords',
        'images', 'thumb', 'from', 'to', 'link', 'price', 'price_unit', 'provider', 'currency', 'pano_type', 'pano_size',
        'pano_border', 'pano_light', 'pano_power', 'ad_channel', 'ad_coverage', 'ad_time', 'social_type',
        'social_follow', 'web_type', 'web_position', 'find_service', 'last_refresh', 'note', 'tags', 'lat',
        'long', 'title_color', 'parameter_color', 'price_color', 'icon', 'images_number', 'allow_sms',
        'allow_promotion', 'allow_management', 'allow_send_author', 'manual_refresh', 'auto_refresh',
        'refresh_fee', 'backup_time', 'direct_link', 'priority', 'display_in_trend', 'display_in_search',
        'display_in_tags', 'auto_active', 'edit_times', 'keep_alive', 'youtube_link', 'allow_direct_link',
        'refresh_type',
    ];

    protected $appends = [
        'thumb_url',
        'category_text',
        'category_parent_text',
        'from_date_text',
        'to_date_text',
        'provider_text',
        'product_url',
        'tags_text',
        'lang_text',
    ];

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function subCat()
    {
        return $this->belongsTo('App\Category', 'category', 'id');
    }


    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'product_tag');
    }

    public function service()
    {
        return $this->belongsTo('App\Service', 'level', 'id');
    }

    public function levelText()
    {
        if ($this->service) {
            return $this->service->name;
        }
        return '';
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

    public function getProviderTextAttribute()
    {
        if (empty($this->provider)) {
            return '';
        }

        foreach (config('product.provider') as $p) {
            if ($p['id'] == $this->provider) {
                return $p['name'];
            }
        }
        return '';
    }

    public function getProductUrlAttribute()
    {
        return $this->detailLink();
    }

    public function isActive()
    {
        return $this->status == config('product.status.active')
            || $this->status == config('product.status.disabled');
    }

    public function isPending()
    {
        return $this->status == config('product.status.pending');
    }

    public function isDisabled()
    {
        return $this->status == config('product.status.disabled');
    }

    public function cityText()
    {
        $city = Location::getCity($this->city);
        return $city ? $city['name'] : '';
    }

    public function districtText()
    {
        $dist = Location::getDistrict($this->district);
        return $dist ? $dist['name'] : '';
    }

    public function wardText()
    {
        $ward = Location::getWard($this->ward);
        return $ward ? $ward['name'] : '';
    }

    public function streetText()
    {
        $street = Location::getStreet($this->street);
        return $street ? $street['name'] : '';
    }

    public function locationText()
    {
        $dist = $this->districtText();
        $city = $this->cityText();
        if (!empty($dist) && !empty($city)) {
            return $dist . ', ' . $city;
        }
        return $dist || $city;
    }

    public function fullLocationText()
    {
        $text = $this->districtText() . ', ' . $this->cityText();
        if ($ward = $this->wardText()) {
            $text = $ward . ', ' . $text;
        }
        if ($street = $this->streetText()) {
            $text = $street . ', ' . $text;
        }
        return $text;
    }

    public function priceText()
    {
        if ($this->price == 0 && !$this->price_unit) {
            return 'Thỏa thuận';
        }

        if ($this->currency == 'VND') {

            $str = '';
            $num = intval($this->price);
            $num = trim($num);
            $arr = str_split($num);
            $count = count($arr);
            $f = number_format($num);
            if ($count < 4) {
                $str = $num;
            } else {
                $r = explode(',', $f);
                switch (count($r)) {
                    case 4:
                        $str = $r[0] . ' tỉ';
                        if ((int) $r[1]) {
                            $str .= ' ' . $r[1] . ' triệu';
                        }
                        break;
                    case 3:
                        $str = $r[0] . ' triệu';
                        if ((int) $r[1]) {
                            $str .= ' ' . $r[1] . ' ngàn';
                        }
                        break;
                    case 2:
                        $str = $r[0] . ' ngàn';
                        if ((int) $r[1]) {
                            $str .= ' ' . $r[1] . ' đồng';
                        }
                        break;
                }
            }
            return $str . ' vnđ/' . $this->price_unit;
        }
        return intval($this->price) . 'vnđ/' . $this->price_unit;
    }

    public function getFromDateTextAttribute()
    {
        if ($this->from) {
            return $this->from->format('d/m/Y');
        }
        return '';
    }

    public function getToDateTextAttribute()
    {
        if ($this->to) {
            return $this->to->format('d/m/Y');
        }
        return '';
    }

    public function getTextAttr($attr)
    {
        if (!isset($this->attributes[$attr]) || $this->attributes[$attr] == null) {
            return '';
        }
        $id = $this->attributes[$attr];
        $config = $attr;
        if (strpos($attr, '_') != -1) {
            $config[strpos($attr, '_')] = '.';
        }
        foreach (config('product.' . $config) as $item) {
            if ($item['id'] == $id) {
                return $item['name'];
            }
        }

        return '';
    }

    public function thumbImage()
    {
        $defaultImage = asset('imgs/img_placeholder.png');

        if ($this->thumb) {
            return Storage::disk('public')->url('uploads/products/' . $this->thumb);
        }

        if (!$this->images) {
            return $defaultImage;
        }

        $images = json_decode($this->images);
        if (empty($images)) {
            return $defaultImage;
        }

        return Storage::disk('public')->url('uploads/products/' . $images[0]);
    }

    public function getImages()
    {
        $images = json_decode($this->images);
        return is_array($images) ? $images : [];
    }

    public function getImageJsonArray()
    {
        $urls = [];
        $images = json_decode($this->images);
        if (!empty($images)) {
            foreach ($images as $img) {
                $urls[] = [
                    'filename' => $img,
                    'original' => Storage::disk('public')->url('uploads/products/' . $img)
                ];
            }
        }
        return $urls;
    }

    public function getImageURLs()
    {
        $urls = [];
        $images = json_decode($this->images);
        if (!empty($images)) {
            foreach ($images as $img) {
                $urls[] = Storage::disk('public')->url('uploads/products/' . $img);
            }
        }
        return $urls;
    }

    public function getThumbURLs()
    {
        $images = $this->getImages();
        $urls = [];
        foreach ($images as $img) {
            $thumb = IImage::toThumbName($img);
            $urls[] = Storage::disk('public')->url('uploads/products/' . $thumb);
        }
        return $urls;
    }

    public function getThumbUrlAttribute()
    {
        $defaultImage = asset('imgs/img_placeholder.png');

        if (!$this->images) {
            return $defaultImage;
        }

        $images = json_decode($this->images);
        if (empty($images)) {
            return $defaultImage;
        }

        $url = Storage::disk('public')->url('uploads/products/' . $images[0]);

        return $url;
    }

    public function cat($locale = '')
    {
        if ($locale == 'en') {
            $config = config('product_en');
        } else {
            $config = config('product');
        }

        foreach ($config['category'] as $cat) {
            if ($cat['id'] == $this->category_parent) {
                return $cat;
            }
        }

        return [
            'id' => 0,
            'name' => 'category',
            'slug' => 'category-slug',
            'name_en' => 'category',
            'slug_en' => 'category-slug',
        ];
    }

    public function detailLink()
    {
        if ($this->lang == config('user.lang.en')) {
            $cat = $this->cat('en');
        } else {
            $cat = $this->cat('vi');
        }

        return route('product-detail', [
            'catSlug' => $cat['slug'],
            'slug' => str_slug($this->title),
            'id' => $this->id
        ]);
    }

    public function getCategoryParentTextAttribute()
    {
        return $this->cat()['name'];
    }

    public function getCategoryTextAttribute()
    {
        if ($this->subCat) {
            return $this->subCat->name;
        }
        return '';
    }

    public function subCatSlug()
    {
        $subCat = $this->subCat;
        if ($this->lang == config('user.lang.en')) {
            return $subCat->slug_en;
        }

        return $subCat->slug;
    }

    public function getTagsTextAttribute()
    {
        $tags = [];
        foreach ($this->tags()->get() as $tag) {
            $tags[] = $tag->name;
        }
        return $tags;
    }

    public function canRefresh($user = null, $isNeedFee = false, $autoTime = 8)
    {
        if ($this->status != config('product.status.active')) {
            return false;
        }
        $user = $user ?: Auth::user();
        if (!$user) {
            return false;
        }
        $waitingTime = $this->manual_refresh;
        // Free to f5
        if ($isNeedFee) {
            $waitingTime = $autoTime;
            $remainPoint = $this->allow_promotion ? $user->remain_point + $user->promotion_point
                : $user->remain_point;
            if ($remainPoint < $this->refresh_fee) {
                return false;
            }
        }

        $lastRefresh = $this->last_refresh->copy();
        $lastRefresh->addHour($waitingTime);
        if ($lastRefresh->lessThan(Carbon::now())) {
            return true;
        }

        return false;
    }

    public function canAutoRefresh($user = null, $isNeedFee = false, $autoTime = 8)
    {
        if ($this->status != config('product.status.active')) {
            return false;
        }
        $user = $user ?: Auth::user();
        if (!$user) {
            return false;
        }
        $waitingTime = $this->manual_refresh;
        // Free to f5
        if ($isNeedFee) {
            $waitingTime = $autoTime;
            $remainPoint = $user->remain_point;
            if ($remainPoint < $this->refresh_fee) {
                return false;
            }
        }

        $lastRefresh = $this->last_refresh->copy();
        $lastRefresh->addHour($waitingTime);
        if ($lastRefresh->lessThan(Carbon::now())) {
            return true;
        }

        return false;
    }

    public function nextRefreshTime($autoTime = null)
    {
        if ($autoTime) {
            $lastRefresh = $this->last_refresh->copy();
            $lastRefresh->addHour($autoTime);
            return $lastRefresh->format('H:i d/m/Y');
        } else {
            if ($this->manual_refresh) {
                $lastRefresh = $this->last_refresh->copy();
                $lastRefresh->addHour($this->manual_refresh);
                return $lastRefresh->format('H:i d/m/Y');
            }
        }
        return '';
    }

    public function isPro()
    {
        return $this->level == 2;
    }

    public function isFree()
    {
        return $this->level == 1;
    }

    public function hasPosition()
    {
        return $this->lat != 0 && $this->long != 0;
    }

    public function getViewBaseOnCategory()
    {
        switch ($this->category_parent) {
            case 1:
                return 'pano';
            case 2:
                return 'ad';
            case 3:
                return 'social';
            case 4:
                return 'web';
            case 5:
                return 'other';
            case 6:
                return 'find';
            default:
                return '';
        }
    }

    public function toArray()
    {
        $returnArray = parent::toArray(); // TODO: Change the autogenerated stub
        $returnArray['images'] = $this->getImageJsonArray();
        return $returnArray;
    }

    public function hasYoutubeLink()
    {
        return !!$this->youtube_link;
    }
}
