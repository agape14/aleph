<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolContenido extends Model
{
    use HasFactory;

    protected $table = 'roles_contenido';

    protected $fillable = [
        'nombre',
        'descripcion',
        'permisos',
        'activo',
        'token_activacion',
        'fecha_activacion'
    ];

    protected $casts = [
        'permisos' => 'array',
        'activo' => 'boolean',
        'fecha_activacion' => 'datetime'
    ];

    // Scope para roles activos
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Método para verificar si un usuario tiene un permiso específico
    public function tienePermiso($permiso)
    {
        return in_array($permiso, $this->permisos ?? []);
    }

    // Método para activar el rol con token
    public function activarConToken($token)
    {
        if ($this->token_activacion === $token) {
            $this->update([
                'activo' => true,
                'fecha_activacion' => now()
            ]);
            return true;
        }
        return false;
    }

    // Método para generar token de activación
    public function generarTokenActivacion()
    {
        $token = 'GC_' . strtoupper(substr(md5(uniqid()), 0, 12));
        $this->update(['token_activacion' => $token]);
        return $token;
    }
}
