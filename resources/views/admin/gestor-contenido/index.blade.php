@extends('layouts.admin')

@section('title', 'Gestor de Contenido - Dashboard')

@section('content')
<div class="bg-dark-info pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Gestor de Contenido</h3>
                    <p class="text-white-50">Administra textos dinámicos y documentos del sistema</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.gestor-contenido.exportar') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-download"></i> Exportar Configuración
                    </a>
                    <button class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#modalImportar">
                        <i class="fas fa-upload"></i> Importar Configuración
                    </button>
                    <form action="{{ route('admin.gestor-contenido.limpiar-cache') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-lg" onclick="return confirm('¿Estás seguro de limpiar el cache?')">
                            <i class="fas fa-broom"></i> Limpiar Cache
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mt-6">
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <div class="card bg-light-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="mb-0">Textos Dinámicos</h4>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-2">
                            <i class="fas fa-file-text fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="fw-bold text-primary">{{ $estadisticas['total_textos'] }}</h1>
                        <p class="mb-0">Total: {{ $estadisticas['textos_activos'] }} activos</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <div class="card bg-light-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="mb-0">Documentos</h4>
                        </div>
                        <div class="icon-shape icon-md bg-success text-white rounded-2">
                            <i class="fas fa-file fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="fw-bold text-success">{{ $estadisticas['total_documentos'] }}</h1>
                        <p class="mb-0">Total: {{ $estadisticas['documentos_activos'] }} activos</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <div class="card bg-light-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="mb-0">Cambios Recientes</h4>
                        </div>
                        <div class="icon-shape icon-md bg-warning text-white rounded-2">
                            <i class="fas fa-history fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="fw-bold text-warning">{{ $estadisticas['cambios_recientes'] }}</h1>
                        <p class="mb-0">Últimos 7 días</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <div class="card bg-light-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="mb-0">Acciones Rápidas</h4>
                        </div>
                        <div class="icon-shape icon-md bg-info text-white rounded-2">
                            <i class="fas fa-bolt fs-4"></i>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.textos.create') }}" class="btn btn-sm btn-primary">Nuevo Texto</a>
                        <a href="{{ route('admin.documentos.create') }}" class="btn btn-sm btn-success">Nuevo Documento</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido reciente -->
    <div class="row mt-6">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Textos Recientes</h5>
                </div>
                <div class="card-body">
                    @if($textosRecientes->count() > 0)
                        @foreach($textosRecientes as $texto)
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <div class="icon-shape icon-sm bg-primary text-white rounded">
                                        <i class="fas fa-file-text"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">{{ $texto->titulo }}</h6>
                                    <small class="text-muted">{{ $texto->seccion }} - {{ $texto->año_lectivo }}</small>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge bg-{{ $texto->activo ? 'success' : 'secondary' }}">
                                        {{ $texto->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">No hay textos recientes.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Documentos Recientes</h5>
                </div>
                <div class="card-body">
                    @if($documentosRecientes->count() > 0)
                        @foreach($documentosRecientes as $documento)
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <div class="icon-shape icon-sm bg-success text-white rounded">
                                        <i class="fas fa-file"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">{{ $documento->nombre }}</h6>
                                    <small class="text-muted">{{ $documento->tipo }} - {{ $documento->año_lectivo }}</small>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge bg-{{ $documento->activo ? 'success' : 'secondary' }}">
                                        {{ $documento->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">No hay documentos recientes.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Logs recientes -->
    <div class="row mt-6">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Actividad Reciente</h5>
                    <a href="{{ route('admin.gestor-contenido.logs') }}" class="btn btn-sm btn-outline-primary">Ver Todos</a>
                </div>
                <div class="card-body">
                    @if($logsRecientes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Acción</th>
                                        <th>Tabla</th>
                                        <th>Usuario</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logsRecientes as $log)
                                        <tr>
                                            <td>
                                                <span class="badge bg-{{ $log->accion === 'created' ? 'success' : ($log->accion === 'updated' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($log->accion) }}
                                                </span>
                                            </td>
                                            <td>{{ $log->tabla_afectada }}</td>
                                            <td>{{ $log->usuario->name ?? 'Sistema' }}</td>
                                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No hay actividad reciente.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Importar -->
<div class="modal fade" id="modalImportar" tabindex="-1" aria-labelledby="modalImportarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImportarLabel">Importar Configuración</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.gestor-contenido.importar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="archivo" class="form-label">Archivo JSON</label>
                        <input type="file" class="form-control" name="archivo" accept=".json" required>
                        <div class="form-text">Selecciona un archivo JSON de configuración exportado previamente.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Importar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
