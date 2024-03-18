<?php

namespace App\Console;

use App\Modules\Currencies\Commands\UpdateRates;
use App\Modules\Currencies\Sources\SourceEnum;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
         $schedule->command(UpdateRates::class, [SourceEnum::Cbrf->value])->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

//        require base_path('routes/console.php');
    }
}
