<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TokenActivacion;
use App\Models\RolContenido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TokenMenuController extends Controller
{
    /**
     * Mostrar página de activación de tokens
     */
    public function index()
    {
        $tokens = TokenActivacion::with('usuarioCreador')
            ->orderBy('tipo')
            ->orderBy('nombre')
            ->get();

        $roles = RolContenido::orderBy('nombre')->get();

        return view('admin.tokens.index', compact('tokens', 'roles'));
    }

    /**
     * Activar un token
     */
    public function activar(Request $request, $token)
    {
        $tokenModel = TokenActivacion::where('token', $token)->first();

        if (!$tokenModel) {
            return response()->json([
                'success' => false,
                'message' => 'Token no encontrado'
            ], 404);
        }

        if (!$tokenModel->esValido()) {
            return response()->json([
                'success' => false,
                'message' => 'Token expirado o sin usos disponibles'
            ], 400);
        }

        $tokenModel->update(['activo' => true]);
        $tokenModel->usar(); // Incrementar usos

        // Limpiar cache
        Cache::forget('menus_activos');

        return response()->json([
            'success' => true,
            'message' => 'Token activado exitosamente',
            'token' => $tokenModel
        ]);
    }

    /**
     * Desactivar un token
     */
    public function desactivar(Request $request, $token)
    {
        $tokenModel = TokenActivacion::where('token', $token)->first();

        if (!$tokenModel) {
            return response()->json([
                'success' => false,
                'message' => 'Token no encontrado'
            ], 404);
        }

        $tokenModel->update(['activo' => false]);

        // Limpiar cache
        Cache::forget('menus_activos');

        return response()->json([
            'success' => true,
            'message' => 'Token desactivado exitosamente',
            'token' => $tokenModel
        ]);
    }

    /**
     * Activar un rol
     */
    public function activarRol(Request $request, $rolId)
    {
        $rol = RolContenido::find($rolId);

        if (!$rol) {
            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado'
            ], 404);
        }

        $rol->update([
            'activo' => true,
            'fecha_activacion' => now()
        ]);

        // Limpiar cache
        Cache::forget('menus_activos');

        return response()->json([
            'success' => true,
            'message' => 'Rol activado exitosamente',
            'rol' => $rol
        ]);
    }

    /**
     * Desactivar un rol
     */
    public function desactivarRol(Request $request, $rolId)
    {
        $rol = RolContenido::find($rolId);

        if (!$rol) {
            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado'
            ], 404);
        }

        $rol->update([
            'activo' => false,
            'fecha_activacion' => null
        ]);

        // Limpiar cache
        Cache::forget('menus_activos');

        return response()->json([
            'success' => true,
            'message' => 'Rol desactivado exitosamente',
            'rol' => $rol
        ]);
    }

    /**
     * API para activar con token
     */
    public function activarConToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        $token = $request->token;
        $tokenModel = TokenActivacion::where('token', $token)->first();

        if (!$tokenModel) {
            return response()->json([
                'success' => false,
                'message' => 'Token no encontrado'
            ], 404);
        }

        if (!$tokenModel->esValido()) {
            return response()->json([
                'success' => false,
                'message' => 'Token expirado o sin usos disponibles'
            ], 400);
        }

        $tokenModel->update(['activo' => true]);
        $tokenModel->usar();

        // Limpiar cache
        Cache::forget('menus_activos');

        return response()->json([
            'success' => true,
            'message' => 'Token activado exitosamente',
            'tipo' => $tokenModel->tipo,
            'configuracion' => $tokenModel->configuracion
        ]);
    }
}
