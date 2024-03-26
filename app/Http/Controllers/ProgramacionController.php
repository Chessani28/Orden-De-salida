<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateStatusJob;
use App\Models\Programacion;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProgramacionController extends Controller
{
    public function index()
    {
        $programaciones = Programacion::with('venta','users')->get();

        return response()->json(['programaciones' => $programaciones]);


    }

    public function store(Request $request)
    {
        $idprogramacion = $request->input('id_venta');
        $fechaInstalacion = $request->input('fecha_instalacion');
        $fecha_termino = $request->input('fecha_termino');
        $status = $request->input('status');

        $modelo = new Programacion();
        $modelo->id_venta = $idprogramacion;
        $modelo->fecha_instalacion = $fechaInstalacion;
        $modelo->fecha_termino = $fecha_termino;
        $modelo->id_users = null;
        $modelo->status = 1;
        $modelo->save();

        return response()->json(['message' => 'Registro de Programacion creado con éxito']);
    }
    public function show($id)
    {
        $programacion = Programacion::find($id);
        if (!$programacion) {
            return response()->json(['error' => 'Programacion no encontrada'], 404);
        }
        return response()->json($programacion);
    }

    public function update(Request $request, $id) //Aceptar
    {
        $venta = Programacion::find($id);

        if (!$venta) {
            return response()->json(['error' => 'Venta no encontrada'], 404);
        }
        $programacion = $request->all();
        $programacion['status'] = 3;

        $venta->update($programacion);

        return response()->json($venta, 200);
    }

    public function update2(Request $request, $id) //Cancelar
    {
        $venta = Programacion::find($id);

        if (!$venta) {
            return response()->json(['error' => 'Venta no encontrada'], 404);
        }

        $programacion = $request->all();
        $programacion['status'] = 0;
        $programacion['fecha_instalacion'] = null;
        $programacion['fecha_termino'] = null;
        $programacion['id_users'] = null;


        $venta->update($programacion);

        return response()->json($venta, 200);
    }

    public function update3(Request $request, $id)
    {
        $programacion = Programacion::find($id);

        if (!$programacion) {
            return response()->json(['error' => 'Programación no encontrada'], 404);
        }

        $datosProgramacion = $request->all();
        $datosProgramacion['status'] = 2;
        $programacion->update($datosProgramacion);

        return response()->json($programacion, 200);
    }



    public function update4(Request $request, $id) //Principal
    {
        $venta = Programacion::find($id);

        if (!$venta) {
            return response()->json(['error' => 'Venta no encontrada'], 404);
        }

        $programacion = $request->all();
        $programacion['status'] = 4;

        $venta->update($programacion);

        return response()->json($venta, 200);
    }

    public function update5(Request $request, $id)
    {
        $venta = Programacion::find($id);

        if (!$venta) {
            Log::error('Venta no encontrada para el ID: ' . $id);
            return response()->json(['error' => 'Venta no encontrada'], 404);
        }

        try {
            $programacion = $request->all();
            $programacion['status'] = 4;

            $venta->update($programacion);
            return response()->json($venta, 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar la venta para el ID: ' . $id . ' - ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }
    public function update6(Request $request, $id)
    {
        $venta = Programacion::find($id);

        if (!$venta) {
            Log::error('Venta no encontrada para el ID: ' . $id);
            return response()->json(['error' => 'Venta no encontrada'], 404);
        }

        try {
            $programacion = $request->all();
            $programacion['status'] = 5;

            $venta->update($programacion);

            return response()->json($venta, 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar la venta para el ID: ' . $id . ' - ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function destroy($id)
    {
        $programacion = Programacion::find($id);
        if (!$programacion) {
            return response()->json(['error' => 'Programacion no encontrada'], 404);
        }

        $programacion->delete();
        return response()->json(null, 204);
    }

    public function getUserName()
{
    $programaciones = Programacion::with('users')->get();

    return response()->json($programaciones);
}

    public function getIne($id)
    {
        try {
            $programacion = Programacion::findOrFail($id);
            return response()->json(['ine' => $programacion->venta->ine]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se encontraron datos'], 404);
        }
    }
public function guardarProgramacion(Request $request, $idVenta)
{

    $programacion = new Programacion([
        'id_venta' => $idVenta,
    ]);

    $programacion->save();

    $venta =  Venta::find($idVenta);
    $venta->status = 4;
    $venta->save();

}
public function actualizarStatus($programacionId)
{
    dispatch(new UpdateStatusJob($programacionId));

    return response()->json(['message' => 'Job encolado para actualizar el status.']);
}

}
