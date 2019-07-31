<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Crypt;

class IssueCancel extends Mailable
{
    use Queueable, SerializesModels;

    public $issue;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($issue, $name)
    {
        $this->issue = $issue;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your order has been canceled #' . $this->issue->id)
                    ->view('emails.issue-cancel');
    }
}
