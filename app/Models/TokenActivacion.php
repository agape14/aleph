<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TokenActivacion extends Model
{
    use HasFactory;

    protected $table = 'tokens_activacion';

    protected $fillable = [
        'token',
        'tipo',
        'nombre',
        'descripcion',
        'configuracion',
        'activo',
        'fecha_expiracion',
        'usos_maximos',
        'usos_actuales',
        'usuario_creador'
    ];

    protected $casts = [
        'configuracion' => 'array',
        'activo' => 'boolean',
        'fecha_expiracion' => 'datetime'
    ];

    // Relación con usuario creador
    public function usuarioCreador()
    {
        return $this->belongsTo(User::class, 'usuario_creador');
    }

    // Scope para tokens activos
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Scope para tokens no expirados
    public function scopeNoExpirados($query)
    {
        return $query->where(function($q) {
            $q->whereNull('fecha_expiracion')
              ->orWhere('fecha_expiracion', '>', now());
        });
    }

    // Scope para tokens con usos disponibles
    public function scopeConUsosDisponibles($query)
    {
        return $query->where(function($q) {
            $q->whereNull('usos_maximos')
              ->orWhereRaw('usos_actuales < usos_maximos');
        });
    }

    // Método para verificar si el token es válido
    public function esValido()
    {
        if (!$this->activo) return false;
        if ($this->fecha_expiracion && $this->fecha_expiracion < now()) return false;
        if ($this->usos_maximos && $this->usos_actuales >= $this->usos_maximos) return false;

        return true;
    }

    // Método para usar el token
    public function usar()
    {
        if (!$this->esValido()) return false;

        $this->increment('usos_actuales');
        return true;
    }

    // Método para generar token único
    public static function generarToken()
    {
        do {
            $token = 'TK_' . strtoupper(substr(md5(uniqid() . microtime()), 0, 16));
        } while (static::where('token', $token)->exists());

        return $token;
    }

    // Método para crear token de activación
    public static function crearToken($tipo, $nombre, $descripcion, $usuarioId, $configuracion = null, $fechaExpiracion = null, $usosMaximos = null)
    {
        return static::create([
            'token' => static::generarToken(),
            'tipo' => $tipo,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'configuracion' => $configuracion,
            'activo' => false, // Se activa manualmente
            'fecha_expiracion' => $fechaExpiracion,
            'usos_maximos' => $usosMaximos,
            'usuario_creador' => $usuarioId
        ]);
    }
}
