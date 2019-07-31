<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Storage;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    // protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'avatar', 'facebook_id', 'google_id',
        'city', 'status', 'group', 'activated', 'activation_token', 'remember_token',
        'personal_id', 'company_id', 'last_name', 'point', 'used_point', 'level',
        'level_apply_date', 'level_end_date', 'unread_message', 'type', 'sms_otp', 'sms_sent',
        'active_time', 'verified_phone', 'verified_by_admin',
    ];

    const LEVEL_NORMAL = 1;
    const LEVEL_VIP = 2;

    const TYPE_NORMAL = 1;
    const TYPE_AGENCY = 2;
    const TYPE_PARTNER = 3;

    const VERIFIED_PHONE_OK = 1;
    const VERIFIED_PHONE_NOK = 0;

    protected $typeLabels = [
        self::TYPE_NORMAL => 'Khách hàng',
        self::TYPE_AGENCY => 'Cộng tác viên',
        self::TYPE_PARTNER => 'Đối tác',
    ];

    public function getTypeArray()
    {
        return $this->typeLabels;
    }

    public function getLevelArray()
    {
        return [
            self::LEVEL_NORMAL => 'Thông thường',
            self::LEVEL_VIP => 'VIP',
        ];
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'deleted_at'
    ];

    protected $dates = ['deleted_at'];

    protected $appends = ['fullname'];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAvatarUrl()
    {
        if (empty($this->avatar)) {
            return asset('imgs/img_placeholder.png');
        } else if (strpos($this->avatar, 'http') !== FALSE) {
            return $this->avatar;
        }
        return Storage::disk('public')->url('uploads/avatars/' . $this->avatar);
    }

    public function isActivated()
    {
        return !!$this->activated;
    }

    public function getFullnameAttribute()
    {
        return $this->last_name  . ' ' . $this->name;
    }

    public function isVerifiedPhone()
    {
        return $this->verified_phone == self::VERIFIED_PHONE_OK;
    }
}
