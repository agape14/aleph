@extends('layouts.admin')

@section('title', 'Editar Documento del Sistema - Gestor de Contenido')

@section('content')
<div class="bg-dark-info pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Editar Documento del Sistema</h3>
                    <p class="text-white-50">Modifica la información del documento</p>
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
                    <form action="{{ route('admin.documentos.update', $documento->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre del Documento <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                           id="nombre" name="nombre" value="{{ old('nombre', $documento->nombre) }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo">Tipo de Documento <span class="text-danger">*</span></label>
                                    <select class="form-control @error('tipo') is-invalid @enderror"
                                            id="tipo" name="tipo" required>
                                        <option value="">Seleccionar tipo</option>
                                        <option value="reglamento" {{ old('tipo', $documento->tipo) == 'reglamento' ? 'selected' : '' }}>Reglamento</option>
                                        <option value="formulario" {{ old('tipo', $documento->tipo) == 'formulario' ? 'selected' : '' }}>Formulario</option>
                                        <option value="manual" {{ old('tipo', $documento->tipo) == 'manual' ? 'selected' : '' }}>Manual</option>
                                        <option value="guia" {{ old('tipo', $documento->tipo) == 'guia' ? 'selected' : '' }}>Guía</option>
                                        <option value="otro" {{ old('tipo', $documento->tipo) == 'otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    @error('tipo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="año_lectivo">Año Lectivo <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('año_lectivo') is-invalid @enderror"
                                           id="año_lectivo" name="año_lectivo"
                                           value="{{ old('año_lectivo', $documento->año_lectivo) }}"
                                           min="2020" max="2030" required>
                                    @error('año_lectivo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="orden">Orden de Visualización</label>
                                    <input type="number" class="form-control @error('orden') is-invalid @enderror"
                                           id="orden" name="orden" value="{{ old('orden', $documento->orden) }}"
                                           min="0" step="1">
                                    @error('orden')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                      id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $documento->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="archivo">Nuevo Archivo (opcional)</label>
                            <input type="file" class="form-control @error('archivo') is-invalid @enderror"
                                   id="archivo" name="archivo" accept=".pdf,.doc,.docx,.txt">
                            <small class="form-text text-muted">
                                Si no selecciona un archivo, se mantendrá el archivo actual.
                                <br>Archivo actual: <strong>{{ $documento->nombre_archivo_original }}</strong>
                            </small>
                            @error('archivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1"
                                       {{ old('activo', $documento->activo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">
                                    Documento activo
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.documentos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar Documento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
