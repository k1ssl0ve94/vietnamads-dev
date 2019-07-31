<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class DayOption extends Model
{
    protected $table = 'day_options';

    protected $fillable = [
        'name', 'days', 'created_by', 'updated_by',
    ];

}