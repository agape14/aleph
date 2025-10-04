<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogContenido extends Model
{
    use HasFactory;

    protected $fillable = [
        'tabla_afectada',
        'registro_id',
        'accion',
        'datos_anteriores',
        'datos_nuevos',
        'campo_modificado',
        'valor_anterior',
        'valor_nuevo',
        'usuario_id',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array'
    ];

    // Relación con User
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    // Scope para obtener logs por tabla
    public function scopePorTabla($query, $tabla)
    {
        return $query->where('tabla_afectada', $tabla);
    }

    // Scope para obtener logs por acción
    public function scopePorAccion($query, $accion)
    {
        return $query->where('accion', $accion);
    }

    // Scope para obtener logs por usuario
    public function scopePorUsuario($query, $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }

    // Scope para obtener logs recientes
    public function scopeRecientes($query, $dias = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($dias));
    }
}
