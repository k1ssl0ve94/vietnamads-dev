<?php

namespace App\Events;


use App\Message;

class MessageEvent extends Event
{
    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }
}