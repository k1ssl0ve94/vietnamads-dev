<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';

    protected $fillable = [
        'user_id', 'type', 'mode', 'date', 'product_id', 'service_id', 'option_id',
        'point', 'discount', 'created_by', 'updated_by', 'status',
        'active_days', 'created_by', 'updated_by', 'from', 'to', 'note', 'promotion_point'
    ];

    const TYPE_SUB = 1;
    const TYPE_ADD = 2;

    const MODE_ACTIVE = 1;
    const MODE_EXTEND = 2;
    const MODE_CANCEL = 3;
    const MODE_REFRESH = 4;
    const MODE_ADMIN = 5;
    const MODE_VNPAY = 6;
    const MODE_GIFT_CODE = 7;

    const STATUS_DONE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_PENDING = 3;
    const STATUS_CANCEL = 4;
    const STATUS_PREPARE = 5;

    public function getModeLabel()
    {
        switch ($this->mode){
            case self::MODE_ADMIN:
                return 'Admin';
                break;
            case self::MODE_REFRESH:
                return 'Làm mới';
                break;
            case self::MODE_EXTEND:
                return 'Gia hạn';
                break;
            case self::MODE_ACTIVE:
                return 'Kích hoạt tin';
                break;
            case self::MODE_CANCEL:
                return 'Hủy bỏ';
                break;
            case self::MODE_VNPAY:
                return 'VNPAY';
                break;
            case self::MODE_GIFT_CODE:
                return 'Gift code';
                break;
            default:
                return '';
        }
    }

    public function getTypeLabel()
    {
        if ($this->type == self::TYPE_SUB){
            return 'Thanh toán';
        } else {
            return 'Hoàn trả/Nạp';
        }
    }

    public function getStatusLabel()
    {
        switch ($this->status){
            case self::STATUS_CANCEL:
                return 'Hủy bỏ';
                break;
            case self::STATUS_DONE:
                return 'Hoàn thành';
                break;
            case self::STATUS_PENDING:
                return 'Đang giao dịch';
                break;
            case self::STATUS_PREPARE:
                return 'Chuẩn bị giao dịch';
                break;
            default:
                return '';
        }
    }
    public function getStatusClass()
    {
        switch ($this->status){
            case self::STATUS_CANCEL:
                return 'badge-cancel';
                break;
            case self::STATUS_DONE:
                return 'badge-success';
                break;
            case self::STATUS_PENDING:
                return 'badge-danger';
                break;
            default:
                return '';
        }
    }

    public static function getTypeList()
    {
        return [
            self::TYPE_SUB => [
                'value' => self::TYPE_SUB,
                'label' => 'Thanh toán',
            ],
            self::TYPE_ADD => [
                'value' => self::TYPE_ADD,
                'label' => 'Hoàn trả/ Nạp',
            ],
        ];
    }

    public static function getModeList()
    {
        return [
            self::MODE_VNPAY => [
                'value' => self::MODE_VNPAY,
                'label' => 'VNPAY',
            ],
            self::MODE_CANCEL => [
                'value' => self::MODE_CANCEL,
                'label' => 'Hủy bỏ',
            ],
            self::MODE_ACTIVE => [
                'value' => self::MODE_ACTIVE,
                'label' => 'Kích hoạt',
            ],
            self::MODE_EXTEND => [
                'value' => self::MODE_EXTEND,
                'label' => 'Gia hạn',
            ],
            self::MODE_REFRESH => [
                'value' => self::MODE_REFRESH,
                'label' => 'Làm mới',
            ],
            self::MODE_ADMIN => [
                'value' => self::MODE_ADMIN,
                'label' => 'Admin',
            ],
        ];
    }

    public function toArray()
    {
        return parent::toArray() + [
                'typeLabel' => $this->getTypeLabel(),
                'modeLabel' => $this->getModeLabel(),
                'statusLabel' => $this->getStatusLabel(),
                'statusClass' => $this->getStatusClass(),
            ];
    }
}