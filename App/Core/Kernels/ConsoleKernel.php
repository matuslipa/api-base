<?php

declare(strict_types=1);

namespace App\Core\Kernels;

use function base_path;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as FrameworkKernel;

class ConsoleKernel extends FrameworkKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(base_path('App/Core/Commands'));

        require base_path('routes/console.php');
    }
}
