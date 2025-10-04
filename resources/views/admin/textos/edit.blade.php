@extends('layouts.admin')

@section('title', 'Editar Texto Dinámico - Gestor de Contenido')

@section('content')
<div class="bg-dark-info pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Editar Texto Dinámico</h3>
                    <p class="text-white-50">Modifica el texto: {{ $texto->titulo }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.textos.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left"></i> Volver a la Lista
                    </a>
                    <a href="{{ route('admin.textos.show', $texto) }}" class="btn btn-info btn-lg">
                        <i class="fas fa-eye"></i> Ver Detalles
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
                    <h5 class="mb-0">Información del Texto</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.textos.update', $texto) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="clave" class="form-label">Clave <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('clave') is-invalid @enderror"
                                           id="clave" name="clave" value="{{ old('clave', $texto->clave) }}" required>
                                    <div class="form-text">Identificador único para el texto</div>
                                    @error('clave')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('titulo') is-invalid @enderror"
                                           id="titulo" name="titulo" value="{{ old('titulo', $texto->titulo) }}" required>
                                    @error('titulo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="seccion" class="form-label">Sección <span class="text-danger">*</span></label>
                                    <select class="form-select @error('seccion') is-invalid @enderror" id="seccion" name="seccion" required>
                                        <option value="">Selecciona una sección</option>
                                        <option value="paso1" {{ old('seccion', $texto->seccion) === 'paso1' ? 'selected' : '' }}>Paso 1</option>
                                        <option value="paso2" {{ old('seccion', $texto->seccion) === 'paso2' ? 'selected' : '' }}>Paso 2</option>
                                        <option value="paso3" {{ old('seccion', $texto->seccion) === 'paso3' ? 'selected' : '' }}>Paso 3</option>
                                        <option value="formulario" {{ old('seccion', $texto->seccion) === 'formulario' ? 'selected' : '' }}>Formulario General</option>
                                    </select>
                                    @error('seccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="año_lectivo" class="form-label">Año Lectivo <span class="text-danger">*</span></label>
                                    <select class="form-select @error('año_lectivo') is-invalid @enderror" id="año_lectivo" name="año_lectivo" required>
                                        @for($i = date('Y'); $i <= date('Y') + 2; $i++)
                                            <option value="{{ $i }}" {{ old('año_lectivo', $texto->año_lectivo) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error('año_lectivo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="orden" class="form-label">Orden</label>
                                    <input type="number" class="form-control @error('orden') is-invalid @enderror"
                                           id="orden" name="orden" value="{{ old('orden', $texto->orden) }}" min="0">
                                    <div class="form-text">Orden de aparición en la sección</div>
                                    @error('orden')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="activo" name="activo"
                                               {{ old('activo', $texto->activo) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="activo">
                                            Texto activo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="contenido" class="form-label">Contenido <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('contenido') is-invalid @enderror"
                                      id="contenido" name="contenido" rows="10" required>{{ old('contenido', $texto->contenido) }}</textarea>
                            <div class="form-text">
                                Puedes usar HTML básico para formatear el texto.
                            </div>
                            @error('contenido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="motivo_cambio" class="form-label">Motivo del Cambio</label>
                            <input type="text" class="form-control @error('motivo_cambio') is-invalid @enderror"
                                   id="motivo_cambio" name="motivo_cambio" value="{{ old('motivo_cambio') }}"
                                   placeholder="Describe brevemente el motivo del cambio">
                            <div class="form-text">Este motivo se guardará en el historial de versiones</div>
                            @error('motivo_cambio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.textos.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar Texto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
