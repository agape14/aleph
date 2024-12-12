<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progenitor;

class ProgenitorController extends Controller
{
    public function index(){
        $progenitores=Progenitor::all();
        return view('admin.progenitores', [
            'msg' => "Hello! I am admin",
            'progenitores' => $progenitores // Pasar la colección a la vista
        ]);
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
}
