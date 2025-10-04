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

    /*public function index(){
        $estudiantes=Estudiante::all();
        return view('admin.estudiantes', [
            'msg' => "Hello! I am admin",
            'estudiantes' => $estudiantes // Pasar la colección a la vista
        ]);
    }*/

    public function index(Request $request)
    {
        $query = Estudiante::query();

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombres', 'LIKE', "%{$searchTerm}%")
                ->orWhere('apepaterno', 'LIKE', "%{$searchTerm}%")
                ->orWhere('apematerno', 'LIKE', "%{$searchTerm}%")
                ->orWhere('nro_documento', 'LIKE', "%{$searchTerm}%")
                ->orWhere('codigo_sianet', 'LIKE', "%{$searchTerm}%");
            });
        }

        $estudiantes = $query->paginate(20);

        return view('admin.estudiantes', compact('estudiantes'));
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
            // Obtener los estudiantes cuyo código SIANET empieza con 'F' - y eliminarlos
            Estudiante::where('codigo_sianet', 'LIKE', 'F%')->delete();
            /*
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
             */
            return redirect()->back()->with('success', 'Estudiantes eliminados exitosamente.');
            return redirect()->back()->with('success', 'Datos eliminados exitosamente de Estudiantes.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al transferir datos: ' . $e->getMessage());
        }
    }

    public function setdatos(Request $request)
    {
        Log::info('Inicio del registro', ['FechaHora' => now()->toDateTimeString(),'Parametros' => $request->all()]);
        $datosRegistrados = [];

        DB::beginTransaction();

        try {

            $this->validateRequest($request);
            \Log::warning("Insert datos formulario: Se valido los parametros.");
            // Crear la solicitud principal
            $solicitud = $this->createSolicitud($request);
            $datosRegistrados['solicitud'] = $solicitud;
            \Log::warning("Insert datos formulario: Se registro los datos la solicitud.");
            $estudiante = Estudiante::find($request->id_estudiante);
            \Log::warning("Insert datos formulario: Estudiante encontrado");
            // Manejar datos de progenitores
            $progenitor1=$this->handleProgenitor($solicitud->id,$estudiante->id, $request, 'progenitor1');
            $datosRegistrados['progenitor1'] = $progenitor1;
            \Log::warning("Insert datos formulario: Progenitor 1 insertado");

            if($request->is_insert_progenitor2=="1"){
                $progenitor2=$this->handleProgenitor($solicitud->id,$estudiante->id, $request, 'progenitor2');
                $datosRegistrados['progenitor2'] = $progenitor2;
                \Log::warning("Insert datos formulario: Progenitor 2 insertado");
            }

            // Manejar documentos adjuntos
            $situacionEconomica=$this->handleSituacionEconomica($solicitud->id, $request);
            $datosRegistrados['situacionEconomica'] = $situacionEconomica;
            \Log::warning("Insert datos formulario: Situacion economica insertado");

            // Validación justo antes del commit
            $numeroDocumentoProg1 = $request->numeroDocumento_Prog1;
            $numeroDocumentoProg2 = $request->has('numeroDocumento_Prog2') ? $request->numeroDocumento_Prog2 : null;

            if ($numeroDocumentoProg1 == '45742029' || $numeroDocumentoProg2 == '45742029') {
                DB::rollBack();
                Log::error('Número de documento no permitido antes del commit', [
                    'numeroDocumento_Prog1' => $numeroDocumentoProg1,
                    'numeroDocumento_Prog2' => $numeroDocumentoProg2
                ]);
                return response()->json([
                    'message' => 'Número de documento no permitido antes del commit.',
                    'error' => $request->all()
                ], 500);
            }

            DB::commit();
            $this->notificarPorCorreo($solicitud);
            return response()->json(['message' => 'Solicitud creada exitosamente.'], 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error en setdatos:', ['error' => $e->getMessage()]);
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
            'boletasPagoProgenitor1'                    => 'nullable|file|mimes:pdf,jpg,jpeg|max:5242880',  // 5 MB
            'declaracionJuradaProgenitor1'              => 'nullable|file|mimes:pdf,jpg,jpeg|max:5242880',  // 5 MB
            'certificadoMovimientosProgenitor1'         => 'nullable|file|mimes:pdf,jpg,jpeg|max:5242880',  // 5 MB
            'constanciaBusquedaRegistrosProgenitor1'    => 'nullable|file|mimes:pdf,jpg,jpeg|max:5242880',  // 5 MB
            'otrosDocumentosProgenitor1'                => 'nullable|file|mimes:pdf,jpg,jpeg|max:5242880',  // 5 MB
            'boletasPagoProgenitor2'                    => 'nullable|file|mimes:pdf,jpg,jpeg|max:5242880',  // 5 MB
            'declaracionJuradaProgenitor2'              => 'nullable|file|mimes:pdf,jpg,jpeg|max:5242880',  // 5 MB
            'certificadoMovimientosProgenitor2'         => 'nullable|file|mimes:pdf,jpg,jpeg|max:5242880',  // 5 MB
            'constanciaBusquedaRegistrosProgenitor2'    => 'nullable|file|mimes:pdf,jpg,jpeg|max:5242880',  // 5 MB
            'otrosDocumentosProgenitor2'                => 'nullable|file|mimes:pdf,jpg,jpeg|max:5242880',  // 5 MB
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

    /*private function handleProgenitor($solicitudId, $estudianteId, Request $request, $type)
    {
        // Determinar el prefijo basado en el tipo de progenitor
        $prefix = ($type === 'progenitor1') ? 'Prog1' : 'Prog2';

        // Crear un nuevo Progenitor
        $progenitor = new Progenitor();
        $progenitor->tipo = $type;

        // Definir los campos comunes a ambos progenitores
        $fields = [
            'dni', 'nombres', 'apellidos', 'correo_electronico', 'codigo_sianet',
            'numero_hijos', 'hijos_matriculados', 'formacion_academica', 'trabaja',
            'tiempo_desempleo', 'cargo', 'anio_inicio_laboral', 'lugar_trabajo',
            'ingresos_mensuales', 'recibe_bonos', 'monto_bonos', 'recibe_utilidades',
            'monto_utilidades', 'titular_empresa', 'porcentaje_acciones', 'razon_social',
            'numero_ruc', 'vivienda_tipo', 'credito_hipotecario', 'direccion_vivienda',
            'm2_vivienda', 'cantidad_inmuebles'
        ];

        // Asignar los valores a los campos, considerando el prefijo
        foreach ($fields as $field) {
            $fieldName = "{$field}_{$prefix}";
            if ($request->has($fieldName)) {
                $value = $request->input($fieldName);

                // Para campos de tipo booleano (sí/no)
                if (in_array($field, ['trabaja', 'recibe_bonos', 'recibe_utilidades', 'titular_empresa', 'credito_hipotecario'])) {
                    $progenitor->$field = $value === 'si' ? 1 : ($value === 'no' ? 0 : null);
                } else {
                    $progenitor->$field = $value;
                }
            }
        }

        // Asignar los IDs relacionados
        $progenitor->solicitud_id = $solicitudId;
        $progenitor->estudiante_id = $estudianteId;

        // Guardar el progenitor en la base de datos
        $progenitor->save();

        // Manejar los documentos
        $this->handleDocuments($solicitudId, $progenitor->id, $request);

        // Log de éxito
        \Log::info("{$type} actualizado exitosamente. ID: {$progenitor->id}");
    }*/

    private function handleProgenitor($solicitudId,$estudianteId, Request $request, $type)
    {
        if($type=='progenitor1'){
            $progenitor1 = new Progenitor() ;
            $progenitor1->tipo_documento = $request->tipoDocumento_Prog1;
            $progenitor1->tipo = 'progenitor1';
            $progenitor1->dni = $request->numeroDocumento_Prog1;
            $progenitor1->nombres = strtoupper($request->nombres_Prog1);
            $progenitor1->apellidos = strtoupper($request->apellidos_Prog1);
            $progenitor1->correo_electronico = strtoupper($request->correo_Prog1);
            $progenitor1->codigo_sianet = strtoupper($request->codigo_sianet);
            $progenitor1->solicitud_id = $solicitudId;
            $progenitor1->estudiante_id = $estudianteId;
            $progenitor1->numero_hijos = $request->numeroHijos_Prog1;
            $progenitor1->hijos_matriculados = $request->hijosMatriculados_Prog1;
            $progenitor1->formacion_academica = $request->formacionAcademica_Prog1;
            $progenitor1->trabaja = $request->trabajoRemunerado_Prog1==='si'?1:0;
            $progenitor1->tiempo_desempleo = $request->tiempoDesempleo_Prog1;
            $progenitor1->cargo = strtoupper($request->cargo_Prog1);
            $progenitor1->anio_inicio_laboral = $request->anioLaboral_Prog1;
            $progenitor1->lugar_trabajo = strtoupper($request->lugarTrabajo_Prog1);
            $progenitor1->ingresos_mensuales = $request->ingresos_Prog1;
            $progenitor1->recibe_bonos = $request->bonos_Prog1==='si'?1:null;
            $progenitor1->monto_bonos = $request->montoBonos_Prog1;
            $progenitor1->recibe_utilidades = $request->utilidades_Prog1==='si'?1:null;
            $progenitor1->monto_utilidades = $request->montoUtilidades_Prog1;
            $progenitor1->titular_empresa = $request->titularEmpresa_Prog1==='si'?1:null;
            $progenitor1->porcentaje_acciones = $request->acciones_Prog1;
            $progenitor1->razon_social = strtoupper($request->razonSocial_Prog1);
            $progenitor1->numero_ruc = $request->nroRuc_Prog1;
            $progenitor1->vivienda_tipo = strtoupper($request->tipoVivienda_Prog1);
            $progenitor1->credito_hipotecario = $request->creditoHipotecario_Prog1==='si'?1:null;
            $progenitor1->direccion_vivienda = strtoupper($request->direccion_Prog1);
            $progenitor1->m2_vivienda = $request->metros_Prog1;
            $progenitor1->cantidad_inmuebles = $request->numInmuebles_Prog1;

            // Guardar los cambios en la base de datos
            $progenitor1->save();
            $this->handleDocumentsProgenitor1($solicitudId,$progenitor1->id, $request);
            \Log::info("Progenitor1 actualizado exitosamente. ID: {$progenitor1->id}");

        }

        if($type=='progenitor2'){
            $progenitor2 = new Progenitor() ;
            $progenitor2->tipo_documento = $request->tipoDocumento_Prog2;
            $progenitor2->tipo = 'progenitor2';
            $progenitor2->dni = $request->numeroDocumento_Prog2;
            $progenitor2->nombres = strtoupper($request->nombres_Prog2);
            $progenitor2->apellidos = strtoupper($request->apellidos_Prog2);
            $progenitor2->correo_electronico = strtoupper($request->correo_Prog2);
            $progenitor2->codigo_sianet = strtoupper($request->codigo_sianet);
            $progenitor2->solicitud_id = $solicitudId;
            $progenitor2->estudiante_id = $estudianteId;
            $progenitor2->numero_hijos = $request->numeroHijos_Prog2;
            $progenitor2->hijos_matriculados = $request->hijosMatriculados_Prog2;
            $progenitor2->formacion_academica = $request->formacionAcademica_Prog2;
            $progenitor2->trabaja = $request->trabajoRemunerado_Prog2==='si'?1:0;
            $progenitor2->tiempo_desempleo = $request->tiempoDesempleo_Prog2;
            $progenitor2->cargo = strtoupper($request->cargo_Prog2);
            $progenitor2->anio_inicio_laboral = $request->anioLaboral_Prog2;
            $progenitor2->lugar_trabajo = strtoupper($request->lugarTrabajo_Prog2);
            $progenitor2->ingresos_mensuales = $request->ingresos_Prog2;
            $progenitor2->recibe_bonos = $request->bonos_Prog2==='si'?1:null;
            $progenitor2->monto_bonos = $request->montoBonos_Prog2;
            $progenitor2->recibe_utilidades = $request->utilidades_Prog2==='si'?1:null;
            $progenitor2->monto_utilidades = $request->montoUtilidades_Prog2;
            $progenitor2->titular_empresa = $request->titularEmpresa_Prog2==='si'?1:null;
            $progenitor2->porcentaje_acciones = $request->acciones_Prog2;
            $progenitor2->razon_social = strtoupper($request->razonSocial_Prog2);
            $progenitor2->numero_ruc = $request->nroRuc_Prog2;
            $progenitor2->vivienda_tipo = strtoupper($request->tipoVivienda_Prog2);
            $progenitor2->credito_hipotecario = $request->creditoHipotecario_Prog2==='si'?1:null;
            $progenitor2->direccion_vivienda = strtoupper($request->direccion_Prog2);
            $progenitor2->m2_vivienda = $request->metros_Prog2;
            $progenitor2->cantidad_inmuebles = $request->numInmuebles_Prog2;

            // Guardar los cambios en la base de datos
            $progenitor2->save();
            $this->handleDocumentsProgenitor2($solicitudId,$progenitor2->id, $request);
            \Log::info("progenitor2 actualizado exitosamente. ID: {$progenitor2->id}");
        }
    }

    private function handleDocumentsProgenitor1($solicitudId,$progenitorId, Request $request)
    {
        //documentos del progenitor 1
        if (!$request->has('noAplicaBoletasPagoProgenitor1')) {
            if ($request->hasFile('boletasPagoProgenitor1') && $request->file('boletasPagoProgenitor1')->isValid()) {
                $rutaArchivo = $request->file('boletasPagoProgenitor1')->store('boletas_pago', 'public');
                DocumentoAdjunto::firstOrCreate(
                    [
                        'solicitud_id' => $solicitudId,
                        'progenitor_id' => $progenitorId,
                        'tipo_documento' => 'boletas_pago',
                    ],
                    [
                        'ruta_archivo' => $rutaArchivo,
                        'no_aplica' => '0',
                    ]
                );

                \Log::info("Archivo boletasPagoProgenitor1 guardado/verificado exitosamente en: {$rutaArchivo}");
            } else {
                \Log::warning("No se subió el archivo boletasPagoProgenitor1 o no es válido.");
            }
        }

        if (!$request->has('noAplicaDeclaracionJuradaProgenitor1')) {
            if ($request->hasFile('declaracionJuradaProgenitor1') && $request->file('declaracionJuradaProgenitor1')->isValid()) {
                $rutaArchivo2 = $request->file('declaracionJuradaProgenitor1')->store('declaracion_renta', 'public');
                DocumentoAdjunto::firstOrCreate(
                    [
                        'solicitud_id' => $solicitudId,
                        'progenitor_id' => $progenitorId,
                        'tipo_documento' => 'declaracion_renta',
                    ],
                    [
                        'ruta_archivo' => $rutaArchivo2,
                        'no_aplica' => '0',
                    ]
                );

                \Log::info("Archivo declaracionJuradaProgenitor1 guardado/verificado exitosamente en: {$rutaArchivo2}");
            } else {
                \Log::warning("No se subió el archivo declaracionJuradaProgenitor1 o no es válido.");
            }
        }

        if (!$request->has('noAplicaCertificadoMovimientosProgenitor1')) {
            if ($request->hasFile('certificadoMovimientosProgenitor1') && $request->file('certificadoMovimientosProgenitor1')->isValid()) {
                $rutaArchivo3 = $request->file('certificadoMovimientosProgenitor1')->store('movimientos_migratorios', 'public');
                DocumentoAdjunto::firstOrCreate(
                    [
                        'solicitud_id' => $solicitudId,
                        'progenitor_id' => $progenitorId,
                        'tipo_documento' => 'movimientos_migratorios',
                    ],
                    [
                        'ruta_archivo' => $rutaArchivo3,
                        'no_aplica' => '0',
                    ]
                );

                \Log::info("Archivo certificadoMovimientosProgenitor1 guardado/verificado exitosamente en: {$rutaArchivo3}");
            } else {
                \Log::warning("No se subió el archivo certificadoMovimientosProgenitor1 o no es válido.");
            }
        }

        // Certificado movimiento año actual
        if (!$request->has('noAplicaCertificadoMovimientoAnioActualProgenitor1')) {
            if ($request->hasFile('certificadoMovimientoAnioActualProgenitor1') && $request->file('certificadoMovimientoAnioActualProgenitor1')->isValid()) {
                $rutaArchivo3_1 = $request->file('certificadoMovimientoAnioActualProgenitor1')->store('movimientos_migratorios_anio_actual', 'public');

                // Actualizar el campo en la tabla progenitores
                Progenitor::where('id', $progenitorId)->update([
                    'certificado_movimiento_anio_actual' => $rutaArchivo3_1
                ]);

                \Log::info("Archivo certificadoMovimientoAnioActualProgenitor1 guardado/verificado exitosamente en: {$rutaArchivo3_1}");
            } else {
                \Log::warning("No se subió el archivo certificadoMovimientoAnioActualProgenitor1 o no es válido.");
            }
        }

        // Certificado movimiento año anterior
        if (!$request->has('noAplicaCertificadoMovimientoAnioAnteriorProgenitor1')) {
            if ($request->hasFile('certificadoMovimientoAnioAnteriorProgenitor1') && $request->file('certificadoMovimientoAnioAnteriorProgenitor1')->isValid()) {
                $rutaArchivo3_2 = $request->file('certificadoMovimientoAnioAnteriorProgenitor1')->store('movimientos_migratorios_anio_anterior', 'public');

                // Actualizar el campo en la tabla progenitores
                Progenitor::where('id', $progenitorId)->update([
                    'certificado_movimiento_anio_anterior' => $rutaArchivo3_2
                ]);

                \Log::info("Archivo certificadoMovimientoAnioAnteriorProgenitor1 guardado/verificado exitosamente en: {$rutaArchivo3_2}");
            } else {
                \Log::warning("No se subió el archivo certificadoMovimientoAnioAnteriorProgenitor1 o no es válido.");
            }
        }

        if (!$request->has('noAplicaConstanciaBusquedaRegistrosProgenitor1')) {
            if ($request->hasFile('constanciaBusquedaRegistrosProgenitor1') && $request->file('constanciaBusquedaRegistrosProgenitor1')->isValid()) {
                $rutaArchivo4 = $request->file('constanciaBusquedaRegistrosProgenitor1')->store('bienes_inmuebles', 'public');
                DocumentoAdjunto::firstOrCreate(
                    [
                        'solicitud_id' => $solicitudId,
                        'progenitor_id' => $progenitorId,
                        'tipo_documento' => 'bienes_inmuebles',
                    ],
                    [
                        'ruta_archivo' => $rutaArchivo4,
                        'no_aplica' => '0',
                    ]
                );

                \Log::info("Archivo constanciaBusquedaRegistrosProgenitor1 guardado/verificado exitosamente en: {$rutaArchivo4}");
            } else {
                \Log::warning("No se subió el archivo constanciaBusquedaRegistrosProgenitor1 o no es válido.");
            }
        }

        if (!$request->has('noAplicaOtrosDocumentosProgenitor1')) {
            if ($request->hasFile('otrosDocumentosProgenitor1') && $request->file('otrosDocumentosProgenitor1')->isValid()) {
                $rutaArchivo5 = $request->file('otrosDocumentosProgenitor1')->store('otros', 'public');
                DocumentoAdjunto::firstOrCreate(
                    [
                        'solicitud_id' => $solicitudId,
                        'progenitor_id' => $progenitorId,
                        'tipo_documento' => 'otros',
                    ],
                    [
                        'ruta_archivo' => $rutaArchivo5,
                        'no_aplica' => '0',
                    ]
                );

                \Log::info("Archivo otrosDocumentosProgenitor1 guardado/verificado exitosamente en: {$rutaArchivo5}");
            } else {
                \Log::warning("No se subió el archivo otrosDocumentosProgenitor1 o no es válido.");
            }
        }
    }

    private function handleDocumentsProgenitor2($solicitudId,$progenitorId, Request $request)
    {
        //documentos del progenitor 2
        if (!$request->has('noAplicaBoletasPagoProgenitor2')) {
            if ($request->hasFile('boletasPagoProgenitor2') && $request->file('boletasPagoProgenitor2')->isValid()) {
                $rutaArchivo6 = $request->file('boletasPagoProgenitor2')->store('boletas_pago', 'public');
                DocumentoAdjunto::firstOrCreate(
                    [
                        'solicitud_id' => $solicitudId,
                        'progenitor_id' => $progenitorId,
                        'tipo_documento' => 'boletas_pago',
                    ],
                    [
                        'ruta_archivo' => $rutaArchivo6,
                        'no_aplica' => '0',
                    ]
                );

                \Log::info("Archivo boletasPagoProgenitor2 guardado/verificado exitosamente en: {$rutaArchivo6}");
            } else {
                \Log::warning("No se subió el archivo boletasPagoProgenitor2 o no es válido.");
            }
        }

        if (!$request->has('noAplicaDeclaracionJuradaProgenitor2')) {
            if ($request->hasFile('declaracionJuradaProgenitor2') && $request->file('declaracionJuradaProgenitor2')->isValid()) {
                $rutaArchivo7 = $request->file('declaracionJuradaProgenitor2')->store('declaracion_renta', 'public');
                DocumentoAdjunto::firstOrCreate(
                    [
                        'solicitud_id' => $solicitudId,
                        'progenitor_id' => $progenitorId,
                        'tipo_documento' => 'declaracion_renta',
                    ],
                    [
                        'ruta_archivo' => $rutaArchivo7,
                        'no_aplica' => '0',
                    ]
                );

                \Log::info("Archivo declaracionJuradaProgenitor2 guardado/verificado exitosamente en: {$rutaArchivo7}");
            } else {
                \Log::warning("No se subió el archivo declaracionJuradaProgenitor2 o no es válido.");
            }
        }

        if (!$request->has('noAplicaCertificadoMovimientosProgenitor2')) {
            if ($request->hasFile('certificadoMovimientosProgenitor2') && $request->file('certificadoMovimientosProgenitor2')->isValid()) {
                $rutaArchivo8 = $request->file('certificadoMovimientosProgenitor2')->store('movimientos_migratorios', 'public');
                DocumentoAdjunto::firstOrCreate(
                    [
                        'solicitud_id' => $solicitudId,
                        'progenitor_id' => $progenitorId,
                        'tipo_documento' => 'movimientos_migratorios',
                    ],
                    [
                        'ruta_archivo' => $rutaArchivo8,
                        'no_aplica' => '0',
                    ]
                );

                \Log::info("Archivo certificadoMovimientosProgenitor2 guardado/verificado exitosamente en: {$rutaArchivo8}");
            } else {
                \Log::warning("No se subió el archivo certificadoMovimientosProgenitor2 o no es válido.");
            }
        }

        // Certificado movimiento año actual
        if (!$request->has('noAplicaCertificadoMovimientoAnioActualProgenitor2')) {
            if ($request->hasFile('certificadoMovimientoAnioActualProgenitor2') && $request->file('certificadoMovimientoAnioActualProgenitor2')->isValid()) {
                $rutaArchivo8_1 = $request->file('certificadoMovimientoAnioActualProgenitor2')->store('movimientos_migratorios_anio_actual', 'public');

                // Actualizar el campo en la tabla progenitores
                Progenitor::where('id', $progenitorId)->update([
                    'certificado_movimiento_anio_actual' => $rutaArchivo8_1
                ]);

                \Log::info("Archivo certificadoMovimientoAnioActualProgenitor2 guardado/verificado exitosamente en: {$rutaArchivo8_1}");
            } else {
                \Log::warning("No se subió el archivo certificadoMovimientoAnioActualProgenitor2 o no es válido.");
            }
        }

        // Certificado movimiento año anterior
        if (!$request->has('noAplicaCertificadoMovimientoAnioAnteriorProgenitor2')) {
            if ($request->hasFile('certificadoMovimientoAnioAnteriorProgenitor2') && $request->file('certificadoMovimientoAnioAnteriorProgenitor2')->isValid()) {
                $rutaArchivo8_2 = $request->file('certificadoMovimientoAnioAnteriorProgenitor2')->store('movimientos_migratorios_anio_anterior', 'public');

                // Actualizar el campo en la tabla progenitores
                Progenitor::where('id', $progenitorId)->update([
                    'certificado_movimiento_anio_anterior' => $rutaArchivo8_2
                ]);

                \Log::info("Archivo certificadoMovimientoAnioAnteriorProgenitor2 guardado/verificado exitosamente en: {$rutaArchivo8_2}");
            } else {
                \Log::warning("No se subió el archivo certificadoMovimientoAnioAnteriorProgenitor2 o no es válido.");
            }
        }

        if (!$request->has('noAplicaConstanciaBusquedaRegistrosProgenitor2')) {
            if ($request->hasFile('constanciaBusquedaRegistrosProgenitor2') && $request->file('constanciaBusquedaRegistrosProgenitor2')->isValid()) {
                $rutaArchivo9 = $request->file('constanciaBusquedaRegistrosProgenitor2')->store('bienes_inmuebles', 'public');
                DocumentoAdjunto::firstOrCreate(
                    [
                        'solicitud_id' => $solicitudId,
                        'progenitor_id' => $progenitorId,
                        'tipo_documento' => 'bienes_inmuebles',
                    ],
                    [
                        'ruta_archivo' => $rutaArchivo9,
                        'no_aplica' => '0',
                    ]
                );

                \Log::info("Archivo constanciaBusquedaRegistrosProgenitor2 guardado/verificado exitosamente en: {$rutaArchivo9}");
            } else {
                \Log::warning("No se subió el archivo constanciaBusquedaRegistrosProgenitor2 o no es válido.");
            }
        }

        if (!$request->has('noAplicaOtrosDocumentosProgenitor2')) {
            if ($request->hasFile('otrosDocumentosProgenitor2') && $request->file('otrosDocumentosProgenitor2')->isValid()) {
                $rutaArchivo10 = $request->file('otrosDocumentosProgenitor2')->store('otros', 'public');
                DocumentoAdjunto::firstOrCreate(
                    [
                        'solicitud_id' => $solicitudId,
                        'progenitor_id' => $progenitorId,
                        'tipo_documento' => 'otros',
                    ],
                    [
                        'ruta_archivo' => $rutaArchivo10,
                        'no_aplica' => '0',
                    ]
                );

                \Log::info("Archivo otrosDocumentosProgenitor2 guardado/verificado exitosamente en: {$rutaArchivo10}");
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
            'detalle_otros_ingresos' =>         $request->detalleOtrosIngresos  ?? null,
            'total_ingresos' =>         $request->totalIngresos ?? 0,
            'gastos_colegios' =>        $request->pagoColegios,
            'gastos_talleres' =>        $request->pagoTalleres,
            'gastos_universidad' =>     $request->pagoUniversidad,
            'gastos_alimentacion' =>    $request->pagoAlimentacion,
            'num_hijos' =>                      $request->numHijos  ?? 0,
            'gastos_alquiler' =>                $request->pagoAlquiler ?? 0.00,
            'gastos_credito_personal' =>        $request->pagoCreditoPersonal  ?? 0.00,
            'gastos_credito_hipotecario' =>     $request->pagoCreditoHipotecario  ?? 0.00,
            'gastos_credito_vehicular' =>       $request->pagoCreditoVehicular  ?? 0.00,
            'gastos_servicios' =>               $request->pagoServicios  ?? 0.00,
            'gastos_mantenimiento' =>           $request->pagoMantenimiento  ?? 0.00,
            'gastos_apoyo_casa' =>              $request->pagoApoyoCasa  ?? 0.00,
            'gastos_clubes' =>                  $request->pagoClubes  ?? 0.00,
            'gastos_seguros' =>                 $request->pagoSeguros  ?? 0.00,
            'gastos_apoyo_familiar' =>          $request->pagoApoyoFamiliar  ?? 0.00,
            'detalle_otros_gastos' =>           $request->detalleOtrosGastos  ?? null,
            'otros_gastos' =>           $request->otrosGastos,
            'total_gastos' =>           $request->totalGastos ?? 0,
        ]);
    }

    public function notificarPorCorreo(Solicitud $solicitud)
    {
        try {
            // Obtener los datos del estudiante
            $nombre = $solicitud->estudiante->nombres;
            $apellido = $solicitud->estudiante->apepaterno . ' ' . $solicitud->estudiante->apematerno;
            $url_alternativa = "https://aleph.eximio.com.pe/login";  // O la ruta adecuada

            // Obtener los correos de los progenitores
            $progenitores = $solicitud->progenitores; // Obtienes todos los progenitores relacionados

            // Obtener el correo del primer progenitor (si existe)
            $correo1cc = $progenitores->first()->correo_electronico ?? null;  // Obtener el correo del primer progenitor

            // Obtener el correo del segundo progenitor (si existe)
            $correo2cc = $progenitores->count() > 1 ? $progenitores->skip(1)->first()->correo_electronico : null; // Segundo progenitor

            // Establecer el destinatario principal CODIGO_USUARIO_NOTIFICA
            $destinatario = User::find(env('CODIGO_USUARIO_NOTIFICA', 3));

            // Correo para la copia
            $emailCopia = env('MAIL_FROM_ADDRESS', 'notificaciones@colegioaleph.edu.pe');

            // Preparar la llamada para enviar el correo
            $mail = Mail::to($destinatario);

            // Verificar si hay correos para agregar a CC
            if (!empty($correo1cc)) {
                $mail->cc($correo1cc);
            }
            if (!empty($correo2cc)) {
                $mail->cc($correo2cc);
            }
            // Agregar el correo de copia
            $mail->cc($emailCopia);

            // Enviar el correo
            $mail->send(new SolicitudCreadaMail($nombre, $apellido, $solicitud->id, $url_alternativa, $destinatario->name));
            \Log::info("Se notifico correctamente : emailCopia = {$emailCopia}; correo1cc={$correo1cc}; correo2cc={$correo2cc}");
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
            $emailCopia = env('MAIL_FROM_ADDRESS','notificaciones@colegioaleph.edu.pe');
            Mail::to($destinatario)
            ->cc($emailCopia)
            ->send(new SolicitudCreadaMail($nombre, $apellido, $id, $url_alternativa,$destinatario->name));
            return response()->json(['message' => 'Notificación enviada correctamente.']);
        }

        return response()->json(['message' => 'Solicitud no encontrada.'], 404);
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'tipo_documento' => 'required|string|max:255',
            'nro_documento' => 'required|string|max:255|unique:estudiantes',
            'apepaterno' => 'required|string|max:255',
            'apematerno' => 'required|string|max:255',
            'nombres' => 'required|string|max:255',
            'codigo_sianet' => 'nullable|string|max:6',
        ]);

        // Transformar los valores a mayúsculas
        $data = $request->only(['tipo_documento', 'nro_documento', 'apepaterno', 'apematerno', 'nombres', 'codigo_sianet']);
        $data = array_map('strtoupper', $data);

        // Crear un nuevo estudiante
        Estudiante::create($data);

        // Redireccionar con un mensaje de éxito
        return redirect()->back()->with('success', 'Estudiante creado correctamente.');
    }

    public function updatestudent(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);

        // Validar los datos
        $request->validate([
            'tipo_documento' => 'required|string',
            'nro_documento' => 'required|string|max:255|unique:estudiantes,nro_documento,' . $id,
            'apepaterno' => 'required|string|max:255',
            'apematerno' => 'required|string|max:255',
            'nombres' => 'required|string|max:255',
            'codigo_sianet' => 'nullable|string|max:6',
        ]);

        // Convertir los campos a mayúsculas antes de actualizar
        $data = $request->only([
            'tipo_documento',
            'nro_documento',
            'apepaterno',
            'apematerno',
            'nombres',
            'codigo_sianet'
        ]);

        // Transformar a mayúsculas
        $data = array_map('mb_strtoupper', $data);

        $estudiante->update($data);

        return redirect()->back()->with('success', 'Estudiante actualizado correctamente.');
    }

    public function destroy($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->delete();
        return redirect()->back()->with('success', 'Estudiante eliminado exitosamente.');
    }

}
