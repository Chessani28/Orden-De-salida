<?php

use App\Http\Controllers\clientesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ventaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstalacionController;
use App\Http\Controllers\ProgramacionController;

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::group(['middleware' => ['role:programacion']], function () {
    Route::get('/programacion/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('admin');
    Route::get('/programacion/productos', [App\Http\Controllers\HomeController::class, 'indexProgramacion'])->name('admin_productos');
});

Route::group(['middleware' => ['role:vendedor']], function () {
    Route::get('/vendedor/vendedor', [App\Http\Controllers\HomeController::class, 'index2'])->name('home2');
    Route::get('/vendedor/datosvendedor', [App\Http\Controllers\HomeController::class, 'indexVendedor'])->name('datos_vendedor');
    Route::get('/vendedor/tablaInstalador', [App\Http\Controllers\HomeController::class, 'indexVendedor1'])->name('tabla_instalador');
});

Route::group(['middleware' => ['role:instalador']], function () {
    Route::get('/instalador/instalador', [App\Http\Controllers\HomeController::class, 'index3'])->name('home3');
    Route::get('/instalador/datosinstalador', [App\Http\Controllers\HomeController::class, 'indexInstalador'])->name('datos_instalador');
});

Route::group(['middleware' => ['role:verificacion']], function () {
    Route::get('/verificacion/verificacion', [App\Http\Controllers\HomeController::class, 'index4'])->name('home4');
    Route::get('/verificacion/datosverificacion', [App\Http\Controllers\HomeController::class, 'indexVerificacion'])->name('datos_verificacion');
});

Route::get('/api/getUserInst', [HomeController::class, 'getUserInst']);

//Route::post('/message/send',[MessageController::class,'sendMessage']);

//Route::post('/messages/{senderId}/{receiverId}',[MessageController::class,'getMessages'])->name('messages.get');

//Route::get('/download-pdf/archivos/{filename}', [PdfController::class, 'showPdf'])->name('show.pdf');
//Route::get('/~max4orsal/public/api/download-pdf/archivos/{filename}', [PdfController::class, 'showPdf'])->name('show.pdf');

Route::get('/download-pdf/archivos/{filename}', [PdfController::class, 'showPdf'])->name('show.pdf');


//Route::get('/api/ventas', [ventaController::class, 'index']); // Obtener todas las ventas

Route::prefix('/~max4orsal/public/api')->group(function () {
    Route::post('/venta', [ventaController::class, 'store'])->name('store');
    Route::get('/getUsers', [UserController::class, 'getUsers']);
    Route::get('/getUsers2', [UserController::class, 'getUserName2']);



    Route::get('/ventas', [VentaController::class, 'index']);
    Route::get('/ventas/{id}', [VentaController::class, 'show']);
    Route::post('/ventas', [VentaController::class, 'store']);
    Route::post('/ventase/{id}', [ventaController::class, 'update']);
    Route::delete('/ventas/{id}', [VentaController::class, 'destroy']);
    Route::post('/ventas/{id}/update-status', [ventaController::class, 'updateStatus']);
    Route::post('/ventasa', [VentaController::class, 'storeGPS']);
    Route::post('/actualizar-venta/{id}', [ventaController::class, 'actualizarVenta']);

    Route::post('/actualizar-venta4/{id}', [ventaController::class, 'actualizarVenta4']);

    Route::post('/actualizar-venta5/{id}', [ventaController::class, 'actualizarVenta5']);

    Route::get('/actualizar-status/{programacionId}', [ProgramacionController::class, 'actualizarStatus']);

    Route::get('/ejecutar-job/{programacionId}', [ProgramacionController::class, 'actualizarStatus']);

    Route::get('/instalacion', [InstalacionController::class, 'index']);
    Route::get('/instalacion/{id}', [InstalacionController::class, 'show']);
    Route::post('/instalacion', [InstalacionController::class, 'store']);
    Route::put('/instalacion/{id}', [InstalacionController::class, 'update']);
    Route::post('/instalaciones/{id}/actualizar-imagenes', [InstalacionController::class, 'updateImagenes'])->name('instalaciones.actualizar-imagenes');
    Route::delete('/instalacion/{id}', [InstalacionController::class, 'destroy']);
    Route::delete('/instalaciones/{id}/eliminar-imagen/{index}', [InstalacionController::class, 'eliminarImagen']);
    Route::get('/verificar-instalacion', [InstalacionController::class, 'verificar']);

    Route::get('/programacion', [ProgramacionController::class, 'index']);
    Route::get('/programacion/{id}', [ProgramacionController::class, 'show']);
    Route::post('/programacion', [ProgramacionController::class, 'store']);
    Route::put('/programacion/{id}', [ProgramacionController::class, 'update']);
    Route::put('/programacione/{id}', [ProgramacionController::class, 'update2']);
    Route::put('/programacionee/{id}', [ProgramacionController::class, 'update3']);
    Route::put('/programacioneee/{id}', [ProgramacionController::class, 'update4']);
    Route::put('/programacioneeee/{id}', [ProgramacionController::class, 'update5']);
    Route::put('/programacioneeeee/{id}', [ProgramacionController::class, 'update6']);
    Route::delete('/programacion/{id}', [ProgramacionController::class, 'destroy']);
    //Route::get('/programacion/{id}/getUserName', [ProgramacionController::class, 'getUserName']);
    Route::get('/programacion/{programacion}/instalaciones',[ InstalacionController::class, 'getInstalacionesPorProgramacion']);


    Route::get('/programaciones', [ProgramacionController::class, 'getUserName']);


    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('verarticulos', [InstalacionController::class, 'verarticulos']);
    Route::get('/programacion/{id}/ine', [ProgramacionController::class, 'getIne']);


    Route::get('/clientes', [clientesController::class, 'index']);
    Route::get('/clientes/{id}', [clientesController::class, 'show']);
    Route::post('/clientes', [clientesController::class, 'store']);
    Route::put('/clientes/{id}', [clientesController::class, 'update']);



    Route::get('/current-user', function () {
        return response()->json(['name' => Auth::user()->id]);
    })->middleware('auth');

});



//Route::get('/~max4orsal/public/api/getUsers', [UserController::class, 'getUsers']);
