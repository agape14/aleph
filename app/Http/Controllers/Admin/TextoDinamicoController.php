<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TextoDinamico;
use App\Models\VersionTexto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TextoDinamicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $textos = TextoDinamico::with(['usuario', 'versiones'])
            ->orderBy('seccion')
            ->orderBy('orden')
            ->paginate(15);

        return view('admin.textos.index', compact('textos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.textos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'clave' => 'required|string|max:255|unique:textos_dinamicos,clave',
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'seccion' => 'required|string|max:255',
            'año_lectivo' => 'required|integer|min:2020|max:2030',
            'orden' => 'integer|min:0'
        ]);

        $texto = TextoDinamico::create([
            'clave' => $request->clave,
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'seccion' => $request->seccion,
            'activo' => $request->has('activo'),
            'orden' => $request->orden ?? 0,
            'año_lectivo' => $request->año_lectivo
        ]);

        // Crear versión inicial
        $texto->crearVersion('', $request->contenido, 'Creación inicial');

        // Limpiar cache
        Cache::forget('textos_dinamicos_' . $request->seccion . '_' . $request->año_lectivo);

        return redirect()->route('admin.textos.index')
            ->with('success', 'Texto dinámico creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TextoDinamico $texto)
    {
        $versiones = $texto->versiones()->with('usuario')->orderBy('created_at', 'desc')->get();
        return view('admin.textos.show', compact('texto', 'versiones'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TextoDinamico $texto)
    {
        return view('admin.textos.edit', compact('texto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TextoDinamico $texto)
    {
        $request->validate([
            'clave' => 'required|string|max:255|unique:textos_dinamicos,clave,' . $texto->id,
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'seccion' => 'required|string|max:255',
            'año_lectivo' => 'required|integer|min:2020|max:2030',
            'orden' => 'integer|min:0',
            'motivo_cambio' => 'nullable|string|max:255'
        ]);

        $contenidoAnterior = $texto->contenido;
        $contenidoNuevo = $request->contenido;

        $texto->update([
            'clave' => $request->clave,
            'titulo' => $request->titulo,
            'contenido' => $contenidoNuevo,
            'seccion' => $request->seccion,
            'activo' => $request->has('activo'),
            'orden' => $request->orden ?? 0,
            'año_lectivo' => $request->año_lectivo
        ]);

        // Crear nueva versión si el contenido cambió
        if ($contenidoAnterior !== $contenidoNuevo) {
            $texto->crearVersion(
                $contenidoAnterior,
                $contenidoNuevo,
                $request->motivo_cambio
            );
        }

        // Limpiar cache
        Cache::forget('textos_dinamicos_' . $request->seccion . '_' . $request->año_lectivo);

        return redirect()->route('admin.textos.index')
            ->with('success', 'Texto dinámico actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TextoDinamico $texto)
    {
        $seccion = $texto->seccion;
        $añoLectivo = $texto->año_lectivo;

        $texto->delete();

        // Limpiar cache
        Cache::forget('textos_dinamicos_' . $seccion . '_' . $añoLectivo);

        return redirect()->route('admin.textos.index')
            ->with('success', 'Texto dinámico eliminado exitosamente.');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(TextoDinamico $texto)
    {
        $texto->update(['activo' => !$texto->activo]);

        // Limpiar cache
        Cache::forget('textos_dinamicos_' . $texto->seccion . '_' . $texto->año_lectivo);

        return response()->json([
            'success' => true,
            'activo' => $texto->activo
        ]);
    }

    /**
     * Restore from version
     */
    public function restaurarVersion(TextoDinamico $texto, VersionTexto $version)
    {
        $contenidoAnterior = $texto->contenido;
        $contenidoNuevo = $version->contenido_nuevo;

        $texto->update(['contenido' => $contenidoNuevo]);

        // Crear nueva versión
        $texto->crearVersion(
            $contenidoAnterior,
            $contenidoNuevo,
            'Restauración desde versión ' . $version->version
        );

        // Limpiar cache
        Cache::forget('textos_dinamicos_' . $texto->seccion . '_' . $texto->año_lectivo);

        return redirect()->back()
            ->with('success', 'Texto restaurado desde la versión ' . $version->version);
    }
}
