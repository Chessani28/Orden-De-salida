<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Programacion;
use Illuminate\Support\Facades\Log;

class UpdateStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $programacionId;

    public function __construct($programacionId)
    {
        $this->programacionId = $programacionId;
    }

    public function handle()
    {
        $programaciones = Programacion::where('fecha_termino', '<', now())
            ->where('status', '!=', 5)
            ->get();

        foreach ($programaciones as $programacion) {
            $estadoAnterior = $programacion->status;
            $programacion->status = 6;
            $programacion->fecha_termino = null;
            $programacion->fecha_instalacion = null;
            $programacion->id_users = null;
            $programacion->save();
            if ($programacion->status != $estadoAnterior) {
                Log::info('Fecha de instalación pasada para programación: ' . $programacion->id);
            }
        }
    }
}
