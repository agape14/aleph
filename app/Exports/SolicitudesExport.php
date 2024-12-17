<?php

namespace App\Exports;

use App\Models\Solicitud;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SolicitudesExport implements FromCollection, WithHeadings, WithCustomStartCell, WithStyles
{
    public function collection()
    {
        // Obtener las solicitudes con las relaciones necesarias
        $solicitudes = Solicitud::with(['estudiante', 'progenitores', 'situacionEconomica'])->get();
        // Inicializamos el contador
        $contador = 1;
        // Mapear los datos y prepararlos para la exportación
        return $solicitudes->map(function ($solicitud) use (&$contador) {
            return [
                //'ID SOLICITUD' => $solicitud->id,
                '#' => $contador++,
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
                'INGRESOS VEHÍCULOS' => $solicitud->situacionEconomica->ingresos_vehiculos ?? 0,
                'OTROS INGRESOS' => $solicitud->situacionEconomica->otros_ingresos ?? 0,
                'DETALLE OTROS INGRESOS' => $solicitud->situacionEconomica->detalle_otros_ingresos ?? '',
                'TOTAL INGRESOS' => $solicitud->situacionEconomica->total_ingresos ?? 0,
                'NÚMERO DE HIJOS' => $solicitud->situacionEconomica->num_hijos ?? 0,
                'GASTOS COLEGIOS' => $solicitud->situacionEconomica->gastos_colegios ?? 0,
                'GASTOS TALLERES' => $solicitud->situacionEconomica->gastos_talleres ?? 0,
                'GASTOS UNIVERSIDAD' => $solicitud->situacionEconomica->gastos_universidad ?? 0,
                'GASTOS ALIMENTACIÓN' => $solicitud->situacionEconomica->gastos_alimentacion ?? 0,
                'GASTOS ALQUILER' => $solicitud->situacionEconomica->gastos_alquiler ?? 0,
                'GASTOS CRÉDITO PERSONAL' => $solicitud->situacionEconomica->gastos_credito_personal ?? 0,
                'GASTOS CRÉDITO HIPOTECARIO' => $solicitud->situacionEconomica->gastos_credito_hipotecario ?? 0,
                'GASTOS CRÉDITO VEHICULAR' => $solicitud->situacionEconomica->gastos_credito_vehicular ?? 0,
                'GASTOS SERVICIOS' => $solicitud->situacionEconomica->gastos_servicios ?? 0,
                'GASTOS MANTENIMIENTO' => $solicitud->situacionEconomica->gastos_mantenimiento ?? 0,
                'GASTOS APOYO CASA' => $solicitud->situacionEconomica->gastos_apoyo_casa ?? 0,
                'GASTOS CLUBES' => $solicitud->situacionEconomica->gastos_clubes ?? 0,
                'GASTOS SEGUROS' => $solicitud->situacionEconomica->gastos_seguros ?? 0,
                'GASTOS APOYO FAMILIAR' => $solicitud->situacionEconomica->gastos_apoyo_familiar ?? 0,
                'OTROS GASTOS' => $solicitud->situacionEconomica->otros_gastos ?? 0,
                'DETALLE OTROS GASTOS' => $solicitud->situacionEconomica->detalle_otros_gastos ?? '',
                'TOTAL GASTOS' => $solicitud->situacionEconomica->total_gastos ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'VIVE CON',
            'MOTIVOS BECA',
            'RAZONES MOTIVOS',
            'PERIODO ACADÉMICO',
            'REGLAMENTO LEÍDO',
            'ESTADO SOLICITUD',

            'ESTUDIANTE TIPO DOCUMENTO',
            'ESTUDIANTE NRO DOCUMENTO',
            'ESTUDIANTE APELLIDO PATERNO',
            'ESTUDIANTE APELLIDO MATERNO',
            'ESTUDIANTE NOMBRES',
            'ESTUDIANTE CÓDIGO SIANET',

            'PROGENITOR 1 NOMBRES',
            'PROGENITOR 1 APELLIDOS',
            'PROGENITOR 1 DNI',
            'PROGENITOR 1 CORREO',
            'PROGENITOR 1 NRO. HIJOS',
            'PROGENITOR 1 HIJOS MATRICULADOS',
            'PROGENITOR 1 FORMACION ACADÉMICA',
            'PROGENITOR 1 TRABAJA',
            'PROGENITOR 1 TIEMPO DESEMPLEO',
            'PROGENITOR 1 SUELDO FIJO',
            'PROGENITOR 1 SUELDO VARIABLE',
            'PROGENITOR 1 CARGO',
            'PROGENITOR 1 INICIO LABORAL',
            'PROGENITOR 1 LUGAR TRABAJO',
            'PROGENITOR 1 INGRESOS MENSUALES',
            'PROGENITOR 1 RECIBE BONOS',
            'PROGENITOR 1 MONTO BONOS',
            'PROGENITOR 1 UTILIDADES',
            'PROGENITOR 1 MONTO UTILIDADES',
            'PROGENITOR 1 TITULAR EMPRESA',
            'PROGENITOR 1 % ACCIONES',
            'PROGENITOR 1 RAZON SOCIAL',
            'PROGENITOR 1 RUC',
            'PROGENITOR 1 TIPO VIVIENDA',
            'PROGENITOR 1 CREDITO HIPOTECARIO',
            'PROGENITOR 1 DIRECCION',
            'PROGENITOR 1 m2 VIVIENDA',
            'PROGENITOR 1 CANT. INMUEBLES',

            'PROGENITOR 2 NOMBRES',
            'PROGENITOR 2 APELLIDOS',
            'PROGENITOR 2 DNI',
            'PROGENITOR 2 CORREO',
            'PROGENITOR 2 NRO. HIJOS',
            'PROGENITOR 2 HIJOS MATRICULADOS',
            'PROGENITOR 2 FORMACION ACADÉMICA',
            'PROGENITOR 2 TRABAJA',
            'PROGENITOR 2 TIEMPO DESEMPLEO',
            'PROGENITOR 2 SUELDO FIJO',
            'PROGENITOR 2 SUELDO VARIABLE',
            'PROGENITOR 2 CARGO',
            'PROGENITOR 2 INICIO LABORAL',
            'PROGENITOR 2 LUGAR TRABAJO',
            'PROGENITOR 2 INGRESOS MENSUALES',
            'PROGENITOR 2 RECIBE BONOS',
            'PROGENITOR 2 MONTO BONOS',
            'PROGENITOR 2 UTILIDADES',
            'PROGENITOR 2 MONTO UTILIDADES',
            'PROGENITOR 2 TITULAR EMPRESA',
            'PROGENITOR 2 % ACCIONES',
            'PROGENITOR 2 RAZON SOCIAL',
            'PROGENITOR 2 RUC',
            'PROGENITOR 2 TIPO VIVIENDA',
            'PROGENITOR 2 CREDITO HIPOTECARIO',
            'PROGENITOR 2 DIRECCION',
            'PROGENITOR 2 m2 VIVIENDA',
            'PROGENITOR 2 CANT. INMUEBLES',

            'INGRESOS PLANILLA',
            'INGRESOS HONORARIOS',
            'INGRESOS PENSIÓN',
            'INGRESOS ALQUILER',
            'INGRESOS VEHÍCULOS',
            'OTROS INGRESOS',
            'DETALLE OTROS INGRESOS',
            'TOTAL INGRESOS',
            'NÚMERO DE HIJOS',
            'GASTOS COLEGIOS',
            'GASTOS TALLERES',
            'GASTOS UNIVERSIDAD',
            'GASTOS ALIMENTACIÓN',
            'GASTOS ALQUILER',
            'GASTOS CRÉDITO PERSONAL',
            'GASTOS CRÉDITO HIPOTECARIO',
            'GASTOS CRÉDITO VEHICULAR',
            'GASTOS SERVICIOS',
            'GASTOS MANTENIMIENTO',
            'GASTOS APOYO CASA',
            'GASTOS CLUBES',
            'GASTOS SEGUROS',
            'GASTOS APOYO FAMILIAR',
            'OTROS GASTOS',
            'DETALLE OTROS GASTOS',
            'TOTAL GASTOS',
        ];
    }

    public function startCell(): string
    {
        return 'A2'; // Las cabeceras normales comienzan en A3
    }

    public function styles(Worksheet $sheet)
    {
        // Combinando las celdas superiores y asignando títulos
        $sheet->mergeCells('A1:G1')->setCellValue('A1', 'SOLICITUDES');
        $sheet->mergeCells('H1:M1')->setCellValue('H1', 'ALUMNOS');
        $sheet->mergeCells('N1:BQ1')->setCellValue('N1', 'PROGENITORES');
        $sheet->mergeCells('BR1:CQ1')->setCellValue('BR1', 'SITUACIÓN ECONÓMICA');

        // Obtener el número total de filas con datos
        $totalRows = count($this->collection());

        // Aplicando bordes solo al rango de datos con registros
        $sheet->getStyle("A1:CQ" . ($totalRows + 2))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Alineación y negrita para los títulos agrupados
        $sheet->getStyle('A1:CQ1')->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
        ]);

        // Negrita para las cabeceras
        $sheet->getStyle('A2:CQ2')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        // Ajustar el ancho de las columnas desde A2 hasta CQ2 (cabeceras)
        $lastColumn = 'CQ2'; // Última columna para la cabecera
        $lastRow = $totalRows + 2; // Si la fila 1 es de títulos agrupados y la fila 2 son las cabeceras

        // Ajuste de tamaño automático de columnas solo para las cabeceras (A2:CQ2)
        foreach (range('A', $lastColumn) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    }
}
