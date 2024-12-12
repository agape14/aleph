<?php

namespace App\Http\Controllers;

use App\Imports\EstudianteImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Solicitud;
use App\Models\Estudiante;
use App\Models\Progenitor;
use App\Models\SituacionEconomica;
use App\Models\DocumentoAdjunto;
use Carbon\Carbon;

class EstudianteController extends Controller
{
    public function importarExcel(Request $request)
    {
        $path = $request->file('file')->store('excel_files');

        Excel::import(new EstudianteImport, $path);
        return redirect()->back()->with('success', 'Se importo los estudiantes de manera correcta');
        //return response()->json(['message' => 'Importación exitosa']);
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

    public function transferToProgenitores()
    {
        try {
            // Obtener los estudiantes cuyo código SIANET empieza con 'F'
            $estudiantes = Estudiante::where('codigo_sianet', 'LIKE', 'F%')->get();

            foreach ($estudiantes as $estudiante) {
                Progenitor::create([
                    'tipo' => $estudiante->tipo ?? 'progenitor1',
                    'tipo_documento' => $estudiante->tipo_documento ?? 'DNI',
                    'dni' => $estudiante->nro_documento ?? '00000000',
                    'nombres' => $estudiante->nombres ?? ' ',
                    'apellidos' => $estudiante->apepaterno . ' ' . $estudiante->apematerno ?? ' ',
                    'codigo_sianet' => $estudiante->codigo_sianet ?? ' ',
                    'numero_hijos' =>  0,
                    'hijos_matriculados' =>  0,
                    'formacion_academica' => 'tecnica',
                    'trabaja' =>  0,
                ]);
                $estudiante->delete();
            }

            return redirect()->back()->with('success', 'Datos transferidos exitosamente de Estudiantes a Progenitores.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al transferir datos: ' . $e->getMessage());
        }
    }

    public function setdatos(Request $request)
    {
        DB::beginTransaction(); // Iniciamos una transacción

        try {
            $periodo_academico = Carbon::now()->year;
            /// Crear una nueva solicitud
            $solicitud = Solicitud::create([
                'periodo_academico' => $periodo_academico,
                'reglamento_leido' => $request->reglamento === 'Si' ? 1 : 0,
                'estado_solicitud' => 'pendiente',
                'estudiante_id' => $request->id_estudiante,
                'vive_con' => $request->viveConProgenitores,
                'motivos_beca' => $request->motivoSalud,
                'razones_motivos' => $request->razones,
            ]);
            $estudiante = Estudiante::find($request->id_estudiante);
            // Crear progenitores
            $progenitor = Progenitor::create([
                'solicitud_id' => $solicitud->id,
                'estudiante_id' => $request->id_estudiante,
                'tipo' => $request->tipoDocumento_Prog1,
                'dni' => $request->numeroDocumento_Prog1,
                'nombres' => $request->nombres_Prog1,
                'apellidos' => $request->apellidos_Prog1,
                'numero_hijos' => $request->numeroHijos_Prog1,
                'hijos_matriculados' => $request->hijosMatriculados_Prog1,
                'formacion_academica' => $request->formacionAcademica_Prog1,
                'trabaja' => $request->trabajoRemunerado_Prog1,
                'tiempo_desempleo' => $request->tiempoDesempleo_Prog1,
                'sueldo_fijo' => $request->id_estudiante,
                'sueldo_variable' => $request->id_estudiante,
                'cargo' => $request->cargo_Prog1,
                'anio_inicio_laboral' => $request->anioLaboral_Prog1,
                'lugar_trabajo' => $request->lugarTrabajo_Prog1,
                'ingresos_mensuales' => $request->ingresos_Prog1,
                'recibe_bonos' => $request->id_estudiante,
                'monto_bonos' => $request->id_estudiante,
                'recibe_utilidades' => $request->id_estudiante,
                'monto_utilidades' => $request->id_estudiante,
                'titular_empresa' => $request->titularEmpresa_Prog1,
                'porcentaje_acciones' => $request->id_estudiante,
                'razon_social' => $request->id_estudiante,
                'numero_ruc' => $request->id_estudiante,
                'vivienda_tipo' => $request->id_estudiante,
                'credito_hipotecario' => $request->id_estudiante,
                'direccion_vivienda' => $request->id_estudiante,
                'm2_vivienda' => $request->id_estudiante,
                'cantidad_inmuebles' => $request->id_estudiante,
            ]);

            // Crear situación económica
            $situacionEconomica = SituacionEconomica::create([
                'solicitud_id' => $solicitud->id,
                // ... otros campos
            ]);

            // Crear documentos adjuntos
            $documentos = DocumentoAdjunto::create([
                'solicitud_id' => $solicitud->id,
                // ... otros campos
            ]);

            DB::commit(); // Confirmamos la transacción si todo salió bien

            // Llamamos a la función de notificación por correo
            $this->notificarPorCorreo($solicitud);

            return response()->json(['success' => true, 'message' => 'Solicitud creada correctamente']);
        } catch (\Exception $e) {
            DB::rollBack(); // Deshacemos los cambios en caso de error
            return response()->json(['success' => false, 'message' => 'Error al procesar la solicitud: ' . $e->getMessage()], 500);
        }
    }

    public function notificarPorCorreo(Solicitud $solicitud)
    {
        try {
            Mail::send('emails.solicitud_creada', ['solicitud' => $solicitud], function($message) {
                $message->to('destinatario@example.com', 'Nombre del Destinatario')
                        ->subject('Nueva Solicitud de Beca');
            });
        } catch (\Exception $e) {
            // Manejar el error de envío del correo
            // Por ejemplo, loguear el error
            Log::error('Error al enviar correo de notificación: ' . $e->getMessage());
        }
    }
}
