<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DB;
use File;
use Log;

class BackupDatabase extends Command
{
    protected $signature = 'database:backup';
    protected $description = 'Genera un backup de la base de datos y lo sube a Google Drive.';

    public function handle()
    {
        $databaseName = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $backupPath = storage_path('app/backups');

        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $backupFile = "aleph_{$timestamp}.sql";
        $backupFullPath = "{$backupPath}/{$backupFile}";

        // Comando para generar el backup
        $command = "mysqldump --user={$user} --password={$password} --host={$host} {$databaseName} > {$backupFullPath}";
        $result = system($command);

        if (!File::exists($backupFullPath)) {
            $this->error('❌ Error al generar el backup.');
            Log::error("Error al generar el backup: {$backupFullPath}");
            return;
        }

        $this->info("✅ Backup generado exitosamente: {$backupFullPath}");
        Log::info("Backup generado: {$backupFullPath}");

        // Subir el archivo a Google Drive
        $this->uploadToGoogleDrive($backupFullPath, $backupFile);
    }

    private function uploadToGoogleDrive($filePath, $fileName)
    {
        try {
            // Verifica que el archivo existe antes de intentar abrirlo
            if (!file_exists($filePath)) {
                $this->error("❌ El archivo no existe: {$filePath}");
                Log::error("El archivo no existe: {$filePath}");
                return;
            }

            // Lee el contenido del archivo como string
            $fileContents = file_get_contents($filePath);

            if ($fileContents === false) {
                $this->error("❌ Error al leer el archivo: {$filePath}");
                Log::error("Error al leer el archivo: {$filePath}");
                return;
            }

            // Usa write() en lugar de writeStream()
            Storage::disk('google')->write($fileName, $fileContents);

            $this->info("✅ Backup subido a Google Drive: {$fileName}");
            Log::info("Backup subido a Google Drive: {$fileName}");

            // ✅ Eliminar el archivo local después de subirlo
            File::delete($filePath);
            $this->info("🗑️ Backup local eliminado: {$filePath}");
            Log::info("Backup local eliminado: {$filePath}");

        } catch (\Exception $e) {
            $this->error("❌ Error al subir el backup a Google Drive: " . $e->getMessage());
            Log::error("Error al subir el backup a Google Drive: " . $e->getMessage());
        }
    }

}
