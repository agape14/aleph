<?php

namespace App\Imports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EstudianteImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Estudiante([
            'codigo_sianet'     => $row['codigo_sianet'],
            'apepaterno'        => $row['apepaterno'],
            'apematerno'        => $row['apematerno'],
            'nombres'           => $row['nombres'],
            'tipo_documento'    => $row['tipo_documento'],
            'nro_documento'     => $row['nro_documento'],
        ]);
    }
}
