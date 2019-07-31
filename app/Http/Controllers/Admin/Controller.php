<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Overwrite default validation response
//    protected function buildFailedValidationResponse(Request $request, array $errors)
//    {
//        $errorMessages = [];
//        foreach ($errors as $error) {
//            $errorMessages = array_merge($errorMessages, $error);
//        }
//        return response()->json([
//            'result' => false,
//            'message' => $errorMessages,
//        ], 422);
//    }
}
