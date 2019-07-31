<?php

namespace App\Validators;

use GuzzleHttp\Client;
use Log;

class ReCaptcha
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $client = new Client();

        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'form_params' => [
                    'secret' => env('RECAPTCHA_SECRET_KEY'),
                    'response' => $value
                ]
            ]
        );

        Log::debug((string)$response->getBody());

        $body = json_decode((string)$response->getBody(), true);

        if (!$body['success'] && !empty($body['error-codes']) && $body['error-codes'][0] == 'timeout-or-duplicate') {
            return true;
        }

        return $body['success'];
    }
}