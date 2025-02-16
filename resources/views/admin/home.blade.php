@extends('layouts.admin')

@section('content')
    <div class="bg-dark-info pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <!-- Page header -->
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-2 mb-lg-0">
                        <h3 class="mb-0 text-white">Bienvenido {{ ucfirst(Auth::user()->name) }}</h3>
                    </div>
                    <div>
                        <form action="{{ route('backup') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres realizar un backup?');">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-database"></i> Realizar Backup
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card bg-light-success">
                    <!-- card body -->
                    <div class="card-body ">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center text-success  mb-3">
                            <div>
                                <h4 class="mb-0">Diario</h4>
                            </div>
                            <div class="icon-shape icon-md bg-success text-white  rounded-2">
                                <i class="bi bi-briefcase fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold text-success">{{ $contadorDiario }}</h1>
                            <p class="mb-0">Registrados</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card bg-light-primary">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center   mb-3">
                            <div>
                                <h4 class="mb-0 ">Semanal</h4>
                            </div>
                            <div class="icon-shape icon-md bg-primary text-white rounded-2">
                                <i class="bi bi-list-task fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold text-primary">{{ $contadorSemanal }}</h1>
                            <p class="mb-0">Registrados</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card bg-light-warning">
                    <!-- card body -->
                    <div class="card-body ">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">Mensual</h4>
                            </div>
                            <div class="icon-shape icon-md bg-warning text-white rounded-2">
                                <i class="bi bi-people fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold">{{ $contadorMensual }}</h1>
                            <p class="mb-0">Registrados</p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card bg-light-info ">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">Anual</h4>
                            </div>
                            <div class="icon-shape icon-md bg-info text-white rounded-2">
                                <i class="bi bi-bullseye fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold">{{ $contadorAnual }}</h1>
                            <p class="mb-0">Registrados</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row  -->
        <div class="row mt-6">
            <div class="col-md-12 col-12">
                <!-- card  -->
                <div class="card">
                    <!-- card header  -->
                    <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Listado de Solicitudes</h4>
                        <div class="bg-white py-2 d-flex flex-column flex-md-row justify-content-between align-items-start w-100">
                            <!-- Formulario de búsqueda -->
                            <form action="{{ route('admin.home') }}" method="GET" class="d-flex flex-column flex-md-row w-100 me-3">
                                <div class="input-group mb-2 mb-md-0 flex-fill me-3">
                                    {{-- <input type="text" class="form-control" name="dni" placeholder="Buscar por DNI" value="{{ request('dni') }}">--}}
                                    <input type="text" class="form-control" name="search" placeholder="Buscar por DNI, Nombre, Apellidos o Código SIANET" value="{{ request('search') }}">
                                </div>
                                <div class="input-group mb-2 mb-md-0 flex-fill me-3">
                                    <input type="date" class="form-control" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
                                </div>
                                <div class="input-group mb-2 mb-md-0 flex-fill me-3">
                                    <input type="date" class="form-control" name="fecha_fin" value="{{ request('fecha_fin') }}">
                                </div>
                                <button type="submit" class="btn btn-secondary mb-2 mb-md-0">Buscar</button>
                            </form>
                            <!-- Exportar dropdown -->
                            <div class="btn-group mt-2 mt-md-0 w-100 w-md-15">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Exportar
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('solicitudes.exportExcel') }}">Exportar a Excel</a></li>
                                    {{--<li><a class="dropdown-item" href="{{ route('solicitudes.exportPDF') }}">Exportar a PDF</a></li>--}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- table  -->
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>DNI <br> Estudiante</th>
                                    <th>Nombres <br> Estudiante</th>
                                    <th>Apellidos <br> Estudiante</th>
                                    <th>Progenitores</th>
                                    <th>Adjuntos</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($solicitudes as $solicitud)
                                <tr>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalSituacionEconomica{{ $solicitud->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditarDocumentos{{ $solicitud->id }}">
                                            <i class="fas fa-file-upload"></i>
                                        </button>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $solicitud->estudiante->nro_documento }}</td>
                                    <td>{{ $solicitud->estudiante->nombres }}</td>
                                    <td>{{ $solicitud->estudiante->apepaterno }} {{ $solicitud->estudiante->apematerno }}</td>
                                    <td>
                                        @if ($solicitud->progenitores->count() === 0)
                                            <span class="badge bg-danger">{{ strtoupper(str_replace('_', ' ', ' Sin progenitores')) }} </span>
                                        @elseif ($solicitud->progenitores->count() === 1)
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalProgenitor{{ $solicitud->id }}">
                                                {{ strtoupper(str_replace('_', ' ', ' Ver progenitor')) }}
                                            </button>
                                        @else
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalProgenitor{{ $solicitud->id }}">
                                                {{ strtoupper(str_replace('_', ' ', ' Ver Progenitores')) }}
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($solicitud->documentosAdjuntos->count() === 0)
                                            <span class="badge bg-danger">{{ strtoupper(str_replace('_', ' ', ' Sin Adjuntos')) }}</span>
                                        @else
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAdjuntos{{ $solicitud->id }}">
                                               {{ strtoupper(str_replace('_', ' ', ' Ver Adjuntos')) }}
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('solicitud.cambiarEstado', $solicitud->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            @php
                                                $colores = [
                                                    'pendiente' => 'btn-warning',
                                                    'en_revision' => 'btn-primary',
                                                    'aprobada' => 'btn-success',
                                                    'rechazada' => 'btn-danger',
                                                ];
                                            @endphp
                                            <button type="submit" class="btn btn-sm {{ $colores[$solicitud->estado_solicitud] ?? 'btn-secondary' }}">
                                                {{ strtoupper(str_replace('_', ' ', $solicitud->estado_solicitud)) }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Situación Económica -->
                                <div class="modal fade" id="modalSituacionEconomica{{ $solicitud->id }}" tabindex="-1" aria-labelledby="modalSituacionEconomicaLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalSituacionEconomicaLabel">Editar Situación Económica</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('situacionEconomica.update', $solicitud->situacionEconomica->id ?? '') }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <h5 class="text-primary">Ingresos</h5>
                                                    @foreach ([
                                                        'ingresos_planilla' => 'Ingresos por Planilla',
                                                        'ingresos_honorarios' => 'Ingresos por Honorarios',
                                                        'ingresos_pension' => 'Ingresos por Pensión',
                                                        'ingresos_alquiler' => 'Ingresos por Alquiler',
                                                        'ingresos_vehiculos' => 'Ingresos por Vehículos',
                                                        'otros_ingresos' => 'Otros Ingresos'
                                                    ] as $campo => $label)
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ $label }}</label>
                                                            <input type="number" class="form-control" name="{{ $campo }}" value="{{ $solicitud->situacionEconomica->$campo ?? '0.00' }}" step="1">
                                                        </div>
                                                    @endforeach

                                                    <div class="mb-3">
                                                        <label class="form-label">Detalle de Otros Ingresos</label>
                                                        <textarea class="form-control" name="detalle_otros_ingresos">{{ $solicitud->situacionEconomica->detalle_otros_ingresos ?? '' }}</textarea>
                                                    </div>

                                                    <h5 class="text-danger">Gastos</h5>
                                                    <div class="mb-3">
                                                        <label class="form-label">Número de Hijos</label>
                                                        <input type="number" class="form-control" name="num_hijos" value="{{ $solicitud->situacionEconomica->num_hijos ?? '0' }}">
                                                    </div>

                                                    @foreach ([
                                                        'gastos_colegios' => 'Gastos en Colegios',
                                                        'gastos_talleres' => 'Gastos en Talleres',
                                                        'gastos_universidad' => 'Gastos en Universidad',
                                                        'gastos_alimentacion' => 'Gastos en Alimentación',
                                                        'gastos_alquiler' => 'Gastos en Alquiler',
                                                        'gastos_credito_personal' => 'Gastos en Crédito Personal',
                                                        'gastos_credito_hipotecario' => 'Gastos en Crédito Hipotecario',
                                                        'gastos_credito_vehicular' => 'Gastos en Crédito Vehicular',
                                                        'gastos_servicios' => 'Gastos en Servicios',
                                                        'gastos_mantenimiento' => 'Gastos en Mantenimiento',
                                                        'gastos_apoyo_casa' => 'Gastos en Apoyo al Hogar',
                                                        'gastos_clubes' => 'Gastos en Clubes',
                                                        'gastos_seguros' => 'Gastos en Seguros',
                                                        'gastos_apoyo_familiar' => 'Gastos en Apoyo Familiar',
                                                        'otros_gastos' => 'Otros Gastos'
                                                    ] as $campo => $label)
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ $label }}</label>
                                                            <input type="number" class="form-control" name="{{ $campo }}" value="{{ $solicitud->situacionEconomica->$campo ?? '0.00' }}" step="1">
                                                        </div>
                                                    @endforeach

                                                    <div class="mb-3">
                                                        <label class="form-label">Detalle de Otros Gastos</label>
                                                        <textarea class="form-control" name="detalle_otros_gastos">{{ $solicitud->situacionEconomica->detalle_otros_gastos ?? '' }}</textarea>
                                                    </div>

                                                    <h5 class="text-success">Totales</h5>
                                                    <div class="mb-3">
                                                        <label class="form-label">Total Ingresos</label>
                                                        <input type="number" class="form-control" name="total_ingresos" value="{{ $solicitud->situacionEconomica->total_ingresos ?? '0.00' }}" step="1" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Total Gastos</label>
                                                        <input type="number" class="form-control" name="total_gastos" value="{{ $solicitud->situacionEconomica->total_gastos ?? '0.00' }}" step="1">
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Modal Editar Documentos -->
                                <div class="modal fade" id="modalEditarDocumentos{{ $solicitud->id }}" tabindex="-1" aria-labelledby="modalEditarDocumentosLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEditarDocumentosLabel">Editar Documentos Adjuntos</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('documentosAdjuntos.update', $solicitud->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                                                        <select class="form-control" name="tipo_documento">
                                                            <option value="boletas_pago">Boletas de Pago</option>
                                                            <option value="declaracion_renta">Declaración de Renta</option>
                                                            <option value="movimientos_migratorios">Movimientos Migratorios</option>
                                                            <option value="bienes_inmuebles">Bienes Inmuebles</option>
                                                            <option value="otros">Otros</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="ruta_archivo" class="form-label">Subir Archivo</label>
                                                        <input type="file" class="form-control" name="ruta_archivo">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $solicitudes->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>

                    @foreach ($solicitudes as $solicitud)
                    <div class="modal fade" id="modalProgenitor{{ $solicitud->id }}" tabindex="-1" aria-labelledby="modalProgenitorLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Progenitores de {{ $solicitud->estudiante->nombres }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if ($solicitud->progenitores->count() === 0)
                                        <p>No hay progenitores registrados.</p>
                                    @else
                                        <ul>
                                            @foreach ($solicitud->progenitores as $progenitor)
                                                <li>
                                                    @if ($progenitor->nombres || $progenitor->apellidos)
                                                        <strong>NOMBRE:</strong> {{ strtoupper($progenitor->nombres) }} {{ strtoupper($progenitor->apellidos) }}<br>
                                                    @endif

                                                    @if ($progenitor->dni)
                                                        <strong>DNI:</strong> {{ strtoupper($progenitor->dni) }}<br>
                                                    @endif

                                                    @if ($progenitor->tipo)
                                                        <strong>TIPO:</strong> {{ strtoupper($progenitor->tipo) }}<br>
                                                    @endif

                                                    @if ($progenitor->codigo_sianet)
                                                        <strong>CÓDIGO SIANET:</strong> {{ strtoupper($progenitor->codigo_sianet) }}<br>
                                                    @endif

                                                    @if ($progenitor->numero_hijos)
                                                        <strong>NRO. HIJOS:</strong> {{ $progenitor->numero_hijos }}<br>
                                                    @endif

                                                    @if ($progenitor->hijos_matriculados)
                                                        <strong>HIJOS MATRICULADOS:</strong> {{ $progenitor->hijos_matriculados }}<br>
                                                    @endif

                                                    @if ($progenitor->formacion_academica)
                                                        <strong>FORMACIÓN ACADÉMICA:</strong> {{ strtoupper($progenitor->formacion_academica) }}<br>
                                                    @endif

                                                    @if ($progenitor->trabaja !== null)
                                                        <strong>TRABAJA:</strong> {{ $progenitor->trabaja ? 'SÍ' : 'NO' }}<br>
                                                    @endif

                                                    @if ($progenitor->tiempo_desempleo)
                                                        <strong>TIEMPO DESEMPLEO:</strong> {{ strtoupper($progenitor->tiempo_desempleo) }}<br>
                                                    @endif

                                                    @if ($progenitor->sueldo_fijo !== null)
                                                        <strong>SUELDO FIJO:</strong> {{ $progenitor->sueldo_fijo ? 'SÍ' : 'NO' }}<br>
                                                    @endif

                                                    @if ($progenitor->sueldo_variable !== null)
                                                        <strong>SUELDO VARIABLE:</strong> {{ $progenitor->sueldo_variable ? 'SÍ' : 'NO' }}<br>
                                                    @endif

                                                    @if ($progenitor->cargo)
                                                        <strong>CARGO:</strong> {{ strtoupper($progenitor->cargo) }}<br>
                                                    @endif

                                                    @if ($progenitor->anio_inicio_laboral)
                                                        <strong>AÑO INICIO LABORAL:</strong> {{ $progenitor->anio_inicio_laboral }}<br>
                                                    @endif

                                                    @if ($progenitor->lugar_trabajo)
                                                        <strong>LUGAR DE TRABAJO:</strong> {{ strtoupper($progenitor->lugar_trabajo) }}<br>
                                                    @endif

                                                    @if ($progenitor->ingresos_mensuales)
                                                        <strong>INGRESOS MENSUALES:</strong> S/. {{ number_format($progenitor->ingresos_mensuales, 2) }}<br>
                                                    @endif

                                                    @if ($progenitor->recibe_bonos !== null)
                                                        <strong>RECIBE BONOS:</strong> {{ $progenitor->recibe_bonos ? 'SÍ' : 'NO' }}<br>
                                                    @endif

                                                    @if ($progenitor->monto_bonos)
                                                        <strong>MONTO BONOS:</strong> {{ strtoupper($progenitor->monto_bonos) }}<br>
                                                    @endif

                                                    @if ($progenitor->recibe_utilidades !== null)
                                                        <strong>RECIBE UTILIDADES:</strong> {{ $progenitor->recibe_utilidades ? 'SÍ' : 'NO' }}<br>
                                                    @endif

                                                    @if ($progenitor->monto_utilidades)
                                                        <strong>MONTO UTILIDADES:</strong> {{ strtoupper($progenitor->monto_utilidades) }}<br>
                                                    @endif

                                                    @if ($progenitor->titular_empresa !== null)
                                                        <strong>TITULAR EMPRESA:</strong> {{ $progenitor->titular_empresa ? 'SÍ' : 'NO' }}<br>
                                                    @endif

                                                    @if ($progenitor->porcentaje_acciones)
                                                        <strong>PORCENTAJE ACCIONES:</strong> {{ $progenitor->porcentaje_acciones }}%<br>
                                                    @endif

                                                    @if ($progenitor->razon_social)
                                                        <strong>RAZÓN SOCIAL:</strong> {{ strtoupper($progenitor->razon_social) }}<br>
                                                    @endif

                                                    @if ($progenitor->numero_ruc)
                                                        <strong>RUC:</strong> {{ $progenitor->numero_ruc }}<br>
                                                    @endif

                                                    @if ($progenitor->vivienda_tipo)
                                                        <strong>TIPO DE VIVIENDA:</strong> {{ strtoupper($progenitor->vivienda_tipo) }}<br>
                                                    @endif

                                                    @if ($progenitor->credito_hipotecario !== null)
                                                        <strong>CRÉDITO HIPOTECARIO:</strong> {{ $progenitor->credito_hipotecario ? 'SÍ' : 'NO' }}<br>
                                                    @endif

                                                    @if ($progenitor->direccion_vivienda)
                                                        <strong>DIRECCIÓN:</strong> {{ strtoupper($progenitor->direccion_vivienda) }}<br>
                                                    @endif

                                                    @if ($progenitor->m2_vivienda)
                                                        <strong>M² VIVIENDA:</strong> {{ $progenitor->m2_vivienda }}<br>
                                                    @endif

                                                    @if ($progenitor->cantidad_inmuebles)
                                                        <strong>CANTIDAD DE INMUEBLES:</strong> {{ $progenitor->cantidad_inmuebles }}<br>
                                                    @endif
                                                </li>
                                                <hr>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach


                    @foreach ($solicitudes as $solicitud)
                    <div class="modal fade" id="modalAdjuntos{{ $solicitud->id }}" tabindex="-1" aria-labelledby="modalAdjuntosLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Documentos Adjuntos</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if ($solicitud->documentosAdjuntos->count() === 0)
                                        <p>No hay documentos adjuntos.</p>
                                    @else
                                        <ul>
                                            @foreach ($solicitud->documentosAdjuntos as $documento)
                                                <li>
                                                    <a href="{{ asset('storage/' . $documento->ruta_archivo) }}" target="_blank">
                                                        Ver PDF {{ strtoupper(str_replace('_', ' ', $documento->tipo_documento)) }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- card footer  -->
                    <div class="card-footer bg-white text-center">
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function calcularTotales() {
        let totalIngresos = 0;
        let totalGastos = 0;

        $('.ingresos').each(function () {
            totalIngresos += parseFloat($(this).val()) || 0;
        });

        $('.gastos').each(function () {
            totalGastos += parseFloat($(this).val()) || 0;
        });

        $('#total_ingresos').val(totalIngresos.toFixed(2));
        $('#total_gastos').val(totalGastos.toFixed(2));
    }

    // Calcular totales cuando cambia un input de ingresos o gastos
    $(document).on('input', '.ingresos, .gastos', function () {
        calcularTotales();
    });

    // Calcular totales cuando se carga la página
    $(document).ready(function () {
        calcularTotales();
    });
</script>
