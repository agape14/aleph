<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProgenitorController;
use App\Http\Controllers\SolicitudController;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return view('auth.login');
})->name("login");
Route::get('/', function () {
    return view('index', [
        'formTimeout' => env('FORM_TIMEOUT', 300),
        'formAlertTime' => env('SESSION_LIFETIME', 240),
    ]);
});

Auth::routes();

//User Routes
Route::middleware(['auth','user-role:user'])->group(function()
{
    Route::get("/home",[App\Http\Controllers\HomeController::class, 'userHome'])->name("home");
});

//Admin Routes
Route::middleware(['auth','user-role:admin'])->group(function()
{
    Route::get("/admin/home",[App\Http\Controllers\HomeController::class, 'adminHome'])->name("admin.home");
    Route::post('/importar-excel', [EstudianteController::class, 'importarExcel']);

    Route::get("/estudiantes",[EstudianteController::class, 'index'])->name("estudiantes.index");
    Route::post('/estudiantes', [EstudianteController::class, 'store'])->name('estudiantes.store');
    Route::put('/estudiantes/{id}', [EstudianteController::class, 'updatestudent'])->name('estudiantes.update');
    //Route::resource('estudiantes', EstudianteController::class);
    Route::resource('estudiantes', EstudianteController::class)->except(['update','show']);


    Route::get("/progenitores",[ProgenitorController::class, 'index'])->name("progenitores.index");
    Route::post('/progenitores/store-or-update', [ProgenitorController::class, 'storeOrUpdate'])->name('progenitores.storeOrUpdate');
    Route::post('/progenitores/store', [ProgenitorController::class, 'store'])->name('progenitores.store');

    //Route::put('/estudiantes/update', [EstudianteController::class, 'update'])->name('estudiantes.update');

    Route::put('/solicitud/{id}/cambiar-estado', [SolicitudController::class, 'cambiarEstado'])->name('solicitud.cambiarEstado');
    Route::get('/solicitudes/export/excel', [SolicitudController::class, 'exportExcel'])->name('solicitudes.exportExcel');
    Route::get('/solicitudes/export/pdf', [SolicitudController::class, 'exportPDF'])->name('solicitudes.exportPDF');

});

Route::post('/progenitores/transfer', [EstudianteController::class, 'transferToProgenitores'])->name('progenitores.transfer');
Route::get('/estudiantes/buscar', [EstudianteController::class, 'buscar'])->name('estudiantes.buscar');
Route::get('/progenitores/buscar', [ProgenitorController::class, 'buscar'])->name('progenitores.buscar');
Route::post('/setdatos', [EstudianteController::class, 'setdatos'])->name('set.datos');
Route::get('/enviar-notificacion/{id}', [EstudianteController::class, 'notificarPorCorreoprueba']);

Route::get('/subirarchivo', function () {
    Storage::disk('google')->write('prueba.txt', 'probarsubida');
    return "Archivo subido con éxito 🚀";
});
