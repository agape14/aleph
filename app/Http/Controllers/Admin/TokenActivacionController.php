<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TokenActivacion;
use App\Models\RolContenido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenActivacionController extends Controller
{
    /**
     * Listar todos los tokens
     */
    public function index()
    {
        $tokens = TokenActivacion::with('usuarioCreador')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.tokens.index', compact('tokens'));
    }

    /**
     * Crear nuevo token
     */
    public function create()
    {
        return view('admin.tokens.create');
    }

    /**
     * Guardar nuevo token
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string|in:rol_contenido,funcionalidad,modulo',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_expiracion' => 'nullable|date|after:now',
            'usos_maximos' => 'nullable|integer|min:1'
        ]);

        $token = TokenActivacion::crearToken(
            $request->tipo,
            $request->nombre,
            $request->descripcion,
            Auth::id(),
            $request->configuracion ? json_decode($request->configuracion, true) : null,
            $request->fecha_expiracion,
            $request->usos_maximos
        );

        return redirect()->route('admin.tokens.show', $token)
            ->with('success', 'Token creado exitosamente. Código: ' . $token->token);
    }

    /**
     * Mostrar detalles del token
     */
    public function show(TokenActivacion $token)
    {
        return view('admin.tokens.show', compact('token'));
    }

    /**
     * Activar token
     */
    public function activar(TokenActivacion $token)
    {
        $token->update(['activo' => true]);

        return redirect()->back()
            ->with('success', 'Token activado exitosamente.');
    }

    /**
     * Desactivar token
     */
    public function desactivar(TokenActivacion $token)
    {
        $token->update(['activo' => false]);

        return redirect()->back()
            ->with('success', 'Token desactivado exitosamente.');
    }

    /**
     * Eliminar token
     */
    public function destroy(TokenActivacion $token)
    {
        $token->delete();

        return redirect()->route('admin.tokens.index')
            ->with('success', 'Token eliminado exitosamente.');
    }

    /**
     * API para activar funcionalidad con token
     */
    public function activarConToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'codigo_activacion' => 'required|string'
        ]);

        $token = TokenActivacion::where('token', $request->token)->first();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token no encontrado'
            ], 404);
        }

        if (!$token->esValido()) {
            return response()->json([
                'success' => false,
                'message' => 'Token no válido o expirado'
            ], 400);
        }

        // Verificar código de activación (puedes implementar tu propia lógica)
        if ($request->codigo_activacion !== 'ACTIVAR_GC_2025') {
            return response()->json([
                'success' => false,
                'message' => 'Código de activación incorrecto'
            ], 400);
        }

        // Activar según el tipo de token
        switch ($token->tipo) {
            case 'rol_contenido':
                $this->activarRolContenido($token);
                break;
            case 'funcionalidad':
                $this->activarFuncionalidad($token);
                break;
            case 'modulo':
                $this->activarModulo($token);
                break;
        }

        $token->usar();

        return response()->json([
            'success' => true,
            'message' => 'Funcionalidad activada exitosamente',
            'data' => [
                'token' => $token->token,
                'tipo' => $token->tipo,
                'nombre' => $token->nombre,
                'usos_restantes' => $token->usos_maximos ? ($token->usos_maximos - $token->usos_actuales) : 'Ilimitado'
            ]
        ]);
    }

    /**
     * Activar rol de contenido
     */
    private function activarRolContenido(TokenActivacion $token)
    {
        // Implementar lógica para activar roles de contenido
        // Por ejemplo, activar el menú del gestor de contenido
        $rol = RolContenido::where('token_activacion', $token->token)->first();
        if ($rol) {
            $rol->activarConToken($token->token);
        }
    }

    /**
     * Activar funcionalidad específica
     */
    private function activarFuncionalidad(TokenActivacion $token)
    {
        // Implementar lógica para activar funcionalidades específicas
        // Por ejemplo, activar el sistema de versionado
        $configuracion = $token->configuracion;

        if (isset($configuracion['funcionalidad'])) {
            // Activar la funcionalidad específica
            // Esto podría ser una configuración en la base de datos o archivo
        }
    }

    /**
     * Activar módulo completo
     */
    private function activarModulo(TokenActivacion $token)
    {
        // Implementar lógica para activar módulos completos
        // Por ejemplo, activar todo el gestor de contenido
        $configuracion = $token->configuracion;

        if (isset($configuracion['modulo'])) {
            // Activar el módulo completo
        }
    }
}
