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

        // Obtener reglamento de becas dinámico con cache: el último PDF subido para el año lectivo
        $reglamentoBecas = Cache::remember('reglamento_becas_' . $añoActual, 3600, function () use ($añoActual) {
            return DocumentoSistema::activos()
                    ->porTipo('reglamento')
                    ->porAñoLectivo($añoActual)
                    ->masReciente()
                    ->first()
                ?? DocumentoSistema::activos()
                    ->porTipo('reglamento')
                    ->masReciente()
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
        $añoActual = date('Y') + 1;

        $documentos = DocumentoSistema::porTipo('reglamento')
            ->masReciente()
            ->get();

        return view('admin.configuracion', compact('config', 'documentos', 'añoActual'));
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

    public function storeDocumento(Request $request)
    {
        $datos = $request->validateWithBag('documento', [
            'nombre' => 'required|string|max:255',
            'año_lectivo' => 'required|integer|min:2020|max:2100',
            'descripcion' => 'nullable|string|max:1000',
            'archivo' => 'required|file|mimes:pdf|mimetypes:application/pdf|max:10240',
        ], [
            'archivo.mimes' => 'El archivo debe ser un PDF.',
            'archivo.mimetypes' => 'El archivo debe ser un PDF.',
            'archivo.max' => 'El PDF no puede superar los 10 MB.',
        ]);

        DocumentoSistema::create(array_merge(
            DocumentoSistema::guardarArchivo($request->file('archivo')),
            [
                'nombre' => $datos['nombre'],
                'tipo' => 'reglamento',
                'descripcion' => $datos['descripcion'] ?? null,
                'activo' => true,
                'orden' => 0,
                'año_lectivo' => $datos['año_lectivo'],
            ]
        ));

        $this->limpiarCacheDocumentos($datos['año_lectivo']);

        return redirect()->route('configuracion.index')
            ->with('success', 'Reglamento subido correctamente. Ya se muestra en el formulario.');
    }

    public function updateDocumento(Request $request, DocumentoSistema $documento)
    {
        $datos = $request->validateWithBag('documentoEdit', [
            'nombre' => 'required|string|max:255',
            'año_lectivo' => 'required|integer|min:2020|max:2100',
            'descripcion' => 'nullable|string|max:1000',
            'archivo' => 'nullable|file|mimes:pdf|mimetypes:application/pdf|max:10240',
        ], [
            'archivo.mimes' => 'El archivo debe ser un PDF.',
            'archivo.mimetypes' => 'El archivo debe ser un PDF.',
            'archivo.max' => 'El PDF no puede superar los 10 MB.',
        ]);

        $añoAnterior = $documento->año_lectivo;

        $atributos = [
            'nombre' => $datos['nombre'],
            'descripcion' => $datos['descripcion'] ?? null,
            'activo' => $request->boolean('activo'),
            'año_lectivo' => $datos['año_lectivo'],
        ];

        if ($request->hasFile('archivo')) {
            $documento->eliminarArchivo();
            $atributos = array_merge($atributos, DocumentoSistema::guardarArchivo($request->file('archivo')));
        }

        $documento->update($atributos);

        $this->limpiarCacheDocumentos($añoAnterior, $documento->año_lectivo);

        return redirect()->route('configuracion.index')
            ->with('success', 'Reglamento actualizado correctamente.');
    }

    public function toggleDocumento(DocumentoSistema $documento)
    {
        $documento->update(['activo' => !$documento->activo]);

        $this->limpiarCacheDocumentos($documento->año_lectivo);

        return redirect()->route('configuracion.index')
            ->with('success', $documento->activo
                ? 'Reglamento activado correctamente.'
                : 'Reglamento desactivado correctamente.');
    }

    public function destroyDocumento(DocumentoSistema $documento)
    {
        $año = $documento->año_lectivo;

        $documento->eliminarArchivo();
        $documento->delete();

        $this->limpiarCacheDocumentos($año);

        return redirect()->route('configuracion.index')
            ->with('success', 'Reglamento eliminado correctamente.');
    }

    /**
     * El reglamento mostrado en el formulario se cachea por año lectivo,
     * por lo que hay que invalidar tanto el año afectado como el vigente.
     */
    private function limpiarCacheDocumentos(...$años): void
    {
        $claves = array_unique(array_filter(array_merge($años, [date('Y'), date('Y') + 1])));

        foreach ($claves as $año) {
            Cache::forget('reglamento_becas_' . $año);
            Cache::forget('documentos_sistema_' . $año);
        }
    }
}
