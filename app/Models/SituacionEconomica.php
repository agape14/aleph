<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SituacionEconomica extends Model
{
    use HasFactory;
    protected $fillable = [
        'solicitud_id',
        'ingresos_planilla',
        'ingresos_honorarios',
        'ingresos_pension',
        'ingresos_alquiler',
        'ingresos_vehiculos',
        'otros_ingresos',
        'total_ingresos',
        'gastos_colegios',
        'gastos_talleres',
        'gastos_universidad',
        'gastos_alimentacion',
        'otros_gastos',
        'total_gastos'
    ];

    // Relación con Solicitud
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }
}
