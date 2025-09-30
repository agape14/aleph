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
        $inicioSemana = Carbon::now()->startOfWeek(); // Lunes de la semana actual
        $finSemana = Carbon::now()->endOfWeek(); // Domingo de la semana actual
        $inicioMes = Carbon::now()->startOfMonth();
        $inicioAnio = Carbon::now()->startOfYear();

        // Optimización: Obtener todos los contadores en una sola consulta usando agregación
        $estadisticas = Solicitud::selectRaw('
            COUNT(*) as total_solicitudes,
            SUM(CASE WHEN DATE(created_at) = ? THEN 1 ELSE 0 END) as diario,
            SUM(CASE WHEN created_at >= ? AND created_at <= ? THEN 1 ELSE 0 END) as semanal,
            SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as mensual,
            SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as anual,
            SUM(CASE WHEN estado_solicitud = ? THEN 1 ELSE 0 END) as pendientes,
            SUM(CASE WHEN estado_solicitud = ? THEN 1 ELSE 0 END) as en_revision,
            SUM(CASE WHEN estado_solicitud = ? THEN 1 ELSE 0 END) as aprobadas,
            SUM(CASE WHEN estado_solicitud = ? THEN 1 ELSE 0 END) as rechazadas
        ', [
            $hoy->format('Y-m-d'),
            $inicioSemana,
            $finSemana,
            $inicioMes,
            $inicioAnio,
            'pendiente',
            'en_revision',
            'aprobada',
            'rechazada'
        ])->first();

        // Contadores de tiempo
        $contadores = [
            'diario' => $estadisticas->diario,
            'semanal' => $estadisticas->semanal,
            'mensual' => $estadisticas->mensual,
            'anual' => $estadisticas->anual,
        ];

        // Contadores por estado
        $contadoresEstado = [
            'pendientes' => $estadisticas->pendientes,
            'en_revision' => $estadisticas->en_revision,
            'aprobadas' => $estadisticas->aprobadas,
            'rechazadas' => $estadisticas->rechazadas,
        ];

        // Contadores adicionales (optimizados)
        $contadoresAdicionales = [
            'total_estudiantes' => Estudiante::count(),
            'total_solicitudes' => $estadisticas->total_solicitudes,
            'con_documentos' => Solicitud::whereHas('documentosAdjuntos')->count(),
            'sin_documentos' => Solicitud::whereDoesntHave('documentosAdjuntos')->count(),
        ];

        // Datos para gráficos estadísticos
        $datosGraficos = [
            // Gráfico de estado de solicitudes
            'estados_solicitudes' => [
                'labels' => ['Pendientes', 'En Revisión', 'Aprobadas', 'Rechazadas'],
                'data' => [
                    $estadisticas->pendientes,
                    $estadisticas->en_revision,
                    $estadisticas->aprobadas,
                    $estadisticas->rechazadas
                ],
                'colors' => ['#ffc107', '#0d6efd', '#198754', '#dc3545']
            ],

            // Gráfico de solicitudes por mes (últimos 6 meses)
            'solicitudes_mensuales' => $this->obtenerSolicitudesMensuales(),

            // Gráfico de documentos
            'documentos' => [
                'labels' => ['Con Documentos', 'Sin Documentos'],
                'data' => [
                    $contadoresAdicionales['con_documentos'],
                    $contadoresAdicionales['sin_documentos']
                ],
                'colors' => ['#6c757d', '#343a40']
            ],

            // Gráfico de tendencia semanal (últimas 4 semanas)
            'tendencia_semanal' => $this->obtenerTendenciaSemanal()
        ];

        // Pasar los datos a la vista
        return view('admin.home', [
            'msg' => "Hello! I am admin",
            'solicitudes' => $solicitudes,
            'contadorDiario' => $contadores['diario'],
            'contadorSemanal' => $contadores['semanal'],
            'contadorMensual' => $contadores['mensual'],
            'contadorAnual' => $contadores['anual'],
            'contadoresEstado' => $contadoresEstado,
            'contadoresAdicionales' => $contadoresAdicionales,
            'datosGraficos' => $datosGraficos,
        ]);
    }

    public function userHome()
    {
        return view('user.home',["msg"=>"Hello! I am user"]);
    }

    /**
     * Obtener solicitudes por mes (últimos 6 meses)
     */
    private function obtenerSolicitudesMensuales()
    {
        $meses = [];
        $datos = [];

        for ($i = 5; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $meses[] = $fecha->format('M Y');
            $datos[] = Solicitud::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
        }

        return [
            'labels' => $meses,
            'data' => $datos,
            'color' => '#0d6efd'
        ];
    }

    /**
     * Obtener tendencia semanal (últimas 4 semanas)
     */
    private function obtenerTendenciaSemanal()
    {
        $semanas = [];
        $datos = [];

        for ($i = 3; $i >= 0; $i--) {
            $inicioSemana = Carbon::now()->subWeeks($i)->startOfWeek();
            $finSemana = Carbon::now()->subWeeks($i)->endOfWeek();

            $semanas[] = 'Sem ' . $inicioSemana->format('d/m');
            $datos[] = Solicitud::whereBetween('created_at', [$inicioSemana, $finSemana])->count();
        }

        return [
            'labels' => $semanas,
            'data' => $datos,
            'color' => '#198754'
        ];
    }
}
