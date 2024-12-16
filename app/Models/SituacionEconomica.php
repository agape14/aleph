<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SituacionEconomica extends Model
{
    use HasFactory;
    protected $table = 'situacion_economica';
    protected $fillable = [
        'solicitud_id',

        'ingresos_planilla',
        'ingresos_honorarios',
        'ingresos_pension',
        'ingresos_alquiler',
        'ingresos_vehiculos',
        'otros_ingresos',
        'detalle_otros_ingresos',
        'total_ingresos',
        'num_hijos',
        'gastos_colegios',
        'gastos_talleres',
        'gastos_universidad',
        'gastos_alimentacion',
        'gastos_alquiler',
        'gastos_credito_personal',
        'gastos_credito_hipotecario',
        'gastos_credito_vehicular',
        'gastos_servicios',
        'gastos_mantenimiento',
        'gastos_apoyo_casa',
        'gastos_clubes',
        'gastos_seguros',
        'gastos_apoyo_familiar',
        'otros_gastos',
        'detalle_otros_gastos',
        'total_gastos'
    ];

    // Relación con Solicitud
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }
}
