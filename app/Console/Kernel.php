<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The application's command schedule.
     *
     * @var \Illuminate\Console\Scheduling\Schedule
     */
    protected $commands = [
        \App\Console\Commands\GetWeather::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('get:weather')->hourly();
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