<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Crypt;

class IssueDone extends Mailable
{
    use Queueable, SerializesModels;

    public $issue;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($issue)
    {
        $this->issue = $issue;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $token = Crypt::encryptString($this->issue->id);
        $url = url("/feedback-issue/${token}");

        return $this->subject('Issue #' . $this->issue->id . ' id done')
                    ->view('emails.issue-done')
                    ->with([
                        'url' => $url,
                    ]);
    }
}
