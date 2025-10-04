<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DocumentoSistema;

class DocumentosSistemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $añoActual = date('Y') + 1;

        // Deshabilitar temporalmente el trait Loggable para seeders
        DocumentoSistema::unsetEventDispatcher();

        // Verificar si ya existe un reglamento para este año
        $reglamentoExistente = DocumentoSistema::where('tipo', 'reglamento')
            ->where('año_lectivo', $añoActual)
            ->first();

        if (!$reglamentoExistente) {
            // Crear reglamento de becas por defecto
            DocumentoSistema::create([
                'nombre' => "Reglamento de Becas {$añoActual}",
                'tipo' => 'reglamento',
                'ruta_archivo' => 'files/REGLAMENTO DE BECAS ' . $añoActual . '.pdf',
                'nombre_archivo_original' => 'REGLAMENTO DE BECAS ' . $añoActual . '.pdf',
                'mime_type' => 'application/pdf',
                'tamaño_archivo' => 1024000, // 1MB aproximado
                'descripcion' => 'Reglamento oficial de becas para el año lectivo ' . $añoActual,
                'activo' => true,
                'orden' => 1,
                'año_lectivo' => $añoActual,
            ]);

            $this->command->info("Reglamento de Becas {$añoActual} creado exitosamente.");
        } else {
            $this->command->info("Reglamento de Becas {$añoActual} ya existe, omitiendo creación.");
        }

        // Rehabilitar el event dispatcher
        DocumentoSistema::setEventDispatcher(app('events'));
    }
}
