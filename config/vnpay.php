<?php
return [
    'tmnCode' => env('VNP_TMN_CODE', 'LONGANH1'),
    'hashSecret' => env('VNP_HASH', 'GUFMCHDGODZCFJFRXDOIIWEDUBNHKDTU'),
    'url' => env('VNP_URL', 'https://pay.vnpay.vn/vpcpay.html'),
    'callback' => env('VNP_CALLBACK', 'https://www.vietnamads.vn/payment/callback'),
    'language' => 'vn',
    'version' => '2.0.0',
    'rate' => 100,
];