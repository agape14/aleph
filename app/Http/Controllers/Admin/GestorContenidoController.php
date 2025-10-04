<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentoSistema;
use App\Models\TextoDinamico;
use App\Models\LogContenido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GestorContenidoController extends Controller
{
    /**
     * Dashboard principal del gestor de contenido
     */
    public function index()
    {
        $estadisticas = [
            'total_textos' => TextoDinamico::count(),
            'textos_activos' => TextoDinamico::activos()->count(),
            'total_documentos' => DocumentoSistema::count(),
            'documentos_activos' => DocumentoSistema::activos()->count(),
            'cambios_recientes' => LogContenido::recientes(7)->count(),
        ];

        $textosRecientes = TextoDinamico::with('usuario')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        $documentosRecientes = DocumentoSistema::with('usuario')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        $logsRecientes = LogContenido::with('usuario')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.gestor-contenido.index', compact(
            'estadisticas',
            'textosRecientes',
            'documentosRecientes',
            'logsRecientes'
        ));
    }

    /**
     * Limpiar cache del sistema
     */
    public function limpiarCache()
    {
        Cache::flush();

        return redirect()->back()
            ->with('success', 'Cache del sistema limpiado exitosamente.');
    }

    /**
     * Exportar configuración de contenido
     */
    public function exportar()
    {
        $textos = TextoDinamico::all();
        $documentos = DocumentoSistema::all();

        $configuracion = [
            'textos_dinamicos' => $textos,
            'documentos_sistema' => $documentos,
            'fecha_exportacion' => now(),
            'version' => '1.0'
        ];

        $filename = 'configuracion_contenido_' . date('Y-m-d_H-i-s') . '.json';

        return response()->json($configuracion)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Importar configuración de contenido
     */
    public function importar(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:json|max:10240'
        ]);

        $contenido = file_get_contents($request->file('archivo')->getPathname());
        $configuracion = json_decode($contenido, true);

        if (!$configuracion) {
            return redirect()->back()
                ->with('error', 'El archivo JSON no es válido.');
        }

        try {
            // Importar textos dinámicos
            if (isset($configuracion['textos_dinamicos'])) {
                foreach ($configuracion['textos_dinamicos'] as $textoData) {
                    TextoDinamico::updateOrCreate(
                        ['clave' => $textoData['clave']],
                        $textoData
                    );
                }
            }

            // Importar documentos del sistema
            if (isset($configuracion['documentos_sistema'])) {
                foreach ($configuracion['documentos_sistema'] as $documentoData) {
                    DocumentoSistema::updateOrCreate(
                        ['nombre' => $documentoData['nombre'], 'año_lectivo' => $documentoData['año_lectivo']],
                        $documentoData
                    );
                }
            }

            return redirect()->back()
                ->with('success', 'Configuración importada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al importar la configuración: ' . $e->getMessage());
        }
    }

    /**
     * Ver logs de cambios
     */
    public function logs(Request $request)
    {
        $query = LogContenido::with('usuario');

        // Filtros
        if ($request->filled('tabla')) {
            $query->porTabla($request->tabla);
        }

        if ($request->filled('accion')) {
            $query->porAccion($request->accion);
        }

        if ($request->filled('usuario')) {
            $query->porUsuario($request->usuario);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.gestor-contenido.logs', compact('logs'));
    }
}
