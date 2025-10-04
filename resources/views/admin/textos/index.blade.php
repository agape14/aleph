@extends('layouts.admin')

@section('title', 'Textos Dinámicos - Gestor de Contenido')

@section('content')
<div class="bg-dark-info pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Textos Dinámicos</h3>
                    <p class="text-white-50">Gestiona los textos del formulario de becas</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.gestor-contenido.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
                    </a>
                    <a href="{{ route('admin.textos.create') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-plus"></i> Nuevo Texto
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
                    <form method="GET" action="{{ route('admin.textos.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="seccion" class="form-label">Sección</label>
                                <select class="form-select" name="seccion" id="seccion">
                                    <option value="">Todas las secciones</option>
                                    <option value="paso1" {{ request('seccion') === 'paso1' ? 'selected' : '' }}>Paso 1</option>
                                    <option value="paso2" {{ request('seccion') === 'paso2' ? 'selected' : '' }}>Paso 2</option>
                                    <option value="formulario" {{ request('seccion') === 'formulario' ? 'selected' : '' }}>Formulario</option>
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
                                    <a href="{{ route('admin.textos.index') }}" class="btn btn-secondary">Limpiar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de textos -->
    <div class="row mt-6">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Listado de Textos Dinámicos</h5>
                </div>
                <div class="card-body">
                    @if($textos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Clave</th>
                                        <th>Título</th>
                                        <th>Sección</th>
                                        <th>Año</th>
                                        <th>Estado</th>
                                        <th>Versiones</th>
                                        <th>Última Modificación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($textos as $texto)
                                        <tr>
                                            <td>{{ $texto->id }}</td>
                                            <td>
                                                <code>{{ $texto->clave }}</code>
                                            </td>
                                            <td>{{ $texto->titulo }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $texto->seccion }}</span>
                                            </td>
                                            <td>{{ $texto->año_lectivo }}</td>
                                            <td>
                                                <span class="badge bg-{{ $texto->activo ? 'success' : 'secondary' }}">
                                                    {{ $texto->activo ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $texto->versiones->count() }} versiones</span>
                                            </td>
                                            <td>{{ $texto->updated_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.textos.show', $texto) }}" class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.textos.edit', $texto) }}" class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-{{ $texto->activo ? 'secondary' : 'success' }}"
                                                            onclick="toggleActive({{ $texto->id }})">
                                                        <i class="fas fa-{{ $texto->activo ? 'pause' : 'play' }}"></i>
                                                    </button>
                                                    <form action="{{ route('admin.textos.destroy', $texto) }}" method="POST"
                                                          style="display: inline;"
                                                          onsubmit="return confirm('¿Estás seguro de eliminar este texto?')">
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
                            {{ $textos->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-text fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No se encontraron textos</h5>
                            <p class="text-muted">No hay textos que coincidan con los filtros aplicados.</p>
                            <a href="{{ route('admin.textos.create') }}" class="btn btn-primary">Crear Primer Texto</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleActive(textoId) {
    fetch(`/admin/textos/${textoId}/toggle-active`, {
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
        alert('Error al cambiar el estado del texto');
    });
}
</script>
@endsection
