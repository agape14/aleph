<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;
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
    return view('index');
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
    Route::put('/estudiantes/update', [EstudianteController::class, 'update'])->name('estudiantes.update');

});

Route::get('/estudiantes/buscar', [EstudianteController::class, 'buscar'])->name('estudiantes.buscar');
Route::post('/setdatos', [EstudianteController::class, 'setdatos'])->name('set.datos');
