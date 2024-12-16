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
            'codigo_sianet'     => strtoupper($row['codigo_sianet']),
            'apepaterno'        => strtoupper($row['apepaterno']),
            'apematerno'        => strtoupper($row['apematerno']),
            'nombres'           => strtoupper($row['nombres']),
            'tipo_documento'    => strtoupper($row['tipo_documento']),
            'nro_documento'     => strtoupper($row['nro_documento']),
        ]);
    }
}
