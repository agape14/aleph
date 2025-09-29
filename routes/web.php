<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProgenitorController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\ConfiguracionController;
use Illuminate\Support\Facades\Storage;
use App\Models\Backup;
use Carbon\Carbon;
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
//Route::get('/', function () {return view('index', ['formTimeout' => env('FORM_TIMEOUT', 300),'formAlertTime' => env('SESSION_LIFETIME', 240),]);});
  Route::get('/', [ConfiguracionController::class, 'verificarFormulario'])->name("inicio");
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
    Route::put('/progenitores/{progenitor}', [ProgenitorController::class, 'updateProgenitor'])->name('progenitores.update');
    //Route::put('/estudiantes/update', [EstudianteController::class, 'update'])->name('estudiantes.update');
    Route::get('/descargar-documentos/{solicitud_id}', [ProgenitorController::class, 'descargarDocumentos'])->name('descargar.documentos');

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

        // Verificar si ya se hizo un backup hoy
        $lastBackup = Backup::whereDate('created_at', Carbon::today())->first();
        if ($lastBackup) {
            return back()->with('error', 'Ya se realizó un backup hoy. Solo se permite uno por día.');
        }

        try {
            // Ejecutar el comando de backup
            $exitCode = Artisan::call('database:backup');

            // Verificar si se ejecutó correctamente
            if ($exitCode !== 0) {
                Backup::create([
                    'user_id' => Auth::id(),
                    'file_path' => 'drive', // Se almacena en Drive
                    'status' => 'failed',
                    'error_message' => 'Error al realizar el backup'
                ]);
                return back()->with('error', 'Error al realizar el backup. Inténtalo nuevamente.');
            }

            // Guardar el backup exitoso en la base de datos
            Backup::create([
                'user_id' => Auth::id(),
                'file_path' => 'drive', // El archivo se subió a Google Drive
                'status' => 'success'
            ]);

            return back()->with('success', 'Backup realizado correctamente y guardado en Drive.');

        } catch (\Exception $e) {
            // Registrar el error en la base de datos
            Backup::create([
                'user_id' => Auth::id(),
                'file_path' => 'drive',
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);

            return back()->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage());
        }
    })->name('backup')->middleware('auth');


    Route::get('/admin/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::post('/admin/configuracion', [ConfiguracionController::class, 'update'])->name('configuracion.update');
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

// Rutas de prueba para el modo de mantenimiento
Route::get('/test-maintenance', function () {
    return response()->json([
        'maintenance_mode' => env('MAINTENANCE_MODE', false),
        'message' => env('MAINTENANCE_MESSAGE', 'Mensaje por defecto'),
        'estimated_time' => env('MAINTENANCE_ESTIMATED_TIME', '2-4 horas'),
        'contact_email' => env('MAINTENANCE_CONTACT_EMAIL', 'soporte@aleph.edu'),
        'contact_phone' => env('MAINTENANCE_CONTACT_PHONE', '+1 (555) 123-4567')
    ]);
});

Route::get('/test-maintenance-activate', function () {
    // Esta ruta solo funciona en desarrollo
    if (app()->environment('local')) {
        return response()->json([
            'message' => 'Para activar el modo de mantenimiento, agrega MAINTENANCE_MODE=true a tu archivo .env',
            'current_status' => env('MAINTENANCE_MODE', false)
        ]);
    }
    return response()->json(['message' => 'Esta ruta solo está disponible en modo local']);
});
