<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('chatbot:purge-logs')->dailyAt('02:30')->withoutOverlapping();
        $documents = escapeshellarg(public_path('archivos'));
        $schedule
            ->command("knowledge:import-directory {$documents} --limit=5 --index --only-referenced")
            ->everyTenMinutes()
            ->withoutOverlapping(120);
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
