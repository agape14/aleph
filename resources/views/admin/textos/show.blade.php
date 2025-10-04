@extends('layouts.admin')

@section('title', 'Detalles del Texto Dinámico - Gestor de Contenido')

@section('content')
<div class="bg-dark-info pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Detalles del Texto Dinámico</h3>
                    <p class="text-white-50">{{ $texto->titulo }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.textos.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left"></i> Volver a la Lista
                    </a>
                    <a href="{{ route('admin.textos.edit', $texto) }}" class="btn btn-warning btn-lg">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del texto -->
    <div class="row mt-6">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Información del Texto</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>ID:</strong></td>
                                    <td>{{ $texto->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Clave:</strong></td>
                                    <td><code>{{ $texto->clave }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Título:</strong></td>
                                    <td>{{ $texto->titulo }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Sección:</strong></td>
                                    <td><span class="badge bg-info">{{ $texto->seccion }}</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Año Lectivo:</strong></td>
                                    <td>{{ $texto->año_lectivo }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Orden:</strong></td>
                                    <td>{{ $texto->orden }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Estado:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $texto->activo ? 'success' : 'secondary' }}">
                                            {{ $texto->activo ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Versiones:</strong></td>
                                    <td><span class="badge bg-primary">{{ $versiones->count() }} versiones</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6>Contenido Actual:</h6>
                        <div class="bg-light p-3 rounded">
                            {!! $texto->contenido !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.textos.edit', $texto) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar Texto
                        </a>
                        <button class="btn btn-{{ $texto->activo ? 'secondary' : 'success' }}"
                                onclick="toggleActive({{ $texto->id }})">
                            <i class="fas fa-{{ $texto->activo ? 'pause' : 'play' }}"></i>
                            {{ $texto->activo ? 'Desactivar' : 'Activar' }}
                        </button>
                        <form action="{{ route('admin.textos.destroy', $texto) }}" method="POST"
                              onsubmit="return confirm('¿Estás seguro de eliminar este texto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de versiones -->
    <div class="row mt-6">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Historial de Versiones</h5>
                </div>
                <div class="card-body">
                    @if($versiones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Versión</th>
                                        <th>Motivo del Cambio</th>
                                        <th>Usuario</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($versiones as $version)
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary">{{ $version->version }}</span>
                                            </td>
                                            <td>{{ $version->motivo_cambio ?? 'Sin motivo especificado' }}</td>
                                            <td>{{ $version->usuario->name ?? 'Sistema' }}</td>
                                            <td>{{ $version->created_at->format('d/m/Y H:i:s') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalVersion{{ $version->id }}">
                                                    <i class="fas fa-eye"></i> Ver Cambios
                                                </button>
                                                @if(!$loop->first)
                                                    <form action="{{ route('admin.textos.restaurar-version', ['texto' => $texto, 'version' => $version]) }}"
                                                          method="POST" style="display: inline;"
                                                          onsubmit="return confirm('¿Estás seguro de restaurar esta versión?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                                            <i class="fas fa-undo"></i> Restaurar
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-history fa-2x text-muted mb-3"></i>
                            <h6 class="text-muted">No hay versiones disponibles</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales de versiones -->
@foreach($versiones as $version)
<div class="modal fade" id="modalVersion{{ $version->id }}" tabindex="-1" aria-labelledby="modalVersionLabel{{ $version->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVersionLabel{{ $version->id }}">Versión {{ $version->version }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Contenido Anterior:</h6>
                        <div class="bg-light p-3 rounded" style="max-height: 300px; overflow-y: auto;">
                            {!! $version->contenido_anterior ?: '<em>Contenido inicial</em>' !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Contenido Nuevo:</h6>
                        <div class="bg-light p-3 rounded" style="max-height: 300px; overflow-y: auto;">
                            {!! $version->contenido_nuevo !!}
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <h6>Información de la Versión:</h6>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Versión:</strong></td>
                            <td>{{ $version->version }}</td>
                        </tr>
                        <tr>
                            <td><strong>Motivo:</strong></td>
                            <td>{{ $version->motivo_cambio ?? 'Sin motivo especificado' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Usuario:</strong></td>
                            <td>{{ $version->usuario->name ?? 'Sistema' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha:</strong></td>
                            <td>{{ $version->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                @if(!$loop->first)
                    <form action="{{ route('admin.textos.restaurar-version', ['texto' => $texto, 'version' => $version]) }}"
                          method="POST" style="display: inline;"
                          onsubmit="return confirm('¿Estás seguro de restaurar esta versión?')">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-undo"></i> Restaurar Esta Versión
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

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
