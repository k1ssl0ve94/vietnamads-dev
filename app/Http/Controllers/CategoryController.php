<?php

namespace App\Http\Controllers;

use App\ClassCategory;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use App\Repositories\TagRepository;
use App\Lib\Location;
use Cookie;

class CategoryController extends Controller
{
    protected $productRepo;
    protected $catRepo;
    protected $tagRepo;

    public function __construct(ProductRepository $productRepo, CategoryRepository $catRepo, UserRepository $userRepo, TagRepository $tagRepo)
    {
        $this->productRepo = $productRepo;
        $this->catRepo = $catRepo;
        $this->userRepo = $userRepo;
        $this->tagRepo = $tagRepo;
    }

    public function index()
    {
//        if (\request()->input('sub_cat')) {
//            $subCatId = \request()->input('sub_cate');
//            $subCat = $this->catRepo->getClassCategoryById($subCatId);
//        }
        return $this->renderCategory(null);
    }

    public function category($catSlug)
    {
        $cat = $this->catRepo->getParentCategoryBySlug(\App::getLocale(), $catSlug);
        if (!$cat) {
            return redirect()->route('home');
        }

        $cat['classCategoryArray'] = $this->catRepo
            ->getClassCategoryOf(ClassCategory::TYPE_SPONSOR, $cat['id']);
        $subCat = null;
        if (\request()->input('sub_cat')) {
            $subCat = $this->catRepo->getBySlug(\request()->input('sub_cat'));
        }
        return $this->renderCategory($cat, $subCat);
    }

    public function subCategory($catSlug, $slug)        
    {

        $cat = $this->catRepo->getParentCategoryBySlug(\App::getLocale(), $catSlug);
        if (!$cat) {
            return redirect()->route('home');
        }
        $subCat = '';
        $subCat = $this->catRepo->getBySlug($slug);
        
        $subCity = '';
        $subCity = Location::getCitySlug($slug);

        $cat['classCategoryArray'] = $this->catRepo
            ->getClassCategoryOf(ClassCategory::TYPE_SPONSOR, $cat['id']);
//        $subCat->classCategoryArray = $this->catRepo
//            ->getClassCategoryOf(ClassCategory::TYPE_ADVISER, $cat['id'], $subCat->id);
//            

        if($subCity)
            return $this->renderCategory($cat, $subCat,$subCity);
        else{
            return $this->renderCategory($cat, $subCat);
        }
    }

    public function subCategoryCity($catSlug, $slug, $city)
    {
        $cat = $this->catRepo->getParentCategoryBySlug(\App::getLocale(), $catSlug);
        if (!$cat) {
            return redirect()->route('home');
        }
        $subCat = '';
        $subCat = $this->catRepo->getBySlug($slug);
        if (!$subCat) {
            return redirect()->route('home');
        }
        $subCity = '';
        $subCity = Location::getCitySlug($city);
         if (!$subCity) {
            return redirect()->route('home');
        }
               
        $cat['classCategoryArray'] = $this->catRepo
            ->getClassCategoryOf(ClassCategory::TYPE_SPONSOR, $cat['id']);
//        $subCat->classCategoryArray = $this->catRepo
//            ->getClassCategoryOf(ClassCategory::TYPE_ADVISER, $cat['id'], $subCat->id);
        return $this->renderCategory($cat, $subCat, $subCity);
    }

    public function subCategoryDistrict($catSlug, $slug, $city, $district)
    {
        $cat = $this->catRepo->getParentCategoryBySlug(\App::getLocale(), $catSlug);
        if (!$cat) {
            return redirect()->route('home');
        }

        $subCat = '';
        $subCat = $this->catRepo->getBySlug($slug);
        if (!$subCat) {
            //return redirect()->route('home');
        }
        $subCity = '';
        $subCity = Location::getCitySlug($city);
         if (!$subCity) {
           // return redirect()->route('home');
        }
        $subDistrict = '';
        $subDistrict = Location::getDistrictSlug($district);
         if (!$subDistrict) {
            //return redirect()->route('home');
        }        
        $cat['classCategoryArray'] = $this->catRepo
            ->getClassCategoryOf(ClassCategory::TYPE_SPONSOR, $cat['id']);
//        $subCat->classCategoryArray = $this->catRepo
//            ->getClassCategoryOf(ClassCategory::TYPE_ADVISER, $cat['id'], $subCat->id);
        return $this->renderCategory($cat, $subCat, $subCity,$subDistrict);
    }


    public function map($catSlug)
    {
        $cat = $this->catRepo->getParentCategoryBySlug(\App::getLocale(), $catSlug);
        if (!$cat) {
            return redirect()->route('home');
        }

        return $this->renderMap($cat, null);
    }

    public function subMap($catSlug, $slug)
    {
        $cat = $this->catRepo->getParentCategoryBySlug(\App::getLocale(), $catSlug);
        if (!$cat) {
            return redirect()->route('home');
        }

        $subCat = $this->catRepo->getBySlug($slug);
        if (!$subCat) {
            return redirect()->route('home');
        }

        return $this->renderMap($cat, $subCat);
    }

    protected function renderMap($cat = null, $subCat = null)
    {
        $params = [
            'keyword' => request()->input('s', ''),
            'order' => request()->input('order', ''),
            'city' => request()->input('city', ''),
            'district' => request()->input('district', ''),
            'ward' => request()->input('ward', ''),
            'street' => request()->input('street', ''),
            'provider' => request()->input('provider', ''),
            'price_range' => request()->input('price_range', ''),
            'pano_type' => request()->input('pano_type', ''),
            'pano_size' => request()->input('pano_size', ''),
            'pano_border' => request()->input('pano_border', ''),
            'pano_light' => request()->input('pano_light', ''),
            'ad_channel' => request()->input('ad_channel', ''),
            'ad_coverage' => request()->input('ad_coverage', ''),
            'ad_time' => request()->input('ad_time', ''),
            'social_type' => request()->input('social_type', ''),
            'social_follow' => request()->input('social_follow', ''),
            'web_type' => request()->input('web_type', ''),
            'web_position' => request()->input('web_position', ''),
            'sub_cat' => request()->input('sub_cat', ''),
            'has_image' => request()->input('has_image', ''),
            'has_video' => request()->input('has_video', ''),
        ];

        if ($cat) {
            $params['cat_id'] = $cat['id'];
        }

        if ($subCat) {
            $params['sub_cat_id'] = $subCat->id;
        }

        $data = [
            'params' => $params,
            'cat' => $cat,
            'subCat' => $subCat,
            'city' => null,
            'order' => $params['order'],
            'has_image' => $params['has_image'],
            'has_video' => $params['has_video'],
        ];

        $data['viewListUrl'] = url(substr(request()->getRequestUri(), strlen('/ban-do')));

        return view('pages.category_map', $data);
    }

    public function mapAjax()
    {
        $params = [
            'keyword' => request()->input('s', ''),
            'order' => request()->input('order', ''),
            'city' => request()->input('city', ''),
            'district' => request()->input('district', ''),
            'ward' => request()->input('ward', ''),
            'street' => request()->input('street', ''),
            'provider' => request()->input('provider', ''),
            'price_range' => request()->input('price_range', ''),
            'pano_type' => request()->input('pano_type', ''),
            'pano_size' => request()->input('pano_size', ''),
            'pano_border' => request()->input('pano_border', ''),
            'pano_light' => request()->input('pano_light', ''),
            'ad_channel' => request()->input('ad_channel', ''),
            'ad_coverage' => request()->input('ad_coverage', ''),
            'ad_time' => request()->input('ad_time', ''),
            'social_type' => request()->input('social_type', ''),
            'social_follow' => request()->input('social_follow', ''),
            'web_type' => request()->input('web_type', ''),
            'web_position' => request()->input('web_position', ''),
            'sub_cat' => request()->input('sub_cat', ''),
            'has_image' => request()->input('has_image', ''),
            'has_video' => request()->input('has_video', ''),
            'cat_id' => request()->input('cat_id', ''),
            'sub_cat_id' => request()->input('sub_cat_id', ''),
            'north_east' => request()->input('north_east'),
            'south_west' => request()->input('south_west'),
        ];
        $params['status'] = config('product.status.active');

        if (!isset($params['cat_id']) || !$params['cat_id']) {
            return ['msg' => 'invalid'];
        }
        $cat = $this->catRepo->getParentCategoryByID($params['cat_id']);

        if (!$cat) {
            return ['msg' => 'invalid'];
        }
        $params['category_parent'] = $cat['id'];
        if (isset($params['sub_cat_id']) && $params['sub_cat_id']) {
            $subCat = $this->catRepo->getById($params['sub_cat_id']);
            if ($subCat) {
                $params['category'] = $subCat->id;
            }
        }
        $params['lang'] = $this->getLang();
        $productData = $this->productRepo->getMapProducts($params);

        $products = [];
        foreach ($productData as $p) {
            $link = $p->detailLink();
            $products[] = [
                'id' => $p->id,
                'title' => $p->title,
                'title_limit' => str_limit($p->title, 80),
                'thumb_url' => $p->thumbImage(),
                'link' => $link,
                'to_date_text' => $p->to_date_text,
                'price_text' => $p->priceText(),
                'location_text' => $p->locationText(),
                'position' => ['lat' => floatval($p->lat), 'lng' => floatval($p->long)],
            ];
        }

        return response()->json([
            'products' => $products,
        ]);
    }

    protected function renderCategory($cat = null, $subCat = null, $city =null, $district = null)
    {
        $data = [
            'keyword' => request()->input('s', ''),
            'order' => request()->input('order', ''),
            'city' => request()->input('city', ''),
            'district' => request()->input('district', ''),
            'ward' => request()->input('ward', ''),
            'street' => request()->input('street', ''),
            'provider' => request()->input('provider', ''),
            'price_range' => request()->input('price_range', ''),
            'pano_type' => request()->input('pano_type', ''),
            'pano_size' => request()->input('pano_size', ''),
            'pano_border' => request()->input('pano_border', ''),
            'pano_light' => request()->input('pano_light', ''),
            'ad_channel' => request()->input('ad_channel', ''),
            'ad_coverage' => request()->input('ad_coverage', ''),
            'ad_time' => request()->input('ad_time', ''),
            'social_type' => request()->input('social_type', ''),
            'social_follow' => request()->input('social_follow', ''),
            'web_type' => request()->input('web_type', ''),
            'web_position' => request()->input('web_position', ''),
            'sub_cat' => request()->input('sub_cat', ''),
            'has_image' => request()->input('has_image', ''),
            'has_video' => request()->input('has_video', ''),
        ];

        $params = $data;
        if (empty($params['order'])) {
            $params['order'] = 'default';
        }

        if ($cat) {
            $params['category_parent'] = $cat['id'];
        }


        if($city){
            $params['city'] = $city['id'];
        }
 
        if($district){
            $params['district'] = $district['id'];
        }

        if ($data['sub_cat']) {
            $tmp = $this->catRepo->getById($data['sub_cat']);
            if ($tmp) {
                $subCat = $tmp;
                $cat = $subCat->cat();
                $cat['classCategoryArray'] = $this->catRepo
                    ->getClassCategoryOf(ClassCategory::TYPE_SPONSOR, $cat['id']);
                $params['category_parent'] = $cat['id'];
            }
        }

        if ($subCat) {
            $params['category'] = $subCat->id;
            $subCat->classCategoryArray = $this->catRepo
                ->getClassCategoryOf(ClassCategory::TYPE_ADVISER, $cat['id'], $subCat->id);
        }
 
        $params['status'] = [
            config('product.status.active'),
            config('product.status.disabled'),
        ];

    

        $params['lang'] = $this->getLang();
        $data['check'] = 'No';
        $data['products'] = $this->productRepo->paginate($params, 16);
        $data['cat'] = $cat;
        $data['subCat'] = $subCat;    
        if (!$_GET) {    
            $data['city'] = json_encode($city);
            $data['district'] = json_encode($district);
        }
        if (!empty($params['category_parent'])) {
            session()->put('search.category_parent', $params['category_parent']);
            if (!empty($params['category'])) {
                session()->put('search.category', $params['category']);
            } else {
                session()->forget('search.category');
            }
        } else {
            session()->forget(['search.category_parent', 'search.sub_cat']);
        }

        if (!empty($params['city'])) {

            session()->put('search.city', $params['city']);
            if (!empty($params['district'])) {
                session()->put('search.district', $params['district']);
            } else {
                session()->forget('search.district');
            }
        } else {
            session()->forget(['search.city', 'search.district']);
        }

        $data['viewMapUrl'] = url('ban-do'.request()->getRequestUri());
		$data['isSearch'] = request()->input('s') ? true : false;

        return view('pages.category', $data);
    }

    public function userProduct(Request $request, $id)
    {

        $user = $this->userRepo->findFrontEndUserById($id);

        if ($user == null) {
            abort(404);
        }

        $params = ['user_id' => $user->id];

        $data = [];
        $data['products'] = $this->productRepo->paginate($params, 16);
        $data['user'] = $user;

        return view('pages.user-product', $data);
    }

    public function viewByTag(Request $request, $slug, $id)
    {
        $tag = $this->tagRepo->getById($id);

        if ($tag == null) {
            abort(404);
        }
        $params = ['tag_id' => $tag->id];
        $params['lang'] = $this->getLang();
        $data['products'] = $this->productRepo->paginate($params, 16);
        $data['tag'] = $tag;

        return view('pages.product-by-tag', $data);
    }

    public function classCategory(Request $request, $slug, $id)
    {
        $classCategory = $this->catRepo->getClassCategoryById($id);
        if (!$classCategory || $classCategory->status == ClassCategory::STATUS_INACTIVE) {
            return redirect()->route('home');
        }
        $cat = $this->catRepo->getParentCategoryByID($classCategory->category_id);
        if (!$cat) {
            return redirect()->route('home');
        }
        $data = [
            'keyword' => request()->input('s', ''),
            'order' => request()->input('order', ''),
            'city' => request()->input('city', ''),
            'district' => request()->input('district', ''),
            'ward' => request()->input('ward', ''),
            'street' => request()->input('street', ''),
            'provider' => request()->input('provider', ''),
            'price_range' => request()->input('price_range', ''),
            'pano_type' => request()->input('pano_type', ''),
            'pano_size' => request()->input('pano_size', ''),
            'pano_border' => request()->input('pano_border', ''),
            'pano_light' => request()->input('pano_light', ''),
            'ad_channel' => request()->input('ad_channel', ''),
            'ad_coverage' => request()->input('ad_coverage', ''),
            'ad_time' => request()->input('ad_time', ''),
            'social_type' => request()->input('social_type', ''),
            'social_follow' => request()->input('social_follow', ''),
            'web_type' => request()->input('web_type', ''),
            'web_position' => request()->input('web_position', ''),
            'sub_cat' => request()->input('sub_cat', ''),
            'has_image' => request()->input('has_image', ''),
            'has_video' => request()->input('has_video', ''),
            'classCategory' => $classCategory,
        ];
        $cat['classCategoryArray'] = $this->catRepo
            ->getClassCategoryOf(ClassCategory::TYPE_SPONSOR, $cat['id']);

        $data['cat'] = $cat;
        $data['check'] = 'Yes';
        $breadcrumb = 'category';

        $params = [];
        if (empty($params['order'])) {
            $params['order'] = 'default';
        }

//        $params['category_parent'] = $classCategory->category_id;
        if ($classCategory->sub_category_id) {
            $subCat = $this->catRepo->getById($classCategory->sub_category_id);
//            $params['category'] = $classCategory->sub_category_id;
            $subCat->classCategoryArray = $this->catRepo
                ->getClassCategoryOf(ClassCategory::TYPE_ADVISER, $cat['id'], $subCat->id);
            $data['subCat'] = $subCat;
            $breadcrumb = 'subcategory';
        }
        $data['breadcrumb'] = $breadcrumb;

        $params['status'] = [
            config('product.status.active'),
            config('product.status.disabled'),
        ];

        $params['lang'] = $this->getLang();
        $params['class_category_id'] = $classCategory->id;

        $data['products'] = $this->productRepo->paginate($params, 16);
        if (!empty($params['category_parent'])) {
            session()->put('search.category_parent', $params['category_parent']);
            if (!empty($params['category'])) {
                session()->put('search.category', $params['category']);
            } else {
                session()->forget('search.category');
            }
        } else {
            session()->forget(['search.category_parent', 'search.sub_cat']);
        }

        if (!empty($params['city'])) {
            session()->put('search.city', $params['city']);
            if (!empty($params['district'])) {
                session()->put('search.district', $params['district']);
            } else {
                session()->forget('search.district');
            }
        } else {
            session()->forget(['search.city', 'search.district']);
        }

        $data['viewMapUrl'] = url('ban-do'.request()->getRequestUri());
        return view('pages.category', $data);
    }
}
