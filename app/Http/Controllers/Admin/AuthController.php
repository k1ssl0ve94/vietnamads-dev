<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use App\Repositories\UserRepository;

class AuthController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function login(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credential['group'] = config('user.group.backend');

        if ($token = auth('api')->attempt($credential)) {
            $user = auth('api')->user();
            if ($user->status == 1) {
                event(new \App\Events\AdminLog([
                    'admin_id' => $user->id,
                    'action' => 'login',
                ]));

                return response()->json([
                    'user' => auth('api')->user()->toArray(),
                    'token' => $token,
                ]);
            } else {
                return response()->json([
                    'errors' => ['Your account has been suspended'],
                ]);
            }

        }

        return response()->json([
            'errors' => ['Email or password is incorrect.'],
        ]);
    }
}
