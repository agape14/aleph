<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progenitor extends Model
{
    use HasFactory;
    protected $table = 'progenitores';
    protected $fillable = [
        'solicitud_id',
        'estudiante_id',
        'tipo_documento',
        'tipo',
        'dni',
        'nombres',
        'apellidos',
        'codigo_sianet',
        'numero_hijos',
        'hijos_matriculados',
        'formacion_academica',
        'trabaja',
        'tiempo_desempleo',
        'sueldo_fijo',
        'sueldo_variable',
        'cargo',
        'anio_inicio_laboral',
        'lugar_trabajo',
        'ingresos_mensuales',
        'recibe_bonos',
        'monto_bonos',
        'recibe_utilidades',
        'monto_utilidades',
        'titular_empresa',
        'porcentaje_acciones',
        'razon_social',
        'numero_ruc',
        'vivienda_tipo',
        'credito_hipotecario',
        'direccion_vivienda',
        'm2_vivienda',
        'cantidad_inmuebles'
    ];

    // Relación con Solicitud
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }

    // Relación con Estudiante (si existe)
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    // Relación con DocumentosAdjuntos
    public function documentosAdjuntos()
    {
        return $this->hasMany(DocumentoAdjunto::class);
    }
}
