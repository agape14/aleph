<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progenitor;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use App\Models\DocumentoAdjunto;
use App\Models\Solicitud;


class ProgenitorController extends Controller
{
    public function index(Request $request)
    {
        // Obtenemos el término de búsqueda
        $search = $request->input('search');

        // Realizamos la consulta con paginación y filtrado
        $progenitores = Progenitor::query()
            ->when($search, function ($query, $search) {
                return $query->where('nombres', 'like', "%{$search}%")
                            ->orWhere('apellidos', 'like', "%{$search}%")
                            ->orWhere('dni', 'like', "%{$search}%")
                            ->orWhere('codigo_sianet', 'like', "%{$search}%");
            })
            ->paginate(20); // Puedes cambiar 10 por el número de registros por página que desees

        // Retornamos la vista con los progenitores y el término de búsqueda
        return view('admin.progenitores', compact('progenitores', 'search'));
    }


    public function buscar(Request $request)
    {
        $tipoDocumento = $request->query('tipoDocumento');
        $numeroDocumento = $request->query('nroDocumento');
        // Busca el estudiante por el número de documento
        $estudiante = Progenitor::where('tipo_documento', $tipoDocumento)->where('dni', $numeroDocumento)->first();

        if ($estudiante) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $estudiante->id,
                    'nombres' => $estudiante->nombres,
                    'apellidos' => $estudiante->apellidos,
                    'codigo_sianet' => $estudiante->codigo_sianet,
                ]
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Progenitor no encontrado.'], 404);
    }


    public function store(Request $request)
    {
        //dd($request->all());
        try {
            $validatedData = $request->validate([
                'nombres' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'dni' => 'required|string|max:15',
                'tipo_documento' => 'required|string|max:80',
                'cargo' => 'nullable|string|max:255',
                'lugar_trabajo' => 'nullable|string|max:255',
                'ingresos_mensuales' => 'nullable|numeric',
                'recibe_bonos' => 'nullable|boolean',
                'numero_hijos' => 'required|integer|min:0',
                'hijos_matriculados' => 'required|integer|min:0',
            ]);

            $progenitor = $request->id ? Progenitor::find($request->id) : new Progenitor;
            $progenitor->fill($validatedData);
            $progenitor->save();

            return redirect()->back()->with('success', 'Datos registrados correctamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()->with('show_modal', true);
        } catch (\Exception $e) {
            \Log::error('Error al insertar nuevo progenitor desde el CMS: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->with('show_modal',  'create');
        }
    }


    public function storeOrUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => 'required|string|max:15',
            'tipo_documento' => 'required|string|max:80',
            'cargo' => 'nullable|string|max:255',
            'lugar_trabajo' => 'nullable|string|max:255',
            'ingresos_mensuales' => 'nullable|numeric',
            'recibe_bonos' => 'nullable|boolean',
        ]);

        /*$progenitor = Progenitor::updateOrCreate(
            ['dni' => $validatedData['dni']],
            $validatedData
        );*/
        $progenitor = $request->id ? Progenitor::find($request->id) : new Progenitor;
        $progenitor->fill($request->all());
        $progenitor->save();

        return redirect()->back()->with('success', 'Datos guardados correctamente');
    }


    public function updateProgenitor(Request $request, Progenitor $progenitor)
    {
        //dd($request->all(), $progenitor);
        try {
            $validatedData = $request->validate([
                'nombres' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'dni' => 'required|string|max:15',
                'tipo' => 'required|in:progenitor1,progenitor2',
                'codigo_sianet' => 'nullable|string|max:255',
                'numero_hijos' => 'required|integer|min:0',
                'hijos_matriculados' => 'required|integer|min:0',
                'formacion_academica' => 'required|in:tecnica,universitaria,bachillerato,titulado,maestria,doctorado',
                'trabaja' => 'required|boolean',
                'tiempo_desempleo' => 'nullable|string|max:255',
                'sueldo_fijo' => 'nullable|boolean',
                'sueldo_variable' => 'nullable|boolean',
                'cargo' => 'nullable|string|max:255',
                'anio_inicio_laboral' => 'nullable|integer|min:1900|max:' . date('Y'),
                'lugar_trabajo' => 'nullable|string|max:255',
                'ingresos_mensuales' => 'nullable|numeric|min:0',
                'recibe_bonos' => 'nullable|boolean',
                'monto_bonos' => 'nullable|in:5000-10000,10000-15000,15000-mas',
                'recibe_utilidades' => 'nullable|boolean',
                'monto_utilidades' => 'nullable|in:5000-10000,10000-15000,15000-mas',
                'titular_empresa' => 'nullable|boolean',
                'porcentaje_acciones' => 'nullable|numeric|min:0',
                'razon_social' => 'nullable|string|max:255',
                'numero_ruc' => 'nullable|string|max:15',
                'vivienda_tipo' => 'nullable|in:propia,alquilada',
                'credito_hipotecario' => 'nullable|boolean',
                'direccion_vivienda' => 'nullable|string',
                'm2_vivienda' => 'nullable|numeric|min:0',
                'cantidad_inmuebles' => 'nullable|integer|min:0',
            ]);

            // Actualizar los campos del progenitor
            $resultado = $progenitor->update($validatedData);

            // Ver qué devuelve update() y cómo quedó el modelo después
            //dd(['Resultado de update()' => $resultado,'Datos después de actualizar' => $progenitor->refresh()]);

            // Redireccionar con un mensaje de éxito
            return redirect()->back()->with('success', 'Progenitor actualizado correctamente.');
        } catch (\Exception $e) {
            // Si hay un error, redirigir con el mensaje de error
            return redirect()->back()->with('error', 'Error al actualizar el progenitor: ' . $e->getMessage());
        }
    }

    public function descargarDocumentos($solicitud_id)
    {
        // Obtener la solicitud y el estudiante
        $solicitud = Solicitud::with('estudiante', 'documentosAdjuntos')->find($solicitud_id);

        if (!$solicitud || $solicitud->documentosAdjuntos->isEmpty()) {
            return back()->with('error', 'No hay documentos para esta solicitud.');
        }

        $estudianteNombre = str_replace(' ', '_', $solicitud->estudiante->apepaterno.' '.$solicitud->estudiante->apematerno.' '.$solicitud->estudiante->nombres); // Reemplaza espacios por guiones bajos
        $zipFileName = "documentos_{$estudianteNombre}.zip";
        $zipPath = storage_path("app/public/temp/{$zipFileName}");

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($solicitud->documentosAdjuntos as $doc) {
                $filePath = storage_path("app/public/{$doc->ruta_archivo}");

                if (file_exists($filePath)) {
                    // Organizar por progenitor si es posible
                    $folder = $doc->progenitor_id ? "Progenitor_{$doc->progenitor_id}" : "Estudiante";
                    $zip->addFile($filePath, "{$folder}/" . basename($doc->ruta_archivo));
                }
            }
            $zip->close();
        } else {
            return back()->with('error', 'No se pudo crear el archivo ZIP.');
        }

        // Descargar y eliminar después de enviar
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

}
