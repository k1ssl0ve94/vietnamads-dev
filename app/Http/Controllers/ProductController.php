<?php

namespace App\Http\Controllers;

use App\ClassCategory;
use App\Repositories\ServiceRepository;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use App\Lib\Location;
use Carbon\Carbon;
use App\Product;
use App\Repositories\SettingRepository;
use App\Lib\IImage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productRepo;
    protected $catRepo;
    protected $userRepo;
    protected $settingRepo;
    protected $serviceRepository;

    public function __construct(
        ProductRepository $productRepo,
        CategoryRepository $catRepo,
        UserRepository $userRepo,
        SettingRepository $settingRepo,
        ServiceRepository $serviceRepository
    ) {
        $this->middleware('auth')->except(['show']);

        $this->productRepo = $productRepo;
        $this->catRepo = $catRepo;
        $this->userRepo = $userRepo;
        $this->settingRepo = $settingRepo;
        $this->serviceRepository = $serviceRepository;
    }

    public function show($catSlug, $slug, $id)
    {
        $product = $this->productRepo->getById($id);
        if (!$product) {
            abort(404);
        }
        $product->user = $this->userRepo->getById($product->user_id);
        $token = request()->token;
        if ($token) {
            $id = decrypt($token);
            if (!$id && !$product->isActive()) {
                // Check keep alive
                if (!$product->keep_alive) {
                    abort(404);
                }
            }
        } else {
            if (!$product->isActive() && !$product->keep_alive) {
                abort(404);
            }
        }

        $product->direct_link = explode(',', $product->direct_link) + [
                '', '', '', ''
            ];
        $product->direct_link = array_slice($product->direct_link, 0, 4);

        $relatedProducts = $this->productRepo->getByParams([
            'category_parent' => $product->category_parent,
            'category' => $product->category,
            'excludedIds' => [$product->id],
            'city' => $product->city,
//            'district' => $product->district,
            'status' => [
                config('product.status.active'),
                config('product.status.disabled'),
            ],
            'lang' => $this->getLang(),
        ], 10);

        $cat = $this->catRepo->getParentCategoryByID($product->category_parent);
        $cat['classCategoryArray'] = $this->catRepo
            ->getClassCategoryOf(ClassCategory::TYPE_SPONSOR, $cat['id']);
        $subCat = $this->catRepo->getById($product->category);
        $subCat->classCategoryArray = $this->catRepo
        ->getClassCategoryOf(ClassCategory::TYPE_ADVISER, $cat['id'], $subCat->id);

        session()->put('search.category_parent', $product->category_parent);
        session()->put('search.category', $product->category);
        session()->put('search.city', $product->city);
        session()->put('search.district', $product->district);

//        $refreshTimeSetting = $this->settingRepo->getByKeyAndGroup('refresh_time', 'all');
        $refreshTime = 8; //$refreshTimeSetting ? $refreshTimeSetting->value : 8;

        return view('pages.product-detail', compact('product',
            'relatedProducts', 'refreshTime', 'cat', 'subCat'));
    }

    public function getCreateAd()
    {
        if (!auth()->user()->isActivated()) {
            return redirect()->route('home');
        }
        $tab = request()->input('tab', 1);
        return view('pages.create-product', compact('tab'));
    }

    public function postCreatePano()
    {
        $rules = [
            'pano_type' => 'required',
            'pano_size' => 'required'
        ];

        $subCat = request()->category;
        if (in_array($subCat, [5, 7])) {
            unset($rules['pano_type']);
        }

        if (in_array($subCat, [5])) {
            unset($rules['pano_size']);
        }

        return $this->createProduct(1, $rules);
    }

    public function postCreateAd()
    {
        $rules = [
            // 'ward' => 'required',
            // 'street' => 'required',
        ];

        return $this->createProduct(2, $rules);
    }

    public function postCreateSocial()
    {
        return $this->createProduct(3, []);
    }

    public function postCreateWeb()
    {
        $rules = [
            'web_type' => 'required',
            'web_position' => 'required',
        ];
        return $this->createProduct(4, $rules);
    }

    public function postCreateOther()
    {
        return $this->createProduct(5, []);
    }

    public function postCreateFind()
    {
        return $this->createProduct(6, []);
    }

    protected function editProduct($editId)
    {
        $user = auth()->user();
        if (!$user->isActivated()) {
            return redirect()->route('home');
        }
        $editProduct = $this->productRepo->getById($editId);
        if (!$editProduct || $editProduct->user_id != $user->id) {
            return response()->json([
                'status' => 0,
                'message' => 'Yêu cầu không hợp lệ hoặc tin rao không phải của bạn.',
            ]);
        }
        if ($editProduct->edit_times <= 0) {
            return response()->json([
                'status' => 0,
                'message' => 'Tin rao đã hết số lần được phép chỉnh sửa.',
            ]);
        }
        $data = request()->only([
            'content', 'provider', 'images', 'youtube_link', 'direct_link',
            'ad_time', 'contact_name', 'contact_phone', 'contact_email', 'contact_address',
        ]);
        $data['direct_link'] = [
            \request('direct_link1'),
            \request('direct_link2'),
            \request('direct_link3'),
            \request('direct_link4'),
        ];
        $service = $this->serviceRepository->getDetail($editProduct->level);
        if (!$service
            || ($user->level != User::LEVEL_VIP && $service->vip_only)) {
            return response()->json([
                'status' => 0,
                'message' => 'Yêu cầu không hợp lệ. Gói không hợp lệ.',
            ]);
        }
        // Validate content length and title length
        $data['content'] = strip_tags($data['content']);
        $allowNumberOfImage = 12 - count($editProduct->getImages());
        $allowNumberOfImage = $allowNumberOfImage > 0 ? $allowNumberOfImage : 0;
        if (!is_array($data['images'])) {
            $data['images'] = [];
        } else {
            $images = [];
            foreach ($data['images'] as $index => $img) {
                $images[] = $img['filename'];

                $thumbData = IImage::makeThumb($img['filename'], 'products');

                IImage::addWaterMark($img['filename'], 'products', 'lg');
                IImage::addWaterMark($thumbData['filename'], 'products', 'sm');

                if ($index == 0) {
                    $data['thumb'] = $thumbData['filename'];
                }
            }
            // @TODO change to number image of service
//            $allowNumberOfImage = 12; // @TODO change to hard-code $service->images_number;
            $data['images'] = array_slice($images, 0, $allowNumberOfImage);
        }

        if (!$service->auto_active) {
            $data['status'] = config('product.status.pending');
        } else {
            $data['status'] = config('product.status.active');
        }
        $this->productRepo->update($editProduct, $data);
        \Session::flash('msg', 'Cập nhật tin thành công');
        return response()->json([
            'status' => 1,
        ]);
    }

    protected function createProduct($cat, $rules)
    {
        $user = auth()->user();
        /** @var $user User */
        if (!$user->isActivated() || !$user->isVerifiedPhone()) {
            return redirect()->route('home');
        }

        $editId = \request()->input('id');
        if ($editId) {
            return $this->editProduct($editId);
        }

        $defaultRules = [
            'title' => 'required|min:30|max:120',
            'city' => 'required|numeric',
            'district' => 'required|numeric',
            'provider' => 'required',
            'category' => 'required',
            'content' => 'required|min:80|max:3000',
            'contact_name' => 'required|max:30',
            'contact_address' => 'required|between:2,30',
            'contact_phone' => 'required|phone_number|between:8,14',
            'contact_email' => 'required|email',
            'level' => 'required|integer',
            'price' => 'numeric|digits_between:0,11',
            'price_unit' => 'max:20',
            'package_option' => 'integer|required',
        ];
        $rules = array_merge($defaultRules, $rules);

        if ($cat == 6) {
            unset($rules['provider']);
        }
        request()->validate($rules);

        $data = request()->all();
        $data['category_parent'] = $cat;


        $service = $this->serviceRepository->getDetail($data['level']);
        if (!$service
         || ($user->level != User::LEVEL_VIP && $service->vip_only)) {
            return response()->json([
                'status' => 0,
                'message' => 'Yêu cầu không hợp lệ. Gói không hợp lệ.',
            ]);
        }
        $packageOption = $this->serviceRepository->getOptionById($data['package_option']);
        if (!$packageOption || !$this->serviceRepository->isOptionBelongToService($packageOption->id,
                $service->id)) {
            return response()->json([
                'status' => 0,
                'message' => 'Yêu cầu không hợp lệ. Lựa chọn ngày đăng không nằm trong gói.',
            ]);
        }
        // Validate content length and title length
        $data['content'] = strip_tags($data['content']);
        $data['direct_link'] = [
            \request('direct_link1'),
            \request('direct_link2'),
            \request('direct_link3'),
            \request('direct_link4'),
        ];

        $totalFee = $service->fee_point * $packageOption->days;
        $remain = $user->remain_point;
        if ($service->allow_promotion){
            $remain += $user->promotion_point;
        }
        if ($remain < $totalFee) {
            return response()->json([
                'status' => 0,
                'message' => 'Bạn không đủ tiền đăng tin theo gói này.',
            ]);
        }

        $data['user_id'] = $user->id;
        $data['currency'] = 'VND';

        if (!is_array($data['images'])) {
            $data['images'] = [];
        } else {
            $images = [];
            foreach ($data['images'] as $index => $img) {
                $images[] = $img['filename'];

                $thumbData = IImage::makeThumb($img['filename'], 'products');

                IImage::addWaterMark($img['filename'], 'products', 'lg');
                IImage::addWaterMark($thumbData['filename'], 'products', 'sm');

                if ($index == 0) {
                    $data['thumb'] = $thumbData['filename'];
                }
            }
            // @TODO change to number image of service
            $allowNumberOfImage = 12; // @TODO change to hard-code $service->images_number;
            $data['images'] = array_slice($images, 0, $allowNumberOfImage);
        }

        $data['from'] = Carbon::now();
        $data['to'] = Carbon::now()->addDays($packageOption->days);
        $product = $this->productRepo->add($data, [], Auth::user());

        if ($product) {
            if ($product->status == config('product.status.active')) {
//                $point = $this->productRepo->additionData[0];
//                $promotionPoint = $this->productRepo->additionData[1];
                $this->productRepo->additionData = [];
                $this->userRepo->decreasePoint($user, $totalFee, $service->allow_promotion);
            }
            \Session::flash('msg', 'Đăng tin thành công');
            return response()->json([
                'status' => 1,
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Cannot add product.',
            ]);
        }

    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:3000|mimes:jpg,jpeg,png,bmp,tiff', // max 3MB
        ]);

        $file = $request->file('file');
        $file->getSize();

        if (!$file->isValid()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $folder = $request->input('folder', '');
        if (!in_array($folder, ['products', 'avatars'])) {
            return response()->json([
                'success' => false,
                'errors' => ['invalid folder'],
            ]);
        }
        $originalName = $file->getClientOriginalName();

        $data = IImage::upload($file, $folder);

        return response()->json([
            'success' => true,
            'file' => [
                'filename' => $data['filename'],
                'original' => $originalName,
                'url' => $data['url'],
            ],
        ]);
    }

    public function refresh(Request $request, Product $product)
    {
        if (!$product || !$product->isActive()) {
            abort(404);
        }
        if (!$product->canRefresh(Auth::user())) {
            return redirect()->route('profile')->with('msg_err', 'Chưa thể làm mới tin này hoặc bạn không đủ tiền để thực hiện làm mới tin.');
        }

        if ($this->productRepo->refresh($product, Auth::user())) {
            return redirect()->route('profile')->with('msg', 'Làm mới thành công');
        }
        return redirect()->route('profile')->with('msg_err', 'Làm mới không thành công');
    }

    public function setAuto(Request $request, int $productId)
    {
        $this->validate($request, [
           'auto_refresh' => 'required|integer|min:1',
        ]);
        $product = $this->productRepo->getById($productId);
        if (!$product || $product->status != config('product.status.active')) {
            abort(404);
        }
        $fromDate = new Carbon($product->from);
        $toDate = new Carbon($product->to);
        $totalHour = $toDate->diffInHours($fromDate);
        $maxAuto = floor($totalHour/8);
        $auto_refresh = $request->input('auto_refresh');
        if ($auto_refresh > $maxAuto) {
            return response()->json([
                'status' => 0,
                'message' => "Bạn không thể set số lần làm mới tự động vượt quá $maxAuto lần. "
                    ."Sản phẩm của bạn hết hạn vào ngày ".$toDate->format('d/m/y'),
            ]);
        }
        $this->productRepo->update($product, [
            'auto_refresh' => $auto_refresh,
        ]);
        return response()->json([
            'status' => 1,
        ]);
    }

    public function edit(Request $request, $id)
    {
        /** @var Product $product */
        $product = $this->productRepo->getById($id);
        if (!$product || $product->user_id != Auth::user()->id) {
            abort('404');
        }
        if ($product->edit_times <= 0) {
            abort('403');
        }

        $allowImgNb = 12 - count($product->getImages());
        $allowImgNb = $allowImgNb > 0 ? $allowImgNb : 0;

        return view('pages.edit_product', [
            'product' => $product,
            'tab' => $product->category_parent,
            'editView' => $product->getViewBaseOnCategory(),
            'allowImgNb' => $allowImgNb,
        ]);
    }
}
