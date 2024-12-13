<?php

namespace App\Exports;

use App\Models\Solicitud;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SolicitudesExport implements FromCollection
{
    public function collection()
    {
        return Solicitud::with(['estudiante', 'progenitores', 'documentosAdjuntos'])->get()->map(function ($solicitud) {
            return [
                'ID' => $solicitud->id,
                'DNI Estudiante' => $solicitud->estudiante->nro_documento,
                'Nombre Estudiante' => $solicitud->estudiante->nombres,
                'Apellido Estudiante' => $solicitud->estudiante->apepaterno . ' ' . $solicitud->estudiante->apematerno,
                'Progenitores' => $solicitud->progenitores->pluck('nombres')->implode(', '),
                'Estado' => $solicitud->estado_solicitud,
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'DNI Estudiante', 'Nombre Estudiante', 'Apellido Estudiante', 'Progenitores', 'Estado'];
    }
}
