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
                    <div class="d-flex gap-2">
                        <!-- Botón de Reportes y Estadísticas -->
                        <button class="btn btn-outline-light btn-lg shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalEstadisticas" style="transition: all 0.3s ease;">
                            <i class="bi bi-graph-up" style="transition: transform 0.3s ease;"></i>
                            <span>Ver Reportes y Estadísticas</span>
                        </button>

                        <!-- Botón de Backup con SweetAlert -->
                        <form action="{{ route('backup') }}" method="POST" id="backupForm">
                            @csrf
                            <button type="button" class="btn btn-success btn-lg" onclick="confirmarBackup()">
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
                                    <input type="text" class="form-control" name="search" placeholder="Buscar por DNI, Nombre, Apellidos o Código SIANET" value="{{ request('search') }}">
                                </div>
                                <div class="input-group mb-2 mb-md-0 flex-fill me-3">
                                    <select class="form-select" name="año" id="año">
                                        @for($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                                            <option value="{{ $i }}" {{ ($añoSeleccionado ?? date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="input-group mb-2 mb-md-0 flex-fill me-3">
                                    <input type="date" class="form-control" name="fecha_inicio" value="{{ request('fecha_inicio') }}" placeholder="Fecha inicio">
                                </div>
                                <div class="input-group mb-2 mb-md-0 flex-fill me-3">
                                    <input type="date" class="form-control" name="fecha_fin" value="{{ request('fecha_fin') }}" placeholder="Fecha fin">
                                </div>
                                <button type="submit" class="btn btn-secondary mb-2 mb-md-0">Buscar</button>
                            </form>
                            <!-- Exportar dropdown -->
                            <div class="btn-group mt-2 mt-md-0 w-100 w-md-15">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Exportar
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('solicitudes.exportExcel', request()->query()) }}">Exportar a Excel</a></li>
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
                                    <th>Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($solicitudes as $solicitud)
                                <tr>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalSituacionEconomica{{ $solicitud->id }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Situación Económica">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditarDocumentos{{ $solicitud->id }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Documentos Adjuntos">
                                            <i class="fas fa-file-upload"></i>
                                        </button>
                                        <a href="{{ route('descargar.documentos', $solicitud->id) }}" class="btn btn-primary btn-sm"
                                           data-bs-toggle="tooltip" data-bs-placement="top" title="Descargar Documentos">
                                            <i class="fas fa-file-archive"></i>
                                        </a>
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
                                        @php
                                            $tieneDocumentosAdjuntos = $solicitud->documentosAdjuntos->count() > 0;
                                            $tieneCertificadosProgenitores = $solicitud->progenitores->filter(function($progenitor) {
                                                return !empty($progenitor->certificado_movimiento_anio_actual) || !empty($progenitor->certificado_movimiento_anio_anterior);
                                            })->isNotEmpty();
                                            $tieneDocumentos = $tieneDocumentosAdjuntos || $tieneCertificadosProgenitores;
                                        @endphp
                                        @if (!$tieneDocumentos)
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
                                    <td>
                                        {{ $solicitud->created_at->timezone('America/Lima')->format('d/m/Y') }} <br>
                                        {{ $solicitud->created_at->timezone('America/Lima')->format('H:i:s') }}
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $solicitudes->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>

                    <!-- Modales movidos fuera del grid -->

                    <!-- Modales de progenitores y adjuntos movidos fuera del grid -->

                    <!-- card footer  -->
                    <div class="card-footer bg-white text-center">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- MODALES DEL GRID MOVIDOS FUERA PARA EVITAR PARPADEO -->
    @foreach ($solicitudes as $solicitud)
    <!-- Modal Situación Económica -->
    <div class="modal fade" id="modalSituacionEconomica{{ $solicitud->id }}" tabindex="-1" aria-labelledby="modalSituacionEconomicaLabel{{ $solicitud->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSituacionEconomicaLabel{{ $solicitud->id }}">Editar Situación Económica - {{ $solicitud->estudiante->nombres }}</h5>
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
                                <input type="number" class="form-control" name="{{ $campo }}" value="{{ $solicitud->situacionEconomica->$campo ?? '0.00' }}" step="0.01">
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
                                <input type="number" class="form-control" name="{{ $campo }}" value="{{ $solicitud->situacionEconomica->$campo ?? '0.00' }}" step="0.01">
                            </div>
                        @endforeach

                        <div class="mb-3">
                            <label class="form-label">Detalle de Otros Gastos</label>
                            <textarea class="form-control" name="detalle_otros_gastos">{{ $solicitud->situacionEconomica->detalle_otros_gastos ?? '' }}</textarea>
                        </div>

                        <h5 class="text-success">Totales</h5>
                        <div class="mb-3">
                            <label class="form-label">Total Ingresos</label>
                            <input type="number" class="form-control" name="total_ingresos" value="{{ $solicitud->situacionEconomica->total_ingresos ?? '0.00' }}" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Gastos</label>
                            <input type="number" class="form-control" name="total_gastos" value="{{ $solicitud->situacionEconomica->total_gastos ?? '0.00' }}" step="0.01">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Documentos -->
    <div class="modal fade" id="modalEditarDocumentos{{ $solicitud->id }}" tabindex="-1" aria-labelledby="modalEditarDocumentosLabel{{ $solicitud->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarDocumentosLabel{{ $solicitud->id }}">Editar Documentos Adjuntos - {{ $solicitud->estudiante->nombres }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('documentosAdjuntos.update', $solicitud->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                            <select class="form-control" name="tipo_documento" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="boletas_pago">Boletas de Pago</option>
                                <option value="declaracion_renta">Declaración de Renta</option>
                                <option value="movimientos_migratorios">Movimientos Migratorios</option>
                                <option value="certificados_migratorio_anio_actual">Certificados de Movimiento Migratorio - Año Actual</option>
                                <option value="certificados_migratorio_anio_anterior">Certificados de Movimiento Migratorio - Año Anterior</option>
                                <option value="bienes_inmuebles">Bienes Inmuebles</option>
                                <option value="otros">Otros</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="ruta_archivo" class="form-label">Subir Archivo</label>
                            <input type="file" class="form-control" name="ruta_archivo" accept=".pdf,.jpg,.jpeg,.png" required>
                            <div class="form-text">Formatos permitidos: PDF, JPG, JPEG, PNG. Tamaño máximo: 5MB</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Documento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- MODALES DE PROGENITORES Y ADJUNTOS MOVIDOS FUERA DEL GRID -->
    @foreach ($solicitudes as $solicitud)
    <!-- Modal Progenitores -->
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
                                <form action="{{ route('progenitores.update', $progenitor->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Campo oculto para el tipo de progenitor -->
                                    <input type="hidden" name="tipo" value="{{ $progenitor->tipo }}">

                                    <!-- Título del progenitor -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <h4>{{ $progenitor->tipo === 'progenitor1' ? 'Progenitor 1' : 'Progenitor 2' }}</h4>
                                        </div>
                                    </div>

                                    <!-- Nombre -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="nombres{{ $progenitor->id }}" class="form-label">NOMBRE:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="nombres{{ $progenitor->id }}" name="nombres" value="{{ strtoupper($progenitor->nombres) }}">
                                        </div>
                                    </div>

                                    <!-- Apellidos -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="apellidos{{ $progenitor->id }}" class="form-label">APELLIDOS:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="apellidos{{ $progenitor->id }}" name="apellidos" value="{{ strtoupper($progenitor->apellidos) }}">
                                        </div>
                                    </div>

                                    <!-- DNI -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="dni{{ $progenitor->id }}" class="form-label">DNI:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="dni{{ $progenitor->id }}" name="dni" value="{{ strtoupper($progenitor->dni) }}">
                                        </div>
                                    </div>

                                    <!-- Código SIANET -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="codigo_sianet{{ $progenitor->id }}" class="form-label">CÓDIGO SIANET:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="codigo_sianet{{ $progenitor->id }}" name="codigo_sianet" value="{{ strtoupper($progenitor->codigo_sianet) }}">
                                        </div>
                                    </div>

                                    <!-- Número de hijos -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="numero_hijos{{ $progenitor->id }}" class="form-label">NRO. HIJOS:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" id="numero_hijos{{ $progenitor->id }}" name="numero_hijos" value="{{ $progenitor->numero_hijos }}">
                                        </div>
                                    </div>

                                    <!-- Hijos matriculados -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="hijos_matriculados{{ $progenitor->id }}" class="form-label">HIJOS MATRICULADOS:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" id="hijos_matriculados{{ $progenitor->id }}" name="hijos_matriculados" value="{{ $progenitor->hijos_matriculados }}">
                                        </div>
                                    </div>

                                    <!-- Formación académica -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="formacion_academica{{ $progenitor->id }}" class="form-label">FORMACIÓN ACADÉMICA:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" id="formacion_academica{{ $progenitor->id }}" name="formacion_academica">
                                                <option value="tecnica" {{ $progenitor->formacion_academica == 'tecnica' ? 'selected' : '' }}>Técnica</option>
                                                <option value="universitaria" {{ $progenitor->formacion_academica == 'universitaria' ? 'selected' : '' }}>Universitaria</option>
                                                <option value="bachillerato" {{ $progenitor->formacion_academica == 'bachillerato' ? 'selected' : '' }}>Bachillerato</option>
                                                <option value="titulado" {{ $progenitor->formacion_academica == 'titulado' ? 'selected' : '' }}>Titulado</option>
                                                <option value="maestria" {{ $progenitor->formacion_academica == 'maestria' ? 'selected' : '' }}>Maestría</option>
                                                <option value="doctorado" {{ $progenitor->formacion_academica == 'doctorado' ? 'selected' : '' }}>Doctorado</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Trabaja -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="trabaja{{ $progenitor->id }}" class="form-label">TRABAJA:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" id="trabaja{{ $progenitor->id }}" name="trabaja">
                                                <option value="1" {{ $progenitor->trabaja ? 'selected' : '' }}>SÍ</option>
                                                <option value="0" {{ !$progenitor->trabaja ? 'selected' : '' }}>NO</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Tiempo de desempleo -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="tiempo_desempleo{{ $progenitor->id }}" class="form-label">TIEMPO DESEMPLEO:</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" id="tiempo_desempleo{{ $progenitor->id }}" name="tiempo_desempleo" value="{{ strtoupper($progenitor->tiempo_desempleo) }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="tiempo_desempleo{{ $progenitor->id }}" class="form-label">(en meses)</label>
                                        </div>
                                    </div>

                                    <!-- Sueldo fijo -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="sueldo_fijo{{ $progenitor->id }}" class="form-label">SUELDO FIJO:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" id="sueldo_fijo{{ $progenitor->id }}" name="sueldo_fijo">
                                                <option value="1" {{ $progenitor->sueldo_fijo ? 'selected' : '' }}>SÍ</option>
                                                <option value="0" {{ !$progenitor->sueldo_fijo ? 'selected' : '' }}>NO</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Sueldo variable -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="sueldo_variable{{ $progenitor->id }}" class="form-label">SUELDO VARIABLE:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" id="sueldo_variable{{ $progenitor->id }}" name="sueldo_variable">
                                                <option value="1" {{ $progenitor->sueldo_variable ? 'selected' : '' }}>SÍ</option>
                                                <option value="0" {{ !$progenitor->sueldo_variable ? 'selected' : '' }}>NO</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Cargo -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="cargo{{ $progenitor->id }}" class="form-label">CARGO:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="cargo{{ $progenitor->id }}" name="cargo" value="{{ strtoupper($progenitor->cargo) }}">
                                        </div>
                                    </div>

                                    <!-- Año inicio laboral -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="anio_inicio_laboral{{ $progenitor->id }}" class="form-label">AÑO INICIO LABORAL:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="anio_inicio_laboral{{ $progenitor->id }}" name="anio_inicio_laboral" value="{{ $progenitor->anio_inicio_laboral }}">
                                        </div>
                                    </div>

                                    <!-- Lugar de trabajo -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="lugar_trabajo{{ $progenitor->id }}" class="form-label">LUGAR DE TRABAJO:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="lugar_trabajo{{ $progenitor->id }}" name="lugar_trabajo" value="{{ strtoupper($progenitor->lugar_trabajo) }}">
                                        </div>
                                    </div>

                                    <!-- Ingresos mensuales -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="ingresos_mensuales{{ $progenitor->id }}" class="form-label">INGRESOS MENSUALES:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" step="0.01" class="form-control" id="ingresos_mensuales{{ $progenitor->id }}" name="ingresos_mensuales" value="{{ $progenitor->ingresos_mensuales }}">
                                        </div>
                                    </div>

                                    <!-- Recibe bonos -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="recibe_bonos{{ $progenitor->id }}" class="form-label">RECIBE BONOS:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" id="recibe_bonos{{ $progenitor->id }}" name="recibe_bonos">
                                                <option value="1" {{ $progenitor->recibe_bonos ? 'selected' : '' }}>SÍ</option>
                                                <option value="0" {{ !$progenitor->recibe_bonos ? 'selected' : '' }}>NO</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Monto bonos -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="monto_bonos{{ $progenitor->id }}" class="form-label">MONTO BONOS:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" id="monto_bonos{{ $progenitor->id }}" name="monto_bonos">
                                                <option value="5000-10000" {{ $progenitor->monto_bonos == '5000-10000' ? 'selected' : '' }}>5000-10000</option>
                                                <option value="10000-15000" {{ $progenitor->monto_bonos == '10000-15000' ? 'selected' : '' }}>10000-15000</option>
                                                <option value="15000-mas" {{ $progenitor->monto_bonos == '15000-mas' ? 'selected' : '' }}>15000-mas</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Recibe utilidades -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="recibe_utilidades{{ $progenitor->id }}" class="form-label">RECIBE UTILIDADES:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" id="recibe_utilidades{{ $progenitor->id }}" name="recibe_utilidades">
                                                <option value="1" {{ $progenitor->recibe_utilidades ? 'selected' : '' }}>SÍ</option>
                                                <option value="0" {{ !$progenitor->recibe_utilidades ? 'selected' : '' }}>NO</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Monto utilidades -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="monto_utilidades{{ $progenitor->id }}" class="form-label">MONTO UTILIDADES:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" id="monto_utilidades{{ $progenitor->id }}" name="monto_utilidades">
                                                <option value="5000-10000" {{ $progenitor->monto_utilidades == '5000-10000' ? 'selected' : '' }}>5000-10000</option>
                                                <option value="10000-15000" {{ $progenitor->monto_utilidades == '10000-15000' ? 'selected' : '' }}>10000-15000</option>
                                                <option value="15000-mas" {{ $progenitor->monto_utilidades == '15000-mas' ? 'selected' : '' }}>15000-mas</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Titular empresa -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="titular_empresa{{ $progenitor->id }}" class="form-label">TITULAR EMPRESA:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" id="titular_empresa{{ $progenitor->id }}" name="titular_empresa">
                                                <option value="1" {{ $progenitor->titular_empresa ? 'selected' : '' }}>SÍ</option>
                                                <option value="0" {{ !$progenitor->titular_empresa ? 'selected' : '' }}>NO</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Porcentaje acciones -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="porcentaje_acciones{{ $progenitor->id }}" class="form-label">PORCENTAJE ACCIONES:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" step="0.01" class="form-control" id="porcentaje_acciones{{ $progenitor->id }}" name="porcentaje_acciones" value="{{ $progenitor->porcentaje_acciones }}">
                                        </div>
                                    </div>

                                    <!-- Razón social -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="razon_social{{ $progenitor->id }}" class="form-label">RAZÓN SOCIAL:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="razon_social{{ $progenitor->id }}" name="razon_social" value="{{ strtoupper($progenitor->razon_social) }}">
                                        </div>
                                    </div>

                                    <!-- RUC -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="numero_ruc{{ $progenitor->id }}" class="form-label">RUC:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="numero_ruc{{ $progenitor->id }}" name="numero_ruc" value="{{ $progenitor->numero_ruc }}">
                                        </div>
                                    </div>

                                    <!-- Tipo de vivienda -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="vivienda_tipo{{ $progenitor->id }}" class="form-label">TIPO DE VIVIENDA:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" id="vivienda_tipo{{ $progenitor->id }}" name="vivienda_tipo">
                                                <option value="propia" {{ $progenitor->vivienda_tipo == 'propia' ? 'selected' : '' }}>Propia</option>
                                                <option value="alquilada" {{ $progenitor->vivienda_tipo == 'alquilada' ? 'selected' : '' }}>Alquilada</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Crédito hipotecario -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="credito_hipotecario{{ $progenitor->id }}" class="form-label">CRÉDITO HIPOTECARIO:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" id="credito_hipotecario{{ $progenitor->id }}" name="credito_hipotecario">
                                                <option value="1" {{ $progenitor->credito_hipotecario ? 'selected' : '' }}>SÍ</option>
                                                <option value="0" {{ !$progenitor->credito_hipotecario ? 'selected' : '' }}>NO</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Dirección de vivienda -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="direccion_vivienda{{ $progenitor->id }}" class="form-label">DIRECCIÓN:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" id="direccion_vivienda{{ $progenitor->id }}" name="direccion_vivienda">{{ strtoupper($progenitor->direccion_vivienda) }}</textarea>
                                        </div>
                                    </div>

                                    <!-- M² vivienda -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="m2_vivienda{{ $progenitor->id }}" class="form-label">M² VIVIENDA:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" step="0.01" class="form-control" id="m2_vivienda{{ $progenitor->id }}" name="m2_vivienda" value="{{ $progenitor->m2_vivienda }}">
                                        </div>
                                    </div>

                                    <!-- Cantidad de inmuebles -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="cantidad_inmuebles{{ $progenitor->id }}" class="form-label">CANTIDAD DE INMUEBLES:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" id="cantidad_inmuebles{{ $progenitor->id }}" name="cantidad_inmuebles" value="{{ $progenitor->cantidad_inmuebles }}">
                                        </div>
                                    </div>

                                    <!-- Botón de guardar -->
                                    <div class="row mb-3">
                                        <div class="col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                        </div>
                                    </div>
                                </form>
                            </li>
                            <hr>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Adjuntos -->
    <div class="modal fade" id="modalAdjuntos{{ $solicitud->id }}" tabindex="-1" aria-labelledby="modalAdjuntosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Documentos Adjuntos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $tieneDocumentosAdjuntos = $solicitud->documentosAdjuntos->count() > 0;
                        $tieneCertificadosProgenitores = $solicitud->progenitores->filter(function($progenitor) {
                            return !empty($progenitor->certificado_movimiento_anio_actual) || !empty($progenitor->certificado_movimiento_anio_anterior);
                        })->isNotEmpty();
                    @endphp

                    @if (!$tieneDocumentosAdjuntos && !$tieneCertificadosProgenitores)
                        <p>No hay documentos adjuntos.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tipo de Documento</th>
                                        <th>Progenitor</th>
                                        <th>Archivo</th>
                                        <th>Tamaño</th>
                                        <th>Fecha de Subida</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitud->documentosAdjuntos as $documento)
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary">
                                                    {{ strtoupper(str_replace('_', ' ', $documento->tipo_documento)) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($documento->progenitor_id)
                                                    <span class="badge bg-info">Progenitor {{ $documento->progenitor_id }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Estudiante</span>
                                                @endif
                                            </td>
                                            <td>
                                                <i class="fas fa-file-pdf text-danger"></i>
                                                {{ $documento->nombre_archivo_original ?? basename($documento->ruta_archivo) }}
                                            </td>
                                            <td>
                                                @if($documento->tamaño_archivo)
                                                    {{ number_format($documento->tamaño_archivo / 1024, 2) }} KB
                                                @else
                                                    @php
                                                        $filePath = storage_path('app/public/' . $documento->ruta_archivo);
                                                        $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
                                                    @endphp
                                                    @if($fileSize > 0)
                                                        {{ number_format($fileSize / 1024, 2) }} KB
                                                    @else
                                                        N/A
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                {{ $documento->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td>
                                                <a href="{{ asset('storage/' . $documento->ruta_archivo) }}"
                                                   target="_blank"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                                <a href="{{ asset('storage/' . $documento->ruta_archivo) }}"
                                                   download
                                                   class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-download"></i> Descargar
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    {{-- Certificados de Movimientos Migratorios de los Progenitores --}}
                                    @foreach ($solicitud->progenitores as $progenitor)
                                        @if(!empty($progenitor->certificado_movimiento_anio_actual))
                                            <tr>
                                                <td>
                                                    <span class="badge bg-success">
                                                        CERTIFICADO MOVIMIENTO MIGRATORIO AÑO ACTUAL
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">Progenitor {{ $progenitor->id }}</span>
                                                </td>
                                                <td>
                                                    <i class="fas fa-file-pdf text-danger"></i>
                                                    {{ basename($progenitor->certificado_movimiento_anio_actual) }}
                                                </td>
                                                <td>
                                                    @php
                                                        $filePath = storage_path('app/public/' . $progenitor->certificado_movimiento_anio_actual);
                                                        $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
                                                    @endphp
                                                    @if($fileSize > 0)
                                                        {{ number_format($fileSize / 1024, 2) }} KB
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $progenitor->updated_at->format('d/m/Y H:i') }}
                                                </td>
                                                <td>
                                                    <a href="{{ asset('storage/' . $progenitor->certificado_movimiento_anio_actual) }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </a>
                                                    <a href="{{ asset('storage/' . $progenitor->certificado_movimiento_anio_actual) }}"
                                                       download
                                                       class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-download"></i> Descargar
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif

                                        @if(!empty($progenitor->certificado_movimiento_anio_anterior))
                                            <tr>
                                                <td>
                                                    <span class="badge bg-success">
                                                        CERTIFICADO MOVIMIENTO MIGRATORIO AÑO ANTERIOR
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">Progenitor {{ $progenitor->id }}</span>
                                                </td>
                                                <td>
                                                    <i class="fas fa-file-pdf text-danger"></i>
                                                    {{ basename($progenitor->certificado_movimiento_anio_anterior) }}
                                                </td>
                                                <td>
                                                    @php
                                                        $filePath = storage_path('app/public/' . $progenitor->certificado_movimiento_anio_anterior);
                                                        $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
                                                    @endphp
                                                    @if($fileSize > 0)
                                                        {{ number_format($fileSize / 1024, 2) }} KB
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $progenitor->updated_at->format('d/m/Y H:i') }}
                                                </td>
                                                <td>
                                                    <a href="{{ asset('storage/' . $progenitor->certificado_movimiento_anio_anterior) }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </a>
                                                    <a href="{{ asset('storage/' . $progenitor->certificado_movimiento_anio_anterior) }}"
                                                       download
                                                       class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-download"></i> Descargar
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal de Estadísticas -->
    <div class="modal fade" id="modalEstadisticas" tabindex="-1" aria-labelledby="modalEstadisticasLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalEstadisticasLabel">
                        <i class="bi bi-graph-up me-2"></i>Reportes y Estadísticas del Sistema
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Resumen de contadores -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-light-warning text-center">
                                <div class="card-body">
                                    <h3 class="text-warning">{{ $contadoresEstado['pendientes'] }}</h3>
                                    <p class="mb-0">Pendientes</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light-primary text-center">
                                <div class="card-body">
                                    <h3 class="text-primary">{{ $contadoresEstado['en_revision'] }}</h3>
                                    <p class="mb-0">En Revisión</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light-success text-center">
                                <div class="card-body">
                                    <h3 class="text-success">{{ $contadoresEstado['aprobadas'] }}</h3>
                                    <p class="mb-0">Aprobadas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light-danger text-center">
                                <div class="card-body">
                                    <h3 class="text-danger">{{ $contadoresEstado['rechazadas'] }}</h3>
                                    <p class="mb-0">Rechazadas</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gráficos -->
                    <div class="row">
                        <!-- Gráfico de Estados (Dona) -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Estado de Solicitudes</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="chartEstados"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfico de Documentos (Dona) -->
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Estado de Documentos</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="chartDocumentos"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfico de Tendencia Mensual (Línea) -->
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Tendencia Mensual de Solicitudes</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="chartMensual"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfico de Tendencia Semanal (Barras) -->
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Tendencia Semanal de Solicitudes</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="chartSemanal"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .collapse {
        transition: height 0.35s ease;
    }

    .btn-outline-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,123,255,0.2) !important;
    }

    .card {
        transition: transform 0.1s ease, box-shadow 0.1s ease;
    }

    .card:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    #contadoresAdicionales {
        border-top: 1px solid #e9ecef;
        padding-top: 1rem;
        margin-top: 1rem;
    }

    /* Estilos para los gráficos */
    .modal-body canvas {
        max-height: 300px !important;
        width: 100% !important;
    }

    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    /* Estilos para botones superiores */
    .btn-outline-light:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(255,255,255,0.3) !important;
        background-color: rgba(255,255,255,0.1) !important;
        border-color: rgba(255,255,255,0.5) !important;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(25,135,84,0.3) !important;
    }

    .gap-2 {
        gap: 0.5rem !important;
    }

    /* Prevenir parpadeo de modales */
    .modal {
        pointer-events: auto !important;
    }

    .modal.show {
        display: block !important;
        pointer-events: auto !important;
    }

    .modal-backdrop {
        pointer-events: auto !important;
    }

    /* Efectos hover deshabilitados en modales para prevenir parpadeo */
    .modal .card:hover,
    .modal .btn:hover,
    .modal .form-control:hover,
    .modal input:hover,
    .modal select:hover,
    .modal textarea:hover {
        transform: none !important;
        box-shadow: none !important;
    }

    /* Estabilizar modales */
    .modal.fade {
        transition: opacity 0.15s linear;
    }

    .modal.fade .modal-dialog {
        transition: transform 0.15s ease-out;
    }

    /* Prevenir parpadeo específico */
    .modal.show {
        opacity: 1 !important;
        display: block !important;
        pointer-events: auto !important;
    }

    .modal-backdrop.show {
        opacity: 0.5 !important;
        pointer-events: auto !important;
    }

    /* Prevenir parpadeo cuando el cursor está sobre el modal */
    .modal.show .modal-dialog {
        pointer-events: auto !important;
        position: relative !important;
        z-index: 1055 !important;
    }

    .modal.show .modal-content {
        pointer-events: auto !important;
        position: relative !important;
    }

    /* Deshabilitar efectos de focus que puedan causar parpadeo */
    .modal .form-control:focus,
    .modal .btn:focus,
    .modal input:focus,
    .modal select:focus,
    .modal textarea:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
        border-color: #80bdff !important;
        outline: 0 !important;
    }

    /* Estilos para tooltips */
    .tooltip {
        font-size: 0.875rem;
    }

    .tooltip-inner {
        background-color: #333;
        color: #fff;
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
    }

    /* CSS MÍNIMO PARA MODALES DEL GRID */
    .modal[id*="modalSituacionEconomica"],
    .modal[id*="modalEditarDocumentos"] {
        pointer-events: auto !important;
    }

    .modal[id*="modalSituacionEconomica"].show,
    .modal[id*="modalEditarDocumentos"].show {
        opacity: 1 !important;
        display: block !important;
    }
</style>

<!-- Scripts al final del documento -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fallback para Chart.js si no se carga desde el primer CDN
    if (typeof Chart === 'undefined') {
        console.log('Cargando Chart.js desde CDN alternativo...');
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js';
        script.onload = function() {
            console.log('Chart.js cargado desde CDN alternativo');
        };
        document.head.appendChild(script);
    }
</script>
<script>
    // Variables globales para los gráficos
    let chartEstados, chartDocumentos, chartMensual, chartSemanal;

    // Función para confirmar backup con SweetAlert
    function confirmarBackup() {
        Swal.fire({
            title: '¿Realizar Backup?',
            text: '¿Estás seguro de que quieres realizar un backup de la base de datos?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Sí, realizar backup',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar loading
                Swal.fire({
                    title: 'Procesando...',
                    text: 'Realizando backup de la base de datos',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Enviar formulario
                document.getElementById('backupForm').submit();
            }
        });
    }

    // Función para calcular totales
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

    // Función para inicializar gráficos
    function inicializarGraficos() {
        try {
            // Verificar que Chart.js esté disponible
            if (typeof Chart === 'undefined') {
                console.error('Chart.js no está cargado');
                return;
            }

            // Datos para los gráficos
            const datosEstados = @json($datosGraficos['estados_solicitudes']);
            const datosDocumentos = @json($datosGraficos['documentos']);
            const datosMensual = @json($datosGraficos['solicitudes_mensuales']);
            const datosSemanal = @json($datosGraficos['tendencia_semanal']);

            console.log('Datos de gráficos:', {
                estados: datosEstados,
                documentos: datosDocumentos,
                mensual: datosMensual,
                semanal: datosSemanal
            });

            // Gráfico de Estados (Dona)
            const ctxEstados = document.getElementById('chartEstados');
            if (ctxEstados) {
                chartEstados = new Chart(ctxEstados, {
                    type: 'doughnut',
                    data: {
                        labels: datosEstados.labels,
                        datasets: [{
                            data: datosEstados.data,
                            backgroundColor: datosEstados.colors,
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
                console.log('Gráfico de Estados creado');
            }

            // Gráfico de Documentos (Dona)
            const ctxDocumentos = document.getElementById('chartDocumentos');
            if (ctxDocumentos) {
                chartDocumentos = new Chart(ctxDocumentos, {
                    type: 'doughnut',
                    data: {
                        labels: datosDocumentos.labels,
                        datasets: [{
                            data: datosDocumentos.data,
                            backgroundColor: datosDocumentos.colors,
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
                console.log('Gráfico de Documentos creado');
            }

            // Gráfico Mensual (Línea)
            const ctxMensual = document.getElementById('chartMensual');
            if (ctxMensual) {
                chartMensual = new Chart(ctxMensual, {
                    type: 'line',
                    data: {
                        labels: datosMensual.labels,
                        datasets: [{
                            label: 'Solicitudes',
                            data: datosMensual.data,
                            borderColor: datosMensual.color,
                            backgroundColor: datosMensual.color + '20',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
                console.log('Gráfico Mensual creado');
            }

            // Gráfico Semanal (Barras)
            const ctxSemanal = document.getElementById('chartSemanal');
            if (ctxSemanal) {
                chartSemanal = new Chart(ctxSemanal, {
                    type: 'bar',
                    data: {
                        labels: datosSemanal.labels,
                        datasets: [{
                            label: 'Solicitudes',
                            data: datosSemanal.data,
                            backgroundColor: datosSemanal.color + '80',
                            borderColor: datosSemanal.color,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
                console.log('Gráfico Semanal creado');
            }
        } catch (error) {
            console.error('Error al inicializar gráficos:', error);
        }
    }

    // Script consolidado para manejar todos los eventos
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado, inicializando eventos...');

        // Calcular totales cuando se carga la página
        calcularTotales();

        // Calcular totales cuando cambia un input de ingresos o gastos
        $(document).on('input', '.ingresos, .gastos', function () {
            calcularTotales();
        });

        // Inicializar gráficos cuando se abre el modal
        const modalEstadisticas = document.getElementById('modalEstadisticas');
        if (modalEstadisticas) {
            modalEstadisticas.addEventListener('shown.bs.modal', function () {
                console.log('Modal abierto, inicializando gráficos...');

                // Destruir gráficos existentes si existen
                if (chartEstados) chartEstados.destroy();
                if (chartDocumentos) chartDocumentos.destroy();
                if (chartMensual) chartMensual.destroy();
                if (chartSemanal) chartSemanal.destroy();

                // Pequeño delay para asegurar que el modal esté completamente visible
                setTimeout(() => {
                    inicializarGraficos();
                }, 100);
            });
        } else {
            console.error('Modal modalEstadisticas no encontrado');
        }

        // SOLUCIÓN SIMPLE PARA MODALES DEL GRID - SIN INTERFERENCIAS
        const modalesGrid = document.querySelectorAll('.modal[id*="modalSituacionEconomica"], .modal[id*="modalEditarDocumentos"]');
        modalesGrid.forEach(modal => {
            modal.addEventListener('show.bs.modal', function (event) {
                // Solo cerrar otros modales del grid
                const otrosModalesGrid = document.querySelectorAll('.modal[id*="modalSituacionEconomica"].show, .modal[id*="modalEditarDocumentos"].show');
                otrosModalesGrid.forEach(modalAbierto => {
                    if (modalAbierto !== modal) {
                        const bsModal = bootstrap.Modal.getInstance(modalAbierto);
                        if (bsModal) {
                            bsModal.hide();
                        }
                    }
                });
            });
        });

        // Manejar el cierre de modales
        const botonesCerrar = document.querySelectorAll('[data-bs-dismiss="modal"]');
        botonesCerrar.forEach(boton => {
            boton.addEventListener('click', function() {
                const modal = this.closest('.modal');
                if (modal) {
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    if (bsModal) {
                        bsModal.hide();
                    }
                }
            });
        });

        // Prevenir múltiples envíos de formularios
        const formularios = document.querySelectorAll('form');
        formularios.forEach(formulario => {
            formulario.addEventListener('submit', function(e) {
                const botonSubmit = this.querySelector('button[type="submit"]');
                if (botonSubmit) {
                    botonSubmit.disabled = true;
                    botonSubmit.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
                }
            });
        });

        // Scripts eliminados para prevenir conflictos

        // Inicializar tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // SCRIPTS PROBLEMÁTICOS ELIMINADOS COMPLETAMENTE
    });
</script>
