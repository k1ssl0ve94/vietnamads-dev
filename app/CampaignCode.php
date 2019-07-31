<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class CampaignCode extends Model
{
    protected $table = 'campaign_codes';

    protected $fillable = [
        'code', 'campaign_id', 'value', 'valid_times', 'used_times', 'from_date', 'end_date',
        'status',
    ];

    const STATUS_RUNNING = 1;
    const STATUS_USED = 2;
    const STATUS_CANCEL = 3;
}