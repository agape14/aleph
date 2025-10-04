@extends('layouts.admin')

@section('title', 'Documentos del Sistema - Gestor de Contenido')

@section('content')
<div class="bg-dark-info pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Documentos del Sistema</h3>
                    <p class="text-white-50">Gestiona los documentos del formulario de becas</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.gestor-contenido.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
                    </a>
                    <a href="{{ route('admin.documentos.create') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-plus"></i> Nuevo Documento
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="row mt-6">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Filtros</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.documentos.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="tipo" class="form-label">Tipo</label>
                                <select class="form-select" name="tipo" id="tipo">
                                    <option value="">Todos los tipos</option>
                                    <option value="reglamento" {{ request('tipo') === 'reglamento' ? 'selected' : '' }}>Reglamento</option>
                                    <option value="formulario" {{ request('tipo') === 'formulario' ? 'selected' : '' }}>Formulario</option>
                                    <option value="guia" {{ request('tipo') === 'guia' ? 'selected' : '' }}>Guía</option>
                                    <option value="otros" {{ request('tipo') === 'otros' ? 'selected' : '' }}>Otros</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="año_lectivo" class="form-label">Año Lectivo</label>
                                <select class="form-select" name="año_lectivo" id="año_lectivo">
                                    <option value="">Todos los años</option>
                                    @for($i = date('Y'); $i <= date('Y') + 2; $i++)
                                        <option value="{{ $i }}" {{ request('año_lectivo') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="activo" class="form-label">Estado</label>
                                <select class="form-select" name="activo" id="activo">
                                    <option value="">Todos los estados</option>
                                    <option value="1" {{ request('activo') === '1' ? 'selected' : '' }}>Activos</option>
                                    <option value="0" {{ request('activo') === '0' ? 'selected' : '' }}>Inactivos</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                    <a href="{{ route('admin.documentos.index') }}" class="btn btn-secondary">Limpiar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de documentos -->
    <div class="row mt-6">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Listado de Documentos del Sistema</h5>
                </div>
                <div class="card-body">
                    @if($documentos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Año</th>
                                        <th>Tamaño</th>
                                        <th>Estado</th>
                                        <th>Última Modificación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documentos as $documento)
                                        <tr>
                                            <td>{{ $documento->id }}</td>
                                            <td>{{ $documento->nombre }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ ucfirst($documento->tipo) }}</span>
                                            </td>
                                            <td>{{ $documento->año_lectivo }}</td>
                                            <td>{{ $documento->tamaño_formateado }}</td>
                                            <td>
                                                <span class="badge bg-{{ $documento->activo ? 'success' : 'secondary' }}">
                                                    {{ $documento->activo ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </td>
                                            <td>{{ $documento->updated_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.documentos.show', $documento) }}" class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.documentos.edit', $documento) }}" class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ $documento->url }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-{{ $documento->activo ? 'secondary' : 'success' }}"
                                                            onclick="toggleActive({{ $documento->id }})">
                                                        <i class="fas fa-{{ $documento->activo ? 'pause' : 'play' }}"></i>
                                                    </button>
                                                    <form action="{{ route('admin.documentos.destroy', $documento) }}" method="POST"
                                                          style="display: inline;"
                                                          onsubmit="return confirm('¿Estás seguro de eliminar este documento?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-center">
                            {{ $documentos->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No se encontraron documentos</h5>
                            <p class="text-muted">No hay documentos que coincidan con los filtros aplicados.</p>
                            <a href="{{ route('admin.documentos.create') }}" class="btn btn-primary">Crear Primer Documento</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleActive(documentoId) {
    fetch(`/admin/documentos/${documentoId}/toggle-active`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cambiar el estado del documento');
    });
}
</script>
@endsection
