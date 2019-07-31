<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaign';

    protected $fillable = [
        'title', 'prefix', 'number_codes', 'value', 'used_codes', 'from_date', 'end_date',
        'status', 'created_by', 'updated_by',
    ];

    const STATUS_RUNNING = 1;
    const STATUS_CLOSE = 2;
}