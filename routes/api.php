<?php

use App\Http\Controllers\clientesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstalacionController;
use App\Http\Controllers\mensajeController;
use App\Http\Controllers\ProgramacionController;
use App\Http\Controllers\SolicitudInstalacionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ventaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/venta', [ventaController::class, 'store'])->name('store');

Route::get('/ventas', [VentaController::class, 'index']);
Route::get('/ventas/{id}', [VentaController::class, 'show']);
Route::post('/ventas', [VentaController::class, 'store']);
Route::post('/ventasa', [VentaController::class, 'storeGPS']);

Route::post('/ventase/{id}', [ventaController::class, 'update']);
Route::delete('/ventas/{id}', [VentaController::class, 'destroy']);

Route::post('/ventas/{id}/update-status', [ventaController::class, 'updateStatus']);

Route::post('/actualizar-venta/{id}', [ventaController::class, 'actualizarVenta']);

Route::post('/actualizar-venta4/{id}', [ventaController::class, 'actualizarVenta4']);

Route::post('/actualizar-venta5/{id}', [ventaController::class, 'actualizarVenta5']);


Route::get('/instalacion', [InstalacionController::class, 'index']);
Route::get('/instalacion/{id}', [InstalacionController::class, 'show']);
Route::post('/instalacion', [InstalacionController::class, 'store']);
Route::put('/instalacion/{id}', [InstalacionController::class, 'update']);

Route::post('/instalaciones/{id}/actualizar-imagenes', [InstalacionController::class, 'updateImagenes'])->name('instalaciones.actualizar-imagenes');

Route::delete('/instalacion/{id}', [InstalacionController::class, 'destroy']);

Route::delete('/instalaciones/{id}/eliminar-imagen/{index}', [InstalacionController::class, 'eliminarImagen']);


Route::get('/verificar-instalacion', [InstalacionController::class, 'verificar']);


/* Mensajes
Route::get('/messages', [mensajeController::class, 'index']);
//Route::get('/getMessagesByUser/{userId}', [UserController::class, 'getMessagesByUser']);
//Route::post('/sendMessage', [UserController::class, 'sendMessage']);


Route::get('/getUser',[HomeController::class,'getUserInst']);
Route::get('/instalaciones', [HomeController::class, 'getInstalaciones']);
Route::get('/getUserName/{userId}', 'UserController@getUserName');
Route::get('/getUserName/{userId}',[UserController::class,'getUserName']);
*/

Route::get('max4orsal/public/getUsers', [UserController::class, 'getUsers']);
Route::get('/actualizar-status/{programacionId}', [ProgramacionController::class, 'actualizarStatus']);

Route::get('/ejecutar-job/{programacionId}', [ProgramacionController::class, 'actualizarStatus']);


//Route::get('/sacaruser',[UserController::class,'Sacaeluser']);

Route::get('/programacion', [ProgramacionController::class, 'index']);
Route::get('/programacion/{id}', [ProgramacionController::class, 'show']);
Route::post('/programacion', [ProgramacionController::class, 'store']);
Route::put('/programacion/{id}', [ProgramacionController::class, 'update']);
Route::put('/programacione/{id}', [ProgramacionController::class, 'update2']);
Route::post('/programacionee/{id}', [ProgramacionController::class, 'update3']);
Route::put('/programacioneee/{id}', [ProgramacionController::class, 'update4']);
Route::put('/programacioneeee/{id}', [ProgramacionController::class, 'update5']);
Route::delete('/programacion/{id}', [ProgramacionController::class, 'destroy']);
Route::put('/programacioneeeee/{id}', [ProgramacionController::class, 'update6']);

//Route::get('/programacion/{id}/getUserName', [ProgramacionController::class, 'getUserName']);

Route::get('/programacion/{programacion}/instalaciones',[ InstalacionController::class, 'getInstalacionesPorProgramacion']);


Route::get('/programaciones', [ProgramacionController::class, 'getUserName']);



Route::get('/clientes', [clientesController::class, 'index']);
Route::get('/clientes/{id}', [clientesController::class, 'show']);
Route::post('/clientes', [clientesController::class, 'store']);
Route::put('/clientes/{id}', [clientesController::class, 'update']);


Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();


});

   Route::get('verarticulos', [InstalacionController::class, 'verarticulos']);

   Route::get('/programacion/{id}/ine', [ProgramacionController::class, 'getIne']);

   Route::get('/current-user', function () {
    return response()->json(['name' => Auth::user()->name]);
})->middleware('auth');
