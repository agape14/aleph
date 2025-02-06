<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progenitor;

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


}
