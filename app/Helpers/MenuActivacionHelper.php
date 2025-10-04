<?php

namespace App\Helpers;

use App\Models\TokenActivacion;
use App\Models\RolContenido;

class MenuActivacionHelper
{
    /**
     * Verificar si un menú está activado por token
     */
    public static function isMenuActivo($menuKey)
    {
        // Verificar si hay un token activo para este menú
        $token = TokenActivacion::activos()
            ->where('tipo', 'menu')
            ->where('configuracion->menu_key', $menuKey)
            ->where('activo', true)
            ->first();

        if ($token) {
            return $token->esValido();
        }

        // Verificar si hay un rol activo que tenga permisos para este menú
        $rol = RolContenido::activos()
            ->where('activo', true)
            ->where('permisos->menus', 'like', '%' . $menuKey . '%')
            ->first();

        return $rol !== null;
    }

    /**
     * Verificar si un submenú está activado
     */
    public static function isSubmenuActivo($menuKey, $submenuKey)
    {
        $token = TokenActivacion::activos()
            ->where('tipo', 'submenu')
            ->where('configuracion->menu_key', $menuKey)
            ->where('configuracion->submenu_key', $submenuKey)
            ->where('activo', true)
            ->first();

        if ($token) {
            return $token->esValido();
        }

        // Verificar rol
        $rol = RolContenido::activos()
            ->where('activo', true)
            ->where('permisos->submenus', 'like', '%' . $menuKey . '.' . $submenuKey . '%')
            ->first();

        return $rol !== null;
    }

    /**
     * Obtener todos los menús activos
     */
    public static function getMenusActivos()
    {
        $menus = [];

        // Verificar tokens de menús
        $tokens = TokenActivacion::activos()
            ->where('tipo', 'menu')
            ->where('activo', true)
            ->get();

        foreach ($tokens as $token) {
            if ($token->esValido()) {
                $config = $token->configuracion;
                if (isset($config['menu_key'])) {
                    $menus[] = $config['menu_key'];
                }
            }
        }

        // Verificar roles
        $roles = RolContenido::activos()
            ->where('activo', true)
            ->get();

        foreach ($roles as $rol) {
            if (isset($rol->permisos['menus'])) {
                $menus = array_merge($menus, $rol->permisos['menus']);
            }
        }

        return array_unique($menus);
    }
}
