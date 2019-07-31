<?php

namespace App\Console;

use App\Console\Commands\ClearData;
use App\Console\Commands\DisableProduct;
use App\Console\Commands\ProductMapCreator;
use App\Console\Commands\RefreshProduct;
use App\Console\Commands\ResetDataDev;
use App\Console\Commands\SendTestEmail;
use App\Console\Commands\SiteMapGenerate;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        RefreshProduct::class,
        DisableProduct::class,
        ClearData::class,
        SiteMapGenerate::class,
        ProductMapCreator::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('product:auto_refresh')->everyMinute();
        $schedule->command('product:disable')->dailyAt('00:01');
        $schedule->command('map_generate:product')->dailyAt('00:01');
        $schedule->command('map_generate:post')->dailyAt('00:01');
        $schedule->command('sitemap:generate')->dailyAt('04:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
