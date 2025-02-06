<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DB;
use File;

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
            $this->error('Error al generar el backup.');
            return;
        }

        $this->info("Backup generado exitosamente: {$backupFullPath}");
/*
        // Subir el backup a Google Drive
        $folderId = $this->getGoogleDriveFolder();
        $fileContents = file_get_contents($backupFullPath);

        $filePath = "backups/{$folderId}/aleph/" . Carbon::now()->format('Y/m') . "/{$backupFile}";
        Storage::disk('google')->put($filePath, $fileContents);

        $this->info("Backup subido a Google Drive: {$filePath}");
        */
    }

    private function getGoogleDriveFolder()
    {
        return env('GOOGLE_DRIVE_FOLDER_ID');
    }
}
