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

    // Rutas del Gestor de Contenido
    Route::prefix('admin/gestor-contenido')->name('admin.gestor-contenido.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\GestorContenidoController::class, 'index'])->name('index');
        Route::post('/limpiar-cache', [App\Http\Controllers\Admin\GestorContenidoController::class, 'limpiarCache'])->name('limpiar-cache');
        Route::get('/exportar', [App\Http\Controllers\Admin\GestorContenidoController::class, 'exportar'])->name('exportar');
        Route::post('/importar', [App\Http\Controllers\Admin\GestorContenidoController::class, 'importar'])->name('importar');
        Route::get('/logs', [App\Http\Controllers\Admin\GestorContenidoController::class, 'logs'])->name('logs');
    });

    // Rutas de Documentos del Sistema
    Route::resource('admin/documentos', App\Http\Controllers\Admin\DocumentoSistemaController::class)->names([
        'index' => 'admin.documentos.index',
        'create' => 'admin.documentos.create',
        'store' => 'admin.documentos.store',
        'show' => 'admin.documentos.show',
        'edit' => 'admin.documentos.edit',
        'update' => 'admin.documentos.update',
        'destroy' => 'admin.documentos.destroy'
    ]);
    Route::post('/admin/documentos/{documento}/toggle-active', [App\Http\Controllers\Admin\DocumentoSistemaController::class, 'toggleActive'])->name('admin.documentos.toggle-active');

    // Rutas de Textos Dinámicos
    Route::resource('admin/textos', App\Http\Controllers\Admin\TextoDinamicoController::class)->names([
        'index' => 'admin.textos.index',
        'create' => 'admin.textos.create',
        'store' => 'admin.textos.store',
        'show' => 'admin.textos.show',
        'edit' => 'admin.textos.edit',
        'update' => 'admin.textos.update',
        'destroy' => 'admin.textos.destroy'
    ]);
    Route::post('/admin/textos/{texto}/toggle-active', [App\Http\Controllers\Admin\TextoDinamicoController::class, 'toggleActive'])->name('admin.textos.toggle-active');
    Route::post('/admin/textos/{texto}/restaurar-version/{version}', [App\Http\Controllers\Admin\TextoDinamicoController::class, 'restaurarVersion'])->name('admin.textos.restaurar-version');

    // Rutas de Tokens de Activación
    Route::resource('admin/tokens', App\Http\Controllers\Admin\TokenActivacionController::class)->names([
        'index' => 'admin.tokens.index',
        'create' => 'admin.tokens.create',
        'store' => 'admin.tokens.store',
        'show' => 'admin.tokens.show',
        'destroy' => 'admin.tokens.destroy'
    ]);
    Route::post('/admin/tokens/{token}/activar', [App\Http\Controllers\Admin\TokenActivacionController::class, 'activar'])->name('admin.tokens.activar');
    Route::post('/admin/tokens/{token}/desactivar', [App\Http\Controllers\Admin\TokenActivacionController::class, 'desactivar'])->name('admin.tokens.desactivar');

    // Rutas de Tokens de Menú
    Route::get('/admin/tokens-menu', [App\Http\Controllers\Admin\TokenMenuController::class, 'index'])->name('admin.tokens-menu.index');
    Route::post('/admin/tokens-menu/{token}/activar', [App\Http\Controllers\Admin\TokenMenuController::class, 'activar'])->name('admin.tokens-menu.activar');
    Route::post('/admin/tokens-menu/{token}/desactivar', [App\Http\Controllers\Admin\TokenMenuController::class, 'desactivar'])->name('admin.tokens-menu.desactivar');
    Route::post('/admin/tokens-menu/rol/{rol}/activar', [App\Http\Controllers\Admin\TokenMenuController::class, 'activarRol'])->name('admin.tokens-menu.rol.activar');
    Route::post('/admin/tokens-menu/rol/{rol}/desactivar', [App\Http\Controllers\Admin\TokenMenuController::class, 'desactivarRol'])->name('admin.tokens-menu.rol.desactivar');

    // Rutas de Plantillas
    Route::get('/admin/plantillas', [App\Http\Controllers\Admin\PlantillaController::class, 'index'])->name('admin.plantillas.index');
    Route::get('/admin/plantillas/{plantilla}', [App\Http\Controllers\Admin\PlantillaController::class, 'show'])->name('admin.plantillas.show');
    Route::post('/admin/plantillas/{plantilla}/generar', [App\Http\Controllers\Admin\PlantillaController::class, 'generar'])->name('admin.plantillas.generar');
    Route::post('/admin/plantillas/{plantilla}/guardar', [App\Http\Controllers\Admin\PlantillaController::class, 'guardar'])->name('admin.plantillas.guardar');
    Route::get('/admin/plantillas-api/listar', [App\Http\Controllers\Admin\PlantillaController::class, 'listar'])->name('admin.plantillas.listar');

    // Rutas de Gestor de Logs
    Route::prefix('admin/logs')->name('admin.logs.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\LogManagerController::class, 'index'])->name('index');
        Route::post('/copiar', [App\Http\Controllers\Admin\LogManagerController::class, 'copiar'])->name('copiar');
        Route::post('/ver', [App\Http\Controllers\Admin\LogManagerController::class, 'ver'])->name('ver');
        Route::post('/eliminar', [App\Http\Controllers\Admin\LogManagerController::class, 'eliminar'])->name('eliminar');
        Route::get('/descargar/{fileName}', [App\Http\Controllers\Admin\LogManagerController::class, 'descargar'])->name('descargar');
    });
});

Route::post('/progenitores/transfer', [EstudianteController::class, 'transferToProgenitores'])->name('progenitores.transfer');
Route::get('/estudiantes/buscar', [EstudianteController::class, 'buscar'])->name('estudiantes.buscar');
Route::get('/progenitores/buscar', [ProgenitorController::class, 'buscar'])->name('progenitores.buscar');
Route::post('/setdatos', [EstudianteController::class, 'setdatos'])->name('set.datos');
Route::get('/enviar-notificacion/{id}', [EstudianteController::class, 'notificarPorCorreoprueba']);

// API para activar funcionalidades con token
Route::post('/api/activar-funcionalidad', [App\Http\Controllers\Admin\TokenActivacionController::class, 'activarConToken'])->name('api.activar-funcionalidad');

// Ruta directa para activar tokens desde URL
Route::get('/activar/{token}', function($token) {
    $tokenModel = \App\Models\TokenActivacion::where('token', $token)->first();

    if (!$tokenModel) {
        return response()->json([
            'success' => false,
            'message' => 'Token no encontrado'
        ], 404);
    }

    // Verificar si el token puede ser activado (no verificar si ya está activo)
    if ($tokenModel->fecha_expiracion && $tokenModel->fecha_expiracion < now()) {
        return response()->json([
            'success' => false,
            'message' => 'Token expirado'
        ], 400);
    }

    if ($tokenModel->usos_maximos && $tokenModel->usos_actuales >= $tokenModel->usos_maximos) {
        return response()->json([
            'success' => false,
            'message' => 'Token sin usos disponibles'
        ], 400);
    }

    // Activar el token
    $tokenModel->update(['activo' => true]);
    $tokenModel->usar();

    // Limpiar cache
    \Illuminate\Support\Facades\Cache::forget('menus_activos');

    return response()->json([
        'success' => true,
        'message' => 'Token activado exitosamente',
        'token' => $tokenModel->token,
        'tipo' => $tokenModel->tipo,
        'nombre' => $tokenModel->nombre
    ]);
});

// Ruta directa para desactivar tokens desde URL
Route::get('/desactivar/{token}', function($token) {
    $tokenModel = \App\Models\TokenActivacion::where('token', $token)->first();

    if (!$tokenModel) {
        return response()->json([
            'success' => false,
            'message' => 'Token no encontrado'
        ], 404);
    }

    // Desactivar el token
    $tokenModel->update(['activo' => false]);

    // Limpiar cache
    \Illuminate\Support\Facades\Cache::forget('menus_activos');

    return response()->json([
        'success' => true,
        'message' => 'Token desactivado exitosamente',
        'token' => $tokenModel->token,
        'tipo' => $tokenModel->tipo,
        'nombre' => $tokenModel->nombre
    ]);
});

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

// Ruta temporal para ver la página de error 413
Route::get('/test-error-413', function () {
    return response()->view('errors.413', [
        'max_size' => '100 MB',
        'current_size' => '150 MB'
    ], 413);
});

