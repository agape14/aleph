<?php

namespace App\Http\Controllers;

use App\Imports\EstudianteImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Estudiante;

class EstudianteController extends Controller
{
    public function importarExcel(Request $request)
    {
        $path = $request->file('file')->store('excel_files');

        Excel::import(new EstudianteImport, $path);

        return response()->json(['message' => 'Importación exitosa']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:estudiantes,id',
            'nombres' => 'required|string',
            'apepaterno' => 'required|string',
            'apematerno' => 'required|string',
            'tipo_documento' => 'required|string',
            'nro_documento' => 'required|string|max:15',
            'codigo_sianet' => 'required|string',
        ]);

        $estudiante = Estudiante::findOrFail($request->id);
        $estudiante->update($request->all());

        return redirect()->back()->with('success', 'Estudiante actualizado correctamente');
    }

    public function index(){
        $estudiantes=Estudiante::all();
        return view('admin.estudiantes', [
            'msg' => "Hello! I am admin",
            'estudiantes' => $estudiantes // Pasar la colección a la vista
        ]);
    }

    public function buscar(Request $request)
    {
        $tipoDocumento = $request->query('tipoDocumento');
        $numeroDocumento = $request->query('nroDocumento');
        // Busca el estudiante por el número de documento
        $estudiante = Estudiante::where('tipo_documento', $tipoDocumento)->where('nro_documento', $numeroDocumento)->first();

        if ($estudiante) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $estudiante->id,
                    'nombres' => $estudiante->nombres,
                    'apellidos' => $estudiante->apepaterno.' '.$estudiante->apematerno,
                    'codigo_sianet' => $estudiante->codigo_sianet,
                ]
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Estudiante no encontrado.'], 404);
    }

    public function setdatos(Request $request)
    {
        dd($request->all());
        return response()->json(['success' => false, 'message' => 'Estudiante no encontrado.'], 404);
    }
}
