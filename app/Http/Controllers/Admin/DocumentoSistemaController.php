<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentoSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DocumentoSistemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentos = DocumentoSistema::with('usuario')
            ->orderBy('año_lectivo', 'desc')
            ->orderBy('orden')
            ->paginate(15);

        return view('admin.documentos.index', compact('documentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.documentos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|in:reglamento,formulario,guia,otros',
            'archivo' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB
            'descripcion' => 'nullable|string',
            'año_lectivo' => 'required|integer|min:2020|max:2030',
            'orden' => 'integer|min:0'
        ]);

        $documento = DocumentoSistema::create(array_merge(
            DocumentoSistema::guardarArchivo($request->file('archivo')),
            [
                'nombre' => $request->nombre,
                'tipo' => $request->tipo,
                'descripcion' => $request->descripcion,
                'activo' => $request->has('activo'),
                'orden' => $request->orden ?? 0,
                'año_lectivo' => $request->año_lectivo
            ]
        ));

        // Limpiar cache
        Cache::forget('documentos_sistema_' . $request->año_lectivo);
        Cache::forget('reglamento_becas_' . $request->año_lectivo);

        return redirect()->route('admin.documentos.index')
            ->with('success', 'Documento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentoSistema $documento)
    {
        return view('admin.documentos.show', compact('documento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentoSistema $documento)
    {
        return view('admin.documentos.edit', compact('documento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentoSistema $documento)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|in:reglamento,formulario,guia,otros',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'descripcion' => 'nullable|string',
            'año_lectivo' => 'required|integer|min:2020|max:2030',
            'orden' => 'integer|min:0'
        ]);

        $datos = [
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
            'activo' => $request->has('activo'),
            'orden' => $request->orden ?? 0,
            'año_lectivo' => $request->año_lectivo
        ];

        if ($request->hasFile('archivo')) {
            $documento->eliminarArchivo();
            $datos = array_merge($datos, DocumentoSistema::guardarArchivo($request->file('archivo')));
        }

        $documento->update($datos);

        // Limpiar cache
        Cache::forget('documentos_sistema_' . $request->año_lectivo);
        Cache::forget('reglamento_becas_' . $request->año_lectivo);

        return redirect()->route('admin.documentos.index')
            ->with('success', 'Documento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentoSistema $documento)
    {
        $añoLectivo = $documento->año_lectivo;

        $documento->eliminarArchivo();
        $documento->delete();

        // Limpiar cache
        Cache::forget('documentos_sistema_' . $añoLectivo);
        Cache::forget('reglamento_becas_' . $añoLectivo);

        return redirect()->route('admin.documentos.index')
            ->with('success', 'Documento eliminado exitosamente.');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(DocumentoSistema $documento)
    {
        $documento->update(['activo' => !$documento->activo]);

        // Limpiar cache
        Cache::forget('documentos_sistema_' . $documento->año_lectivo);
        Cache::forget('reglamento_becas_' . $documento->año_lectivo);

        return response()->json([
            'success' => true,
            'activo' => $documento->activo
        ]);
    }
}
