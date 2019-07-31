<?php

namespace App\Http\Controllers\Admin;


use App\Bill;
use App\Repositories\BillRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use http\Env\Response;
use Illuminate\Http\Request;

class BillController extends Controller
{
    protected $billRepository;
    protected $userRepository;
    protected $productRepository;
    public function __construct(BillRepository $billRepository, UserRepository $userRepository,
            ProductRepository $productRepository)
    {
        $this->middleware('auth:api');
        $this->billRepository = $billRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $npp = 5;

        $items = $this->billRepository->getPagination($request->all(), $npp, $page);
        return response()->json([
            'items' => $items,
        ]);
    }

    public function update(Request $request, $id)
    {
        $status = $request->input('status');
        $note = $request->input('note');
        $bill = $this->billRepository->getById($id);
        if (!$bill) {
            return response()->json([
                'status' => false,
                'message' => 'Giao dịch không tồn tại.',
            ]);
        }
        if ($bill->status == Bill::STATUS_DONE
            || $bill->status == Bill::STATUS_CANCEL) {
//            return response()->json([
//                'status' => false,
//                'message' => 'Giao dịch đã hoàn thành/ hủy bỏ, không thể cập nhật.',
//            ]);
            $status = null; // Update note only
        }
        $rs = $this->billRepository->update($bill, [
            'status' => $status ? $status : $bill->status,
            'note' => $note,
        ]);
        if ($rs && $status == Bill::STATUS_DONE) {
            $user = $this->userRepository->getById($bill->user_id);
            if ($user) {
                if ($bill->type == Bill::TYPE_SUB) {
                    $isUsePromotion = false;
                    if ($bill->product_id) {
                        $product = $this->productRepository->getById($bill->product_id);
                        $isUsePromotion = $product->allow_promotion;
                    }

                    $this->userRepository->decreasePoint($user, $bill->point
                            + $bill->promotion_point, $isUsePromotion);
                } else {
                    $point = $user->point;
                    if (in_array($bill->mode, [
                        Bill::MODE_VNPAY,
                        Bill::MODE_ADMIN,
                    ])) {
                        $point += $bill->point;
                    }
                    $remainPoint = $user->remain_point + $bill->point;
                    $this->userRepository->update($user, [
                        'point' => $point,
                        'remain_point' => $remainPoint,
                    ]);
                }
            }
        }
        return response()->json([
            'result' => $rs,
        ]);
    }

    public function getBasicData(Request $request)
    {
        return response()->json([
            'typeList' => Bill::getTypeList(),
            'modeList' => Bill::getModeList(),
        ]);
    }
}