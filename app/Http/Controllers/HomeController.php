<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Instalacion;
use App\Models\Message;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('programacion/programacion');
    }

    public function index2()
    {
        return view('/vendedor/vendedor');
    }

    public function index3()
    {
        $usuarioAutenticado = auth()->user();
        $usuarioId = $usuarioAutenticado->original;
        if (auth()->check()) {
            $usuarioAutenticado = auth()->user();
            $usuarioId = $usuarioAutenticado->id;

        } else {
            dd("No hay na");
         }
        return view('/instalador/instalador', [
            'usuario' => $usuarioAutenticado,
            'usuarioId' => $usuarioId,
        ]);
    }

    public function index4()
    {
        return view('/verificacion/verificacion');
    }
    public function getUserInst()
{
    $usuarioAutenticado = auth()->user();
    $usuarioId = $usuarioAutenticado->id;
    $instalaciones = Message::where('receiver_id', $usuarioId)->get();

    return response()->json(['instalaciones' => $instalaciones]);
}

    public function indexVendedor()
{
    return view('/vendedor/datosvendedor');
}
public function indexVendedor1()
{
    return view('/vendedor/tablaInstalador');
}

public function indexInstalador()
{
    return view('/instalador/instalador');
}
public function indexProgramacion()
{
    return view('/programacion/productos');
}
public function indeVerificacion()
{
    return view('/verificacion/verificacion');
}
}
