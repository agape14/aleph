<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LogContenido;
use App\Models\User;

class LogContenidoSeeder extends Seeder
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

        // Crear algunos logs de ejemplo
        $logs = [
            [
                'accion' => 'created',
                'tabla_afectada' => 'textos_dinamicos',
                'registro_id' => 1,
                'usuario_id' => $usuario->id,
                'ip_address' => '127.0.0.1',
                'datos_anteriores' => null,
                'datos_nuevos' => [
                    'clave' => 'declaracion_jurada',
                    'titulo' => 'Declaración Jurada',
                    'contenido' => 'Texto de declaración jurada...'
                ],
                'campo_modificado' => null,
                'motivo_cambio' => 'Creación inicial del texto'
            ],
            [
                'accion' => 'updated',
                'tabla_afectada' => 'textos_dinamicos',
                'registro_id' => 1,
                'usuario_id' => $usuario->id,
                'ip_address' => '127.0.0.1',
                'datos_anteriores' => [
                    'contenido' => 'Texto anterior...'
                ],
                'datos_nuevos' => [
                    'contenido' => 'Texto actualizado...'
                ],
                'campo_modificado' => 'contenido',
                'motivo_cambio' => 'Actualización del contenido'
            ],
            [
                'accion' => 'created',
                'tabla_afectada' => 'documentos_sistema',
                'registro_id' => 1,
                'usuario_id' => $usuario->id,
                'ip_address' => '127.0.0.1',
                'datos_anteriores' => null,
                'datos_nuevos' => [
                    'nombre' => 'Reglamento de Becas 2025',
                    'tipo' => 'reglamento',
                    'año_lectivo' => 2025
                ],
                'campo_modificado' => null,
                'motivo_cambio' => 'Creación del reglamento'
            ]
        ];

        foreach ($logs as $log) {
            LogContenido::create($log);
        }

        $this->command->info('Logs de contenido creados exitosamente.');
    }
}
