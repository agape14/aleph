@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4 mt-4">Configuración del Formulario</h2>

    <form action="{{ route('configuracion.update') }}" method="POST">
        @csrf
        <style>
            /* Aumentar tamaño del switch */
            .switch-lg {
                width: 2.5rem;
                height: 1.1rem;
            }

            .switch-lg:checked {
                background-color: #0d6efd !important;
            }

            #estadoSwitch {
                transform: scale(1.5); /* Agranda el interruptor */
            }
        </style>
        <div class="mb-3">
            <label class="form-label fw-bold d-block">Estado</label>
            <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input me-2 switch-lg" type="checkbox" id="estadoSwitch"
                    {{ old('valor', $config->valor) == 'activo' ? 'checked' : '' }}>
                <label class="form-check-label fw-bold" id="estadoLabel">
                    {{ old('valor', $config->valor) == 'activo' ? 'Activo' : 'Inactivo' }}
                </label>
            </div>
            <input type="hidden" id="estadoHidden" name="valor" value="{{ old('valor', $config->valor) }}">
        </div>

        {{-- Fecha Inicio --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Fecha Inicio</label>
            <input type="datetime-local" name="fecha_inicio" class="form-control" value="{{ $config->fecha_inicio }}">
        </div>

        {{-- Fecha Fin --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Fecha Fin</label>
            <input type="datetime-local" name="fecha_fin" class="form-control" value="{{ $config->fecha_fin }}">
        </div>

        {{-- Título del Mensaje --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Título del Mensaje</label>
            <input type="text" name="titulo_mensaje" class="form-control" value="{{ $config->titulo_mensaje }}">
            {{-- <textarea id="titulomensaje" name="titulo_mensaje" class="form-control">{!! $config->titulo_mensaje !!}</textarea>--}}
            <small class="text-muted">Puedes usar guión (-) para que no se visualice <strong>Titulo</strong> en el formulario.</small>
        </div>

        {{-- Mensaje con CKEditor --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Mensaje</label>
            <textarea id="editor" name="mensaje" class="form-control">{!! $config->mensaje !!}</textarea>
            <small class="text-muted">ingrese datos que se mostraran en la parte central del mensaje</small>
        </div>

        {{-- Pie del Mensaje --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Pie del Mensaje</label>
            <input type="text" name="pie_mensaje" class="form-control" value="{{ $config->pie_mensaje }}">
            <small class="text-muted">Puedes usar guión (-) para que no se visualice <strong>Pie del Mensaje</strong> en el formulario.</small>
        </div>

        <script>
            // Inicializar CKEditor
            const elementos = ['#editor', '#titulomensaje'];

            elementos.forEach(selector => {
                ClassicEditor.create(document.querySelector(selector), {
                    toolbar: [
                        'heading', '|', 'bold', 'italic', 'underline', 'strikethrough', '|',
                        'fontColor', 'fontBackgroundColor', '|',
                        'bulletedList', 'numberedList', '|', 'link', 'blockQuote', 'undo', 'redo'
                    ],
                    fontColor: {
                        colors: [
                            { color: 'black', label: 'Negro' },
                            { color: 'red', label: 'Rojo' },
                            { color: 'blue', label: 'Azul' },
                            { color: 'green', label: 'Verde' },
                            { color: 'yellow', label: 'Amarillo' }
                        ]
                    },
                    fontBackgroundColor: {
                        colors: [
                            { color: 'white', label: 'Blanco' },
                            { color: 'lightgray', label: 'Gris claro' },
                            { color: 'yellow', label: 'Amarillo' },
                            { color: 'pink', label: 'Rosa' },
                            { color: 'lightblue', label: 'Celeste' }
                        ]
                    }
                }).catch(error => console.error(error));
            });
            // Control del Switch de Estado
            document.getElementById('estadoSwitch').addEventListener('change', function() {
                let estadoLabel = document.getElementById('estadoLabel');
                let estadoHidden = document.getElementById('estadoHidden');

                if (this.checked) {
                    estadoLabel.textContent = 'Activo';
                    estadoHidden.value = 'activo';
                } else {
                    estadoLabel.textContent = 'Inactivo';
                    estadoHidden.value = 'inactivo';
                }
            });
        </script>

        {{-- Botón Guardar --}}
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>

    @php
        $vigente = $documentos->firstWhere(fn($d) => $d->activo && $d->año_lectivo == $añoActual)
            ?? $documentos->firstWhere('activo', true);
    @endphp

    {{-- Reglamento de Becas (PDF) --}}
    <div class="card mt-5 mb-5">
        <div class="card-header">
            <h5 class="mb-0">Reglamento de Becas (PDF)</h5>
            <small class="text-muted">
                El último PDF activo subido para el año lectivo {{ $añoActual }} es el que se muestra en el formulario de solicitud.
            </small>
        </div>
        <div class="card-body">
            @if($vigente)
                <div class="alert alert-info d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Mostrándose actualmente:</strong> {{ $vigente->nombre }}
                        <span class="text-muted">({{ $vigente->nombre_archivo_original }})</span>
                        @unless($vigente->existe_archivo)
                            <span class="badge bg-danger ms-2">Archivo no encontrado en el servidor</span>
                        @endunless
                    </div>
                    <a href="{{ $vigente->url }}" target="_blank" class="btn btn-sm btn-outline-primary">Ver PDF</a>
                </div>
            @else
                <div class="alert alert-warning">
                    No hay ningún reglamento activo. El formulario usará el enlace por defecto
                    <code>files/REGLAMENTO DE BECAS {{ $añoActual }}.pdf</code>.
                </div>
            @endif

            @if($errors->documentoEdit->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->documentoEdit->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Subir nuevo PDF --}}
            <form action="{{ route('configuracion.documentos.store') }}" method="POST" enctype="multipart/form-data" class="row g-3 align-items-start">
                @csrf
                <div class="col-md-4">
                    <label class="form-label fw-bold">Nombre a mostrar</label>
                    <input type="text" name="nombre" class="form-control @error('nombre', 'documento') is-invalid @enderror"
                        value="{{ old('nombre', 'Reglamento de Becas ' . $añoActual) }}" required>
                    @error('nombre', 'documento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Año lectivo</label>
                    <input type="number" name="año_lectivo" class="form-control @error('año_lectivo', 'documento') is-invalid @enderror"
                        value="{{ old('año_lectivo', $añoActual) }}" min="2020" max="2100" required>
                    @error('año_lectivo', 'documento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Archivo PDF</label>
                    <input type="file" name="archivo" accept="application/pdf,.pdf"
                        class="form-control @error('archivo', 'documento') is-invalid @enderror" required>
                    @error('archivo', 'documento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Solo PDF, máximo 10 MB.</small>
                </div>
                <div class="col-md-2 d-grid">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-success">Subir PDF</button>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Descripción (opcional)</label>
                    <input type="text" name="descripcion" class="form-control @error('descripcion', 'documento') is-invalid @enderror"
                        value="{{ old('descripcion') }}">
                    @error('descripcion', 'documento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </form>

            <hr class="my-4">

            {{-- Listado --}}
            @if($documentos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Archivo</th>
                                <th>Año</th>
                                <th>Tamaño</th>
                                <th>Subido</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documentos as $documento)
                                <tr>
                                    <td>
                                        {{ $documento->nombre }}
                                        @if($vigente && $vigente->id === $documento->id)
                                            <span class="badge bg-primary ms-1">En uso</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $documento->nombre_archivo_original }}</span>
                                        @unless($documento->existe_archivo)
                                            <span class="badge bg-danger ms-1">Falta</span>
                                        @endunless
                                    </td>
                                    <td>{{ $documento->año_lectivo }}</td>
                                    <td>{{ $documento->tamaño_formateado }}</td>
                                    <td>{{ $documento->created_at?->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $documento->activo ? 'success' : 'secondary' }}">
                                            {{ $documento->activo ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ $documento->url }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Ver PDF">Ver</a>
                                            <button type="button" class="btn btn-sm btn-outline-warning"
                                                data-bs-toggle="modal" data-bs-target="#modalEditarDocumento{{ $documento->id }}">
                                                Editar
                                            </button>
                                            <form action="{{ route('configuracion.documentos.toggle', $documento) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                    {{ $documento->activo ? 'Desactivar' : 'Activar' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('configuracion.documentos.destroy', $documento) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('¿Eliminar este reglamento y su archivo PDF?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">Aún no se ha subido ningún reglamento.</p>
            @endif
        </div>
    </div>

    {{-- Modales de edición --}}
    @foreach($documentos as $documento)
        <div class="modal fade" id="modalEditarDocumento{{ $documento->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('configuracion.documentos.update', $documento) }}" method="POST" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Editar reglamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre a mostrar</label>
                            <input type="text" name="nombre" class="form-control" value="{{ $documento->nombre }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Año lectivo</label>
                            <input type="number" name="año_lectivo" class="form-control" value="{{ $documento->año_lectivo }}" min="2020" max="2100" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Descripción</label>
                            <input type="text" name="descripcion" class="form-control" value="{{ $documento->descripcion }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Reemplazar PDF (opcional)</label>
                            <input type="file" name="archivo" accept="application/pdf,.pdf" class="form-control">
                            <small class="text-muted">Actual: {{ $documento->nombre_archivo_original }}</small>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="activo" value="1"
                                id="activoDocumento{{ $documento->id }}" {{ $documento->activo ? 'checked' : '' }}>
                            <label class="form-check-label" for="activoDocumento{{ $documento->id }}">Activo</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
