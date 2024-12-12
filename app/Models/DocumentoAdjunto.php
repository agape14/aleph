<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoAdjunto extends Model
{
    use HasFactory;
    protected $table = 'documentos_adjuntos';
    protected $fillable = [
        'solicitud_id',
        'progenitor_id',
        'tipo_documento',
        'ruta_archivo',
        'no_aplica'
    ];

    // Relación con Solicitud
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }

    // Relación con Progenitor (si existe)
    public function progenitor()
    {
        return $this->belongsTo(Progenitor::class);
    }
}
