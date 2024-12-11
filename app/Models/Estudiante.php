<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipo_documento',
        'nro_documento',
        'apepaterno',
        'apematerno',
        'nombres',
        'codigo_sianet',
        'vive_con',
        'motivos_beca',
        'razones_motivos',
    ];
}
