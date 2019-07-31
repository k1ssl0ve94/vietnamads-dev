<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClearData extends Command
{
    protected $signature = 'clear_data_init';
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        DB::raw("SET FOREIGN_KEY_CHECKS = 0;");
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            if ('migrations' != $table->Tables_in_vnads) {
                DB::table($table->Tables_in_vnads)->truncate();
                Log::info("truncate table ".$table->Tables_in_vnads);
            }
        }
        $this->call('config:clear');
        $this->call('config:cache');

        $this->call('db:seed', [
            '--class' => 'UserSeeder',
        ]);

        $this->call('db:seed', [
            '--class' => 'CategorySeeder',
        ]);
        $this->call('db:seed', [
            '--class' => 'RolesAndPermissionsSeeder',
        ]);

        $this->call('db:seed', [
            '--class' => 'SettingsSeeder',
        ]);
        Log::info("Db seeder done");
    }
}