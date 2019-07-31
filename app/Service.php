<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $fillable = [
        'name', 'title_color', 'parameter_color', 'price_color', 'fee_point',
        'icon', 'min_days', 'images_number', 'max_content', 'max_title', 'allow_sms',
        'allow_promotion', 'allow_management', 'allow_send_author', 'created_by', 'updated_by',
        'manual_refresh', 'auto_refresh', 'backup_time', 'direct_link', 'priority',
        'display_in_search', 'display_in_trend', 'display_in_tags', 'refresh_fee',
        'auto_active', 'edit_times', 'keep_alive', 'vip_only',
    ];

}