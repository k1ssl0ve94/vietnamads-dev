<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Brand extends Model
{
    protected $appends = [
        'logo_url',
    ];

    public function getLogoUrlAttribute()
    {
        return Storage::disk('public')->url('uploads/brands/' . $this->logo);
    }
}
