@extends('layouts.admin')

@section('title', 'Detalles del Documento - Gestor de Contenido')

@section('content')
<div class="bg-dark-info pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Detalles del Documento</h3>
                    <p class="text-white-50">{{ $documento->nombre }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.documentos.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left"></i> Volver a la Lista
                    </a>
                    <a href="{{ route('admin.documentos.edit', $documento) }}" class="btn btn-warning btn-lg">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del documento -->
    <div class="row mt-6">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Información del Documento</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>ID:</strong></td>
                                    <td>{{ $documento->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nombre:</strong></td>
                                    <td>{{ $documento->nombre }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tipo:</strong></td>
                                    <td><span class="badge bg-info">{{ ucfirst($documento->tipo) }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Año Lectivo:</strong></td>
                                    <td>{{ $documento->año_lectivo }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Orden:</strong></td>
                                    <td>{{ $documento->orden }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Estado:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $documento->activo ? 'success' : 'secondary' }}">
                                            {{ $documento->activo ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tamaño:</strong></td>
                                    <td>{{ $documento->tamaño_formateado }}</td>
                                </tr>
                                <tr>
                                    <td><strong>MIME Type:</strong></td>
                                    <td>{{ $documento->mime_type }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($documento->descripcion)
                        <div class="mt-4">
                            <h6>Descripción:</h6>
                            <p class="text-muted">{{ $documento->descripcion }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Acciones</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.documentos.edit', $documento) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar Documento
                        </a>
                        <a href="{{ $documento->url }}" target="_blank" class="btn btn-success">
                            <i class="fas fa-download"></i> Descargar
                        </a>
                        <button class="btn btn-{{ $documento->activo ? 'secondary' : 'success' }}"
                                onclick="toggleActive({{ $documento->id }})">
                            <i class="fas fa-{{ $documento->activo ? 'pause' : 'play' }}"></i>
                            {{ $documento->activo ? 'Desactivar' : 'Activar' }}
                        </button>
                        <form action="{{ route('admin.documentos.destroy', $documento) }}" method="POST"
                              onsubmit="return confirm('¿Estás seguro de eliminar este documento?')">
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
