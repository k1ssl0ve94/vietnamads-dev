<?php

namespace App\Http\Controllers\Admin;

use App\Bill;
use App\Repositories\BillRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Repositories\TagRepository;
use App\Lib\Location;
use App\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Storage;
use App\Lib\IImage;

class ProductController extends Controller
{

    protected $productRepo;
    protected $tagRepo;
    protected $billRepository;
    protected $serviceRepository;
    protected $userRepository;
    protected $settingRepository;

    public function __construct(ProductRepository $productRepo, TagRepository $tagRepo,
            ServiceRepository $serviceRepository, BillRepository $billRepository,
            UserRepository $userRepository,
            SettingRepository $settingRepository)
    {
        $this->middleware('auth:api');

        $this->productRepo = $productRepo;
        $this->tagRepo = $tagRepo;
        $this->billRepository = $billRepository;
        $this->serviceRepository = $serviceRepository;
        $this->userRepository = $userRepository;
        $this->settingRepository = $settingRepository;
    }

    public function index()
    {
        if (!auth('api')->user()->can('view product')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        $params = request()->only('keyword', 'category', 'category_parent', 'status',
            'level', 'user_level', 'user_type', 'lang');
        $params['withs'] = ['author'];
        $params['order'] = 'newest';

        $products = $this->productRepo->paginate($params, 20);

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $user = auth('api')->user();
        if (!auth('api')->user()->can('manage product')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        request()->validate([
            'title' => 'required|between:30,120',
            'content' => 'required|between:80,3000',
            'category' => 'required',
            'category_parent' => 'required',
            'user_id' => 'required|exists:users,id',
            'status' => 'required',
            'level' => 'required',
            'contact_email' => 'required',
            'contact_phone' => 'required',
            'lang' => 'required|in:'.implode(',', array_values(config('user.lang'))),
        ]);

        $data = request()->all();

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
            $data['images'] = $images;
        }

        $tagIDs = [];
        if (isset($data['tags_text']) && is_array($data['tags_text']) && !empty($data['tags_text'])) {
            foreach ($data['tags_text'] as $name) {
                $t = $this->tagRepo->findByName($name);
                if (!$t) {
                    $t = $this->tagRepo->add($name);
                }
                $tagIDs[] = $t->id;
            }
        }
        unset($data['tags_text']);

        if ($product = $this->productRepo->add($data, $tagIDs, Auth::user())) {
            event(new \App\Events\AdminLog([
                'admin_id' => $user->id,
                'action' => 'create_product',
                'metadata' => [
                    'id' => $product->id,
                ]
            ]));
            return ['status' => 1];
        }

        return ['status' => 0];
    }

    public function show(Product $product)
    {
        if (!auth('api')->user()->can('view product')) {
            return response()->json(['errors' => ['unauthorized']]);
        }
        $product->tags()->get();


        return response()->json(['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        $user = auth('api')->user();
        if (!$user->can('manage product')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        request()->validate([
            'title' => 'required|between:30,120',
            'content' => 'required|between:80,3000',
            'category' => 'required',
            'category_parent' => 'required',
            'user_id' => 'required|exists:users,id',
            'status' => 'required',
            'level' => 'required',
            'contact_email' => 'required',
            'contact_phone' => 'required',
            'lang' => 'required|in:'.implode(',', array_values(config('user.lang'))),
        ]);

        $data = request()->all();
        $oldImages = $product->getImages();

        if (!is_array($data['images'])) {
            $data['images'] = [];
        } else {
            $images = [];
            foreach ($data['images'] as $img) {
                $images[] = $img['filename'];
            }
            $data['images'] = $images;

            foreach (array_diff($images, $oldImages) as $image) {
                $thumbData = IImage::makeThumb($image, 'products');

                IImage::addWaterMark($image, 'products', 'lg');
                IImage::addWaterMark($thumbData['filename'], 'products', 'sm');
            }

            if (isset($images[0])) {
                $data['thumb'] = IImage::toThumbName($images[0]);
            }
        }

        $tagIDs = [];
        if (isset($data['tags_text']) && is_array($data['tags_text']) && !empty($data['tags_text'])) {
            foreach ($data['tags_text'] as $name) {
                $t = $this->tagRepo->findByName($name);
                if (!$t) {
                    $t = $this->tagRepo->add($name);
                }
                $tagIDs[] = $t->id;
            }
        }
        unset($data['tags_text']);

        if ($this->productRepo->update($product, $data, $tagIDs)) {
            event(new \App\Events\AdminLog([
                'admin_id' => $user->id,
                'action' => 'update_product',
                'metadata' => [
                    'id' => $product->id,
                ]
            ]));
            return ['status' => 1];
        }

        return ['status' => 0];
    }

    public function destroy(Product $product)
    {
        $user = auth('api')->user();
        if (!$user->can('manage product')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        if ($this->productRepo->delete($product)) {
            event(new \App\Events\AdminLog([
                'admin_id' => $user->id,
                'action' => 'update_product',
                'metadata' => [
                    'id' => $product->id,
                ]
            ]));
            return ['success' => 1];
        }
        return ['success' => 0];
    }

    public function updateStatus(Product $product)
    {
        $updateToStatus = intval(request()->status);
        $statuses = array_values(config('product.status'));
        if (!in_array($updateToStatus, $statuses)) {
            return response()->json([
                'status' => 0,
                'message' => 'Có lỗi xảy ra. Vui lòng liên hệ Admin.'
            ]);
        }
        $customer = $this->userRepository->getById($product->user_id);
        $bill = $this->billRepository->isAddBill($product);

        if ($updateToStatus === config('product.status.active')
            && $product->status === config('product.status.pending')){
            // Add bill
            list($data, $allowPromotion) = $this->serviceRepository->prepareDataForProductAndBill($product->level,
                $product->package_option, $customer);

            if (!$data) {
                return response()->json([
                   'status' => 0,
                   'message' => $allowPromotion,
                ]);
            }
            if (!$bill){
                if ($data) {
                    $billData = [
                            'product_id' => $product->id,
                            'type' => Bill::TYPE_SUB,
                            'mode' => Bill::MODE_ACTIVE,
                            'service_id' => $product->level,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'created_by' => Auth::user() ? Auth::user()->id : null,
                            'status' => Bill::STATUS_DONE,
                            'user_id' => $product->user_id,
                        ] + $data;
                    $bill = $this->billRepository->addBill($billData, Auth::user());
                    // Update user point
                    $this->userRepository->decreasePoint($customer, $bill->point
                            + $bill->promotion_point, $allowPromotion);
                    $product->from = $data['from'];
                    $product->to = $data['to'];
                    $product->last_refresh = Carbon::now();
                } else {
                   return response()->json([
                       'status' => 0,
                       'message' => 'Có lỗi xảy ra. Vui lòng liên hệ Admin.'
                   ]);
                }
            } else {
                if ($bill->status == Bill::STATUS_PENDING) {
                    $bill->status = Bill::STATUS_DONE;
                    $bill->from = $data['from'];
                    $bill->to = $data['to'];
                    $bill->updated_by = Auth::user()->id;
                    $bill->save();
                    // Update user point
                    $this->userRepository->decreasePoint($customer, $bill->point
                            + $bill->promotion_point, $allowPromotion);
                    $product->from = $data['from'];
                    $product->to = $data['to'];
                    $product->last_refresh = Carbon::now();
                }
            }
        } else {
            if ($bill && $bill->status == Bill::STATUS_DONE) {
                // @TODO Add refund
//                $this->billRepository->addRefundFrom($bill, Auth::user());
                // @TODO Update user point
            }
        }
        $product->status = $updateToStatus;
        $product->note = trim(request()->note);
        $product->save();
        return response()->json([
            'status' => 1,
            'message' => ''
        ]);
    }

    public function autoSuggest(Product $product)
    {
        $data = request()->only('category', 'category_parent', 'keyword');
        $items  = $this->productRepo->getSuggestionProduct($data);

        return response()->json(['data' => $items]);
    }
}
