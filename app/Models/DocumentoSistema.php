<?php

namespace App\Models;

use App\Models\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentoSistema extends Model
{
    use HasFactory, Loggable;

    /**
     * Los archivos se sirven desde public/ porque el hosting no dispone del enlace storage:link.
     */
    public const DIRECTORIO = 'files';

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

    // Scope para obtener primero el documento subido más recientemente
    public function scopeMasReciente($query)
    {
        return $query->orderByDesc('created_at')->orderByDesc('id');
    }

    /**
     * Mueve el archivo subido a public/files y devuelve los atributos a persistir.
     */
    public static function guardarArchivo(UploadedFile $archivo): array
    {
        $nombreOriginal = $archivo->getClientOriginalName();
        $datos = [
            'nombre_archivo_original' => $nombreOriginal,
            'mime_type' => $archivo->getMimeType(),
            'tamaño_archivo' => $archivo->getSize(),
        ];

        $extension = strtolower($archivo->getClientOriginalExtension() ?: 'pdf');
        $base = Str::slug(pathinfo($nombreOriginal, PATHINFO_FILENAME)) ?: 'documento';
        $nombreFinal = $base . '-' . now()->format('YmdHis') . '-' . Str::random(6) . '.' . $extension;

        $archivo->move(public_path(self::DIRECTORIO), $nombreFinal);

        $datos['ruta_archivo'] = self::DIRECTORIO . '/' . $nombreFinal;

        return $datos;
    }

    // Borra el archivo físico, tanto si vive en public/ como en el disco public
    public function eliminarArchivo(): void
    {
        if (!$this->ruta_archivo) {
            return;
        }

        if (is_file(public_path($this->ruta_archivo))) {
            @unlink(public_path($this->ruta_archivo));
            return;
        }

        Storage::disk('public')->delete($this->ruta_archivo);
    }

    // Método para obtener la URL del archivo
    public function getUrlAttribute()
    {
        if (!$this->ruta_archivo) {
            return null;
        }

        if (Str::startsWith($this->ruta_archivo, ['http://', 'https://'])) {
            return $this->ruta_archivo;
        }

        if (is_file(public_path($this->ruta_archivo))) {
            $segmentos = array_map('rawurlencode', explode('/', $this->ruta_archivo));

            return asset(implode('/', $segmentos));
        }

        return Storage::url($this->ruta_archivo);
    }

    // Indica si el archivo referenciado sigue existiendo en el servidor
    public function getExisteArchivoAttribute(): bool
    {
        if (!$this->ruta_archivo) {
            return false;
        }

        return is_file(public_path($this->ruta_archivo))
            || Storage::disk('public')->exists($this->ruta_archivo);
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
