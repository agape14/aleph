<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;
    protected $table = 'configuraciones';

    protected $fillable = [
        'nombre', 'valor', 'fecha_inicio', 'fecha_fin','mensaje', 'titulo_mensaje','pie_mensaje'
    ];
}
