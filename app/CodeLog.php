<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class CodeLog extends Model
{
    protected $table = 'code_logs';

    protected $fillable = [
        'campaign_id', 'code_id', 'user_id', 'created_by',
    ];

}