<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TokenActivacion;
use App\Models\RolContenido;
use App\Models\User;

class MenuActivacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el primer usuario
        $usuario = User::first();

        if (!$usuario) {
            $this->command->info('No hay usuarios en la base de datos. Creando usuario de prueba...');
            $usuario = User::create([
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Crear tokens de activación para menús
        $tokens = [
            [
                'token' => 'GESTOR_CONTENIDO_2025',
                'tipo' => 'menu',
                'nombre' => 'Gestor de Contenido',
                'descripcion' => 'Activa el menú de Gestor de Contenido',
                'configuracion' => [
                    'menu_key' => 'gestor_contenido',
                    'menu_name' => 'Gestor de Contenido',
                    'icon' => 'edit'
                ],
                'activo' => false, // Inactivo por defecto
                'fecha_expiracion' => now()->addYear(),
                'usos_maximos' => 999,
                'usos_actuales' => 0,
                'usuario_creador' => $usuario->id
            ],
            [
                'token' => 'TEXTOS_DINAMICOS_2025',
                'tipo' => 'submenu',
                'nombre' => 'Textos Dinámicos',
                'descripcion' => 'Activa el submenú de Textos Dinámicos',
                'configuracion' => [
                    'menu_key' => 'gestor_contenido',
                    'submenu_key' => 'textos',
                    'submenu_name' => 'Textos Dinámicos',
                    'icon' => 'file-text'
                ],
                'activo' => false,
                'fecha_expiracion' => now()->addYear(),
                'usos_maximos' => 999,
                'usos_actuales' => 0,
                'usuario_creador' => $usuario->id
            ],
            [
                'token' => 'DOCUMENTOS_SISTEMA_2025',
                'tipo' => 'submenu',
                'nombre' => 'Documentos del Sistema',
                'descripcion' => 'Activa el submenú de Documentos del Sistema',
                'configuracion' => [
                    'menu_key' => 'gestor_contenido',
                    'submenu_key' => 'documentos',
                    'submenu_name' => 'Documentos del Sistema',
                    'icon' => 'file'
                ],
                'activo' => false,
                'fecha_expiracion' => now()->addYear(),
                'usos_maximos' => 999,
                'usos_actuales' => 0,
                'usuario_creador' => $usuario->id
            ],
            [
                'token' => 'LOGS_CAMBIOS_2025',
                'tipo' => 'submenu',
                'nombre' => 'Logs de Cambios',
                'descripcion' => 'Activa el submenú de Logs de Cambios',
                'configuracion' => [
                    'menu_key' => 'gestor_contenido',
                    'submenu_key' => 'logs',
                    'submenu_name' => 'Logs de Cambios',
                    'icon' => 'activity'
                ],
                'activo' => false,
                'fecha_expiracion' => now()->addYear(),
                'usos_maximos' => 999,
                'usos_actuales' => 0,
                'usuario_creador' => $usuario->id
            ]
        ];

        foreach ($tokens as $tokenData) {
            TokenActivacion::create($tokenData);
        }

        // Crear rol de contenido con permisos
        RolContenido::create([
            'nombre' => 'Administrador de Contenido',
            'descripcion' => 'Rol con acceso completo al gestor de contenido',
            'permisos' => [
                'menus' => ['gestor_contenido'],
                'submenus' => ['gestor_contenido.textos', 'gestor_contenido.documentos', 'gestor_contenido.logs'],
                'acciones' => ['create', 'read', 'update', 'delete']
            ],
            'activo' => false, // Inactivo por defecto
            'token_activacion' => 'ROL_ADMIN_CONTENIDO_2025',
            'fecha_activacion' => null
        ]);

        $this->command->info('Tokens de activación de menús creados exitosamente.');
        $this->command->info('Para activar menús, usa los siguientes tokens:');
        $this->command->info('- GESTOR_CONTENIDO_2025 (Menú principal)');
        $this->command->info('- TEXTOS_DINAMICOS_2025 (Submenú Textos)');
        $this->command->info('- DOCUMENTOS_SISTEMA_2025 (Submenú Documentos)');
        $this->command->info('- LOGS_CAMBIOS_2025 (Submenú Logs)');
        $this->command->info('- ROL_ADMIN_CONTENIDO_2025 (Rol completo)');
    }
}
