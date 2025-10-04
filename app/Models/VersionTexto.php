<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersionTexto extends Model
{
    use HasFactory;

    protected $fillable = [
        'texto_dinamico_id',
        'version',
        'contenido_anterior',
        'contenido_nuevo',
        'motivo_cambio',
        'usuario_id'
    ];

    // Relación con TextoDinamico
    public function textoDinamico()
    {
        return $this->belongsTo(TextoDinamico::class);
    }

    // Relación con User
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    // Scope para obtener versiones de un texto específico
    public function scopePorTexto($query, $textoId)
    {
        return $query->where('texto_dinamico_id', $textoId);
    }

    // Scope para obtener versiones por usuario
    public function scopePorUsuario($query, $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }
}
