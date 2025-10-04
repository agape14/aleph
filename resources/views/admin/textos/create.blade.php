@extends('layouts.admin')

@section('title', 'Crear Texto Dinámico - Gestor de Contenido')

@section('content')
<div class="bg-dark-info pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Crear Texto Dinámico</h3>
                    <p class="text-white-50">Agrega un nuevo texto al formulario de becas</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.textos.index') }}" class="btn btn-outline-light btn-lg">
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
                    <h5 class="mb-0">Información del Texto</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.textos.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="clave" class="form-label">Clave <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('clave') is-invalid @enderror"
                                           id="clave" name="clave" value="{{ old('clave') }}" required>
                                    <div class="form-text">Identificador único para el texto (ej: declaracion_jurada)</div>
                                    @error('clave')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('titulo') is-invalid @enderror"
                                           id="titulo" name="titulo" value="{{ old('titulo') }}" required>
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
                                        <option value="paso1" {{ old('seccion') === 'paso1' ? 'selected' : '' }}>Paso 1</option>
                                        <option value="paso2" {{ old('seccion') === 'paso2' ? 'selected' : '' }}>Paso 2</option>
                                        <option value="paso3" {{ old('seccion') === 'paso3' ? 'selected' : '' }}>Paso 3</option>
                                        <option value="formulario" {{ old('seccion') === 'formulario' ? 'selected' : '' }}>Formulario General</option>
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
                                            <option value="{{ $i }}" {{ old('año_lectivo', date('Y') + 1) == $i ? 'selected' : '' }}>{{ $i }}</option>
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
                                           id="orden" name="orden" value="{{ old('orden', 0) }}" min="0">
                                    <div class="form-text">Orden de aparición en la sección (0 = primero)</div>
                                    @error('orden')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="activo" name="activo"
                                               {{ old('activo', true) ? 'checked' : '' }}>
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
                                      id="contenido" name="contenido" rows="10" required>{{ old('contenido') }}</textarea>
                            <div class="form-text">
                                Puedes usar HTML básico para formatear el texto.
                                <br>Ejemplo: &lt;strong&gt;Texto en negrita&lt;/strong&gt;, &lt;em&gt;Texto en cursiva&lt;/em&gt;
                            </div>
                            @error('contenido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.textos.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Crear Texto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
