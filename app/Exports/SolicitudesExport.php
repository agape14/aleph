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
            'PROGENITOR 1 INGRESOS MENSUALES',
            'PROGENITOR 2 NOMBRES',
            'PROGENITOR 2 APELLIDOS',
            'PROGENITOR 2 INGRESOS MENSUALES',

            'INGRESOS PLANILLA',
            'INGRESOS HONORARIOS',
            'INGRESOS PENSIÓN',
            'INGRESOS ALQUILER',
            'OTROS INGRESOS',
            'TOTAL INGRESOS',
            'GASTOS COLEGIOS',
            'GASTOS TALLERES',
            'GASTOS UNIVERSIDAD',
            'OTROS GASTOS',
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
        $sheet->mergeCells('N1:S1')->setCellValue('N1', 'PROGENITORES');
        $sheet->mergeCells('T1:AD1')->setCellValue('T1', 'SITUACIÓN ECONÓMICA');

        // Obtener el número total de filas con datos
        $totalRows = count($this->collection());

        // Aplicando bordes solo al rango de datos con registros
        $sheet->getStyle("A1:AD" . ($totalRows + 2))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Alineación y negrita para los títulos agrupados
        $sheet->getStyle('A1:AA1')->applyFromArray([
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
        $sheet->getStyle('A2:AD2')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        // Ajustar el ancho de las columnas desde A2 hasta AD2 (cabeceras)
        $lastColumn = 'AD2'; // Última columna para la cabecera
        $lastRow = $totalRows + 2; // Si la fila 1 es de títulos agrupados y la fila 2 son las cabeceras

        // Ajuste de tamaño automático de columnas solo para las cabeceras (A2:AD2)
        foreach (range('A', $lastColumn) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    }
}
