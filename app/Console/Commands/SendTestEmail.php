<?php

namespace App\Console\Commands;

use App\Lib\Email;
use Illuminate\Console\Command;

class SendTestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Email::send([
            'template_id' => Email::TEMPLATE_WELCOME_ID,
            'to_email' => env('EMAIL_FIX_TO', 'nguyenvanvu028@gmail.com'),
            'to_name' => 'Nguyen Van Vu',
            'data' => [
                'name' => 'Vu',
                'active_url' => 'http://vietnamads.vn/'
            ],
        ]);
    }
}
