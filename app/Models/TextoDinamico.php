<?php

namespace App\Models;

use App\Models\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextoDinamico extends Model
{
    use HasFactory, Loggable;

    protected $table = 'textos_dinamicos';

    protected $fillable = [
        'clave',
        'titulo',
        'contenido',
        'seccion',
        'activo',
        'orden',
        'año_lectivo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'año_lectivo' => 'integer'
    ];

    // Scope para textos activos
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Scope para textos por sección
    public function scopePorSeccion($query, $seccion)
    {
        return $query->where('seccion', $seccion);
    }

    // Scope para textos por año lectivo
    public function scopePorAñoLectivo($query, $año)
    {
        return $query->where('año_lectivo', $año);
    }

    // Método para obtener texto por clave
    public static function obtenerPorClave($clave, $año = null)
    {
        $query = static::activos()->where('clave', $clave);

        if ($año) {
            $query->porAñoLectivo($año);
        }

        return $query->first();
    }

    // Método para obtener todos los textos de una sección
    public static function obtenerPorSeccion($seccion, $año = null)
    {
        $query = static::activos()->porSeccion($seccion)->orderBy('orden');

        if ($año) {
            $query->porAñoLectivo($año);
        }

        return $query->get();
    }

    // Relación con VersionTexto
    public function versiones()
    {
        return $this->hasMany(VersionTexto::class);
    }

    // Relación con User (para logs)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Método para crear una nueva versión
    public function crearVersion($contenidoAnterior, $contenidoNuevo, $motivoCambio = null, $usuarioId = null)
    {
        $ultimaVersion = $this->versiones()->max('version') ?? '0.0';
        $nuevaVersion = $this->incrementarVersion($ultimaVersion);

        return $this->versiones()->create([
            'version' => $nuevaVersion,
            'contenido_anterior' => $contenidoAnterior,
            'contenido_nuevo' => $contenidoNuevo,
            'motivo_cambio' => $motivoCambio,
            'usuario_id' => $usuarioId ?? auth()->id()
        ]);
    }

    // Método para incrementar versión
    private function incrementarVersion($versionActual)
    {
        $partes = explode('.', $versionActual);
        $partes[1] = (int)$partes[1] + 1;
        return implode('.', $partes);
    }

    // Método para obtener la versión actual
    public function obtenerVersionActual()
    {
        return $this->versiones()->latest()->first();
    }
}
