<?php

namespace App\Repositories;


use App\Bill;
use App\Lib\Email;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VnPayRepository
{
    protected $banks = [
        'VIETCOMBANK' => 'Ngân hàng Ngoại thương (Vietcombank)',
        'VIETINBANK' => 'Ngân hàng Công thương (Vietinbank)',
        'BIDV' => 'Ngân hàng đầu tư và phát triển Việt Nam (BIDV)',
        'AGRIBANK' => 'Ngân hàng Nông nghiệp (Agribank)',
        'SACOMBANK' => 'Ngân hàng TMCP Sài Gòn Thương Tín (SacomBank)',
        'TECHCOMBANK' => 'Ngân hàng Kỹ thương Việt Nam (TechcomBank)',
        'ACB' => 'Ngân hàng ACB	',
        'VPBANK' => 'Ngân hàng Việt Nam Thịnh vượng (VPBank)',
        'DONGABANK' => 'Ngân hàng Đông Á (DongABank)',
        'EXIMBANK' => 'Ngân hàng EximBank',
        'TPBANK' => 'Ngân hàng Tiên Phong (TPBank)',
        'NCB' => 'Ngân hàng Quốc dân (NCB)',
        'OJB' => 'Ngân hàng Đại Dương (OceanBank)',
        'MSBANK' => 'Ngân hàng Hàng Hải (MSBANK)',
        'HDBANK' => 'Ngan hàng HDBank',
        'NAMABANK' => 'Ngân hàng Nam Á (NamABank)',
        'OCB' => 'Ngân hàng Phương Đông (OCB)',
//        'VISA' => 'Thẻ quốc tế Visa',
//        'VISA' => 'Thẻ quốc tế MasterCard',
//        'VISA' => 'Thẻ quốc tế JCB',
        'VNMART' => 'Ví điện tử VnMart',
        'SCB' => 'Ngân hàng TMCP Sài Gòn (SCB)',
        'IVB' => 'Ngân hàng TNHH Indovina (IVB)',
        'ABBANK' => 'Ngân hàng thương mại cổ phần An Bình (ABBANK)',
        'SHB' => 'Ngân hàng Thương mại cổ phần Sài Gòn (SHB)',
        'VIB' => 'Ngân hàng Thương mại cổ phần Quốc tế Việt Nam (VIB)',
//        'VNPAYQR' => 'Cổng thanh toán VNPAYQR',
        'VIETCAPITALBANK' => 'Ngân Hàng Bản Việt',
        'PVCOMBANK' => 'Ngân hàng TMCP Đại Chúng Việt Nam',
        'SAIGONBANK' => 'Ngân hàng thương mại cổ phần Sài Gòn Công Thương',
        'MBBANK' => 'Ngân hàng thương mại cổ phần Quân đội',
        'BACABANK' => 'Ngân Hàng TMCP Bắc Á',
        'UPI' => 'UnionPay International',
    ];

    protected $visa = [
        'VISA' => 'Thẻ quốc tế Visa',
        'MASTERCARD' => 'Thẻ quốc tế MasterCard',
        'JCB' => 'Thẻ quốc tế JCB',
    ];

    protected $qrPays = [
        'VNPAYQR' => 'Cổng thanh toán VNPAYQR',
    ];

    protected $amountOptions = [
        100000,
        500000,
        1000000,
        2000000,
        5000000,
    ];

    protected $config;
    protected $billRepository;
    protected $userRepository;

    public function __construct(BillRepository $billRepository, UserRepository $userRepository)
    {
        $this->config = config('vnpay');
        $this->billRepository = $billRepository;
        $this->userRepository = $userRepository;
    }

    public function getSecureHash($hashData)
    {
        return md5($this->config['hashSecret'].$hashData);
    }

    public function getAmountOptions()
    {
        return $this->amountOptions;
    }

    public function getBanks()
    {
        return $this->banks + $this->visa + $this->qrPays;
    }

    public function getVisa()
    {
        return $this->visa;
    }

    public function getQrPays()
    {
        return $this->qrPays;
    }

    public function buildHashData($inputData)
    {
        $hashdata = "";
        $query = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        return [$hashdata, $query];
    }

    public function buildPaymentUrl($data, $user)
    {
        // Add bill
        $billData = [
            'type' => Bill::TYPE_ADD,
            'mode' => Bill::MODE_VNPAY,
            'point' => $data['amount'],
            'date' => date('Y-m-d'),
            'user_id' => $user->id,
            'created_by' => Auth::user() ? Auth::user()->id : null,
            'product_id' => null,
            'service_id' => null,
            'option_id' => null,
            'status' => Bill::STATUS_PENDING,
            'note' => 'Add point via VNPAY.',
        ];
        $bill = $this->billRepository->addBill($billData, Auth::user());

        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => $this->config['version'],
            "vnp_TmnCode" => $this->config['tmnCode'],
            "vnp_Amount" => $data['amount'] * $this->config['rate'],
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $this->config['language'],
            "vnp_OrderInfo" => isset($data['note']) ? $data['note']: null,
            "vnp_OrderType" => $bill->mode,
            "vnp_ReturnUrl" => $this->config['callback'],
            "vnp_TxnRef" => $bill->id,
            'vnp_BankCode' => $data['bank'],
        );
        ksort($inputData);
        list ($hashdata, $query) = $this->buildHashData($inputData);

        $vnp_Url = $this->config['url'] . "?" . $query;
        $vnpSecureHash = md5($this->config['hashSecret'] . $hashdata);
        $vnp_Url .= 'vnp_SecureHashType=MD5&vnp_SecureHash=' . $vnpSecureHash;
        return $vnp_Url;
    }

    public function processResponse($data)
    {
        $vnp_SecureHash = $data['vnp_SecureHash'];
        $inputData = array();
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }

        $secureHash = md5($this->config['hashSecret'] . $hashData);
        if ($secureHash == $vnp_SecureHash) {
            $billId = $data['vnp_TxnRef'];
            $bill = $this->billRepository->getById($billId);

            if (!$bill) {
                return [false, 'Giao dịch thất bại.'];
            }
            $user = $this->userRepository->getById($bill->user_id);
            if (!$user) {
                return [false, 'Giao dịch thất bại.'];
            }
            if ($data['vnp_ResponseCode'] == '00') {
                return [true, 'Giao dịch thành công'];
            } else {
                return [false, 'Giao dịch thất bại.'];
            }
        } else {
            return [false, 'Chữ ký không hợp lệ.'];
        }
    }
}