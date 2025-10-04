@extends('layouts.admin')

@section('title', 'Crear Documento del Sistema - Gestor de Contenido')

@section('content')
<div class="bg-dark-info pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Crear Documento del Sistema</h3>
                    <p class="text-white-50">Agrega un nuevo documento al sistema</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.documentos.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left"></i> Volver a la Lista
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="row mt-6">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Información del Documento</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.documentos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre del Documento <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                           id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipo" class="form-label">Tipo de Documento <span class="text-danger">*</span></label>
                                    <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                        <option value="">Selecciona un tipo</option>
                                        <option value="reglamento" {{ old('tipo') === 'reglamento' ? 'selected' : '' }}>Reglamento</option>
                                        <option value="formulario" {{ old('tipo') === 'formulario' ? 'selected' : '' }}>Formulario</option>
                                        <option value="guia" {{ old('tipo') === 'guia' ? 'selected' : '' }}>Guía</option>
                                        <option value="otros" {{ old('tipo') === 'otros' ? 'selected' : '' }}>Otros</option>
                                    </select>
                                    @error('tipo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="año_lectivo" class="form-label">Año Lectivo <span class="text-danger">*</span></label>
                                    <select class="form-select @error('año_lectivo') is-invalid @enderror" id="año_lectivo" name="año_lectivo" required>
                                        @for($i = date('Y'); $i <= date('Y') + 2; $i++)
                                            <option value="{{ $i }}" {{ old('año_lectivo', date('Y') + 1) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error('año_lectivo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="orden" class="form-label">Orden</label>
                                    <input type="number" class="form-control @error('orden') is-invalid @enderror"
                                           id="orden" name="orden" value="{{ old('orden', 0) }}" min="0">
                                    <div class="form-text">Orden de aparición (0 = primero)</div>
                                    @error('orden')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="archivo" class="form-label">Archivo <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('archivo') is-invalid @enderror"
                                   id="archivo" name="archivo" accept=".pdf,.doc,.docx" required>
                            <div class="form-text">Formatos permitidos: PDF, DOC, DOCX. Tamaño máximo: 10MB</div>
                            @error('archivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                      id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="activo" name="activo"
                                       {{ old('activo', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">
                                    Documento activo
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.documentos.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Crear Documento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
