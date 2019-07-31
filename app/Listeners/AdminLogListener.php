<?php

namespace App\Listeners;

use App\Events\AdminLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\LogRepository;

class AdminLogListener
{
    protected $logRepo;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(LogRepository $logRepo)
    {
        $this->logRepo = $logRepo;
    }

    /**
     * Handle the event.
     *
     * @param  AdminLog  $event
     * @return void
     */
    public function handle(AdminLog $event)
    {
        $this->logRepo->add($event->data);
    }
}
