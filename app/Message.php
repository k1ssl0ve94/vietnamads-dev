<?php

namespace App;


use App\Events\MessageEvent;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'from_user', 'to_user', 'content', 'status', 'product_id',
    ];

    protected $dispatchesEvents = [
        'saved' => MessageEvent::class,
    ];

    const STATUS_NEW = 1;
    const STATUS_READ = 2;
}