<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class ventaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('user')->get();

        return response()->json($ventas);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'file1' => 'required|file|mimes:pdf,jpg,png',
            'file2' => 'required|file|mimes:pdf,jpg,png',
            'file3' => 'required|file|mimes:pdf,jpg,png',
            'ubicacion' => 'required',
            'nombre' => 'required',

        ]);

        $ineFile = $request->file('file1');
        $luzFile = $request->file('file2');
        $pagoFile = $request->file('file3');

        $inePath = $ineFile->store('archivos');
        $luzPath = $luzFile->store('archivos');
        $pagoPath = $pagoFile->store('archivos');

        $modelo = new Venta();
        $modelo->ine = $inePath;
        $modelo->luz = $luzPath;
        $modelo->pago = $pagoPath;
        $modelo->ubicacion = $request->input('ubicacion');
        $modelo->nombre = $request->input('nombre');
        $modelo->status = 1;
        $modelo->tipo = 1;

        \Log::info('===================================================== Archivos guardados para el comprador: ' . $modelo->nombre . '=====================================================');
        \Log::info('Archivo: ' . $ineFile . 'Ruta del archivo INE: ' . $inePath);
        \Log::info('Archivo: ' . $luzFile . 'Ruta del archivo Luz: ' . $luzPath);
        \Log::info('Archivo: ' . $pagoFile . 'Ruta del archivo Pago: ' . $pagoPath);

        $modelo->save();

        return response()->json(['message' => 'Registro guardado con éxito'], 201);
    }

    public function storeGPS(Request $request)
    {
        $modelo = new Venta();
        $modelo->ine = null;
        $modelo->luz = null;
        $modelo->pago = null;
        $modelo->nombre = $request->input('nombre');
        $modelo->ubicacion = $request->input('ubicacion');
        $modelo->status = 2;
        $modelo->tipo = 2;


        $modelo->save();

        $idVenta = $modelo->id;
        return response()->json(['id' => $idVenta, 'message' => 'Registro guardado con éxito'], 201);
    }

    public function update(Request $request, $id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            \Log::error('Registro no encontrado');
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'ine' => 'required|file|mimes:pdf,jpg,png',
            'luz' => 'required|file|mimes:pdf,jpg,png',
            'pago' => 'required|file|mimes:pdf,jpg,png',
        ]);

        $ineFile = $request->file('ine');
        $luzFile = $request->file('luz');
        $pagoFile = $request->file('pago');

        $inePath = $ineFile->store('archivos');
        $luzPath = $luzFile->store('archivos');
        $pagoPath = $pagoFile->store('archivos');

        \Log::info('===================================================== Archivos actualizados para el comprador: ' . $venta->nombre . '=====================================================');
        \Log::info('Archivo: ' . $ineFile . 'Ruta del archivo INE: ' . $inePath);
        \Log::info('Archivo: ' . $luzFile . 'Ruta del archivo Luz: ' . $luzPath);
        \Log::info('Archivo: ' . $pagoFile . 'Ruta del archivo Pago: ' . $pagoPath);

        $venta->ine = $inePath;
        $venta->luz = $luzPath;
        $venta->pago = $pagoPath;
        $venta->ubicacion = $request->input('ubicacion');
        $venta->nombre = $request->input('nombre');
        $venta->status = $request->input('status');
        $venta->save();

        return response()->json(['message' => 'Registro actualizado con éxito']);
    }

    public function updateStatus(Request $request, $id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return response()->json(['error' => 'Venta no encontrada'], 404);
        }
        $request->validate([
            'status' => 'required|in:0,1,2,3,4,5,6',
        ]);
        $venta->update($request->all());
        $venta->status = $request->input('status');
        $venta->save();


        return response()->json(['message' => 'Estado actualizado con éxito']);
    }

    public function destroy($id)
    {
        $venta = Venta::find($id);
        if (!$venta) {
            return response()->json(['error' => 'venta no encontrada'], 404);
        }

        $venta->delete();
        return response()->json(null, 204);
    }

    public function actualizarVenta($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->status = 3;
        $venta->save();

        return response()->json(['message' => 'Venta actualizada correctamente']);
    }
    public function actualizarVenta4($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->status = 4;
        $venta->save();

        return response()->json(['message' => 'Venta actualizada correctamente']);
    }

    public function actualizarVenta5($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->status = 5;
        $venta->save();

        return response()->json(['message' => 'Venta actualizada correctamente']);
    }

}

