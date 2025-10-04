<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VersionTexto;
use App\Models\TextoDinamico;
use App\Models\User;

class VersionTextoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el primer usuario para los logs
        $usuario = User::first();

        if (!$usuario) {
            $this->command->info('No hay usuarios en la base de datos. Creando usuario de prueba...');
            $usuario = User::create([
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Obtener textos dinámicos existentes
        $textos = TextoDinamico::all();

        if ($textos->count() > 0) {
            foreach ($textos as $texto) {
                // Crear una versión inicial para cada texto
                VersionTexto::create([
                    'texto_dinamico_id' => $texto->id,
                    'version' => 1,
                    'contenido_anterior' => '',
                    'contenido_nuevo' => $texto->contenido,
                    'motivo_cambio' => 'Versión inicial',
                    'usuario_id' => $usuario->id
                ]);
            }

            $this->command->info('Versiones de texto creadas exitosamente.');
        } else {
            $this->command->info('No hay textos dinámicos para crear versiones.');
        }
    }
}
