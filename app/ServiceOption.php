<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class ServiceOption extends Model
{
    protected $table = 'service_options';

    protected $fillable = [
        'service_id', 'option_id', 'created_by', 'updated_by',
    ];
}