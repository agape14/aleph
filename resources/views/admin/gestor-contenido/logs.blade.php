@extends('layouts.admin')

@section('title', 'Logs de Cambios - Gestor de Contenido')

@section('content')
<div class="bg-dark-info pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Logs de Cambios</h3>
                    <p class="text-white-50">Historial de todas las modificaciones en el contenido</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.gestor-contenido.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
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
                    <form method="GET" action="{{ route('admin.gestor-contenido.logs') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="tabla" class="form-label">Tabla</label>
                                <select class="form-select" name="tabla" id="tabla">
                                    <option value="">Todas las tablas</option>
                                    <option value="textos_dinamicos" {{ request('tabla') === 'textos_dinamicos' ? 'selected' : '' }}>Textos Dinámicos</option>
                                    <option value="documentos_sistema" {{ request('tabla') === 'documentos_sistema' ? 'selected' : '' }}>Documentos del Sistema</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="accion" class="form-label">Acción</label>
                                <select class="form-select" name="accion" id="accion">
                                    <option value="">Todas las acciones</option>
                                    <option value="created" {{ request('accion') === 'created' ? 'selected' : '' }}>Creado</option>
                                    <option value="updated" {{ request('accion') === 'updated' ? 'selected' : '' }}>Actualizado</option>
                                    <option value="deleted" {{ request('accion') === 'deleted' ? 'selected' : '' }}>Eliminado</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="fecha_desde" class="form-label">Fecha Desde</label>
                                <input type="date" class="form-control" name="fecha_desde" value="{{ request('fecha_desde') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                                <input type="date" class="form-control" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                    <a href="{{ route('admin.gestor-contenido.logs') }}" class="btn btn-secondary">Limpiar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de logs -->
    <div class="row mt-6">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Historial de Cambios</h5>
                </div>
                <div class="card-body">
                    @if($logs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Acción</th>
                                        <th>Tabla</th>
                                        <th>Registro ID</th>
                                        <th>Usuario</th>
                                        <th>IP</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>{{ $log->id }}</td>
                                            <td>
                                                <span class="badge bg-{{ $log->accion === 'created' ? 'success' : ($log->accion === 'updated' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($log->accion) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $log->tabla_afectada }}</span>
                                            </td>
                                            <td>{{ $log->registro_id }}</td>
                                            <td>{{ $log->usuario->name ?? 'Sistema' }}</td>
                                            <td>{{ $log->ip_address ?? 'N/A' }}</td>
                                            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalDetalle{{ $log->id }}">
                                                    <i class="fas fa-eye"></i> Ver Detalles
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-center">
                            {{ $logs->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No se encontraron logs</h5>
                            <p class="text-muted">No hay registros que coincidan con los filtros aplicados.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales de detalles -->
@foreach($logs as $log)
<div class="modal fade" id="modalDetalle{{ $log->id }}" tabindex="-1" aria-labelledby="modalDetalleLabel{{ $log->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetalleLabel{{ $log->id }}">Detalles del Log #{{ $log->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Información General</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>ID:</strong></td>
                                <td>{{ $log->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Acción:</strong></td>
                                <td>
                                    <span class="badge bg-{{ $log->accion === 'created' ? 'success' : ($log->accion === 'updated' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($log->accion) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tabla:</strong></td>
                                <td>{{ $log->tabla_afectada }}</td>
                            </tr>
                            <tr>
                                <td><strong>Registro ID:</strong></td>
                                <td>{{ $log->registro_id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Usuario:</strong></td>
                                <td>{{ $log->usuario->name ?? 'Sistema' }}</td>
                            </tr>
                            <tr>
                                <td><strong>IP:</strong></td>
                                <td>{{ $log->ip_address ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Fecha:</strong></td>
                                <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Datos del Cambio</h6>
                        @if($log->datos_anteriores)
                            <div class="mb-3">
                                <strong>Datos Anteriores:</strong>
                                <pre class="bg-light p-2 rounded small">{{ json_encode($log->datos_anteriores, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        @endif
                        @if($log->datos_nuevos)
                            <div class="mb-3">
                                <strong>Datos Nuevos:</strong>
                                <pre class="bg-light p-2 rounded small">{{ json_encode($log->datos_nuevos, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        @endif
                        @if($log->campo_modificado)
                            <div class="mb-3">
                                <strong>Campo Modificado:</strong>
                                <span class="badge bg-info">{{ $log->campo_modificado }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
