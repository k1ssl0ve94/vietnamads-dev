<?php

namespace App\Lib;

use Illuminate\Support\Facades\Log;
use SendGrid\Mail\Mail;
use SendGrid;

class Email
{
    const TEMPLATE_TRANSACTION_INFO_ID = 'd-5b580d10f3144f34bf99958a97a184df';
    const TEMPLATE_WELCOME_ID = 'd-696ea1b47ae94bfa83e46e7ff9dc7ecb';
    const TEMPLATE_PAYMENT_SUCCESS = 'd-eac06ffdba014f47815fd5628955ab77';
    const TEMPLATE_PAYMENT_CANCEL = 'd-1589e2c22e4449d2a9fd7697e46b2fff';
    const TEMPLATE_PAYMENT_PENDING = 'd-a0f2ca2ede944d36b1c02b5f6fa53591';
    const TEMPLATE_ADD_MONEY = 'd-09c0a9ef730e42f2b1794b6b6560c6b6';
    const TEMPLATE_RESET_PASSWORD = 'd-d4704ee532b040e7a4437df9ddb5dc8f';
    const TEMPLATE_FORGOT_PASSWORD = 'd-ee9cae1c07594c2187548f4b6d2a80e3';
    const TEMPLATE_REGISTER = 'd-696ea1b47ae94bfa83e46e7ff9dc7ecb';

    public static function send($params)
    {
        $email = new Mail();
        $email->setFrom("noreply@vietnamads.vn", "VietnamAds");
        if (env('EMAIL_FIX_TO')) {
            $email->addTo(env('EMAIL_FIX_TO'), $params['to_name']);
        } else {
            $email->addTo($params['to_email'], $params['to_name']);
        }

        $email->setTemplateId($params['template_id']);
        if (!empty($params['data'])) {
            foreach ($params['data'] as $key => $value) {
                $email->addDynamicTemplateData($key, $value);
            }
        }
        $apiKey = "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"; //env('SENDGRID_API_KEY');
//        Log::info("API KEY: ".$apiKey);
        $sendgrid = new SendGrid($apiKey);
        try {
            $response = $sendgrid->send($email);
//            Log::info($response->statusCode());
//            Log::info($response->body());
            return $response->statusCode();
        } catch (Exception $e) {
            Log::error('Caught exception: ' . $e->getMessage());
            return 0;
        }
    }
}