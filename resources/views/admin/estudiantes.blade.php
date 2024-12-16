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
                        <h4 class="mb-0">Estudiantes </h4>


                        <form action="/importar-excel" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" required>
                            <button type="submit"  class="btn btn-success">Importar Excel</button>
                        </form>

                        <form action="{{ route('progenitores.transfer') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Limpiar Alumnos</button>
                        </form>

                        @if(session('success'))
                            <p class="text-primary">{{ session('success') }}</p>
                        @endif

                        @if(session('error'))
                            <p class="text-danger">{{ session('error') }}</p>
                        @endif
                    </div>
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
                                @foreach($estudiantes as $estudiante)
                                    <tr>
                                        <td>{{ $estudiante->nombres }} {{ $estudiante->apepaterno }} {{ $estudiante->apematerno }}</td>
                                        <td>{{ $estudiante->tipo_documento }}</td>
                                        <td>{{ $estudiante->nro_documento }}</td>
                                        <td>{{ $estudiante->codigo_sianet }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editStudentModal"
                                                data-id="{{ $estudiante->id }}"
                                                data-nombres="{{ $estudiante->nombres }}"
                                                data-apepaterno="{{ $estudiante->apepaterno }}"
                                                data-apematerno="{{ $estudiante->apematerno }}"
                                                data-tipo_documento="{{ $estudiante->tipo_documento }}"
                                                data-nro_documento="{{ $estudiante->nro_documento }}"
                                                data-codigo_sianet="{{ $estudiante->codigo_sianet }}">
                                                Editar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="editStudentForm" method="POST" action="{{ route('estudiantes.update') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editStudentModalLabel">Editar Estudiante</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" id="edit-id">
                                        <div class="mb-3">
                                            <label for="edit-nombres" class="form-label">Nombres</label>
                                            <input type="text" class="form-control" id="edit-nombres" name="nombres" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-apepaterno" class="form-label">Apellido Paterno</label>
                                            <input type="text" class="form-control" id="edit-apepaterno" name="apepaterno" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-apematerno" class="form-label">Apellido Materno</label>
                                            <input type="text" class="form-control" id="edit-apematerno" name="apematerno" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-tipo_documento" class="form-label">Tipo de Documento</label>
                                            <input type="text" class="form-control" id="edit-tipo_documento" name="tipo_documento" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-nro_documento" class="form-label">Número de Documento</label>
                                            <input type="text" class="form-control" id="edit-nro_documento" name="nro_documento" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-codigo_sianet" class="form-label">Código Sianet</label>
                                            <input type="text" class="form-control" id="edit-codigo_sianet" name="codigo_sianet" required>
                                        </div>
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
            </div>
        </div>
    </div>
@endsection

