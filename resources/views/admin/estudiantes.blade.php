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
                <div class="card h-100">
                    <!-- card header  -->
                    <div class="card-header bg-white py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Estudiantes</h4>

                            <div class="d-flex flex-wrap justify-content-end">
                                <!-- Formulario de importar Excel -->
                                @if(auth()->user()->id == 1)
                                    <form action="/importar-excel" method="POST" enctype="multipart/form-data" class="me-2 mb-2 mb-sm-0">
                                        @csrf
                                        <div class="input-group">
                                            <input type="file" name="file" class="form-control" required>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-file-import"></i> Importar Excel
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Botón de Limpiar Alumnos -->
                                    <form action="{{ route('progenitores.transfer') }}" method="POST" class="me-2 mb-2 mb-sm-0">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-broom"></i> Limpiar Alumnos
                                        </button>
                                    </form>
                                @endif

                                <!-- Botón Nuevo Alumno -->
                                <button type="button" class="btn btn-success mb-2 mb-sm-0" data-bs-toggle="modal" data-bs-target="#nuevoEstudianteModal">
                                    <i class="fas fa-plus"></i> Nuevo Alumno
                                </button>
                            </div>

                        </div>

                        <!-- Mensajes de éxito o error -->
                        @if(session('success'))
                            <p class="text-primary mt-3">{{ session('success') }}</p>
                        @endif

                        @if(session('error'))
                            <p class="text-danger mt-3">{{ session('error') }}</p>
                        @endif
                    </div>
                    <!-- table  -->
                    <div class="table-responsive">
                        <form method="GET" action="{{ route('estudiantes.index') }}" class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre, documento, o código Sianet">
                                <button class="btn btn-outline-primary" type="submit">Buscar</button>
                            </div>
                        </form>

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
                                @forelse($estudiantes as $estudiante)
                                    <tr data-bs-toggle="collapse" data-bs-target="#estudiante-{{ $estudiante->id }}" aria-expanded="false" aria-controls="estudiante-{{ $estudiante->id }}">
                                        <td>{{ $estudiante->nombres }} {{ $estudiante->apepaterno }} {{ $estudiante->apematerno }}</td>
                                        <td>{{ $estudiante->tipo_documento }}</td>
                                        <td>{{ $estudiante->nro_documento }}</td>
                                        <td>{{ $estudiante->codigo_sianet }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm btn-edit"
                                                data-id="{{ $estudiante->id }}"
                                                data-nombres="{{ $estudiante->nombres }}"
                                                data-apepaterno="{{ $estudiante->apepaterno }}"
                                                data-apematerno="{{ $estudiante->apematerno }}"
                                                data-tipo_documento="{{ $estudiante->tipo_documento }}"
                                                data-nro_documento="{{ $estudiante->nro_documento }}"
                                                data-codigo_sianet="{{ $estudiante->codigo_sianet }}">
                                                <i class="fas fa-pencil"></i> Editar
                                            </button>

                                            <form action="{{ route('estudiantes.destroy', $estudiante->id) }}" method="POST" class="d-inline" id="delete-form-{{ $estudiante->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $estudiante->id }})">
                                                    <i class="fas fa-trash-alt"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Fila expandida con más detalles -->
                                    <tr id="estudiante-{{ $estudiante->id }}" class="collapse">
                                        <td colspan="5">
                                            <ul>
                                                <li><strong>Nombre Completo:</strong> {{ $estudiante->nombres }} {{ $estudiante->apepaterno }} {{ $estudiante->apematerno }}</li>
                                                <li><strong>Tipo de Documento:</strong> {{ $estudiante->tipo_documento }}</li>
                                                <li><strong>Número de Documento:</strong> {{ $estudiante->nro_documento }}</li>
                                                <li><strong>Código Sianet:</strong> {{ $estudiante->codigo_sianet }}</li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No se encontraron registros.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <script>
                            function confirmDelete(estudianteId) {
                                Swal.fire({
                                    title: '¿Estás seguro?',
                                    text: "¡Esta acción no se puede deshacer!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Sí, eliminar',
                                    cancelButtonText: 'Cancelar',
                                    reverseButtons: true
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Si el usuario confirma la eliminación, se envía el formulario
                                        document.getElementById('delete-form-' + estudianteId).submit();
                                    }
                                });
                            }
                        </script>

                        <div class="flex items-center justify-between bg-white p-3 border-t dark:bg-gray-800">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                              Mostrando {{ $estudiantes->firstItem() }} a {{ $estudiantes->lastItem() }} de {{ $estudiantes->total() }} registros
                            </p>

                            <nav class="flex space-x-1">
                              <!-- Paginación Anterior -->
                              @if ($estudiantes->onFirstPage())
                                <span class="px-3 py-1 rounded-md text-gray-500 bg-gray-200 dark:bg-gray-700 dark:text-white cursor-not-allowed">
                                  « Anterior
                                </span>
                              @else
                                <a href="{{ $estudiantes->previousPageUrl() }}" class="px-3 py-1 rounded-md text-gray-500 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:text-white">
                                  « Anterior
                                </a>
                              @endif

                              <!-- Páginas -->
                              @foreach ($estudiantes->getUrlRange(1, $estudiantes->lastPage()) as $page => $url)
                                @if ($page == $estudiantes->currentPage())
                                  <span class="px-3 py-1 btn btn-primary">{{ $page }}</span>
                                @else
                                  <a href="{{ $url }}" class="px-3 py-1 rounded-md text-gray-500 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:text-white">{{ $page }}</a>
                                @endif
                              @endforeach

                              <!-- Paginación Siguiente -->
                              @if ($estudiantes->hasMorePages())
                                <a href="{{ $estudiantes->nextPageUrl() }}" class="px-3 py-1 rounded-md text-gray-500 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:text-white">
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


                    <!-- Modal para Editar Estudiante -->
                    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="editStudentForm" action="#" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editStudentModalLabel">Editar Estudiante</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="edit_id" name="id">

                                        <div class="mb-3">
                                            <label for="edit_tipo_documento" class="form-label text-uppercase">TIPO DE DOCUMENTO</label>
                                            <select class="form-control text-uppercase" id="edit_tipo_documento" name="tipo_documento" required onchange="setEditDocumentoLength()">
                                                <option value="" disabled>SELECCIONE UN TIPO DE DOCUMENTO</option>
                                                <option value="DNI" data-length="8">DNI (8 CARACTERES)</option>
                                                <option value="CARNET_EXTRANJERIA" data-length="9">CARNET DE EXTRANJERÍA (9 CARACTERES)</option>
                                                <option value="PASAPORTE" data-length="12">PASAPORTE (12 CARACTERES)</option>
                                                <option value="RUC" data-length="11">RUC (11 CARACTERES)</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_nro_documento" class="form-label text-uppercase">NÚMERO DE DOCUMENTO</label>
                                            <input type="text" class="form-control text-uppercase" id="edit_nro_documento" name="nro_documento" required maxlength="8">
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_apepaterno" class="form-label text-uppercase">APELLIDO PATERNO</label>
                                            <input type="text" class="form-control text-uppercase" id="edit_apepaterno" name="apepaterno" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_apematerno" class="form-label text-uppercase">APELLIDO MATERNO</label>
                                            <input type="text" class="form-control text-uppercase" id="edit_apematerno" name="apematerno" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_nombres" class="form-label text-uppercase">NOMBRES</label>
                                            <input type="text" class="form-control text-uppercase" id="edit_nombres" name="nombres" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_codigo_sianet" class="form-label text-uppercase">CÓDIGO SIANET</label>
                                            <input type="text" class="form-control text-uppercase" id="edit_codigo_sianet" name="codigo_sianet" maxlength="6" pattern="[A-Za-z0-9]+" title="Sólo se permiten letras y números">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger text-uppercase" data-bs-dismiss="modal"><i class="fas fa-cancel"></i> CERRAR</button>
                                        <button type="submit" class="btn btn-primary text-uppercase"><i class="fas fa-save"></i> GUARDAR CAMBIOS</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const editModal = new bootstrap.Modal(document.getElementById('editStudentModal'));

                            document.querySelectorAll('.btn-edit').forEach(button => {
                                button.addEventListener('click', function () {
                                    const estudiante = this.dataset;

                                    // Llenar el formulario con los datos del estudiante
                                    document.getElementById('edit_id').value = estudiante.id;
                                    document.getElementById('edit_tipo_documento').value = estudiante.tipo_documento;
                                    document.getElementById('edit_nro_documento').value = estudiante.nro_documento;
                                    document.getElementById('edit_apepaterno').value = estudiante.apepaterno;
                                    document.getElementById('edit_apematerno').value = estudiante.apematerno;
                                    document.getElementById('edit_nombres').value = estudiante.nombres;
                                    document.getElementById('edit_codigo_sianet').value = estudiante.codigo_sianet;

                                    // Actualizar el action del formulario
                                    document.getElementById('editStudentForm').action = `/estudiantes/${estudiante.id}`;

                                    editModal.show();
                                });
                            });
                        });

                        function setEditDocumentoLength() {
                            const tipoDocumento = document.getElementById('edit_tipo_documento');
                            const nroDocumento = document.getElementById('edit_nro_documento');
                            const selectedOption = tipoDocumento.options[tipoDocumento.selectedIndex];
                            const maxLength = selectedOption.getAttribute('data-length');
                            nroDocumento.value = '';
                            nroDocumento.setAttribute('maxlength', maxLength);
                        }
                    </script>


                    <!-- Modal -->
                    <div class="modal fade" id="nuevoEstudianteModal" tabindex="-1" aria-labelledby="nuevoEstudianteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="nuevoEstudianteModalLabel">Agregar Nuevo Estudiante</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario para agregar nuevo estudiante -->
                                    <form action="{{ route('estudiantes.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="tipo_documento" class="form-label text-uppercase">TIPO DE DOCUMENTO</label>
                                            <select class="form-control text-uppercase" id="tipo_documento" name="tipo_documento" required onchange="setDocumentoLength()">
                                                <option value="" disabled selected>SELECCIONE UN TIPO DE DOCUMENTO</option>
                                                <option value="DNI" data-length="8">DNI (8 CARACTERES)</option>
                                                <option value="CARNET_EXTRANJERIA" data-length="9">CARNET DE EXTRANJERÍA (9 CARACTERES)</option>
                                                <option value="PASAPORTE" data-length="12">PASAPORTE (12 CARACTERES)</option>
                                                <option value="RUC" data-length="11">RUC (11 CARACTERES)</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="nro_documento" class="form-label text-uppercase">NÚMERO DE DOCUMENTO</label>
                                            <input type="text" class="form-control text-uppercase" id="nro_documento" name="nro_documento" required maxlength="8" placeholder="INGRESE NÚMERO DE DOCUMENTO">
                                        </div>

                                        <div class="mb-3">
                                            <label for="apepaterno" class="form-label text-uppercase">APELLIDO PATERNO</label>
                                            <input type="text" class="form-control text-uppercase" id="apepaterno" name="apepaterno" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="apematerno" class="form-label text-uppercase">APELLIDO MATERNO</label>
                                            <input type="text" class="form-control text-uppercase" id="apematerno" name="apematerno" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="nombres" class="form-label text-uppercase">NOMBRES</label>
                                            <input type="text" class="form-control text-uppercase" id="nombres" name="nombres" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="codigo_sianet" class="form-label text-uppercase">CÓDIGO SIANET</label>
                                            <input type="text" class="form-control text-uppercase" id="codigo_sianet" name="codigo_sianet" maxlength="6"  pattern="[A-Za-z0-9]+" title="Sólo se permiten letras y números">
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger text-uppercase" data-bs-dismiss="modal"><i class="fas fa-cancel"></i> CERRAR</button>
                                            <button type="submit" class="btn btn-primary text-uppercase"><i class="fas fa-save"></i> GUARDAR</button>
                                        </div>
                                    </form>

                                    <script>
                                        function setDocumentoLength() {
                                            const tipoDocumento = document.getElementById('tipo_documento');
                                            const nroDocumento = document.getElementById('nro_documento');
                                            const selectedOption = tipoDocumento.options[tipoDocumento.selectedIndex];
                                            const maxLength = selectedOption.getAttribute('data-length');
                                            nroDocumento.value = ''; // Limpiar el campo
                                            nroDocumento.setAttribute('maxlength', maxLength);
                                            nroDocumento.setAttribute('placeholder', `INGRESE ${maxLength} CARACTERES`);
                                        }
                                    </script>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

