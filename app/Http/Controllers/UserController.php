<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Lib\Email;
use App\Repositories\BillRepository;
use App\Repositories\CampaignRepository;
use App\Repositories\MessageRepository;
use App\Repositories\SettingRepository;
use App\Repositories\VnPayRepository;
use App\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Hash;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected $productRepo;
    protected $userRepo;
    protected $billRepository;
    protected $vnpayRepository;
    protected $messageRepository;
    protected $settingRepository;
    protected $campaignRepository;

    public function __construct(ProductRepository $productRepo, UserRepository $userRepo,
        BillRepository $billRepository, VnPayRepository $vnPayRepository,
        MessageRepository $messageRepository, SettingRepository $settingRepository,
        CampaignRepository $campaignRepository)
    {
        $this->middleware('auth')->only([
            'profile', 'upload-image']);
        $this->productRepo = $productRepo;
        $this->userRepo = $userRepo;
        $this->billRepository = $billRepository;
        $this->vnpayRepository = $vnPayRepository;
        $this->messageRepository = $messageRepository;
        $this->settingRepository = $settingRepository;
        $this->campaignRepository = $campaignRepository;
    }

    public function profile(Request $request)
    {
        $products = $this->productRepo->paginate([
            'user_id' => auth()->user()->id,
            'order' => 'newest',
        ]);
        $activeTab = 'products';
//        $refreshTimeSetting = $this->settingRepository->getByKeyAndGroup('refresh_time', 'all');
        $autoTime = 8; //$refreshTimeSetting ? $refreshTimeSetting->value : 8;
        $isNeedActiveSms = $request->input('active_sms');
//        $message = $request->session()->get('message_active');

        return view('pages.profile', compact('products',
            'activeTab', 'autoTime', 'isNeedActiveSms'));
    }

    public function bills(Request $request)
    {
        $bills = $this->billRepository->getPagination([
            'user_id' => auth()->user()->id,
        ], 10, $request->input('page', 1));
        $activeTab = 'bills';
        return view('pages.bills', compact('bills', 'activeTab'));
    }

    public function changePassword()
    {
        $user = auth()->user();

        request()->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:5|confirmed',
        ]);

        if (!empty($user->password) && !Hash::check(request()->current_password, $user->password)) {
            return [
                'status' => 0,
                'errors' => ['current password is wrong'],
            ];
        }

        if ($this->userRepo->updatePassword($user, request()->new_password)) {
            \Session::flash('msg', 'Đổi mật khẩu thành công');
            return ['status' => 1];
        }

        return ['status' => 0];
    }

    public function updateAvatar()
    {
        $user = auth()->user();

        request()->validate([
            'avatar' => 'required',
        ]);

        $user->avatar = request()->avatar;
        $user->save();
        return ['status' => 1];

    }

    public function updateProfile()
    {
        $user = auth()->user();

        request()->validate([
            'name' => 'required',
//            'phone' => 'required',
        ]);

        $data = request()->only('name');

        if ($this->userRepo->update($user, $data)) {
            \Session::flash('msg', 'Đổi thông tin cá nhân thành công');
            return ['status' => 1];
        }

        return ['status' => 0];
    }

    public function addPoint(Request $request)
    {
        $banks = $this->vnpayRepository->getBanks();
        $qrPays = $this->vnpayRepository->getQrPays();
        $visaPays = $this->vnpayRepository->getVisa();
        $validBanks = array_merge($banks, $qrPays, $visaPays);

        $amountList = $this->vnpayRepository->getAmountOptions();
        $errorMessages = [];
        if ($request->isMethod('post')) {
            $amount = $request->input('amount');
            $bank = $request->input('bank');

            if (!$amount || !in_array($amount, $amountList)) {
                $errorMessages[] = "Số tiền nạp không hợp lệ.";
            }
            if (!$bank || !in_array($bank, array_keys($validBanks))) {
                $errorMessages[] = "Ngân hàng không hợp lệ hoặc không được hỗ trợ.";
            }
            if (!count($errorMessages)) {
                $url = $this->vnpayRepository->buildPaymentUrl([
                    'amount' => $request->input('amount'),
                    'bank' => $request->input('bank'),
                    'note' => 'Nap tien VNP',
                ], Auth::user());
                if ($url) {
                    return redirect($url);
                }
            } else {
                \Session::flash('msg_err', implode('<br/>', $errorMessages));
            }

        }
        return view('pages.add_point', compact('banks',
            'qrPays', 'visaPays', 'amountList', 'errorMessages'));
    }

    public function paymentCallback(Request $request)
    {
        list($result, $message) = $this->vnpayRepository->processResponse($request->all());
        if ($result) {
            \Session::flash('msg', 'Nạp tiền thành công.');
            return redirect(route('bills'));
        } else {
            \Session::flash('msg_err', 'Nạp tiền thất bại.');
            return redirect(route('add_point'));
        }
    }

    public function ipnCallback(Request $request)
    {
        $vnp_SecureHash = $request->input('vnp_SecureHash');
        $inputData = [];
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == 'vnp_') {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        list($hashData, $query) = $this->vnpayRepository->buildHashData($inputData);
        $returnData = [];
        try {
            if ($vnp_SecureHash != $this->vnpayRepository->getSecureHash($hashData)) {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Chu ky khong hop le';
            } else {
                // Check bill
                $billId = $inputData['vnp_TxnRef'];
                $bill = $this->billRepository->getById($billId);
                if ($bill) {
                    if ($bill->status == Bill::STATUS_DONE) {
                        $returnData['RspCode'] = '02';
                        $returnData['Message'] = 'Order already confirmed';
                    } elseif ($bill->status == Bill::STATUS_PENDING) {
                        // Update point to user
                        if ($inputData['vnp_ResponseCode'] == '00') {
                            $user = $this->userRepo->getById($bill->user_id);
                            $bill->status = Bill::STATUS_DONE;
                            $bill->note .= ', Confirm Mã giao dịch: ' . $inputData['vnp_TransactionNo']
                                . ', Time: ' . $inputData['vnp_PayDate'];
                            $bill->save();
                            if ($user) {
                                // Add point to user
                                $point = $user->point + $bill->point;
                                $remainPoint = $user->remain_point + $bill->point;
                                $this->userRepo->update($user, [
                                    'point' => $point,
                                    'remain_point' => $remainPoint,
                                ]);
                                // Send mail
                                Email::send([
                                    'template_id' => Email::TEMPLATE_PAYMENT_SUCCESS,
                                    'to_email' => $user->email,
                                    'to_name' => $user->name,
                                    'data' => [
                                        'name' => $user->name,
                                        'user' => $user->email,
                                        'point' => number_format($bill->point),
                                        'bill_id' => 'VNADS_TRANS_' . $bill->id,
                                        'payment_method' => 'VNPAY, Mã giao dịch: ' . $inputData['vnp_TransactionNo'],
                                        'payment_date' => Carbon::now()->format('d/m/Y H:i:s'),
                                    ],
                                ]);
                            }
                        } else {
                            $bill->status = Bill::STATUS_CANCEL;
                            $bill->note .= ', Giao dịch thất bại.';
                            $bill->save();
                            Email::send([
                                'template_id' => Email::TEMPLATE_PAYMENT_CANCEL,
                                'to_email' => $user->email,
                                'to_name' => $user->name,
                                'data' => [
                                    'name' => $user->name,
                                    'user' => $user->email,
                                    'point' => number_format($bill->point),
                                    'bill_id' => 'VNADS_TRANS_' . $bill->id,
                                    'payment_method' => 'VNPAY, Mã giao dịch: ' . $inputData['vnp_TransactionNo'],
                                    'payment_date' => Carbon::now()->format('d/m/Y H:i:s'),
                                ],
                            ]);
                        }
                        //Trả kết quả về cho VNPAY: Website TMĐT ghi nhận yêu cầu thành công
                        $returnData['RspCode'] = '00';
                        $returnData['Message'] = 'Confirm Success';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            }
        } catch(\Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
//            Log::error($e->getMessage(), $e->getTrace());
        }

        return \response()->json($returnData);
    }

    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'to_user' => 'integer|required',
            'message_content' => 'string|required',
            'product_id' => 'integer',
        ]);
        $toUser = $request->input('to_user');
        $user = $this->userRepo->getById($toUser);
        $fromProduct = $request->input('from_product');
        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Dữ liệu không hợp lệ.',
            ]);
        }
        if ($toUser == Auth::user()->id) {
            return response()->json([
                'status' => 0,
                'message' => 'Không được gửi tin cho chính mình.',
            ]);
        }
        $content = trim($request->input('message_content'));
        if (!Auth::user() || !$toUser || !$content || mb_strlen($content) <= 0) {
            return response()->json([
                'status' => 0,
                'message' => 'Dữ liệu không hợp lệ.',
            ]);
        }
        $result = $this->messageRepository->sendMessage(Auth::user()->id, $toUser, $content, $fromProduct);
        return response()->json([
                'status' => $result,
            ]
        );
    }

    public function messages(Request $request)
    {
        $toUser = Auth::user()->id;
        $page = $request->input('page', 1);
        $senderList = $this->messageRepository->getSenderList($toUser, $page);

        if ($request->isXmlHttpRequest()) {
            return response()->json($senderList);
        }

        return view('pages.message_box', [
            'senderList' => $senderList,
        ]);
    }

    public function getMessage(Request $request)
    {
        $this->validate($request, [
            'from' => 'integer|required',
        ]);
        $fromUserId = $request->input('from');
        $fromUser = $this->userRepo->getById($fromUserId);
        $items = [];
        if ($fromUser) {
            $toUser = \auth('web')->user()->id;
            $items = $this->messageRepository->getContentOfThread($fromUserId, $toUser);
            $this->messageRepository->markReadFor($fromUserId, $toUser);
        }
        return view('partials.message_content', [
            'items' => $items,
            'currentUser' => \auth('web')->user(),
            'fromUser' => $fromUser,
        ]);
    }

    public function validGiftCode(Request $request)
    {
        $code = $request->input('giftCode');
        $loginUser = auth()->user();
        /** @var $loginUser User */
        if (!$loginUser->isVerifiedPhone()) {
            return response()->json([
                'status' => 0,
                'message' => 'Tài khoản chưa xác minh số điện thoại.',
            ]);
        }
        $campaignCode = $this->campaignRepository->getByCodeStr($code);
        if (!$code || !$campaignCode) {
            return response()->json([
                'status' => 0,
                'message' => 'Gift code không hợp lệ.',
            ]);
        }
        if (!$this->campaignRepository->canUseCode($campaignCode, $loginUser)) {
            return response()->json([
                'status' => 0,
                'message' => 'Gift code đã hết hạn hoặc bạn đã sử dụng code này.',
            ]);
        }
        $this->campaignRepository->useCode($campaignCode, $loginUser);
        $this->userRepo->update($loginUser, [
            'promotion_point' => $loginUser->promotion_point + $campaignCode->value,
        ]);
        $billData = [
            'type' => Bill::TYPE_ADD,
            'mode' => Bill::MODE_GIFT_CODE,
            'point' => 0,
            'promotion_point' => $campaignCode->value,
            'date' => date('Y-m-d'),
            'user_id' => $loginUser->id,
            'created_by' => $loginUser->id,
            'product_id' => null,
            'service_id' => null,
            'option_id' => null,
            'status' => Bill::STATUS_DONE,
            'note' => 'Sử dụng Gift code: '.$code,
        ];
        $this->billRepository->addBill($billData, $loginUser);


        return response()->json([
            'status' => 1,
        ]);
    }

    public function pointGuide(Request $request)
    {
        return view('pages.point_guide', [
            'page' => 'Hướng dẫn nạp tiền',
            'slug' => 'point_guide',
        ]);
    }

    public function activate(Request $request, $token)
    {
        $type = 'sms';
        $user = $this->userRepo->findByActivationToken($token, $type);

        if (!$user) {
            if (\request()->isXmlHttpRequest()) {
                return response()->json([
                    'status' => 0
                ]);
            }
            $request->session()->flash('message_active', 'Mã xác minh không hợp lệ. Vui lòng kiểm tra lại tin nhắn.');
            return redirect()->route('profile');
        }

        if ($user->id != \auth()->user()->id) {
            $request->session()->flash('message_active', 'Mã xác minh không hợp lệ. Vui lòng kiểm tra lại tin nhắn.');
            return redirect()->route('profile');
        }

        /** @var $user User */
        if ($type == 'email' && $user->isActivated()) {
            return redirect()->route('profile');
        } elseif ($type == 'sms' && $user->isVerifiedPhone()) {
            return redirect()->route('profile');
        }

        $dataUpdate = [
            'activated' => 1,
        ];
        if ($type == 'sms') {
            $dataUpdate['verified_phone'] = User::VERIFIED_PHONE_OK;
        }
        $this->userRepo->update($user, $dataUpdate);
        $request->session()->flash('message_active', 'Số điện thoại đã được xác nhận thành công.');
        // @TODO send email inform active success
        Email::send([
            'template_id' => Email::TEMPLATE_REGISTER, //'d-696ea1b47ae94bfa83e46e7ff9dc7ecb',
            'to_email' => $user->email,
            'to_name' => $user->name,
            'data' => [
                'name' => $user->name,
                'phone' => $user->phone,
                'ID_user' => $user->id,
            ],
        ]);

        return redirect()->route('profile');
    }
}
