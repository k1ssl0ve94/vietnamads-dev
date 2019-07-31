<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetDataDev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset_data_dev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Data Dev';

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
        $this->info('DO NOTHING');
        // $this->line($this->description);
         $this->call('migrate:fresh');
         $this->call('db:seed');
    }
}
