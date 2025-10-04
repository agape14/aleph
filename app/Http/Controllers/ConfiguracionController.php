<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;
use App\Models\DocumentoSistema;
use App\Models\TextoDinamico;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ConfiguracionController extends Controller
{
    public function verificarFormulario()
    {
        $config = Configuracion::where('nombre', 'registro_solicitud')->first();

        $mensaje = null;
        $mostrarFormulario = false;

        if (!$config || $config->valor !== 'activo') {
            $mensaje = $config->mensaje ?? 'El registro de solicitudes no está activo en este momento.';
        } else {
            $now = Carbon::now();

            if ($config->fecha_inicio && $config->fecha_fin) {
                if ($now->lt($config->fecha_inicio) || $now->gt($config->fecha_fin)) {
                    $mensaje = $config->mensaje ?? 'El registro de solicitudes está fuera del rango de fechas permitido.';
                } else {
                    $mostrarFormulario = true;
                }
            } else {
                $mensaje = $config->mensaje ?? 'El rango de fechas para el registro de solicitudes no está configurado.';
            }
        }

        // Obtener datos dinámicos con cache
        $añoActual = date('Y') + 1;

        // Obtener reglamento de becas dinámico con cache
        $reglamentoBecas = Cache::remember('reglamento_becas_' . $añoActual, 3600, function () use ($añoActual) {
            return DocumentoSistema::activos()
                ->porTipo('reglamento')
                ->porAñoLectivo($añoActual)
                ->orderBy('orden')
                ->first();
        });

        // Obtener textos dinámicos del paso 1 con cache
        $textosDinamicos = Cache::remember('textos_dinamicos_paso1_' . $añoActual, 3600, function () use ($añoActual) {
            return TextoDinamico::obtenerPorSeccion('paso1', $añoActual);
        });

        return view('index', [
            'formTimeout' => env('FORM_TIMEOUT', 300),
            'formAlertTime' => env('SESSION_LIFETIME', 240),
            'mostrarFormulario' => $mostrarFormulario,
            'mensaje' => $mensaje,
            'titulo_mensaje' => $config->titulo_mensaje === '-' ? '' : $config->titulo_mensaje,
            'pie_mensaje' => $config->pie_mensaje === '-' ? '' : $config->pie_mensaje,
            'reglamentoBecas' => $reglamentoBecas,
            'textosDinamicos' => $textosDinamicos,
            'añoActual' => $añoActual,
        ]);
    }


    public function index() {
        $config = Configuracion::where('nombre', 'registro_solicitud')->first();
        return view('admin.configuracion', compact('config'));
    }

    public function update(Request $request) {
        $request->validate([
            'valor' => 'required|in:activo,inactivo',
            'mensaje' => 'nullable',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        Configuracion::updateOrCreate(
            ['nombre' => 'registro_solicitud'],
            [
                'valor' => $request->valor,
                'mensaje' => $request->mensaje,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'titulo_mensaje' => $request->titulo_mensaje,
                'pie_mensaje' => $request->pie_mensaje,
            ]
        );

        return redirect()->route('configuracion.index')->with('success', 'Configuración actualizada correctamente.');
    }

}
