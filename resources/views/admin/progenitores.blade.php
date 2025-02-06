@extends('layouts.admin')

@section('content')
    <div class="bg-dark-info pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <!-- Page header -->
                <div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-2 mb-lg-0">
                            <h3 class="mb-0  text-white">Bienvenido {{ ucfirst(Auth::user()->role) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row  -->
        <div class="row my-6">

            <!-- card  -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="card h-100 ">
                    <!-- card header  -->
                    <div class="d-flex justify-content-between align-items-center p-4">
                        <h4 class="mb-0">Progenitores</h4>

                        <div class="d-flex flex-wrap justify-content-end">

                            <!-- Botón Nuevo Progenitor -->
                            <button type="button" class="btn btn-success mb-2 mb-sm-0" data-bs-toggle="modal" data-bs-target="#createProgenitorModal">
                                <i class="fas fa-plus"></i> Nuevo Progenitor
                            </button>
                        </div>

                    </div>

                    <!-- Formulario de búsqueda -->
                    <form method="GET" action="{{ route('progenitores.index') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar Progenitor" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-primary">Buscar</button>
                        </div>
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any() || session('show_modal') == 'create')
                        <script>
                            window.onload = function () {
                                $('#createProgenitorModal').modal('show');
                            }
                        </script>
                    @endif

                    {{-- <a href="{{ route('progenitores.create') }}" class="btn btn-primary mb-3">Nuevo Progenitor</a>--}}

                    <!-- table  -->
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombres Completos</th>
                                    <th>Tipo Doc.</th>
                                    <th>Nro. Doc.</th>
                                    <th>Cod. Sianet</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($progenitores as $progenitor)
                                    <tr>
                                        <td>{{ $progenitor->nombres }} {{ $progenitor->apellidos }} </td>
                                        <td>{{ $progenitor->tipo_documento }}</td>
                                        <td>{{ $progenitor->dni }}</td>
                                        <td>{{ $progenitor->codigo_sianet }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning edit-progenitor" data-progenitor='{{ json_encode($progenitor) }}'>Editar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="flex items-center justify-between bg-white p-3 border-t dark:bg-gray-800">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                              Mostrando {{ $progenitores->firstItem() }} a {{ $progenitores->lastItem() }} de {{ $progenitores->total() }} registros
                            </p>

                            <nav class="flex space-x-1">
                              <!-- Paginación Anterior -->
                              @if ($progenitores->onFirstPage())
                                <span class="px-3 py-1 rounded-md text-gray-500 bg-gray-200 dark:bg-gray-700 dark:text-white cursor-not-allowed">
                                  « Anterior
                                </span>
                              @else
                                <a href="{{ $progenitores->previousPageUrl() }}" class="px-3 py-1 rounded-md text-gray-500 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:text-white">
                                  « Anterior
                                </a>
                              @endif

                              <!-- Páginas -->
                              @foreach ($progenitores->getUrlRange(1, $progenitores->lastPage()) as $page => $url)
                                @if ($page == $progenitores->currentPage())
                                  <span class="px-3 py-1 btn btn-primary">{{ $page }}</span>
                                @else
                                  <a href="{{ $url }}" class="px-3 py-1 rounded-md text-gray-500 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:text-white">{{ $page }}</a>
                                @endif
                              @endforeach

                              <!-- Paginación Siguiente -->
                              @if ($progenitores->hasMorePages())
                                <a href="{{ $progenitores->nextPageUrl() }}" class="px-3 py-1 rounded-md text-gray-500 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:text-white">
                                  Siguiente »
                                </a>
                              @else
                                <span class="px-3 py-1 rounded-md text-gray-500 bg-gray-200 dark:bg-gray-700 dark:text-white cursor-not-allowed">
                                  Siguiente »
                                </span>
                              @endif
                            </nav>
                        </div>
                    </div>

                    <!-- Modal Insertar Progenitor -->
                    <div class="modal fade" id="createProgenitorModal" tabindex="-1" aria-labelledby="createProgenitorModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createProgenitorModalLabel">Registrar Progenitor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <form action="{{ route('progenitores.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <!-- Tabs Navigation -->
                                        <ul class="nav nav-tabs" id="progenitorTabs" role="tablist">
                                          <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="datos-personales-tabedit" data-bs-toggle="tab" data-bs-target="#datos-personalesedit" type="button" role="tab" aria-controls="datos-personalesedit" aria-selected="true">Datos Personales</button>
                                          </li>
                                          <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="info-familiar-tabedit" data-bs-toggle="tab" data-bs-target="#info-familiaredit" type="button" role="tab" aria-controls="info-familiaredit" aria-selected="false">Información Familiar</button>
                                          </li>
                                          <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="info-laboral-tabedit" data-bs-toggle="tab" data-bs-target="#info-laboraledit" type="button" role="tab" aria-controls="info-laboraledit" aria-selected="false">Información Laboral y Económica</button>
                                          </li>
                                          <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="datos-vivienda-tabedit" data-bs-toggle="tab" data-bs-target="#datos-viviendaedit" type="button" role="tab" aria-controls="datos-viviendaedit" aria-selected="false">Datos de Vivienda</button>
                                          </li>
                                        </ul>

                                        <!-- Tabs Content -->
                                        <div class="tab-content mt-3" id="progenitorTabsContent">
                                          <!-- Datos Personales -->
                                          <div class="tab-pane fade show active" id="datos-personalesedit" role="tabpanel" aria-labelledby="datos-personales-tabedit">

                                            <div class="mb-3">
                                                <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                                                <select class="form-control text-uppercase" id="tipo_documento" name="tipo_documento" value="{{ old('tipo_documento') }}" required onchange="setEditDocumentoLength()">
                                                    <option value="" disabled>SELECCIONE UN TIPO DE DOCUMENTO</option>
                                                    <option value="DNI" data-length="8">DNI (8 CARACTERES)</option>
                                                    <option value="CARNET_EXTRANJERIA" data-length="9">CARNET DE EXTRANJERÍA (9 CARACTERES)</option>
                                                    <option value="PASAPORTE" data-length="12">PASAPORTE (12 CARACTERES)</option>
                                                    <option value="RUC" data-length="11">RUC (11 CARACTERES)</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="dni" class="form-label">DNI</label>
                                                <input type="text" class="form-control" id="dni" name="dni"  value="{{ old('dni') }}" required>
                                              </div>
                                            <div class="mb-3">
                                              <label for="nombres" class="form-label">Nombres</label>
                                              <input type="text" class="form-control" id="nombres" name="nombres"  value="{{ old('nombres') }}" required>
                                            </div>
                                            <div class="mb-3">
                                              <label for="apellidos" class="form-label">Apellidos</label>
                                              <input type="text" class="form-control" id="apellidos" name="apellidos"  value="{{ old('apellidos') }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                                                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" value="{{ old('correo_electronico') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="codigo_sianet" class="form-label">Código Sianet</label>
                                                <input type="text" class="form-control" id="codigo_sianet" name="codigo_sianet"  value="{{ old('codigo_sianet') }}">
                                            </div>
                                          </div>

                                          <!-- Información Familiar -->
                                          <div class="tab-pane fade" id="info-familiaredit" role="tabpanel" aria-labelledby="info-familiar-tabedit">
                                            <div class="mb-3">
                                              <label for="numero_hijos" class="form-label">Número de Hijos</label>
                                              <input type="number" class="form-control" id="numero_hijos" name="numero_hijos"  value="{{ old('numero_hijos') }}">
                                            </div>
                                            <div class="mb-3">
                                              <label for="hijos_matriculados" class="form-label">Hijos Matriculados</label>
                                              <input type="number" class="form-control" id="hijos_matriculados" name="hijos_matriculados" value="{{ old('hijos_matriculados') }}">
                                            </div>
                                          </div>

                                          <!-- Información Laboral y Económica -->
                                          <div class="tab-pane fade" id="info-laboraledit" role="tabpanel" aria-labelledby="info-laboral-tabedit">
                                            <div class="mb-3">
                                                <label for="tiempo_desempleo" class="form-label">Tiempo Desempleo</label>
                                                <input type="number" class="form-control" id="tiempo_desempleo" name="tiempo_desempleo" value="{{ old('tiempo_desempleo') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="sueldo_fijo" class="form-label">Sueldo Fijo</label>
                                                <input type="number" class="form-control" id="sueldo_fijo" name="sueldo_fijo" value="{{ old('sueldo_fijo') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="sueldo_variable" class="form-label">Sueldo Variable</label>
                                                <input type="number" class="form-control" id="sueldo_variable" name="sueldo_variable" value="{{ old('sueldo_variable') }}">
                                            </div>
                                            <div class="mb-3">
                                              <label for="cargo" class="form-label">Cargo</label>
                                              <input type="text" class="form-control" id="cargo" name="cargo" value="{{ old('cargo') }}">
                                            </div>
                                            <div class="mb-3">
                                              <label for="lugar_trabajo" class="form-label">Lugar de Trabajo</label>
                                              <input type="text" class="form-control" id="lugar_trabajo" name="lugar_trabajo" value="{{ old('lugar_trabajo') }}">
                                            </div>
                                            <div class="mb-3">
                                              <label for="anio_inicio_laboral" class="form-label">Año de Inicio Laboral</label>
                                              <input type="number" class="form-control" id="anio_inicio_laboral" name="anio_inicio_laboral" min="1900" max="{{ date('Y') }}"  value="{{ old('anio_inicio_laboral') }}">
                                            </div>
                                            <div class="mb-3">
                                              <label for="ingresos_mensuales" class="form-label">Ingresos Mensuales</label>
                                              <input type="number" class="form-control" id="ingresos_mensuales" name="ingresos_mensuales" step="0.01"  value="{{ old('ingresos_mensuales') }}">
                                            </div>
                                            <div class="mb-3">
                                              <label for="recibe_bonos" class="form-label">¿Recibe Bonos?</label>
                                              <select class="form-select" id="recibe_bonos" name="recibe_bonos"  value="{{ old('recibe_bonos') }}">
                                                <option value="1">Sí</option>
                                                <option value="0">No</option>
                                              </select>
                                            </div>
                                            <div class="mb-3">
                                              <label for="monto_bonos" class="form-label">Monto de Bonos</label>
                                              <select class="form-select" id="monto_bonos" name="monto_bonos" value="{{ old('monto_bonos') }}">
                                                <option value="5000-10000">5000-10000</option>
                                                <option value="10000-15000">10000-15000</option>
                                                <option value="15000-mas">15000 o más</option>
                                              </select>
                                            </div>
                                            <div class="mb-3">
                                              <label for="recibe_utilidades" class="form-label">¿Recibe Utilidades?</label>
                                              <select class="form-select" id="recibe_utilidades" name="recibe_utilidades" value="{{ old('recibe_utilidades') }}">
                                                <option value="1">Sí</option>
                                                <option value="0">No</option>
                                              </select>
                                            </div>
                                            <div class="mb-3">
                                              <label for="monto_utilidades" class="form-label">Monto de Utilidades</label>
                                              <select class="form-select" id="monto_utilidades" name="monto_utilidades" value="{{ old('monto_utilidades') }}">
                                                <option value="5000-10000">5000-10000</option>
                                                <option value="10000-15000">10000-15000</option>
                                                <option value="15000-mas">15000 o más</option>
                                              </select>
                                            </div>
                                            <div class="mb-3">
                                              <label for="titular_empresa" class="form-label">¿Es Titular de Empresa?</label>
                                              <select class="form-select" id="titular_empresa" name="titular_empresa" value="{{ old('titular_empresa') }}">
                                                <option value="1">Sí</option>
                                                <option value="0">No</option>
                                              </select>
                                            </div>
                                            <div class="mb-3">
                                              <label for="porcentaje_acciones" class="form-label">Porcentaje de Acciones</label>
                                              <input type="number" class="form-control" id="porcentaje_acciones" name="porcentaje_acciones" step="0.01" value="{{ old('porcentaje_acciones') }}">
                                            </div>
                                            <div class="mb-3">
                                              <label for="razon_social" class="form-label">Razón Social</label>
                                              <input type="text" class="form-control" id="razon_social" name="razon_social" value="{{ old('razon_social') }}">
                                            </div>
                                            <div class="mb-3">
                                              <label for="numero_ruc" class="form-label">Número de RUC</label>
                                              <input type="text" class="form-control" id="numero_ruc" name="numero_ruc" value="{{ old('numero_ruc') }}">
                                            </div>
                                          </div>

                                          <!-- Datos de Vivienda -->
                                          <div class="tab-pane fade" id="datos-viviendaedit" role="tabpanel" aria-labelledby="datos-vivienda-tabedit">
                                            <div class="mb-3">
                                                <label for="vivienda_tipo" class="form-label">Tipo de Vivienda</label>
                                                <select class="form-control" id="vivienda_tipo" name="vivienda_tipo">
                                                    <option value="propia">Propia</option>
                                                    <option value="alquilada">Alquilada</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="credito_hipotecario" class="form-label">¿Tiene Crédito Hipotecario?</label>
                                                <select class="form-control" id="credito_hipotecario" name="credito_hipotecario">
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                              <label for="direccion_vivienda" class="form-label">Dirección de Vivienda</label>
                                              <textarea class="form-control" id="direccion_vivienda" name="direccion_vivienda" value="{{ old('direccion_vivienda') }}"></textarea>
                                            </div>
                                            <div class="mb-3">
                                              <label for="m2_vivienda" class="form-label">Metros Cuadrados de la Vivienda</label>
                                              <input type="number" class="form-control" id="m2_vivienda" name="m2_vivienda" step="0.01" value="{{ old('m2_vivienda') }}">
                                            </div>
                                            <div class="mb-3">
                                              <label for="cantidad_inmuebles" class="form-label">Cantidad de Inmuebles</label>
                                              <input type="number" class="form-control" id="cantidad_inmuebles" name="cantidad_inmuebles" value="{{ old('cantidad_inmuebles') }}">
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Registrar</button>
                                      </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal <div class="modal fade" id="progenitorModal" tabindex="-1" aria-labelledby="progenitorModalLabel" aria-hidden="true"> -->
                    <div class="modal fade" id="progenitorModal" tabindex="-1" aria-labelledby="progenitorModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="progenitorModalLabel"> Editar Progenitor</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form id="progenitorForm" action="{{ route('progenitores.storeOrUpdate') }}" method="POST">
                                  @csrf
                                  <div class="modal-body">
                                    <!-- Tabs Navigation -->
                                    <ul class="nav nav-tabs" id="progenitorTabs" role="tablist">
                                      <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="datos-personales-tab" data-bs-toggle="tab" data-bs-target="#datos-personales" type="button" role="tab" aria-controls="datos-personales" aria-selected="true">Datos Personales</button>
                                      </li>
                                      <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="info-familiar-tab" data-bs-toggle="tab" data-bs-target="#info-familiar" type="button" role="tab" aria-controls="info-familiar" aria-selected="false">Información Familiar</button>
                                      </li>
                                      <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="info-laboral-tab" data-bs-toggle="tab" data-bs-target="#info-laboral" type="button" role="tab" aria-controls="info-laboral" aria-selected="false">Información Laboral y Económica</button>
                                      </li>
                                      <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="datos-vivienda-tab" data-bs-toggle="tab" data-bs-target="#datos-vivienda" type="button" role="tab" aria-controls="datos-vivienda" aria-selected="false">Datos de Vivienda</button>
                                      </li>
                                    </ul>

                                    <!-- Tabs Content -->
                                    <div class="tab-content mt-3" id="progenitorTabsContent">
                                      <!-- Datos Personales -->
                                      <input type="hidden" id="progenitorId" name="id">
                                      <div class="tab-pane fade show active" id="datos-personales" role="tabpanel" aria-labelledby="datos-personales-tab">
                                        <div class="mb-3">
                                            <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                                            <select class="form-control text-uppercase" id="tipo_documento" name="tipo_documento" required onchange="setEditDocumentoLength()">
                                                <option value="" disabled>SELECCIONE UN TIPO DE DOCUMENTO</option>
                                                <option value="DNI" data-length="8">DNI (8 CARACTERES)</option>
                                                <option value="CARNET_EXTRANJERIA" data-length="9">CARNET DE EXTRANJERÍA (9 CARACTERES)</option>
                                                <option value="PASAPORTE" data-length="12">PASAPORTE (12 CARACTERES)</option>
                                                <option value="RUC" data-length="11">RUC (11 CARACTERES)</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="dni" class="form-label">DNI</label>
                                            <input type="text" class="form-control" id="dni" name="dni" required>
                                          </div>
                                        <div class="mb-3">
                                          <label for="nombres" class="form-label">Nombres</label>
                                          <input type="text" class="form-control" id="nombres" name="nombres" required>
                                        </div>
                                        <div class="mb-3">
                                          <label for="apellidos" class="form-label">Apellidos</label>
                                          <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                                            <input type="email" class="form-control" id="correo_electronico" name="correo_electronico">
                                        </div>
                                        <div class="mb-3">
                                            <label for="codigo_sianet" class="form-label">Código Sianet</label>
                                            <input type="text" class="form-control" id="codigo_sianet" name="codigo_sianet">
                                        </div>
                                      </div>

                                      <!-- Información Familiar -->
                                      <div class="tab-pane fade" id="info-familiar" role="tabpanel" aria-labelledby="info-familiar-tab">
                                        <div class="mb-3">
                                          <label for="numero_hijos" class="form-label">Número de Hijos</label>
                                          <input type="number" class="form-control" id="numero_hijos" name="numero_hijos">
                                        </div>
                                        <div class="mb-3">
                                          <label for="hijos_matriculados" class="form-label">Hijos Matriculados</label>
                                          <input type="number" class="form-control" id="hijos_matriculados" name="hijos_matriculados">
                                        </div>
                                      </div>

                                      <!-- Información Laboral y Económica -->
                                      <div class="tab-pane fade" id="info-laboral" role="tabpanel" aria-labelledby="info-laboral-tab">
                                        <div class="mb-3">
                                            <label for="tiempo_desempleo" class="form-label">Tiempo Desempleo</label>
                                            <input type="number" class="form-control" id="tiempo_desempleo" name="tiempo_desempleo">
                                        </div>
                                        <div class="mb-3">
                                            <label for="sueldo_fijo" class="form-label">Sueldo Fijo</label>
                                            <input type="number" class="form-control" id="sueldo_fijo" name="sueldo_fijo">
                                        </div>
                                        <div class="mb-3">
                                            <label for="sueldo_variable" class="form-label">Sueldo Variable</label>
                                            <input type="number" class="form-control" id="sueldo_variable" name="sueldo_variable">
                                        </div>
                                        <div class="mb-3">
                                          <label for="cargo" class="form-label">Cargo</label>
                                          <input type="text" class="form-control" id="cargo" name="cargo">
                                        </div>
                                        <div class="mb-3">
                                          <label for="lugar_trabajo" class="form-label">Lugar de Trabajo</label>
                                          <input type="text" class="form-control" id="lugar_trabajo" name="lugar_trabajo">
                                        </div>
                                        <div class="mb-3">
                                          <label for="anio_inicio_laboral" class="form-label">Año de Inicio Laboral</label>
                                          <input type="number" class="form-control" id="anio_inicio_laboral" name="anio_inicio_laboral" min="1900" max="{{ date('Y') }}">
                                        </div>
                                        <div class="mb-3">
                                          <label for="ingresos_mensuales" class="form-label">Ingresos Mensuales</label>
                                          <input type="number" class="form-control" id="ingresos_mensuales" name="ingresos_mensuales" step="0.01">
                                        </div>
                                        <div class="mb-3">
                                          <label for="recibe_bonos" class="form-label">¿Recibe Bonos?</label>
                                          <select class="form-select" id="recibe_bonos" name="recibe_bonos">
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                          </select>
                                        </div>
                                        <div class="mb-3">
                                          <label for="monto_bonos" class="form-label">Monto de Bonos</label>
                                          <select class="form-select" id="monto_bonos" name="monto_bonos">
                                            <option value="5000-10000">5000-10000</option>
                                            <option value="10000-15000">10000-15000</option>
                                            <option value="15000-mas">15000 o más</option>
                                          </select>
                                        </div>
                                        <div class="mb-3">
                                          <label for="recibe_utilidades" class="form-label">¿Recibe Utilidades?</label>
                                          <select class="form-select" id="recibe_utilidades" name="recibe_utilidades">
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                          </select>
                                        </div>
                                        <div class="mb-3">
                                          <label for="monto_utilidades" class="form-label">Monto de Utilidades</label>
                                          <select class="form-select" id="monto_utilidades" name="monto_utilidades">
                                            <option value="5000-10000">5000-10000</option>
                                            <option value="10000-15000">10000-15000</option>
                                            <option value="15000-mas">15000 o más</option>
                                          </select>
                                        </div>
                                        <div class="mb-3">
                                          <label for="titular_empresa" class="form-label">¿Es Titular de Empresa?</label>
                                          <select class="form-select" id="titular_empresa" name="titular_empresa">
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                          </select>
                                        </div>
                                        <div class="mb-3">
                                          <label for="porcentaje_acciones" class="form-label">Porcentaje de Acciones</label>
                                          <input type="number" class="form-control" id="porcentaje_acciones" name="porcentaje_acciones" step="0.01">
                                        </div>
                                        <div class="mb-3">
                                          <label for="razon_social" class="form-label">Razón Social</label>
                                          <input type="text" class="form-control" id="razon_social" name="razon_social">
                                        </div>
                                        <div class="mb-3">
                                          <label for="numero_ruc" class="form-label">Número de RUC</label>
                                          <input type="text" class="form-control" id="numero_ruc" name="numero_ruc">
                                        </div>
                                      </div>

                                      <!-- Datos de Vivienda -->
                                      <div class="tab-pane fade" id="datos-vivienda" role="tabpanel" aria-labelledby="datos-vivienda-tab">
                                        <div class="mb-3">
                                            <label for="vivienda_tipo" class="form-label">Tipo de Vivienda</label>
                                            <select class="form-control" id="vivienda_tipo" name="vivienda_tipo">
                                                <option value="propia">Propia</option>
                                                <option value="alquilada">Alquilada</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="credito_hipotecario" class="form-label">¿Tiene Crédito Hipotecario?</label>
                                            <select class="form-control" id="credito_hipotecario" name="credito_hipotecario">
                                                <option value="1">Sí</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                          <label for="direccion_vivienda" class="form-label">Dirección de Vivienda</label>
                                          <textarea class="form-control" id="direccion_vivienda" name="direccion_vivienda"></textarea>
                                        </div>
                                        <div class="mb-3">
                                          <label for="m2_vivienda" class="form-label">Metros Cuadrados de la Vivienda</label>
                                          <input type="number" class="form-control" id="m2_vivienda" name="m2_vivienda" step="0.01">
                                        </div>
                                        <div class="mb-3">
                                          <label for="cantidad_inmuebles" class="form-label">Cantidad de Inmuebles</label>
                                          <input type="number" class="form-control" id="cantidad_inmuebles" name="cantidad_inmuebles">
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>

                    {{-- <div class="modal fade" id="progenitorModal" tabindex="-1" aria-labelledby="progenitorModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="progenitorModalLabel">Gestión de Progenitores</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form id="progenitorForm" action="{{ route('progenitores.storeOrUpdate') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" id="progenitorTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="datos-personales-tab" data-bs-toggle="tab" data-bs-target="#datos-personales" type="button" role="tab" aria-controls="datos-personales" aria-selected="true">Datos Personales</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="datos-laborales-tab" data-bs-toggle="tab" data-bs-target="#datos-laborales" type="button" role="tab" aria-controls="datos-laborales" aria-selected="false">Datos Laborales</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="datos-vivienda-tab" data-bs-toggle="tab" data-bs-target="#datos-vivienda" type="button" role="tab" aria-controls="datos-vivienda" aria-selected="false">Datos de Vivienda</button>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content" id="progenitorTabsContent">
                                        <!-- Datos Personales -->
                                        <div class="tab-pane fade show active" id="datos-personales" role="tabpanel" aria-labelledby="datos-personales-tab">

                                                <input type="hidden" id="progenitorId" name="id">
                                                <div class="mb-3">
                                                    <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                                                    <select class="form-control text-uppercase" id="tipo_documento" name="tipo_documento" required onchange="setEditDocumentoLength()">
                                                        <option value="" disabled>SELECCIONE UN TIPO DE DOCUMENTO</option>
                                                        <option value="DNI" data-length="8">DNI (8 CARACTERES)</option>
                                                        <option value="CARNET_EXTRANJERIA" data-length="9">CARNET DE EXTRANJERÍA (9 CARACTERES)</option>
                                                        <option value="PASAPORTE" data-length="12">PASAPORTE (12 CARACTERES)</option>
                                                        <option value="RUC" data-length="11">RUC (11 CARACTERES)</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dni" class="form-label">DNI</label>
                                                    <input type="text" class="form-control" id="dni" name="dni" required maxlength="8">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nombres" class="form-label">Nombres</label>
                                                    <input type="text" class="form-control" id="nombres" name="nombres" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="apellidos" class="form-label">Apellidos</label>
                                                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                                                    <input type="email" class="form-control" id="correo_electronico" name="correo_electronico">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="codigo_sianet" class="form-label">Código Sianet</label>
                                                    <input type="text" class="form-control" id="codigo_sianet" name="codigo_sianet">
                                                </div>

                                        </div>

                                        <!-- Datos Laborales -->
                                        <div class="tab-pane fade" id="datos-laborales" role="tabpanel" aria-labelledby="datos-laborales-tab">
                                            <div class="mb-3">
                                                <label for="formacion_academica" class="form-label">Formación Académica</label>
                                                <select class="form-control" id="formacion_academica" name="formacion_academica">
                                                    <option value="tecnica">Técnica</option>
                                                    <option value="universitaria">Universitaria</option>
                                                    <option value="bachillerato">Bachillerato</option>
                                                    <option value="titulado">Titulado</option>
                                                    <option value="maestria">Maestría</option>
                                                    <option value="doctorado">Doctorado</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="trabaja" class="form-label">¿Trabaja?</label>
                                                <select class="form-control" id="trabaja" name="trabaja">
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <!-- Agrega más campos laborales aquí -->
                                        </div>

                                        <!-- Datos de Vivienda -->
                                        <div class="tab-pane fade" id="datos-vivienda" role="tabpanel" aria-labelledby="datos-vivienda-tab">
                                            <div class="mb-3">
                                                <label for="vivienda_tipo" class="form-label">Tipo de Vivienda</label>
                                                <select class="form-control" id="vivienda_tipo" name="vivienda_tipo">
                                                    <option value="propia">Propia</option>
                                                    <option value="alquilada">Alquilada</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="credito_hipotecario" class="form-label">¿Tiene Crédito Hipotecario?</label>
                                                <select class="form-control" id="credito_hipotecario" name="credito_hipotecario">
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <!-- Agrega más campos de vivienda aquí -->
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.getElementById('progenitorModal'));

        // Función para abrir el modal en modo edición
        function openEditModal(progenitor) {
            /*document.getElementById('progenitorId').value = progenitor.id;
            document.getElementById('tipo_documento').value = progenitor.tipo_documento;
            document.getElementById('dni').value = progenitor.dni;
            document.getElementById('nombres').value = progenitor.nombres;
            document.getElementById('apellidos').value = progenitor.apellidos;
            document.getElementById('correo_electronico').value = progenitor.correo_electronico;
            document.getElementById('codigo_sianet').value = progenitor.codigo_sianet;
            document.getElementById('numero_hijos').value = progenitor.numero_hijos;
            document.getElementById('hijos_matriculados').value = progenitor.hijos_matriculados;
            document.getElementById('tiempo_desempleo').value = progenitor.tiempo_desempleo;
            document.getElementById('sueldo_fijo').checked = progenitor.sueldo_fijo;
            document.getElementById('sueldo_variable').checked = progenitor.sueldo_variable;
            document.getElementById('cargo').value = progenitor.cargo;
            document.getElementById('anio_inicio_laboral').value = progenitor.anio_inicio_laboral
            document.getElementById('lugar_trabajo').value = progenitor.lugar_trabajo;
            document.getElementById('ingresos_mensuales').value = progenitor.ingresos_mensuales;
            document.getElementById('recibe_bonos').value = progenitor.recibe_bonos;
            document.getElementById('monto_bonos').value = progenitor.monto_bonos;
            document.getElementById('recibe_utilidades').value = progenitor.recibe_utilidades;
            document.getElementById('monto_utilidades').value = progenitor.monto_utilidades;
            document.getElementById('titular_empresa').value = progenitor.titular_empresa;
            document.getElementById('porcentaje_acciones').value = progenitor.porcentaje_acciones;
            document.getElementById('razon_social').value = progenitor.razon_social;
            document.getElementById('numero_ruc').value = progenitor.numero_ruc;
            document.getElementById('direccion_vivienda').value = progenitor.direccion_vivienda;
            document.getElementById('m2_vivienda').value = progenitor.m2_vivienda;
            document.getElementById('cantidad_inmuebles').value = progenitor.cantidad_inmuebles;*/

            //progenitorForm
            document.getElementById('progenitorForm').querySelector('#progenitorId').value = progenitor.id;
            document.getElementById('progenitorForm').querySelector('#tipo_documento').value = progenitor.tipo_documento;
            document.getElementById('progenitorForm').querySelector('#dni').value = progenitor.dni;
            document.getElementById('progenitorForm').querySelector('#nombres').value = progenitor.nombres;
            document.getElementById('progenitorForm').querySelector('#apellidos').value = progenitor.apellidos;
            document.getElementById('progenitorForm').querySelector('#correo_electronico').value = progenitor.correo_electronico;
            document.getElementById('progenitorForm').querySelector('#codigo_sianet').value = progenitor.codigo_sianet;
            document.getElementById('progenitorForm').querySelector('#numero_hijos').value = progenitor.numero_hijos;
            document.getElementById('progenitorForm').querySelector('#hijos_matriculados').value = progenitor.hijos_matriculados;
            document.getElementById('progenitorForm').querySelector('#tiempo_desempleo').value = progenitor.tiempo_desempleo;
            document.getElementById('progenitorForm').querySelector('#sueldo_fijo').checked = progenitor.sueldo_fijo;
            document.getElementById('progenitorForm').querySelector('#sueldo_variable').checked = progenitor.sueldo_variable;
            document.getElementById('progenitorForm').querySelector('#cargo').value = progenitor.cargo;
            document.getElementById('progenitorForm').querySelector('#anio_inicio_laboral').value = progenitor.anio_inicio_laboral;
            document.getElementById('progenitorForm').querySelector('#lugar_trabajo').value = progenitor.lugar_trabajo;
            document.getElementById('progenitorForm').querySelector('#ingresos_mensuales').value = progenitor.ingresos_mensuales;
            document.getElementById('progenitorForm').querySelector('#recibe_bonos').value = progenitor.recibe_bonos;
            document.getElementById('progenitorForm').querySelector('#monto_bonos').value = progenitor.monto_bonos;
            document.getElementById('progenitorForm').querySelector('#recibe_utilidades').value = progenitor.recibe_utilidades;
            document.getElementById('progenitorForm').querySelector('#monto_utilidades').value = progenitor.monto_utilidades;
            document.getElementById('progenitorForm').querySelector('#titular_empresa').value = progenitor.titular_empresa;
            document.getElementById('progenitorForm').querySelector('#porcentaje_acciones').value = progenitor.porcentaje_acciones;
            document.getElementById('progenitorForm').querySelector('#razon_social').value = progenitor.razon_social;
            document.getElementById('progenitorForm').querySelector('#numero_ruc').value = progenitor.numero_ruc;
            document.getElementById('progenitorForm').querySelector('#vivienda_tipo').value = progenitor.vivienda_tipo;
            document.getElementById('progenitorForm').querySelector('#credito_hipotecario').value = progenitor.credito_hipotecario;
            document.getElementById('progenitorForm').querySelector('#direccion_vivienda').value = progenitor.direccion_vivienda;
            document.getElementById('progenitorForm').querySelector('#m2_vivienda').value = progenitor.m2_vivienda;
            document.getElementById('progenitorForm').querySelector('#cantidad_inmuebles').value = progenitor.cantidad_inmuebles;
            modal.show();
        }

        // Función para abrir el modal en modo inserción
        function openAddModal() {
            form.reset();
            modal.show();
        }


        // Ejemplo de cómo abrir el modal en modo edición desde un botón en la tabla
        document.querySelectorAll('.edit-progenitor').forEach(button => {
            button.addEventListener('click', function() {
                const progenitor = JSON.parse(this.getAttribute('data-progenitor'));
                openEditModal(progenitor);
            });
        });

        // Ejemplo de cómo abrir el modal en modo inserción desde un botón
        /*
        document.getElementById('addProgenitor').addEventListener('click', function() {
            openAddModal();
        });
        */

        function setEditDocumentoLength() {
            const tipoDocumento = document.getElementById('tipo_documento');
            const nroDocumento = document.getElementById('dni');
            const selectedOption = tipoDocumento.options[tipoDocumento.selectedIndex];
            const maxLength = selectedOption.getAttribute('data-length');
            nroDocumento.value = '';
            nroDocumento.setAttribute('maxlength', maxLength);
        }


        const tabTriggerList = [].slice.call(document.querySelectorAll('#progenitorTabs button'));
        tabTriggerList.forEach(tabTriggerEl => {
            const tab = new bootstrap.Tab(tabTriggerEl);
            tabTriggerEl.addEventListener('click', function (event) {
                event.preventDefault();
                tab.show();
            });
        });
    });
</script>

