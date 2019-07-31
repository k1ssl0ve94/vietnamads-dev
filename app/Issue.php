<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Issue extends Model
{

    protected $hidden = [
        'deleted_at'
    ];

    protected $dates = [
        'deadline',
        'done_at',
        'first_response_at',
        'buy_off_at',
        'close_at',
        'assign_at',
    ];

    protected $appends = ['downtime'];

    protected $casts = [
        'tag' => 'array',
        'attachments' => 'array'
    ];

    public function source()
    {
        return $this->belongsTo('App\Setting', 'source', 'id');
    }

    public function system()
    {
        return $this->belongsTo('App\Setting', 'system', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Setting', 'product', 'id');
    }

    public function type()
    {
        return $this->belongsTo('App\Setting', 'type', 'id');
    }

    public function errorType()
    {
        return $this->belongsTo('App\Setting', 'error_type', 'id');
    }

    public function assignee()
    {
        return $this->belongsTo('App\User', 'assignee_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany('App\IssueLog', 'issue_id', 'id')->orderBy('type', 'desc')->orderBy('created_at', 'desc');
    }

    public function getDowntimeAttribute()
    {
        if ($this->deadline) {
            $deadline = new Carbon($this->deadline);

            return $deadline->diffInDays(Carbon::now()) . ' days';
        }

        return '';
    }
}
