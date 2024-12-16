<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SolicitudesExport;
use Barryvdh\DomPDF\Facade\Pdf;

class SolicitudController extends Controller
{
    public function cambiarEstado($id)
    {
        $solicitud = Solicitud::findOrFail($id);

        $estados = ['pendiente', 'en_revision', 'aprobada', 'rechazada'];
        $index = array_search($solicitud->estado_solicitud, $estados);

        $nuevoEstado = $index !== false && $index < count($estados) - 1 ? $estados[$index + 1] : 'pendiente';

        $solicitud->update(['estado_solicitud' => $nuevoEstado]);

        return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }

    public function exportExcel()
    {
        // Obtener la fecha y hora actual en el formato deseado: YYYYMMDD_HHMMSS
        $timestamp = now()->format('Ymd_His');

        // Generar el nombre del archivo concatenando la fecha y hora
        $fileName = 'solicitudes_' . $timestamp . '.xlsx';

        // Descargar el archivo Excel con el nombre generado
        return Excel::download(new SolicitudesExport, $fileName);
    }

    public function exportPDF()
    {
        // Obtener las solicitudes con las relaciones necesarias
        $solicitudes = Solicitud::with(['estudiante', 'progenitores', 'situacionEconomica'])->get();

        // Preparar los datos para el PDF con los mismos campos que en Excel
        $data = $solicitudes->map(function ($solicitud) {
            return [
                'VIVE CON' => mb_strtoupper($solicitud->vive_con),
                'MOTIVOS BECA' => mb_strtoupper(implode(', ', json_decode($solicitud->motivos_beca, true) ?? [])),
                'RAZONES MOTIVOS' => mb_strtoupper($solicitud->razones_motivos),
                'PERIODO ACADÉMICO' => mb_strtoupper($solicitud->periodo_academico),
                'REGLAMENTO LEÍDO' => $solicitud->reglamento_leido ? 'SÍ' : 'NO',
                'ESTADO SOLICITUD' => mb_strtoupper($solicitud->estado_solicitud),
                'ESTUDIANTE TIPO DOCUMENTO' => mb_strtoupper($solicitud->estudiante->tipo_documento ?? ''),
                'ESTUDIANTE NRO DOCUMENTO' => $solicitud->estudiante->nro_documento ?? '',
                'ESTUDIANTE APELLIDO PATERNO' => mb_strtoupper($solicitud->estudiante->apepaterno ?? ''),
                'ESTUDIANTE APELLIDO MATERNO' => mb_strtoupper($solicitud->estudiante->apematerno ?? ''),
                'ESTUDIANTE NOMBRES' => mb_strtoupper($solicitud->estudiante->nombres ?? ''),
                'ESTUDIANTE CÓDIGO SIANET' => $solicitud->estudiante->codigo_sianet ?? '',
                'PROGENITOR 1 NOMBRES' => mb_strtoupper($solicitud->progenitores->where('tipo', 'progenitor1')->first()?->nombres ?? ''),
                'PROGENITOR 1 APELLIDOS' => mb_strtoupper($solicitud->progenitores->where('tipo', 'progenitor1')->first()?->apellidos ?? ''),
                'PROGENITOR 1 INGRESOS MENSUALES' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->ingresos_mensuales ?? 0,
                'PROGENITOR 2 NOMBRES' => mb_strtoupper($solicitud->progenitores->where('tipo', 'progenitor2')->first()?->nombres ?? ''),
                'PROGENITOR 2 APELLIDOS' => mb_strtoupper($solicitud->progenitores->where('tipo', 'progenitor2')->first()?->apellidos ?? ''),
                'PROGENITOR 2 INGRESOS MENSUALES' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->ingresos_mensuales ?? 0,
                'INGRESOS PLANILLA' => $solicitud->situacionEconomica->ingresos_planilla ?? 0,
                'INGRESOS HONORARIOS' => $solicitud->situacionEconomica->ingresos_honorarios ?? 0,
                'INGRESOS PENSIÓN' => $solicitud->situacionEconomica->ingresos_pension ?? 0,
                'INGRESOS ALQUILER' => $solicitud->situacionEconomica->ingresos_alquiler ?? 0,
                'OTROS INGRESOS' => $solicitud->situacionEconomica->otros_ingresos ?? 0,
                'TOTAL INGRESOS' => $solicitud->situacionEconomica->total_ingresos ?? 0,
                'GASTOS COLEGIOS' => $solicitud->situacionEconomica->gastos_colegios ?? 0,
                'GASTOS TALLERES' => $solicitud->situacionEconomica->gastos_talleres ?? 0,
                'GASTOS UNIVERSIDAD' => $solicitud->situacionEconomica->gastos_universidad ?? 0,
                'OTROS GASTOS' => $solicitud->situacionEconomica->otros_gastos ?? 0,
                'TOTAL GASTOS' => $solicitud->situacionEconomica->total_gastos ?? 0,
            ];
        });

        // Obtener la fecha y hora actual en el formato deseado
        $dateTime = now()->format('Ymd_His'); // Año-Mes-Día_Hora-Minuto-Segundo

        // Establecer un tamaño personalizado para el papel (Ejemplo: Ancho: 600 puntos, Alto: 1200 puntos)
        $customPaper = [0, 0, 600, 2400]; // Ancho y alto en puntos

        // Cargar la vista PDF con los datos y configurar el tamaño de papel personalizado
        $pdf = Pdf::loadView('solicitudes.pdf', ['solicitudes' => $data])
            ->setPaper($customPaper, 'landscape'); // Cambiar tamaño a personalizado y orientación horizontal

        // Descargar el archivo PDF con el nombre que incluye la fecha y hora
        return $pdf->download("solicitudes_{$dateTime}.pdf");
    }


}
