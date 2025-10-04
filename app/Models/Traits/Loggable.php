<?php

namespace App\Models\Traits;

use App\Models\LogContenido;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

trait Loggable
{
    protected static function bootLoggable()
    {
        static::created(function ($model) {
            $model->logCambio('created', null, $model->getAttributes());
        });

        static::updated(function ($model) {
            $model->logCambio('updated', $model->getOriginal(), $model->getChanges());
        });

        static::deleted(function ($model) {
            $model->logCambio('deleted', $model->getOriginal(), null);
        });
    }

    protected function logCambio($accion, $datosAnteriores = null, $datosNuevos = null)
    {
        // Obtener usuario ID, usar 1 como fallback para seeders
        $usuarioId = auth()->id() ?? 1;

        // Si no hay usuario autenticado, buscar el primer usuario o crear uno temporal
        if (!$usuarioId || $usuarioId === 1) {
            $usuario = \App\Models\User::first();
            $usuarioId = $usuario ? $usuario->id : 1;
        }

        LogContenido::create([
            'tabla_afectada' => $this->getTable(),
            'registro_id' => $this->getKey(),
            'accion' => $accion,
            'datos_anteriores' => $datosAnteriores,
            'datos_nuevos' => $datosNuevos,
            'usuario_id' => $usuarioId,
            'ip_address' => Request::ip() ?? '127.0.0.1',
            'user_agent' => Request::userAgent() ?? 'Seeder'
        ]);
    }
}
