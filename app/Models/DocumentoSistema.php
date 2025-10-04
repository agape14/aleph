<?php

namespace App\Models;

use App\Models\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DocumentoSistema extends Model
{
    use HasFactory, Loggable;

    protected $table = 'documentos_sistema';

    protected $fillable = [
        'nombre',
        'tipo',
        'ruta_archivo',
        'nombre_archivo_original',
        'mime_type',
        'tamaño_archivo',
        'descripcion',
        'activo',
        'orden',
        'año_lectivo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'año_lectivo' => 'integer'
    ];

    // Scope para documentos activos
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Scope para documentos por tipo
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    // Scope para documentos por año lectivo
    public function scopePorAñoLectivo($query, $año)
    {
        return $query->where('año_lectivo', $año);
    }

    // Método para obtener la URL del archivo
    public function getUrlAttribute()
    {
        return Storage::url($this->ruta_archivo);
    }

    // Método para obtener el tamaño formateado
    public function getTamañoFormateadoAttribute()
    {
        $bytes = $this->tamaño_archivo;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    // Relación con User (para logs)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
