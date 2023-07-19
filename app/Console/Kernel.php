<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\PlayerMissedVocabularyProcess;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // this should be running through supervisor
        // $schedule->command('queue:work --once')
        //                 ->appendOutputTo(storage_path() . '/logs/scheduler-output.log');
        
        // $schedule->job(new PlayerMissedVocabularyProcess)
        //             ->everyMinute()
        //                 ->appendOutputTo(storage_path() . '/logs/scheduler-output.log');
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
