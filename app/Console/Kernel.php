<?php

namespace App\Console;

use App\Jobs\UpdateStatusJob;
use App\Models\Programacion;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {

            $programaciones = Programacion::all();

            foreach ($programaciones as $programacion) {
                if (now() > $programacion->fecha_termino) {
                    UpdateStatusJob::dispatch($programacion->id);
                }
            }

        })->dailyAt('16:00');
    }
//->dailyAt('00:00');
//->everyMinute();

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
