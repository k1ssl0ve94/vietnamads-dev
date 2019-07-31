<?php

namespace App\Repositories;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Ixudra\Curl\Facades\Curl;

class EsmsRepository
{
    protected $config;
    protected $service_url = 'http://rest.esms.vn/MainService.svc/json/';
    protected $url_balance = 'GetBalance/';
    protected $url_sendMulti = 'SendMultipleMessage_V4_get';
    const RESPONSE_OK = 100;
    const RESPONSE_ERROR_UNDEFINED = 99;
    const RESPONSE_ERROR_AUTH = 101;
    const RESPONSE_ERROR_ACCOUNT_BANNED = 102;
    const RESPONSE_ERROR_EMPTY_BALANCE = 103;
    const RESPONSE_ERROR_BRAND_NAME = 104;

    const TYPE_CUSTOMER_SERVICE = 6;
    const TYPE_FIX_NOTIFY = 4;
    const TYPE_FIX_10 = 8;
    const TYPE_BRAND_NAME = 2;

    public function __construct()
    {
        $this->config = config('esms');
    }

    public function buildSendSmsQuery($phone, $content, $smsType = self::TYPE_BRAND_NAME, $returnType = 'query')
    {
        $params = [
            'Phone' => $phone,
            'Content' => $content,
            'SmsType' => $smsType,
            'ApiKey' => $this->config['api_key'],
            'SecretKey' => $this->config['secret_key'],
            'Brandname' => 'Verify', // default
        ];
        if ($returnType == 'array') {
            return $params;
        }
        return http_build_query($params);
    }

    public function sendApi($action, $params = [])
    {
        if (env('TURN_OFF_SMS') == 'On') {
            return true;
        }
        $response = Curl::to(trim($this->service_url.$action))
            ->withData($params)
            ->withContentType('application/json')
            ->get();
        Log::info($response);
        $response = json_decode($response);
        if ($response && $response->CodeResult == '100') {
            return true;
        } else {
            // @TODO send mail to Admin to inform
        }
        return false;
    }

    public function sendRegisterSMS($user)
    {
        $activeCode = random_int(100000, 999999).$user->id;
        $content = "Ma kich hoat tai khoan cua ban la $activeCode";
        $url = $this->url_sendMulti; //.'?'.$this->buildSendSmsQuery($user->phone, $content);
        $params = $this->buildSendSmsQuery($user->phone, $content, self::TYPE_BRAND_NAME, 'array');
        if (env('APP_ENV') == 'local') {
            Log::info('Active code of '.$user->id. ' is '.$activeCode);
        }

        $i = 0;
        while ($i <= 2) {
            $rs = $this->sendApi($url, $params);
            if ($rs) {
                $user->sms_otp = $activeCode;
                $user->sms_sent = !$user->sms_sent ? 1 : $user->sms_sent + 1;
                $user->save();
                break;
            }
            $i++;
        }

        Session::put('activeUser', $user->id);
    }

}