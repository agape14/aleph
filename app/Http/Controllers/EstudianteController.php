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
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\SolicitudCreadaNotification;
use Illuminate\Support\Facades\DB;
use App\Mail\SolicitudCreadaMail;
use Illuminate\Support\Facades\Mail;
use Log;

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
        DB::beginTransaction();

        try {
            $this->validateRequest($request);

            // Crear la solicitud principal
            $solicitud = $this->createSolicitud($request);
            $estudiante = Estudiante::find($request->id_estudiante);
            // Manejar datos de progenitores
            $this->handleProgenitor($solicitud->id,$estudiante->id, $request, 'progenitor1');
            $this->handleProgenitor($solicitud->id,$estudiante->id, $request, 'progenitor2');

            // Manejar documentos adjuntos
            $this->handleSituacionEconomica($solicitud->id, $request);

            DB::commit();
            $this->notificarPorCorreo($solicitud);
            return response()->json(['message' => 'Solicitud creada exitosamente.'], 201);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Ocurrió un error al procesar la solicitud.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            /*'solicitante_nombre' => 'required|string|max:255',
            'solicitante_apellido' => 'required|string|max:255',
            'documentos.*' => 'nullable|file|mimes:jpg,png,pdf|max:2048',*/
            'motivosBeca' => 'nullable|array',
            'boletasPagoProgenitor1'                    => 'nullable|file|mimes:pdf|max:2048',
            'declaracionJuradaProgenitor1'              => 'nullable|file|mimes:pdf|max:2048',
            'certificadoMovimientosProgenitor1'         => 'nullable|file|mimes:pdf|max:2048',
            'constanciaBusquedaRegistrosProgenitor1'    => 'nullable|file|mimes:pdf|max:2048',
            'otrosDocumentosProgenitor1'                => 'nullable|file|mimes:pdf|max:2048',
            'boletasPagoProgenitor2'                    => 'nullable|file|mimes:pdf|max:2048',
            'declaracionJuradaProgenitor2'              => 'nullable|file|mimes:pdf|max:2048',
            'certificadoMovimientosProgenitor2'         => 'nullable|file|mimes:pdf|max:2048',
            'constanciaBusquedaRegistrosProgenitor2'    => 'nullable|file|mimes:pdf|max:2048',
            'otrosDocumentosProgenitor2'                => 'nullable|file|mimes:pdf|max:2048',
        ]);
    }

    private function createSolicitud(Request $request)
    {
        $periodo_academico = Carbon::now()->year;
        return Solicitud::create([
            'periodo_academico' => $periodo_academico,
            'reglamento_leido' => $request->reglamento === 'Si' ? 1 : 0,
            'estado_solicitud' => 'pendiente',
            'estudiante_id' => $request->id_estudiante,
            'vive_con' => $request->viveConProgenitores,
            'motivos_beca' => $request->input('motivosBeca') ? json_encode($request->input('motivosBeca')) : null,
            'razones_motivos' => $request->razones,
        ]);
    }

    private function handleProgenitor($solicitudId,$estudianteId, Request $request, $type)
    {
        if($request->id_progenitor){
            $progenitor1 = Progenitor::find($request->id_progenitor);
            if ($progenitor1) {
                // Actualizar los campos del progenitor
                $progenitor1->solicitud_id = $solicitudId;
                $progenitor1->estudiante_id = $estudianteId;
                $progenitor1->numero_hijos = $request->numeroHijos_Prog1;
                $progenitor1->hijos_matriculados = $request->hijosMatriculados_Prog1;
                $progenitor1->formacion_academica = $request->formacionAcademica_Prog1;
                $progenitor1->trabaja = $request->trabajoRemunerado_Prog1==='si'?1:null;
                $progenitor1->tiempo_desempleo = $request->tiempoDesempleo_Prog1;
                $progenitor1->cargo = $request->cargo_Prog1;
                $progenitor1->anio_inicio_laboral = $request->anioLaboral_Prog1;
                $progenitor1->lugar_trabajo = $request->lugarTrabajo_Prog1;
                $progenitor1->ingresos_mensuales = $request->ingresos_Prog1;
                $progenitor1->recibe_bonos = $request->bonos_Prog1==='si'?1:null;
                $progenitor1->monto_bonos = $request->montoBonos_Prog1;
                $progenitor1->recibe_utilidades = $request->utilidades_Prog1==='si'?1:null;
                $progenitor1->monto_utilidades = $request->montoUtilidades_Prog1;
                $progenitor1->titular_empresa = $request->titularEmpresa_Prog1==='si'?1:null;
                $progenitor1->porcentaje_acciones = $request->acciones_Prog1;
                $progenitor1->razon_social = $request->razonSocial_Prog1;
                $progenitor1->numero_ruc = $request->nroRuc_Prog1;
                $progenitor1->vivienda_tipo = $request->tipoVivienda_Prog1;
                $progenitor1->credito_hipotecario = $request->creditoHipotecario_Prog1==='si'?1:null;
                $progenitor1->direccion_vivienda = $request->direccion_Prog1;
                $progenitor1->m2_vivienda = $request->metros_Prog1;
                $progenitor1->cantidad_inmuebles = $request->numInmuebles_Prog1;

                // Guardar los cambios en la base de datos
                $progenitor1->save();
                $this->handleDocuments($solicitudId,$progenitor1->id, $request);
                \Log::info("Progenitor1 actualizado exitosamente. ID: {$progenitor1->id}");
            } else {
                \Log::warning("No se encontró un progenitor1 con el ID: {$request->id_progenitor}");
            }
        }

        if($request->id_progenitor2){
            $progenitor2 = Progenitor::find($request->id_progenitor2);
            if ($progenitor2) {
                $progenitor2->solicitud_id = $solicitudId;
                $progenitor2->estudiante_id = $estudianteId;
                $progenitor2->$numero_hijos=$request->numeroHijos_Prog2;
                $progenitor2->$hijos_matriculados=$request->hijosMatriculados_Prog2;
                $progenitor2->$formacion_academica=$request->formacionAcademica_Prog2;
                $progenitor2->trabaja = $request->trabajoRemunerado_Prog2==='si'?1:null;
                $progenitor2->$tiempo_desempleo=$request->tiempoDesempleo_Prog2;
                //$progenitor2->$sueldo_fijo=$request->sueldo_fijo_Prog2;
                //$progenitor2->$sueldo_variable=$request->sueldo_variable_Prog2;
                $progenitor2->$cargo=$request->cargo_Prog2;
                $progenitor2->$anio_inicio_laboral=$request->anioLaboral_Prog2;
                $progenitor2->$lugar_trabajo=$request->lugarTrabajo_Prog2;
                $progenitor2->$ingresos_mensuales=$request->ingresos_Prog2;
                $progenitor2->$recibe_bonos=$request->bonos_Prog2==='si'?1:null;
                $progenitor2->$monto_bonos=$request->montoBonos_Prog2;
                $progenitor2->$recibe_utilidades=$request->utilidades_Prog2==='si'?1:null;
                $progenitor2->$monto_utilidades=$request->montoUtilidades_Prog2;
                $progenitor2->$titular_empresa=$request->titularEmpresa_Prog2==='si'?1:null;
                $progenitor2->$porcentaje_acciones=$request->acciones_Prog2;
                $progenitor2->$razon_social=$request->razonSocial_Prog2;
                $progenitor2->$numero_ruc=$request->nroRuc_Prog2;
                $progenitor2->$vivienda_tipo=$request->tipoVivienda_Prog2;
                $progenitor2->$credito_hipotecario=$request->creditoHipotecario_Prog2==='si'?1:null;
                $progenitor2->$direccion_vivienda=$request->direccion_Prog2;
                $progenitor2->$m2_vivienda=$request->metros_Prog2;
                $progenitor2->$cantidad_inmuebles=$request->numInmuebles_Prog2;
                $progenitor2->save();
                $this->handleDocuments($solicitudId,$progenitor2->id, $request);
                \Log::info("Progenitor2 actualizado exitosamente. ID: {$progenitor2->id}");
            } else {
                \Log::warning("No se encontró un progenitor2 con el ID: {$request->id_progenitor2}");
            }
        }
    }

    private function handleDocuments($solicitudId,$progenitorId, Request $request)
    {
        //documentos del progenitor 1
        if (!$request->has('noAplicaBoletasPagoProgenitor1')) {
            if ($request->hasFile('boletasPagoProgenitor1') && $request->file('boletasPagoProgenitor1')->isValid()) {
                $rutaArchivo = $request->file('boletasPagoProgenitor1')->store('boletas_pago', 'public');
                DocumentoAdjunto::create([
                    'solicitud_id' => $solicitudId,
                    'progenitor_id' => $progenitorId,
                    'tipo_documento' => 'boletas_pago',
                    'ruta_archivo' => $rutaArchivo,
                    'no_aplica' => '0',
                ]);
                \Log::info("Archivo boletasPagoProgenitor1 guardado exitosamente en: {$rutaArchivo}");
            } else {
                \Log::warning("No se subió el archivo boletasPagoProgenitor1 o no es válido.");
            }
        }

        if (!$request->has('noAplicaDeclaracionJuradaProgenitor1')) {
            if ($request->hasFile('declaracionJuradaProgenitor1') && $request->file('declaracionJuradaProgenitor1')->isValid()) {
                $rutaArchivo2 = $request->file('declaracionJuradaProgenitor1')->store('declaracion_renta', 'public');
                DocumentoAdjunto::create([
                    'solicitud_id' => $solicitudId,
                    'progenitor_id' => $progenitorId,
                    'tipo_documento' => 'declaracion_renta',
                    'ruta_archivo' => $rutaArchivo2,
                    'no_aplica' => '0',
                ]);
                \Log::info("Archivo declaracionJuradaProgenitor1 guardado exitosamente en: {$rutaArchivo2}");
            } else {
                \Log::warning("No se subió el archivo declaracionJuradaProgenitor1 o no es válido.");
            }
        }

        if (!$request->has('noAplicaCertificadoMovimientosProgenitor1')) {
            if ($request->hasFile('certificadoMovimientosProgenitor1') && $request->file('certificadoMovimientosProgenitor1')->isValid()) {
                $rutaArchivo3 = $request->file('certificadoMovimientosProgenitor1')->store('movimientos_migratorios', 'public');
                DocumentoAdjunto::create([
                    'solicitud_id' => $solicitudId,
                    'progenitor_id' => $progenitorId,
                    'tipo_documento' => 'movimientos_migratorios',
                    'ruta_archivo' => $rutaArchivo3,
                    'no_aplica' => '0',
                ]);
                \Log::info("Archivo certificadoMovimientosProgenitor1 guardado exitosamente en: {$rutaArchivo3}");
            } else {
                \Log::warning("No se subió el archivo certificadoMovimientosProgenitor1 o no es válido.");
            }
        }

        if (!$request->has('noAplicaConstanciaBusquedaRegistrosProgenitor1')) {
            if ($request->hasFile('constanciaBusquedaRegistrosProgenitor1') && $request->file('constanciaBusquedaRegistrosProgenitor1')->isValid()) {
                $rutaArchivo4 = $request->file('constanciaBusquedaRegistrosProgenitor1')->store('bienes_inmuebles', 'public');
                DocumentoAdjunto::create([
                    'solicitud_id' => $solicitudId,
                    'progenitor_id' => $progenitorId,
                    'tipo_documento' => 'bienes_inmuebles',
                    'ruta_archivo' => $rutaArchivo4,
                    'no_aplica' => '0',
                ]);
                \Log::info("Archivo constanciaBusquedaRegistrosProgenitor1 guardado exitosamente en: {$rutaArchivo4}");
            } else {
                \Log::warning("No se subió el archivo constanciaBusquedaRegistrosProgenitor1 o no es válido.");
            }
        }

        if (!$request->has('noAplicaOtrosDocumentosProgenitor1')) {
            if ($request->hasFile('otrosDocumentosProgenitor1') && $request->file('otrosDocumentosProgenitor1')->isValid()) {
                $rutaArchivo5 = $request->file('otrosDocumentosProgenitor1')->store('otros', 'public');
                DocumentoAdjunto::create([
                    'solicitud_id' => $solicitudId,
                    'progenitor_id' => $progenitorId,
                    'tipo_documento' => 'otros',
                    'ruta_archivo' => $rutaArchivo5,
                    'no_aplica' => '0',
                ]);
                \Log::info("Archivo otrosDocumentosProgenitor1 guardado exitosamente en: {$rutaArchivo5}");
            } else {
                \Log::warning("No se subió el archivo otrosDocumentosProgenitor1 o no es válido.");
            }
        }

        //documentos del progenitor 2
        if (!$request->has('noAplicaBoletasPagoProgenitor2')) {
            if ($request->hasFile('boletasPagoProgenitor2') && $request->file('boletasPagoProgenitor2')->isValid()) {
                $rutaArchivo6 = $request->file('boletasPagoProgenitor2')->store('boletas_pago', 'public');
                DocumentoAdjunto::create([
                    'solicitud_id' => $solicitudId,
                    'progenitor_id' => $progenitorId,
                    'tipo_documento' => 'boletas_pago',
                    'ruta_archivo' => $rutaArchivo6,
                    'no_aplica' => '0',
                ]);
                \Log::info("Archivo boletasPagoProgenitor2 guardado exitosamente en: {$rutaArchivo6}");
            } else {
                \Log::warning("No se subió el archivo boletasPagoProgenitor2 o no es válido.");
            }
        }

        if (!$request->has('noAplicaDeclaracionJuradaProgenitor2')) {
            if ($request->hasFile('declaracionJuradaProgenitor2') && $request->file('declaracionJuradaProgenitor2')->isValid()) {
                $rutaArchivo7 = $request->file('declaracionJuradaProgenitor2')->store('declaracion_renta', 'public');
                DocumentoAdjunto::create([
                    'solicitud_id' => $solicitudId,
                    'progenitor_id' => $progenitorId,
                    'tipo_documento' => 'declaracion_renta',
                    'ruta_archivo' => $rutaArchivo7,
                    'no_aplica' => '0',
                ]);
                \Log::info("Archivo declaracionJuradaProgenitor2 guardado exitosamente en: {$rutaArchivo7}");
            } else {
                \Log::warning("No se subió el archivo declaracionJuradaProgenitor2 o no es válido.");
            }
        }

        if (!$request->has('noAplicaCertificadoMovimientosProgenitor2')) {
            if ($request->hasFile('certificadoMovimientosProgenitor2') && $request->file('certificadoMovimientosProgenitor2')->isValid()) {
                $rutaArchivo8 = $request->file('certificadoMovimientosProgenitor2')->store('movimientos_migratorios', 'public');
                DocumentoAdjunto::create([
                    'solicitud_id' => $solicitudId,
                    'progenitor_id' => $progenitorId,
                    'tipo_documento' => 'movimientos_migratorios',
                    'ruta_archivo' => $rutaArchivo8,
                    'no_aplica' => '0',
                ]);
                \Log::info("Archivo certificadoMovimientosProgenitor2 guardado exitosamente en: {$rutaArchivo8}");
            } else {
                \Log::warning("No se subió el archivo certificadoMovimientosProgenitor2 o no es válido.");
            }
        }

        if (!$request->has('noAplicaConstanciaBusquedaRegistrosProgenitor2')) {
            if ($request->hasFile('constanciaBusquedaRegistrosProgenitor2') && $request->file('constanciaBusquedaRegistrosProgenitor2')->isValid()) {
                $rutaArchivo9 = $request->file('constanciaBusquedaRegistrosProgenitor2')->store('bienes_inmuebles', 'public');
                DocumentoAdjunto::create([
                    'solicitud_id' => $solicitudId,
                    'progenitor_id' => $progenitorId,
                    'tipo_documento' => 'bienes_inmuebles',
                    'ruta_archivo' => $rutaArchivo9,
                    'no_aplica' => '0',
                ]);
                \Log::info("Archivo constanciaBusquedaRegistrosProgenitor2 guardado exitosamente en: {$rutaArchivo9}");
            } else {
                \Log::warning("No se subió el archivo constanciaBusquedaRegistrosProgenitor2 o no es válido.");
            }
        }

        if (!$request->has('noAplicaOtrosDocumentosProgenitor2')) {
            if ($request->hasFile('otrosDocumentosProgenitor2') && $request->file('otrosDocumentosProgenitor2')->isValid()) {
                $rutaArchivo10 = $request->file('otrosDocumentosProgenitor2')->store('otros', 'public');
                DocumentoAdjunto::create([
                    'solicitud_id' => $solicitudId,
                    'progenitor_id' => $progenitorId,
                    'tipo_documento' => 'otros',
                    'ruta_archivo' => $rutaArchivo10,
                    'no_aplica' => '0',
                ]);
                \Log::info("Archivo otrosDocumentosProgenitor2 guardado exitosamente en: {$rutaArchivo10}");
            } else {
                \Log::warning("No se subió el archivo otrosDocumentosProgenitor2 o no es válido.");
            }
        }
    }

    public function handleSituacionEconomica($solicitudId, Request $request){
        $situacionEconomica = SituacionEconomica::create([
            'solicitud_id' =>           $solicitudId,
            'ingresos_planilla' =>      $request->remuneracionPlanilla,
            'ingresos_honorarios' =>    $request->honorariosProfesionales,
            'ingresos_pension' =>       $request->pensionista,
            'ingresos_alquiler' =>      $request->rentasInmuebles,
            'ingresos_vehiculos' =>     $request->rentasVehiculos,
            'otros_ingresos' =>         $request->otrosIngresos,
            'total_ingresos' =>         $request->totalIngresos ?? 0,
            'gastos_colegios' =>        $request->pagoColegios,
            'gastos_talleres' =>        $request->pagoTalleres,
            'gastos_universidad' =>     $request->pagoUniversidad,
            'gastos_alimentacion' =>    $request->pagoAlimentacion,
            'otros_gastos' =>           $request->otrosGastos,
            'total_gastos' =>           $request->totalGastos ?? 0,
        ]);
    }

    public function notificarPorCorreo(Solicitud $solicitud)
    {
        try {
            // Notificar al destinatario (puedes configurar dinámicamente el destinatario)
            //$destinatario->notify(new SolicitudCreadaNotification($solicitud));
            $nombre = $solicitud->estudiante->nombres;
            $apellido = $solicitud->estudiante->apepaterno. ' ' .  $solicitud->estudiante->apematerno;
            $url_alternativa = "https://aleph.eximio.com.pe/login";//route('ver_solicitud', $id);
            $destinatario = User::find(3);
            // Enviar el correo
            Mail::to($destinatario)->send(new SolicitudCreadaMail($nombre, $apellido, $solicitud->id, $url_alternativa,$destinatario->name));
        } catch (\Exception $e) {
            \Log::error('Error al enviar correo de notificación: ' . $e->getMessage());
        }
    }

    public function notificarPorCorreoprueba($id)
    {
        $solicitud = Solicitud::find($id);

        if ($solicitud) {
            $nombre = $solicitud->estudiante->nombres;
            $apellido = $solicitud->estudiante->apepaterno. ' ' .  $solicitud->estudiante->apematerno;
            $url_alternativa = "https://aleph.eximio.com.pe/login";//route('ver_solicitud', $id);
            $destinatario = User::find(3);
            // Enviar el correo
            Mail::to($destinatario)->send(new SolicitudCreadaMail($nombre, $apellido, $id, $url_alternativa,$destinatario->name));
            return response()->json(['message' => 'Notificación enviada correctamente.']);
        }

        return response()->json(['message' => 'Solicitud no encontrada.'], 404);
    }
}
