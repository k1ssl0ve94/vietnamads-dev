<?php
namespace App\Repositories;

use App\Bill;
use App\ClassCategory;
use App\Lib\IImage;
use App\Product;
use App\Service;
use App\ServiceOption;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductRepository
{
    protected $billRepository;
    protected $serviceRepository;
    protected $userRepository;

    public $additionData;

    public function __construct(
        BillRepository $billRepository,
        ServiceRepository $serviceRepository,
        UserRepository $userRepository
    ) {
        $this->billRepository = $billRepository;
        $this->serviceRepository = $serviceRepository;
        $this->userRepository = $userRepository;
    }

    public function getById($id)
    {
        return Product::find($id);
    }

    public function all()
    {
        return Product::all();
    }

    public function updateProduct($product, $data)
    {

    }

    public function add($data, $tagIDs = [], $user = null)
    {
        $p = new Product;

        if (isset($data['user_id'])) {
            $p->user_id = $data['user_id'];
        }
        if (isset($data['title'])) {
            $p->title = $data['title'];
        }
        if (isset($data['city'])) {
            $p->city = $data['city'];
        }
        if (isset($data['district'])) {
            $p->district = $data['district'];
        }
        if (isset($data['ward'])) {
            $p->ward = $data['ward'];
        }
        if (isset($data['street'])) {
            $p->street = $data['street'];
        }
        if (isset($data['content'])) {
            $p->content = $data['content'];
        }
        if (isset($data['category'])) {
            $p->category = $data['category'];
        }
        if (isset($data['category_parent'])) {
            $p->category_parent = $data['category_parent'];
        }
        if (isset($data['status'])) {
            $p->status = $data['status'];
        }
        if (isset($data['level'])) {
            $p->level = $data['level'];
        }
        if (isset($data['contact_name'])) {
            $p->contact_name = $data['contact_name'];
        }
        if (isset($data['contact_phone'])) {
            $p->contact_phone = $data['contact_phone'];
        }
        if (isset($data['contact_email'])) {
            $p->contact_email = $data['contact_email'];
        }
        if (isset($data['contact_address'])) {
            $p->contact_address = $data['contact_address'];
        }
        if (isset($data['keywords'])) {
            $p->keywords = $data['keywords'];
        }
        if (isset($data['images'])) {
            $p->images = json_encode($data['images']);
        }
        if (isset($data['from'])) {
            $p->from = new Carbon($data['from']);
        }
        if (isset($data['to'])) {
            $p->to = new Carbon($data['to']);
        }
        if (isset($data['link'])) {
            $p->link = $data['link'];
        }
        if (isset($data['price'])) {
            $p->price = $data['price'];
        }
        if (isset($data['price_unit'])) {
            $p->price_unit = $data['price_unit'];
        }
        if (isset($data['provider'])) {
            $p->provider = $data['provider'];
        }
        if (
            isset($data['youtube_link'])
            && filter_var($data['youtube_link'], FILTER_VALIDATE_URL)
        ) {
            $p->youtube_link = $data['youtube_link'];
        }
        if (isset($data['direct_link'])) {
            $validLink = [];
            foreach ($data['direct_link'] as $link) {
                if (filter_var($link, FILTER_VALIDATE_URL)) {
                    $validLink[] = $link;
                }
            }
            $validLink += ['', '', '', ''];
            $validLink = array_slice($validLink, 0, 4);
            $p->direct_link = implode(',', $validLink);
        } else {
            $p->direct_link = implode(',', ['', '', '', '']);
        }

        // pano
        if (isset($data['pano_type'])) {
            $p->pano_type = $data['pano_type'];
        }
        if (isset($data['pano_size'])) {
            $p->pano_size = $data['pano_size'];
        }
        if (isset($data['pano_border'])) {
            $p->pano_border = $data['pano_border'];
        }
        if (isset($data['pano_light'])) {
            $p->pano_light = $data['pano_light'];
        }

        // ad
        if (isset($data['ad_channel'])) {
            $p->ad_channel = $data['ad_channel'];
        }
        if (isset($data['ad_coverage'])) {
            $p->ad_coverage = $data['ad_coverage'];
        }
        if (isset($data['ad_time'])) {
            $p->ad_time = $data['ad_time'];
        }

        // social
        if (isset($data['social_type'])) {
            $p->social_type = $data['social_type'];
        }
        if (isset($data['social_follow'])) {
            $p->social_follow = $data['social_follow'];
        }

        // web
        if (isset($data['web_type'])) {
            $p->web_type = $data['web_type'];
        }
        if (isset($data['web_position'])) {
            $p->web_position = $data['web_position'];
        }

        if (isset($data['note'])) {
            $p->note = $data['note'];
        }

        if (isset($data['thumb'])) {
            $p->thumb = $data['thumb'];
        }

        if (isset($data['lat'])) {
            $p->lat = $data['lat'];
        }

        if (isset($data['long'])) {
            $p->long = $data['long'];
        }

        if (isset($data['lang'])) {
            $p->lang = intval($data['lang']);
        } else {
            $p->lang = config('user.lang.vi');
        }

        $p->last_refresh = Carbon::now();
        $additionalData = false;
        if (isset($data['level']) && isset($data['package_option'])) {
            // Selected package and option
            list($additionalData, $msg, $point, $promotionPoint) = $this->serviceRepository->prepareDataForProductAndBill(
                $data['level'],
                $data['package_option'],
                $user
            );
            $this->additionData = [
                $point, $promotionPoint,
            ];
            if (!$additionalData) {
                return null; // Invalid service package data
            }
            $p->level = $data['level'];
            $p->package_option = $data['package_option'];
            $p->fill($additionalData);
        }

        if ($p->save()) {
            if (!empty($tagIDs)) {
                $p->tags()->sync($tagIDs);
            }
            if ($p->status == config('product.status.active')) {
                // Create bill
                $billData = [
                    'user_id' => $user ? $user->id : null,
                    'product_id' => $p->id,
                    'type' => Bill::TYPE_SUB,
                    'mode' => Bill::MODE_ACTIVE,
                    'service_id' => $additionalData['level'],
                    'date' => Carbon::now()->format('Y-m-d'),
                    'created_by' => $user ? $user->id : null,
                    'status' => Bill::STATUS_DONE,
                ] + $additionalData;
                $this->billRepository->addBill($billData, $user);
            }

            return $p;
        }

        return null;
    }


    /**
     * @param $p Product
     * @param $data
     * @param array $tagIDs
     * @return mixed
     */
    public function update($p, $data, $tagIDs = [])
    {
        if (isset($data['user_id'])) {
            $p->user_id = $data['user_id'];
        }
        if (isset($data['title'])) {
            $p->title = $data['title'];
        }
        if (isset($data['city'])) {
            $p->city = $data['city'];
        }
        if (isset($data['district'])) {
            $p->district = $data['district'];
        }
        if (isset($data['ward'])) {
            $p->ward = $data['ward'];
        }
        if (isset($data['street'])) {
            $p->street = $data['street'];
        }
        if (isset($data['content'])) {
            $p->content = $data['content'];
        }
        if (isset($data['category'])) {
            $p->category = $data['category'];
        }
        if (isset($data['category_parent'])) {
            $p->category_parent = $data['category_parent'];
        }
        if (isset($data['status'])) {
            $p->status = $data['status'];
        }
        if (isset($data['level'])) {
            $p->level = $data['level'];
        }
        if (isset($data['contact_name'])) {
            $p->contact_name = $data['contact_name'];
        }
        if (isset($data['contact_phone'])) {
            $p->contact_phone = $data['contact_phone'];
        }
        if (isset($data['contact_email'])) {
            $p->contact_email = $data['contact_email'];
        }
        if (isset($data['contact_address'])) {
            $p->contact_address = $data['contact_address'];
        }
        if (isset($data['keywords'])) {
            $p->keywords = $data['keywords'];
        }
        if (isset($data['images']) && count($data['images'])) {
            $images = json_decode($p->images);
            $data['images'] += $images;
            $p->images = json_encode($data['images']);
        }
        if (isset($data['from'])) {
            $p->from = new Carbon($data['from']);
        }
        if (isset($data['to'])) {
            $p->to = new Carbon($data['to']);
        }
        if (isset($data['link'])) {
            $p->link = $data['link'];
        }
        if (isset($data['price'])) {
            $p->price = $data['price'];
        }
        if (isset($data['price_unit'])) {
            $p->price_unit = $data['price_unit'];
        }
        if (isset($data['provider'])) {
            $p->provider = $data['provider'];
        }

        if (
            isset($data['youtube_link'])
            && filter_var($data['youtube_link'], FILTER_VALIDATE_URL)
        ) {
            $p->youtube_link = $data['youtube_link'];
        }
        if (isset($data['direct_link'])) {
            $validLink = [];
            if (is_array($data['direct_link'])) {
                foreach ($data['direct_link'] as $link) {
                    if (filter_var($link, FILTER_VALIDATE_URL)) {
                        $validLink[] = $link;
                    }
                }
            }

            $validLink += ['', '', '', ''];
            $validLink = array_slice($validLink, 0, 4);
            $p->direct_link = implode(',', $validLink);
        } else {
            $p->direct_link = implode(',', ['', '', '', '']);
        }

        if (isset($data['auto_refresh'])) {
            $p->auto_refresh = $data['auto_refresh'];
        }

        // pano
        if (isset($data['pano_type'])) {
            $p->pano_type = $data['pano_type'];
        }
        if (isset($data['pano_size'])) {
            $p->pano_size = $data['pano_size'];
        }
        if (isset($data['pano_border'])) {
            $p->pano_border = $data['pano_border'];
        }
        if (isset($data['pano_light'])) {
            $p->pano_light = $data['pano_light'];
        }

        // ad
        if (isset($data['ad_channel'])) {
            $p->ad_channel = $data['ad_channel'];
        }
        if (isset($data['ad_coverage'])) {
            $p->ad_coverage = $data['ad_coverage'];
        }
        if (isset($data['ad_time'])) {
            $p->ad_time = $data['ad_time'];
        }

        // social
        if (isset($data['social_type'])) {
            $p->social_type = $data['social_type'];
        }
        if (isset($data['social_follow'])) {
            $p->social_follow = $data['social_follow'];
        }

        // web
        if (isset($data['web_type'])) {
            $p->web_type = $data['web_type'];
        }
        if (isset($data['web_position'])) {
            $p->web_position = $data['web_position'];
        }

        if (isset($data['note'])) {
            $p->note = $data['note'];
        }

        if (isset($data['thumb'])) {
            $p->thumb = $data['thumb'];
        }

        if (isset($data['lat'])) {
            $p->lat = $data['lat'];
        }

        if (isset($data['long'])) {
            $p->long = $data['long'];
        }
        $p->edit_times -= 1;

        if (isset($data['lang'])) {
            $p->lang = intval($data['lang']);
        }

        $p->tags()->sync($tagIDs);

        return $p->save();
    }

    public function paginate($params, $take = 5, $page = null)
    {
        $query = Product::query();
        if (isset($params['lang']) && $params['lang'] !== '') {
            $query->where('products.lang', $params['lang']);
        }

        if (isset($params['user_id'])) {
            $query->where('products.user_id', $params['user_id']);
        }

        if (isset($params['category'])) {
            $query->where('products.category', $params['category']);
        }

        if (isset($params['category_parent'])) {
            $query->where('products.category_parent', $params['category_parent']);
        }
        if (isset($params['status'])) {
            if (is_array($params['status'])) {
                $query->whereIn('products.status', $params['status']);
            } else {
                $query->where('products.status', $params['status']);
            }
        }
        if (!empty($params['level'])) {
            $query->where('products.level', $params['level']);
        }
        if (!empty($params['city'])) {
            $query->where('products.city', $params['city']);
        }
        if (!empty($params['district'])) {
            $query->where('products.district', $params['district']);
        }
        if (!empty($params['ward'])) {
            $query->where('products.ward', $params['ward']);
        }
        if (!empty($params['street'])) {
            $query->where('products.street', $params['street']);
        }
        if (!empty($params['keyword'])) {
            $query->where(function ($query) use ($params) {
                $query->where('products.title', 'like', '%' . $params['keyword'] . '%')
                    ->orWhere('products.content', 'like', '%' . $params['keyword'] . '%');

                if (is_numeric($params['keyword'])) {
                    $query->orWhere('products.id', $params['keyword'])->orWhere('products.user_id', $params['keyword']);
                }
            });
        }

        // price_range
        if (!empty($params['price_range'])) {
            $configs = config('product.price_range');
            switch ($params['price_range']) {
                case $configs[0]['id']:
                    $query->where('price', '>', 0)->where('price', '<=', 3000000);
                    break;
                case $configs[1]['id']:
                    $query->where('price', '>=', 3000000)->where('price', '<=', 5000000);
                    break;
                case $configs[2]['id']:
                    $query->where('price', '>=', 5000000)->where('price', '<=', 10000000);
                    break;
                case $configs[3]['id']:
                    $query->where('price', '>=', 10000000);
                    break;
                case $configs[4]['id']:
                    $query->where('price', '>=', 50000000);
                    break;
                case $configs[5]['id']:
                    $query->where('price', '>=', 100000000);
                    break;
                case $configs[6]['id']:
                    $query->where('price', '>=', 500000000);
                    break;
                case $configs[7]['id']:
                    $query->where('price', 0);
                    break;
                default:
                    break;
            }
        }

        if (isset($params['order'])) {
            switch ($params['order']) {
                case 'newest':
//                    $query->orderBy('id', 'desc');
                    $query->orderBy('products.status', 'ASC')
                    ->orderBy('products.priority', 'desc')
                    ->orderBy('products.last_refresh', 'desc')
                    ->orderBy('products.id', 'desc');
                    break;
                case 'no_price':
                    $query->where('products.price', 0)->where(function ($q) {
                        $q->whereNull('products.price_unit')->orWhere('price_unit', '');
                    });
                    $query->orderBy('products.status', 'ASC')
                        ->orderBy('products.priority', 'desc')
                        ->orderBy('products.last_refresh', 'desc')
                        ->orderBy('products.id', 'desc');
                    break;
                case 'lowest_price':
                    $query->where('products.price', '>', 0);
//                        ->orderBy('price', 'asc')
//                        ->orderBy('id', 'desc');
                    $query->orderBy('products.status', 'ASC')
                        ->orderBy('products.price', 'asc')
                        ->orderBy('products.priority', 'desc')
                        ->orderBy('products.last_refresh', 'desc')
                        ->orderBy('products.id', 'desc');
                    break;
                case 'highest_price':
                    $query->where('products.price', '>', 0);
//                        ->orderBy('price', 'desc')
//                        ->orderBy('id', 'desc');
                    $query->orderBy('products.status', 'ASC')
                        ->orderBy('products.price', 'desc')
                        ->orderBy('products.priority', 'desc')
                        ->orderBy('products.last_refresh', 'desc')
                        ->orderBy('products.id', 'desc');
                    break;
                case 'default':
                default:
                    $query->orderBy('products.status', 'ASC')
                        ->orderBy('products.priority', 'desc')
                        ->orderBy('products.last_refresh', 'desc')
                        ->orderBy('products.id', 'desc');
            }
        } else {
            $query->orderBy('products.status', 'ASC')
                ->orderBy('products.priority', 'desc')
                ->orderBy('products.last_refresh', 'desc')
                ->orderBy('products.id', 'desc');
        }

        // $query->where('to', '<=', Carbon::now()->endOfDay());

        // pano
        if (!empty($params['pano_type'])) {
            $query->where('products.pano_type', $params['pano_type']);
        }
        if (!empty($params['pano_size'])) {
            $query->where('products.pano_size', $params['pano_size']);
        }
        if (!empty($params['pano_border'])) {
            $query->where('products.pano_border', $params['pano_border']);
        }
        if (!empty($params['pano_light'])) {
            $query->where('products.pano_light', $params['pano_light']);
        }

        // ad
        if (!empty($params['ad_channel'])) {
            $query->where('products.ad_channel', $params['ad_channel']);
        }
        if (!empty($params['ad_coverage'])) {
            $query->where('products.ad_coverage', $params['ad_coverage']);
        }
        if (!empty($params['ad_time'])) {
            $query->where('products.ad_time', $params['ad_time']);
        }

        // social
        if (!empty($params['social_type'])) {
            $query->where('products.social_type', $params['social_type']);
        }
        if (!empty($params['social_follow'])) {
            $query->where('products.social_follow', $params['social_follow']);
        }

        // web
        if (!empty($params['web_type'])) {
            $query->where('products.web_type', $params['web_type']);
        }
        if (!empty($params['web_position'])) {
            $query->where('products.web_position', $params['web_position']);
        }

        if (!empty($params['withs'])) {
            foreach ($params['withs'] as $w) {
                $query->with($w);
            }
        }

        if (isset($params['tag_id'])) {
            $query->whereHas('tags', function ($query) use ($params) {
                $query->where('id', $params['tag_id']);
            });
        }

        if (isset($params['has_image']) && $params['has_image']) {
            $query->whereRaw('LENGTH(images) > 5');
        }

        if (isset($params['has_video']) && $params['has_video']) {
            $query->where('products.youtube_link', '<>', '');
        }

        if(!empty($params['user_level']) || !empty($params['user_type'])) {
            $query->join('users', 'users.id', '=', 'products.user_id');
            if (!empty($params['user_level'])) {
                $query->where('users.level', $params['user_level']);
            }
            if (!empty($params['user_type'])) {
                $query->where('users.type', $params['user_type']);
            }
        }

        if(!empty($params['class_category_id'])) {
            $query->join('class_categories_products',
                'class_categories_products.product_id', '=', 'products.id');
            $query->where('class_categories_products.class_category_id', $params['class_category_id']);
        }

        if (isset($params['has_position']) && $params['has_position']) {
            $query->where('lat', '<>', 0)->where('lat', '<>', 0);
            $items = $query->get(['products.*']);
        } else {
            if (!empty($page)) {
                $items = $query->paginate($take, ['products.*'], 'page', $page);
            } else {
                $items = $query->paginate($take, ['products.*']);
            }

        }


        $serviceIds = [];
        $optionIds = [];
        $userIds = [];
        foreach ($items as $item) {
            $serviceIds[$item->level] = $item->level;
            $optionIds[$item->package_option] = $item->package_option;
            $userIds[$item->user_id] = $item->user_id;
        }
        $serviceArray = [];
        $optionArray = [];
        $userArray = [];
        if ($userIds) {
            $userList = User::query()->whereIn('id', $userIds)->get();
            if ($userList) {
                foreach ($userList as $u) {
                    $userArray[$u->id] = $u;
                }
            }
        }
        if ($serviceIds) {
            $services = Service::query()->whereIn('id', $serviceIds)->get();
            if ($services) {
                foreach ($services as $service) {
                    $serviceArray[$service->id] = $service;
                }
            }
        }
        if ($optionIds) {
            $options = ServiceOption::query()->whereIn('id', $optionIds)->get();
            if ($options) {
                foreach ($options as $option) {
                    $optionArray[$option->id] = $option;
                }
            }
        }
        foreach ($items as $item) {
            if (isset($serviceArray[$item->level])) {
                $item->service = $serviceArray[$item->level];
            }
            if (isset($optionArray[$item->package_option])) {
                $item->package_option = $optionArray[$item->package_option];
            }
            if (isset($userArray[$item->user_id])) {
                $item->user = $userArray[$item->user_id];
            }
        }
        return $items;
    }

    public function getMapProducts($params)
    {
        $query = Product::query();

        if (isset($params['lang']) && $params['lang'] !== '') {
            $query->where('products.lang', $params['lang']);
        }

        if (isset($params['user_id'])) {
            $query->where('user_id', $params['user_id']);
        }

        if (isset($params['category'])) {
            $query->where('category', $params['category']);
        }

        if (isset($params['category_parent'])) {
            $query->where('category_parent', $params['category_parent']);
        }
        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }
        if (!empty($params['level'])) {
            $query->where('level', $params['level']);
        }
        if (!empty($params['city'])) {
            $query->where('city', $params['city']);
        }
        if (!empty($params['district'])) {
            $query->where('district', $params['district']);
        }
        if (!empty($params['ward'])) {
            $query->where('ward', $params['ward']);
        }
        if (!empty($params['street'])) {
            $query->where('street', $params['street']);
        }
        if (!empty($params['keyword'])) {
            $query->where(function ($query) use ($params) {
                $query->where('title', 'like', '%' . $params['keyword'] . '%')
                    ->orWhere('content', 'like', '%' . $params['keyword'] . '%');

                if (is_numeric($params['keyword'])) {
                    $query->orWhere('id', $params['keyword'])->orWhere('user_id', $params['keyword']);
                }
            });
        }

        if (isset($params['order'])) {
            switch ($params['order']) {
                case 'newest':
                    $query->orderBy('id', 'desc');
                    break;
                case 'no_price':
                    $query->where('price', 0)->where(function ($q) {
                        $q->whereNull('price_unit')->orWhere('price_unit', '');
                    })->orderBy('id', 'desc');
                    break;
                case 'lowest_price':
                    $query->where('price', '>', 0)->orderBy('price', 'asc')->orderBy('id', 'desc');
                    break;
                case 'highest_price':
                    $query->where('price', '>', 0)->orderBy('price', 'desc')->orderBy('id', 'desc');
                    break;
                case 'default':
                    $query->orderBy('level', 'desc')->orderBy('last_refresh', 'desc')->orderBy('id', 'desc');
                    break;
                default:
                    $query->orderBy('id', 'desc');
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        // $query->where('to', '<=', Carbon::now()->endOfDay());

        // pano
        if (!empty($params['pano_type'])) {
            $query->where('pano_type', $params['pano_type']);
        }
        if (!empty($params['pano_size'])) {
            $query->where('pano_size', $params['pano_size']);
        }
        if (!empty($params['pano_border'])) {
            $query->where('pano_border', $params['pano_border']);
        }
        if (!empty($params['pano_light'])) {
            $query->where('pano_light', $params['pano_light']);
        }

        // ad
        if (!empty($params['ad_channel'])) {
            $query->where('ad_channel', $params['ad_channel']);
        }
        if (!empty($params['ad_coverage'])) {
            $query->where('ad_coverage', $params['ad_coverage']);
        }
        if (!empty($params['ad_time'])) {
            $query->where('ad_time', $params['ad_time']);
        }

        // social
        if (!empty($params['social_type'])) {
            $query->where('social_type', $params['social_type']);
        }
        if (!empty($params['social_follow'])) {
            $query->where('social_follow', $params['social_follow']);
        }

        // web
        if (!empty($params['web_type'])) {
            $query->where('web_type', $params['web_type']);
        }
        if (!empty($params['web_position'])) {
            $query->where('web_position', $params['web_position']);
        }

        if (!empty($params['withs'])) {
            foreach ($params['withs'] as $w) {
                $query->with($w);
            }
        }
        if (isset($params['has_image']) && $params['has_image']) {
            $query->whereRaw('LENGTH(images) > 5');
        }
        if (isset($params['has_video']) && $params['has_video']) {
            $query->where('youtube_link', '<>', '');
        }

        $query->where('lat', '<>', 0)->where('lat', '<>', 0);

        // if (isset($params['north_east'])) {
        //     $ne = json_decode($params['north_east'], true);
        //     if (isset($ne['lat']) && isset($ne['lng'])) {
        //         $query->where('lat', '<', floatval($ne['lat']))
        //             ->where('long', '<', floatval($ne['lng']));
        //     }
        // }

        // if (isset($params['south_west'])) {
        //     $sw = json_decode($params['south_west'], true);
        //     if (isset($sw['lat']) && isset($sw['lng'])) {
        //         $query->where('lat', '>', floatval($sw['lat']))
        //             ->where('long', '>', floatval($sw['lng']));
        //     }
        // }

        return $query->get();
    }

    /**
     * @param $product Product
     * @param null $user User
     * @param bool $isFee
     * @return bool
     */
    public function refresh($product, $user = null, $isFee = false)
    {
        $user = $user ?: Auth::user();
        if (!$user) {
            return false;
        }
        if ($user->id != $product->user_id) {
            return false;
        }

        if ($isFee && $product->auto_refresh <= 0) {
            return false;
        }
        $product->refresh_type = $isFee ? Product::REFRESH_TYPE_AUTO : Product::REFRESH_TYPE_MANUALLY;
        $autoFee = 5000;
        if ($isFee) {
            $product->auto_refresh -= 1;
        }
        $product->last_refresh = Carbon::now();
        $product->save();

        if ($isFee) {
            // Add bill
            $billData = [
                'type' => Bill::TYPE_SUB,
                'mode' => Bill::MODE_REFRESH,
                'point' => $autoFee, // $product->refresh_fee,
                'date' => date('Y-m-d'),
                'user_id' => $product->user_id,
                'created_by' => Auth::user() ? Auth::user()->id : null,
                'product_id' => $product->id,
                'service_id' => $product->level,
                'option_id' => $product->package_option,
                'status' => Bill::STATUS_DONE,
                'from' => Carbon::now(),
                'to' => Carbon::now(),
            ];
            $this->billRepository->addBill($billData, Auth::user());
            // Update user point
            $this->userRepository->decreasePoint($user, $autoFee, false);
        }
        return true;
    }


    public function getByParams($params, $take = 5)
    {
        $query = Product::query();

        if (isset($params['lang']) && $params['lang'] !== '') {
            $query->where('products.lang', $params['lang']);
        }

        if (isset($params['category'])) {
            $query->where('category', $params['category']);
        }
        if (!empty($params['excludedIds'])) {
            $query->whereNotIn('id', $params['excludedIds']);
        }

        if (isset($params['category_parent'])) {
            $query->where('category_parent', $params['category_parent']);
        }

        if (isset($params['user_id'])) {
            $query->where('user_id', $params['user_id']);
        }

        if (!empty($params['city'])) {
            $query->where('city', $params['city']);
        }
        if (!empty($params['district'])) {
            $query->where('district', $params['district']);
        }

        if (isset($params['status'])) {
            if (is_array($params['status'])) {
                $query->whereIn('status', $params['status']);
            } else {
                $query->where('status', $params['status']);
            }
        }

        if (isset($params['city'])) {
            $query->where('city', $params['city']);
        }

        // $query->where('to', '>=', Carbon::now()->endOfDay());

        $list = $query
            ->orderBy('status', 'ASC')
            ->orderBy('priority', 'desc')
            ->orderBy('last_refresh', 'desc')
            ->orderBy('id', 'desc')
            ->take($take)->get();

        $userIds = [];
        foreach ($list as $item) {
            $userIds[$item->user_id] = $item->user_id;
        }
        if (count($userIds)) {
            $userArray = User::query()->whereIn('id', $userIds)->pluck('verified_by_admin', 'id')->toArray();
        }
        foreach ($list as $item) {
            if ($item->user_id && isset($userArray[$item->user_id])) {
                $item->verified_by_admin = $userArray[$item->user_id];
            }
        }
        return $list;
    }

    public function getByCat($cat, $take = 5)
    {
        return Product::where('category', $cat)
            ->orderBy('id', 'desc')
            ->take($take)->get();
    }

    public function delete($product)
    {
        return $product->delete();
    }

    public function count()
    {
        return Product::count();
    }

    public function countByRange($from = null, $to = null)
    {
        $query = Product::query();
        if ($from) {
            $query->where('created_at', '>=', $from);
        }

        if ($to) {
            $query->where('created_at', '<=', $to);
        }

        return $query->count();
    }

    public function getCountActiveProductByCategoryParent()
    {
        return Product::select(['category_parent'])->selectRaw('count(*) as count')
            ->where('status', config('product.status.active'))
            ->where('to', '<', Carbon::now()->startOfDay())
            ->groupBy('category_parent')
            ->orderBy('count', 'desc')->get();
    }

    public function getCountActiveProductByCity($catID = null, $subCatID = null)
    {
        $query = Product::select(['city'])->selectRaw('count(*) as count')
            ->where('status', config('product.status.active'))
            ->where('to', '>', Carbon::now()->startOfDay());

        if ($catID) {
            $query->where('category_parent', $catID);
        }

        if ($subCatID) {
            $query->where('category', $subCatID);
        }

        return $query->groupBy('city')->orderBy('count', 'desc')->get();
    }

    public function getRefreshableList($page = 1, $refreshTime = 8)
    {
        $query = Product::query();
        $query->where('status', config('product.status.active'));
        $query->where('auto_refresh', '>', 0);
        //        $query->where(function($builder) {
        //            $builder->whereNull('refresh_type')
        //                ->orWhere('refresh_type', Product::REFRESH_TYPE_AUTO);
        //        });
        $query->whereRaw(DB::raw('DATE_ADD(last_refresh, INTERVAL ' . $refreshTime . ' HOUR) <= CURRENT_TIME'));

        $items = $query->paginate(50, ['*'], 'page', $page);
        return $items;
    }

    public function getCountBySubCatAndDistrict($subCatID, $districtID)
    {
        return Product::where('status', config('product.status.active'))
            ->where('to', '>', Carbon::now()->startOfDay())
            ->where('category', $subCatID)
            ->where('district', $districtID)->count();
    }

    public function getCountBySubCatAndCity($subCatID, $cityID)
    {
        return Product::where('status', config('product.status.active'))
            ->where('to', '>', Carbon::now()->startOfDay())
            ->where('category', $subCatID)
            ->where('city', $cityID)->count();
    }

    public function getDisabledProperty()
    {
        return [
            'level' => 99,
            'edit_times' => 0,
            'title_color' => 'black',
            'parameter_color' => 'black',
            'price_color' => 'black',
            'auto_refresh' => 0,
            'manual_refresh' => 0,
            'auto_active' => 0,
            'status' => config('product.status.disabled'),
            'icon' => null,
        ];
    }

    public function disableExpiredProducts($toDate = null)
    {
        $toDate = $toDate ?: Carbon::today();
        return Product::query()->whereDate('to', '<', $toDate)
            ->update([
                'updated_at' => Carbon::now(),
            ] + $this->getDisabledProperty());
    }

    public function getSuggestionProduct($options, $limit = 15)
    {
        $builder = Product::query()
            ->whereIn('status', [
                config('product.status.active'),
                config('product.status.disabled'),
            ]);
        if (!empty($options['category_parent'])) {
            $builder->where('category_parent', $options['category_parent']);
        }
        if (!empty($options['category'])) {
            $builder->where('category', $options['category']);
        }
        if (!empty($options['keyword'])) {
            $builder->where(function($query) use ($options) {
                $key = "%{$options['keyword']}%";
                $query->where('title', 'like', $key)
                    ->orWhere('keywords', 'like', $key)
                    ->orWhere('contact_name', 'like', $key)
                    ->orWhere('contact_phone', 'like', $key)
                    ->orWhere('contact_email', 'like', $key)
                    ->orWhere('contact_address', 'like', $key);
                if (is_numeric($options['keyword'])) {
                    $query->orWhere('id', $options['keyword']);
                }
            });
        }
        $items = $builder->orderBy('status', 'ASC')
            ->orderBy('priority', 'desc')
            ->orderBy('last_refresh', 'desc')
            ->orderBy('id', 'desc')
            ->take($limit)->get();
        return $items;
    }
}
