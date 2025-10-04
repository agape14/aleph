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
        LogContenido::create([
            'tabla_afectada' => $this->getTable(),
            'registro_id' => $this->getKey(),
            'accion' => $accion,
            'datos_anteriores' => $datosAnteriores,
            'datos_nuevos' => $datosNuevos,
            'usuario_id' => auth()->id(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent()
        ]);
    }
}
