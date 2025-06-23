<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\ExpireOrders::class,  // Register the ExpireOrders command
    ];

    protected function schedule(Schedule $schedule)
    {
        // Schedule the command to run every 10 minutes
        $schedule->command('expire:orders')->everyTenMinutes();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
