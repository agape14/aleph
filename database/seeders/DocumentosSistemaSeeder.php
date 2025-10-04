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
    }
}
