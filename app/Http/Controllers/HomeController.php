<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
    public function adminHome()
    {
        // Obtener todas las solicitudes
        $solicitudes = Solicitud::with(['progenitores', 'estudiante','documentosAdjuntos'])->get();
        // Obtener fechas actuales
        $hoy = Carbon::today();
        $inicioSemana = Carbon::now()->startOfWeek();
        $inicioMes = Carbon::now()->startOfMonth();
        $inicioAnio = Carbon::now()->startOfYear();

        // Contar las solicitudes según el rango de tiempo
        $contadorDiario = Solicitud::whereDate('created_at', $hoy)->count();
        $contadorSemanal = Solicitud::whereBetween('created_at', [$inicioSemana, Carbon::now()])->count();
        $contadorMensual = Solicitud::whereBetween('created_at', [$inicioMes, Carbon::now()])->count();
        $contadorAnual = Solicitud::whereBetween('created_at', [$inicioAnio, Carbon::now()])->count();

        // Pasar los datos a la vista
        return view('admin.home', [
            'msg' => "Hello! I am admin",
            'solicitudes' => $solicitudes,
            'contadorDiario' => $contadorDiario,
            'contadorSemanal' => $contadorSemanal,
            'contadorMensual' => $contadorMensual,
            'contadorAnual' => $contadorAnual,
        ]);
    }
    public function userHome()
    {
        return view('user.home',["msg"=>"Hello! I am user"]);
    }
}
