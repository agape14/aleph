<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomValidatePostSize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener el límite de post_max_size de PHP
        $maxSize = $this->parseSize(ini_get('post_max_size'));

        // Para el formulario principal, permitir hasta 100MB
        if ($request->is('/') || $request->is('setdatos')) {
            $maxSize = 100 * 1024 * 1024; // 100MB
        }

        // Verificar el tamaño del contenido
        $contentLength = $request->header('content-length');

        if ($contentLength && $contentLength > $maxSize) {
            // Si es una petición AJAX, devolver JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'El tamaño de los datos enviados excede el límite permitido.',
                    'message' => 'El formulario es demasiado grande. Por favor, reduce el tamaño de los archivos.',
                    'max_size' => $this->formatBytes($maxSize),
                    'current_size' => $this->formatBytes($contentLength),
                    'suggestions' => [
                        'Comprime los archivos PDF antes de subirlos',
                        'Usa imágenes JPG en lugar de PNG',
                        'Sube menos archivos a la vez'
                    ]
                ], 413);
            }

            // Para peticiones normales, mostrar página de error
            return response()->view('errors.413', [
                'max_size' => $this->formatBytes($maxSize),
                'current_size' => $this->formatBytes($contentLength)
            ], 413);
        }

        return $next($request);
    }

    /**
     * Parse size string to bytes
     */
    private function parseSize($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
        $size = preg_replace('/[^0-9\.]/', '', $size);

        if ($unit) {
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        }

        return round($size);
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
