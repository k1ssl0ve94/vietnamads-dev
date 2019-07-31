<?php
namespace App\Repositories;

use App\Product;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserRepository
{

    public function all()
    {
        return User::all();
    }

    public function addFrontendUser($data)
    {
        $data['group'] = config('user.group.frontend');
        return $this->add($data);
    }

    public function findByActivationToken($token, $type = 'email')
    {
        $builder = User::query();
        if ($type == 'sms') {
            $builder->where('sms_otp', $token);
        } else {
            $builder->where('activation_token', $type);
        }
        return $builder->first();
    }

    public function findFrontEndUserByEmail($email)
    {
        return User::where('email', $email)->where('group', config('user.group.frontend'))->first();
    }

    public function findFrontEndUserById($id)
    {
        return User::where('id', $id)->where('group', config('user.group.frontend'))->first();
    }

    public function add($data, $role = null)
    {
        $user = new User;

        $user->name = $data['name'];
        if (!empty($data['last_name'])) {
            $user->name = $data['last_name'] . ' '.$data['name'];
        }
        $user->email = $data['email'];

        if (isset($data['status'])) {
            $user->status = $data['status'];
        }
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if (isset($data['phone'])) {
            $user->phone = $data['phone'];
        }

        if (isset($data['avatar'])) {
            $user->avatar = $data['avatar'];
        }

        if (isset($data['facebook_id'])) {
            $user->facebook_id = $data['facebook_id'];
        }

        if (isset($data['google_id'])) {
            $user->google_id = $data['google_id'];
        }
        if (isset($data['activation_token'])) {
            $user->activation_token = $data['activation_token'];
        }

        $user->activated = 1;
        if (isset($data['activated'])) {
            $user->activated = $data['activated'];
        }

        if (isset($data['personal_id'])) {
            $user->personal_id = $data['personal_id'];
        }

        if (isset($data['company_id'])) {
            $user->company_id = $data['company_id'];
        }

        if (isset($data['point'])) {
            $user->point = intval($data['point']);
        }

        $user->group = $data['group'];

        if ($user->save()) {
            if ($role) {
                $user->syncRoles([$role->name]);
            } else {
                $user->syncRoles([]);
            }

            return $user;
        }

        return null;
    }

    public function getById($id)
    {
        return User::find($id);
    }

    public function delete($user)
    {
        $user->syncRoles([]);
//        $user->phone = '_rm.'.time();
//        $user->email .= '_deleted';
//        $user->save();
        Product::query()->where('user_id', $user->id)->update([
            'user_id' => 1,
        ]);
        return $user->forceDelete();
    }

    public function paginate($params = [], $with = [], $take = 20)
    {
        $query = User::query();
        if (!empty($params['keyword'])) {
            $query->where(function ($query) use ($params) {
                $query->where('name', 'like', '%' . $params['keyword'] . '%')
                    ->orWhere('phone', 'like', '%' . $params['keyword'] . '%')
                    ->orWhere('email', 'like', '%' . $params['keyword'] . '%');

                if (is_numeric($params['keyword'])) {
                    $query->orWhere('id', $params['keyword']);
                }
            });
        }
        if (!empty($params['type'])) {
            $query->where('type', $params['type']);
        }
        if (!empty($params['level'])) {
            $query->where('level', $params['level']);
        }
        if (!empty($params['department'])) {
            $query->where('department', $params['department']);
        }
        if (!empty($params['role'])) {
            $query->whereHas('roles', function ($query) use ($params) {
                $query->where('name', $params['role']);
            });
        }
        if (isset($params['status']) && $params['status'] !== '') {
            $query->where('status', $params['status']);
        }
        if (isset($params['group'])) {
            $query->where('group', $params['group']);
        }
        if (!empty($with)) {
            $query->with($with);
        }
        return $query->orderBy('id', 'desc')->paginate($take);
    }

    public function getAllByGroup($group)
    {
        return User::where('group', $group)->get();
    }

    public function count()
    {
        return User::count();
    }

    public function getByEmail($email)
    {
        return User::where('email', $email)->first();
    }
    public function getByPhone($value)
    {
        return User::where('phone', trim($value))->first();
    }

    public function getFrontendByEmail($email)
    {
        return User::where('group', config('user.group.frontend'))->where('email', $email)->first();
    }

    public function getByGoogleID($id, $withTrashed = false)
    {
        $query = User::query();

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->where('google_id', $id)->first();
    }

    public function getByFacebookID($id, $withTrashed = false)
    {
        $query = User::query();

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->where('facebook_id', $id)->first();
    }

    public function getByIds($ids)
    {
        return User::whereIn('id', $ids)->get();
    }

    public function updatePassword($user, $newPassword)
    {
        $user->password = Hash::make($newPassword);

        return $user->save();
    }

    public function update($user, $data, $role = null)
    {
        if (!empty($data['name'])) {
            $user->name = $data['name'];
        }

        if (!empty($data['email'])) {
            $user->email = $data['email'];
        }

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if (isset($data['level'])) {
            $user->level = $data['level'];
        }

        if (isset($data['type'])) {
            $user->type = $data['type'];
        }

        if (isset($data['status'])) {
            $user->status = $data['status'];
        }

        if (isset($data['note'])) {
            $user->note = $data['note'];
        }

        if (isset($data['department'])) {
            $user->department = $data['department'];
        }

        if (isset($data['phone'])) {
            $user->phone = $data['phone'];
        }

        if (isset($data['activated'])) {
            $user->activated = $data['activated'];
        }

        if (isset($data['personal_id'])) {
            $user->personal_id = $data['personal_id'];
        }

        if (isset($data['company_id'])) {
            $user->company_id = $data['company_id'];
        }

        if (isset($data['point'])) {
            $user->point = $data['point'];
        }

        if (isset($data['remain_point'])) {
            $user->remain_point = $data['remain_point'];
        }

        if (isset($data['promotion_point'])) {
            $user->promotion_point = $data['promotion_point'];
        }

        if (isset($data['unread_message'])) {
            $user->unread_message = $data['unread_message'];
        }

        if (isset($data['sms_otp'])) {
            $user->sms_otp = $data['sms_otp'];
        }

        if (isset($data['verified_phone'])) {
            $user->verified_phone = $data['verified_phone'];
        }
        if (isset($data['verified_by_admin'])) {
            $user->verified_by_admin = $data['verified_by_admin'] ? 1 : 0;
        }

//        if ($role && $role->id > 2) {
//            $user->password = '';
//        }

        if ($role) {
            $user->syncRoles([$role->name]);
        } else {
            $user->syncRoles([]);
        }

        return $user->save();
    }

    public function decreasePoint($user, $amount, $isUsePromotion = false)
    {
        if ($isUsePromotion && $user->promotion_point > 0) {
            if ($user->promotion_point >= $amount) {
                $user->promotion_point = $user->promotion_point - $amount;
            } else {
                $remain = $amount - $user->promotion_point;
                $user->promotion_point = 0;
                $user->remain_point -= $remain;
            }
        } else {
            $user->remain_point -= $amount;
        }
        if ($user->remain_point < 0) {
            $user->remain_point = 0;
        }
        $user->used_point += intval($amount);

        return $user->save();
    }

    public function countByRange($from = null, $to = null)
    {
        $query = User::query();
        if ($from) {
            $query->where('created_at', '>=', $from);
        }

        if ($to) {
            $query->where('created_at', '<=', $to);
        }

        return $query->count();
    }

    public static function getCaptchaData($configName = 'captcha')
    {
        $captchaArr = config($configName);
        $captchaArrKeys = array_keys($captchaArr);
        $captchaIndex = rand(0, count($captchaArr) - 1);
        $selectedCaptcha = $captchaArrKeys[$captchaIndex];
        $captchaHash = md5($captchaArr[$selectedCaptcha].env('JWT_SECRET'));
        Session::put($configName.'_key', $selectedCaptcha);
        return [
          url("images/$configName/".$selectedCaptcha),
          $captchaHash,
        ];
    }

    public static function isValidCaptcha($captchaValue, $configName = 'captcha')
    {
        $captchaArr = config($configName);
        if (!Session::has($configName.'_key')) {
            return false;
        }
        $selectedCaptcha = Session::get($configName.'_key');
        if (!isset($captchaArr[$selectedCaptcha])
            || $captchaValue != $captchaArr[$selectedCaptcha]) {
            return false;
        }
        return true;
    }

    public static function clearCaptchaData($configName = 'captcha')
    {
        Session::remove($configName.'_key');
    }
}