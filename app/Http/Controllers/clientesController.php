<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;

class clientesController extends Controller
{
    public function index()
    {
        $articulos = Clientes::all();
        return response()->json($articulos);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required',
            'totventas' => 'required|integer',
            'ventasps' => 'required|integer',
            'ventagps' => 'required|integer',
            'calificacion' => 'required|integer',
        ]);

        $instalacion = new Clientes;
        $instalacion->nombre = $request->input('nombre');
        $instalacion->totventas = $request->input('totventas');
        $instalacion->ventasps = $request->input('ventasps');
        $instalacion->ventagps = $request->input('ventagps');
        $instalacion->calificacion = $request->input('calificacion');
        $instalacion->save();

        return response()->json(['message' => 'Registro de clientes creado con éxito'], 201);
    }
    public function update(Request $request, $id)
    {
        $Clientes = Clientes::find($id);
        if (!$Clientes) {
            return response()->json(['error' => 'Clientes no encontrada'], 404);
        }

        $data = $request->validate([
            'nombre' => 'required',
            'totventas' => 'required|integer',
            'ventasps' => 'required|integer',
            'ventagps' => 'required|integer',
            'calificacion' => 'required|integer',
        ]);

        $Clientes->update($data);
        return response()->json($Clientes, 200);
    }

    public function destroy($id)
    {
        $Clientes = Clientes::find($id);
        if (!$Clientes) {
            return response()->json(['error' => 'Clientes no encontrada'], 404);
        }

        $Clientes->delete();
        return response()->json(null, 204);
    }
}
