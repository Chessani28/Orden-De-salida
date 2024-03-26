<?php

namespace App\Http\Controllers;

use App\Models\Articulos;
use App\Models\Instalacion;
use Illuminate\Http\Request;

class InstalacionController extends Controller
{

    public function index()
    {
        $Instalacions = Instalacion::with('user')->get();

        return response()->json($Instalacions);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_programacion' => 'required',
            'img.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|integer',
            'id_venta' => 'required|integer',
        ]);

        $instalacion = new Instalacion;
        $instalacion->id_programacion = $request->input('id_programacion');
        $instalacion->img = $request->input('img');
        $instalacion->status = $request->input('status');
        $instalacion->id_venta = $request->input('id_venta');
        $instalacion->save();



        return response()->json(['message' => 'Registro de instalación creado con éxito'], 201);
    }

    public function updateImagenes(Request $request, $id)
    {
        $request->validate([
            'img.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp,tiff,tif,bmp,ico|max:2048',
        ]);

        $instalacion = Instalacion::findOrFail($id);

        if ($request->hasFile('img')) {
            $nuevasImagenes = $request->file('img');
            $imagenesGuardadas = [];

            foreach ($nuevasImagenes as $imagen) {
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('Imagenes'), $nombreImagen);
                $imagenesGuardadas[] = asset('Imagenes/' . $nombreImagen);
            }

            $imagenesExistentes = explode(',', $instalacion->img);
            $imagenesFinales = array_merge($imagenesExistentes, $imagenesGuardadas);

            $imagenesActualizadas = implode(',', $imagenesFinales);

            $instalacion->img = $imagenesActualizadas;
        }

        $instalacion->save();

        return response()->json(['message' => 'Imágenes actualizadas con éxito']);
    }

    public function show($id)
    {
        $Instalacion = Instalacion::find($id);
        if (!$Instalacion) {
            return response()->json(['error' => 'Instalacion no encontrada'], 404);
        }
        return response()->json($Instalacion);
    }

    public function update(Request $request, $id)
    {
        $Instalacion = Instalacion::find($id);
        if (!$Instalacion) {
            return response()->json(['error' => 'Instalacion no encontrada'], 404);
        }

        $data = $request->validate([
            'id_programacion' => 'required',
            'img.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|integer',
            'id_venta' => 'required|integer',
        ]);

        $Instalacion->update($data);
        return response()->json($Instalacion, 200);
    }

    public function destroy($id)
    {
        $Instalacion = Instalacion::find($id);
        if (!$Instalacion) {
            return response()->json(['error' => 'Instalacion no encontrada'], 404);
        }

        $Instalacion->delete();
        return response()->json(null, 204);
    }
    public function getInstalacionesPorProgramacion($id_programacion)
{
    $instalaciones = Instalacion::where('id_programacion', $id_programacion)->get();

    return response()->json($instalaciones);
}
public function eliminarImagen($id, $index)
{
    $instalacion = Instalacion::findOrFail($id);

    $imagenes = explode(',', $instalacion->img);

    if (isset($imagenes[$index])) {
        unset($imagenes[$index]);

        $instalacion->img = implode(',', $imagenes);

        $instalacion->save();
    }
    return response()->json(['nuevasImagenes' => $imagenes]);
}

}
