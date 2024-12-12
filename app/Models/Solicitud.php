<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;
    protected $table = 'solicitudes';
    protected $fillable = [
        'periodo_academico',
        'reglamento_leido',
        'estado_solicitud',
        'estudiante_id',
        'vive_con',
        'motivos_beca',
        'razones_motivos',

    ];

    // Relación con Progenitores
    public function progenitores()
    {
        return $this->hasMany(Progenitor::class);
    }

    // Relación con SituacionEconomica
    public function situacionEconomica()
    {
        return $this->hasOne(SituacionEconomica::class);
    }

    // Relación con DocumentosAdjuntos
    public function documentosAdjuntos()
    {
        return $this->hasMany(DocumentoAdjunto::class);
    }

    // Solicitud.php
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
}
