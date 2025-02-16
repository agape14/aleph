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
    public function adminHome(Request $request)
    {
        // Obtener las solicitudes con sus relaciones
        $solicitudesQuery = Solicitud::with(['progenitores', 'estudiante', 'documentosAdjuntos']);

        // Filtrar por nombres, apellidos, código SIANET o DNI
        if ($request->filled('search')) {
            $search = $request->search;

            $solicitudesQuery->where(function ($query) use ($search) {
                $query->whereHas('estudiante', function ($q) use ($search) {
                    $q->where('nombres', 'like', "%{$search}%")
                    ->orWhere('apepaterno', 'like', "%{$search}%")
                    ->orWhere('apematerno', 'like', "%{$search}%")
                    ->orWhere('nro_documento', 'like', "%{$search}%")
                    ->orWhere('codigo_sianet', 'like', "%{$search}%");
                })
                ->orWhereHas('progenitores', function ($q) use ($search) {
                    $q->where('nombres', 'like', "%{$search}%")
                    ->orWhere('apellidos', 'like', "%{$search}%")
                    ->orWhere('dni', 'like', "%{$search}%")
                    ->orWhere('codigo_sianet', 'like', "%{$search}%");
                });
            });
        }

        // Filtrar por rango de fechas
        if ($request->filled('fecha_inicio')) {
            $solicitudesQuery->whereDate('created_at', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $solicitudesQuery->whereDate('created_at', '<=', $request->fecha_fin);
        }

        // Aplicar paginación (20 por página)
        $solicitudes = $solicitudesQuery->paginate(20);

        // Obtener fechas actuales para estadísticas
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
