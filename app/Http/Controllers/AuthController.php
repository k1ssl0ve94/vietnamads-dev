<?php

namespace App\Http\Controllers;

use App\Lib\Email;
use App\Repositories\EsmsRepository;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Auth;
use Illuminate\Support\Facades\Session;
use Socialite;

class AuthController extends Controller
{
    protected $userRepo;
    protected $smsRepository;

    public function __construct(UserRepository $userRepo, EsmsRepository $esmsRepository)
    {
        $this->middleware('guest')->except(['logout','activate', 'activateSMS']);
        $this->userRepo = $userRepo;
        $this->smsRepository = $esmsRepository;
    }

    public function getNewCaptcha()
    {
        $type = \request('type', 1);
        if ($type && $type == 2) {
            $configName = 'captcha2';
        } else {
            $configName = 'captcha';
        }
        list($newCaptcha, $newHash) = UserRepository::getCaptchaData($configName);
        return [
            'newCaptcha' => $newCaptcha,
            'newHash' => $newHash,
        ];
    }

    public function register()
    {
        $validateArray = [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'city' => 'required',
            'last_name' => 'required',
            'name' => 'required',
            'phone' => 'required',
        ];
        $validateArray['g-recaptcha-response'] = 'required|captcha';
        $data = request()->validate($validateArray);
        $data = array_map('trim', $data);

        $data['activation_token'] = str_random(60);

        $user = $this->userRepo->addFrontendUser($data);
//        $credentials = request()->only('email', 'password');
        if ($user) {
            if ($user->phone) {
                $this->smsRepository->sendRegisterSMS($user);
            }
//            auth('web')->login($user, true);
            auth('web')->loginUsingId($user->id, true);
            return redirect()->route('profile', [
                'active_sms' => $user->phone ? 1 : 0,
            ]);
//            return ['status' => 1];
        }

        return [
            'status' => 0,
            'message' => 'Have some error, please try again.',
        ];
    }

    public function resendSmsCode(Request $request)
    {
        $this->validate($request, [
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'g-recaptcha-response.required' => 'Vui lòng xác nhận bạn không phải robot.',
            'g-recaptcha-response.captcha' => 'Vui lòng xác nhận bạn không phải robot.',
        ]);

        if (Session::has('activeUser')) {
            $user = $this->userRepo->getById(Session::get('activeUser'));
            if ($user && $user->sms_sent < 2) {
                $this->smsRepository->sendRegisterSMS($user);
                return response()->json([
                    'status' => true,
                ]);
            } else {
                return response()->json([
                   'status' => false,
                   'message' => 'Tài khoản không hợp lệ, hoặc bạn đã gửi SMS token quá 2 lần. Vui lòng liên hệ admin để kích hoạt bằng tay.',
                ]);
            }
        }
        return response()->json([
            'status' => false,
            'message' => 'Tài khoản không hợp lệ, hoặc bạn đã gửi SMS token quá 2 lần.',
        ]);
    }

    protected function sendEmailWelcome($user)
    {
        if (empty($user->email) || empty($user->activation_token)) {
            return;
        }

        Email::send([
            'template_id' => Email::TEMPLATE_WELCOME_ID, //'d-696ea1b47ae94bfa83e46e7ff9dc7ecb',
            'to_email' => $user->email,
            'to_name' => $user->name,
            'data' => [
                'name' => $user->name,
                'active_url' => route('activate', ['token' => $user->activation_token])
            ],
        ]);
    }

    public function login()
    {
        $this->validate(request(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = request()->only('email', 'password');

        if (auth('web')->attempt($credentials, true)) {
            return [
                'status' => 1,
                'message' => 'Đăng nhập thành công',
            ];
        }

        return [
            'status' => 0,
            'errors' => ['mật khẩu không chính xác hoặc bạn chưa kích hoạt tài khoản.'],
        ];
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }

    public function loginFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        $fbUser = Socialite::driver('facebook')->user();

        $user = $this->userRepo->getByFacebookID($fbUser->id, true);
        if ($user == null) {

            $user = $this->userRepo->getFrontendByEmail($fbUser->email);

            if ($user) {
                if ($user->facebook_id != $fbUser->id) {
                    $user->facebook_id = $fbUser->id;
                    $user->save();
                }
            } else {
                $data = [
                    'email' => $fbUser->email,
                    'facebook_id' => $fbUser->id,
                    'avatar' => $fbUser->avatar,
                    'name' => $fbUser->name,
                    'activated' => 1
                ];

                $user = $this->userRepo->addFrontendUser($data);
            }
        }

        if ($user->trashed()) {
            return redirect()->route('home');
        }

        auth('web')->login($user, true);

        return redirect()->route('home');
    }

    public function loginGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $gUser = Socialite::driver('google')->user();

        $user = $this->userRepo->getByGoogleID($gUser->id, true);

        // find by google id not found => find by email
        if ($user == null) {
            $user = $this->userRepo->getFrontendByEmail($gUser->email);
            if ($user && $user->google_id != $gUser->id) {
                $user->google_id = $gUser->id;
                $user->save();
            }
        }

        // user not found => create new one
        if ($user == null) {
            $data = [
                'email' => $gUser->email,
                'google_id' => $gUser->id,
                'avatar' => str_replace("sz=50", "sz=150", $gUser->avatar),
                'name' => $gUser->name,
                'activated' => 1
            ];

            $user = $this->userRepo->addFrontendUser($data);
        }

        if ($user->trashed()) {
            return redirect()->route('home');
        }

        auth('web')->login($user, true);
        return redirect()->route('home');
    }

    public function activate(Request $request, $token)
    {
        $type = $request->input('type', 'email');
        $user = $this->userRepo->findByActivationToken($token, $type);

        if (!$user) {
            if (\request()->isXmlHttpRequest()) {
                return response()->json([
                    'status' => 0
                ]);
            }
            return redirect()->route('home');
        }

        /** @var $user User */
        if ($type == 'email' && $user->isActivated()) {
            return redirect()->route('home');
        } elseif ($type == 'sms' && $user->isVerifiedPhone()) {
            return redirect()->route('home');
        }

        $dataUpdate = [
            'activated' => 1,
        ];
        if ($type == 'sms') {
            $dataUpdate['verified_phone'] = User::VERIFIED_PHONE_OK;
        }
        $this->userRepo->update($user, $dataUpdate);
        auth('web')->login($user, true);
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

        if (\request()->isXmlHttpRequest()) {
            return response()->json([
                'status' => 1
            ]);
        }
        return redirect()->route('profile');
    }

    public function requestForgotPassword(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'g-recaptcha-response' => 'required|captcha',
        ],[
            'g-recaptcha-response.required' => 'Vui lòng xác nhận bạn không phải robot.',
            'g-recaptcha-response.captcha' => 'Vui lòng xác nhận bạn không phải robot.',
        ]);

        $user = $this->userRepo->findFrontEndUserByEmail(request()->email);
        if (!$user) {
            return [
                'status' => 0,
                'errors' => ['Email not found'],
            ];
        }

        $pwToken = new \App\PasswordToken;
        $pwToken->user_id = $user->id;
        $pwToken->token = str_random(60);
        if ($pwToken->save()) {
            $this->sendEmailForgotPassword($user, $pwToken->token);
            return ['status' => 1];
        }

        return [
            'status' => 0,
            'errors' => ['Captcha is not valid. Please try again.'],
        ];
    }

    protected function sendEmailForgotPassword($user, $token)
    {
        if (empty($user->email)) {
            return;
        }

        Email::send([
            'template_id' => Email::TEMPLATE_FORGOT_PASSWORD, //'d-ee9cae1c07594c2187548f4b6d2a80e3',
            'to_email' => $user->email,
            'to_name' => $user->name,
            'data' => [
                'name' => $user->name,
                'button_url' => route('get-forgot-password', ['token' => $token])
            ],
        ]);
    }

    public function getForgotPassword($token = '')
    {
        return view('pages.forgot-password', compact('token'));
    }


    public function postForgotPassword()
    {
        request()->validate([
            'password' => 'required|min:5|confirmed',
            'token' => 'required',
        ]);

        $pwToken = \App\PasswordToken::where('token', request()->token)->first();
        if (!$pwToken) {
            return redirect()->back();
        }
        $user = $this->userRepo->getById($pwToken->user_id);
        if ($user) {
            $this->userRepo->update($user, ['password' => request()->password]);
            $pwToken->delete();
            // @TODO send mail change password done
            Email::send([
                'template_id' => Email::TEMPLATE_RESET_PASSWORD,
                'to_email' => $user->email,
                'to_name' => $user->name,
                'data' => [
                    'name' => $user->name,
                    'user' => $user->email,
                    'password' => request()->password,
                ],
            ]);
            return redirect()->back()->with('success', 'Đổi mật khẩu thành công, vui lòng đăng nhập lại');
        }
        return redirect()->back()->with('error', 'Đổi mật khẩu không thành công');
    }
}
