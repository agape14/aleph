<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\SituacionEconomica;
use App\Models\DocumentoAdjunto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SolicitudesExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;


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

    public function exportExcel(Request $request)
    {
        // Obtener la fecha y hora actual en el formato deseado: YYYYMMDD_HHMMSS
        $timestamp = now()->format('Ymd_His');

        // Generar el nombre del archivo concatenando la fecha y hora
        $fileName = 'solicitudes_' . $timestamp . '.xlsx';

        // Preparar los filtros desde el request
        $filtros = [
            'search' => $request->input('search'),
            'año' => $request->input('año', date('Y')),
            'fecha_inicio' => $request->input('fecha_inicio'),
            'fecha_fin' => $request->input('fecha_fin'),
        ];

        // Descargar el archivo Excel con el nombre generado y los filtros aplicados
        return Excel::download(new SolicitudesExport($filtros), $fileName);
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
                'PROGENITOR 1 DNI' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->dni ?? '',
                'PROGENITOR 1 CORREO' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->correo_electronico ?? '',
                'PROGENITOR 1 NRO. HIJOS' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->numero_hijos ?? 0,
                'PROGENITOR 1 HIJOS MATRICULADOS' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->hijos_matriculados ?? 0,
                'PROGENITOR 1 FORMACION ACADÉMICA' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->formacion_academica ?? '',
                'PROGENITOR 1 TRABAJA' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->trabaja ?? '',
                'PROGENITOR 1 TIEMPO DESEMPLEO' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->tiempo_desempleo ?? '',
                'PROGENITOR 1 SUELDO FIJO' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->sueldo_fijo ?? '',
                'PROGENITOR 1 SUELDO VARIABLE' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->sueldo_variable ?? '',
                'PROGENITOR 1 CARGO' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->cargo ?? '',
                'PROGENITOR 1 INICIO LABORAL' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->anio_inicio_laboral ?? '',
                'PROGENITOR 1 LUGAR TRABAJO' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->lugar_trabajo ?? '',
                'PROGENITOR 1 INGRESOS MENSUALES' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->ingresos_mensuales ?? '',
                'PROGENITOR 1 RECIBE BONOS' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->recibe_bonos ?? '',
                'PROGENITOR 1 MONTO BONOS' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->monto_bonos ?? '',
                'PROGENITOR 1 UTILIDADES' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->recibe_utilidades ?? '',
                'PROGENITOR 1 MONTO UTILIDADES' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->monto_utilidades ?? '',
                'PROGENITOR 1 TITULAR EMPRESA' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->titular_empresa ?? '',
                'PROGENITOR 1 % ACCIONES' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->porcentaje_acciones ?? '',
                'PROGENITOR 1 RAZON SOCIAL' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->razon_social ?? '',
                'PROGENITOR 1 RUC' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->numero_ruc ?? '',
                'PROGENITOR 1 TIPO VIVIENDA' => strtoupper($solicitud->progenitores->where('tipo', 'progenitor1')->first()?->vivienda_tipo) ?? '',
                'PROGENITOR 1 CREDITO HIPOTECARIO' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->credito_hipotecario ?? '',
                'PROGENITOR 1 DIRECCION' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->direccion_vivienda ?? '',
                'PROGENITOR 1 m2 VIVIENDA' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->m2_vivienda ?? '',
                'PROGENITOR 1 CANT. INMUEBLES' => $solicitud->progenitores->where('tipo', 'progenitor1')->first()?->cantidad_inmuebles ?? '',

                'PROGENITOR 2 NOMBRES' => mb_strtoupper($solicitud->progenitores->where('tipo', 'progenitor2')->first()?->nombres ?? ''),
                'PROGENITOR 2 APELLIDOS' => mb_strtoupper($solicitud->progenitores->where('tipo', 'progenitor2')->first()?->apellidos ?? ''),
                'PROGENITOR 2 DNI' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->dni ?? '',
                'PROGENITOR 2 CORREO' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->correo_electronico ?? '',
                'PROGENITOR 2 NRO. HIJOS' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->numero_hijos ?? 0,
                'PROGENITOR 2 HIJOS MATRICULADOS' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->hijos_matriculados ?? 0,
                'PROGENITOR 2 FORMACION ACADÉMICA' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->formacion_academica ?? '',
                'PROGENITOR 2 TRABAJA' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->trabaja ?? '',
                'PROGENITOR 2 TIEMPO DESEMPLEO' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->tiempo_desempleo ?? '',
                'PROGENITOR 2 SUELDO FIJO' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->sueldo_fijo ?? '',
                'PROGENITOR 2 SUELDO VARIABLE' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->sueldo_variable ?? '',
                'PROGENITOR 2 CARGO' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->cargo ?? '',
                'PROGENITOR 2 INICIO LABORAL' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->anio_inicio_laboral ?? '',
                'PROGENITOR 2 LUGAR TRABAJO' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->lugar_trabajo ?? '',
                'PROGENITOR 2 INGRESOS MENSUALES' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->ingresos_mensuales ?? '',
                'PROGENITOR 2 RECIBE BONOS' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->recibe_bonos ?? '',
                'PROGENITOR 2 MONTO BONOS' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->monto_bonos ?? '',
                'PROGENITOR 2 UTILIDADES' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->recibe_utilidades ?? '',
                'PROGENITOR 2 MONTO UTILIDADES' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->monto_utilidades ?? '',
                'PROGENITOR 2 TITULAR EMPRESA' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->titular_empresa ?? '',
                'PROGENITOR 2 % ACCIONES' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->porcentaje_acciones ?? '',
                'PROGENITOR 2 RAZON SOCIAL' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->razon_social ?? '',
                'PROGENITOR 2 RUC' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->numero_ruc ?? '',
                'PROGENITOR 2 TIPO VIVIENDA' => strtoupper($solicitud->progenitores->where('tipo', 'progenitor2')->first()?->vivienda_tipo) ?? '',
                'PROGENITOR 2 CREDITO HIPOTECARIO' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->credito_hipotecario ?? '',
                'PROGENITOR 2 DIRECCION' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->direccion_vivienda ?? '',
                'PROGENITOR 2 m2 VIVIENDA' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->m2_vivienda ?? '',
                'PROGENITOR 2 CANT. INMUEBLES' => $solicitud->progenitores->where('tipo', 'progenitor2')->first()?->cantidad_inmuebles ?? '',

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
        $customPaper = [0, 0, 600, 6000]; // Ancho y alto en puntos

        // Cargar la vista PDF con los datos y configurar el tamaño de papel personalizado
        $pdf = Pdf::loadView('solicitudes.pdf', ['solicitudes' => $data])
            ->setPaper($customPaper, 'landscape'); // Cambiar tamaño a personalizado y orientación horizontal

        // Descargar el archivo PDF con el nombre que incluye la fecha y hora
        return $pdf->download("solicitudes_{$dateTime}.pdf");
    }

    public function updateSituacionEconomica(Request $request, $id)
    {
        $situacion = SituacionEconomica::findOrFail($id);

        // Calcular la suma de ingresos
        $totalIngresos =
            ($request->ingresos_planilla ?? 0) +
            ($request->ingresos_honorarios ?? 0) +
            ($request->ingresos_pension ?? 0) +
            ($request->ingresos_alquiler ?? 0) +
            ($request->ingresos_vehiculos ?? 0) +
            ($request->otros_ingresos ?? 0);

        // Calcular la suma de gastos
        $totalGastos =
            ($request->gastos_colegios ?? 0) +
            ($request->gastos_talleres ?? 0) +
            ($request->gastos_universidad ?? 0) +
            ($request->gastos_alimentacion ?? 0) +
            ($request->gastos_alquiler ?? 0) +
            ($request->gastos_credito_personal ?? 0) +
            ($request->gastos_credito_hipotecario ?? 0) +
            ($request->gastos_credito_vehicular ?? 0) +
            ($request->gastos_servicios ?? 0) +
            ($request->gastos_mantenimiento ?? 0) +
            ($request->gastos_apoyo_casa ?? 0) +
            ($request->gastos_clubes ?? 0) +
            ($request->gastos_seguros ?? 0) +
            ($request->gastos_apoyo_familiar ?? 0) +
            ($request->otros_gastos ?? 0);

        // Actualizar la situación económica con los nuevos valores
        $situacion->update(array_merge(
            $request->except(['total_ingresos', 'total_gastos']),
            [
                'total_ingresos' => $totalIngresos,
                'total_gastos' => $totalGastos
            ]
        ));

        return redirect()->back()->with('success', 'Situación económica actualizada correctamente.');
    }

    public function updateDocumentosAdjuntos(Request $request, $id)
    {
        // Verificar si el tipo de documento existe para la solicitud dada
        $existe = DocumentoAdjunto::where('solicitud_id', $id)
        ->where('tipo_documento', $request->tipo_documento)
        ->exists();

        if (!$existe) {
            return redirect()->back()->with('error', 'El tipo de documento no existe en la base de datos.');
        }

        // Buscar el documento a actualizar
        $documento = DocumentoAdjunto::where('solicitud_id', $id)
            ->where('tipo_documento', $request->tipo_documento)
            ->firstOrFail();

        // Si hay un archivo nuevo, lo subimos y actualizamos la ruta
        if ($request->hasFile('ruta_archivo') && $request->file('ruta_archivo')->isValid()) {
            // Eliminar archivo anterior si existe
            //if ($documento->ruta_archivo) {Storage::disk('public')->delete($documento->ruta_archivo);}

            // Guardar nuevo archivo
            $rutaArchivo = $request->file('ruta_archivo')->store($request->tipo_documento, 'public');
            $documento->ruta_archivo = $rutaArchivo;
        }

        // Actualizar el tipo de documento
        $documento->tipo_documento = $request->tipo_documento;
        $documento->save();

        return redirect()->back()->with('success', 'Documento actualizado correctamente.');
    }


}
