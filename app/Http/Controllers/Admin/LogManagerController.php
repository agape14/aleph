<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LogManagerController extends Controller
{
    private $logPath;
    private $backupPath;

    public function __construct()
    {
        $this->logPath = storage_path('logs/laravel.log');
        $this->backupPath = storage_path('logs/backups');

        // Crear directorio de backups si no existe
        if (!File::exists($this->backupPath)) {
            File::makeDirectory($this->backupPath, 0755, true);
        }
    }

    /**
     * Mostrar la vista principal de gestión de logs
     */
    public function index()
    {
        $backups = $this->getBackups();
        return view('admin.logs.index', compact('backups'));
    }

    /**
     * Obtener lista de copias de logs
     */
    private function getBackups()
    {
        $files = File::files($this->backupPath);
        $backups = [];

        foreach ($files as $file) {
            $backups[] = [
                'name' => $file->getFilename(),
                'path' => $file->getPathname(),
                'size' => $this->formatBytes($file->getSize()),
                'date' => Carbon::createFromTimestamp($file->getMTime())->format('Y-m-d H:i:s')
            ];
        }

        // Ordenar por fecha más reciente primero
        usort($backups, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return $backups;
    }

    /**
     * Crear copia del log principal
     */
    public function copiar()
    {
        try {
            if (!File::exists($this->logPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo de log principal no existe.'
                ], 404);
            }

            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $backupFileName = "laravel_log_backup_{$timestamp}.log";
            $backupFilePath = $this->backupPath . '/' . $backupFileName;

            File::copy($this->logPath, $backupFilePath);

            return response()->json([
                'success' => true,
                'message' => 'Copia del log creada exitosamente.',
                'backup' => [
                    'name' => $backupFileName,
                    'size' => $this->formatBytes(File::size($backupFilePath)),
                    'date' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la copia: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener contenido de una copia específica
     */
    public function ver(Request $request)
    {
        $fileName = $request->input('file');
        $filePath = $this->backupPath . '/' . $fileName;

        if (!File::exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'El archivo no existe.'
            ], 404);
        }

        try {
            $content = File::get($filePath);

            return response()->json([
                'success' => true,
                'content' => $content,
                'filename' => $fileName
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al leer el archivo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar una copia de log
     */
    public function eliminar(Request $request)
    {
        $fileName = $request->input('file');
        $filePath = $this->backupPath . '/' . $fileName;

        if (!File::exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'El archivo no existe.'
            ], 404);
        }

        try {
            File::delete($filePath);

            return response()->json([
                'success' => true,
                'message' => 'Copia eliminada exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el archivo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Descargar una copia de log
     */
    public function descargar($fileName)
    {
        $filePath = $this->backupPath . '/' . $fileName;

        if (!File::exists($filePath)) {
            abort(404, 'El archivo no existe.');
        }

        return response()->download($filePath);
    }

    /**
     * Formatear bytes a un formato legible
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

