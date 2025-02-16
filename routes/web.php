<?php
use Illuminate\Support\Facades\Artisan;
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

    Route::put('/situacion-economica/{id}', [SolicitudController::class, 'updateSituacionEconomica'])->name('situacionEconomica.update');
    Route::put('/documentos-adjuntos/{id}', [SolicitudController::class, 'updateDocumentosAdjuntos'])->name('documentosAdjuntos.update');

    Route::post('/backup', function () {
        Artisan::call('database:backup');
        return back()->with('success', 'Backup realizado correctamente.');
    })->name('backup')->middleware('auth');

    Route::post('/backup', function () {
        // Verificar si el usuario tiene rol de administrador (role == 1)
        if (Auth::user()->role != 'admin') {
            return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción. Tu rol es: ' . Auth::user()->role);
        }

        try {
            // Ejecutar el comando y capturar la salida
            $exitCode = Artisan::call('database:backup');

            // Verificar si el comando se ejecutó correctamente
            if ($exitCode !== 0) {
                return back()->with('error', 'Error al realizar el backup. Inténtalo nuevamente.');
            }

            return back()->with('success', 'Backup realizado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage());
        }
    })->name('backup')->middleware('auth');

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
