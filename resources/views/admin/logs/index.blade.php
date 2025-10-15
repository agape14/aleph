@extends('layouts.admin')

@section('title', 'Gestor de Logs')

@section('content')
<div class="container-fluid px-6 py-4">
    <!-- Encabezado -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-1 h2 fw-bold">Gestor de Logs del Sistema</h1>
                    <p class="mb-0 text-muted">Gestiona y revisa las copias del log de Laravel</p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" id="btnCopiarLog">
                        <i data-feather="copy" style="width: 16px; height: 16px;" class="me-2"></i>Crear Copia del Log
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerta de mensajes -->
    <div id="alertContainer"></div>

    <!-- Tarjeta de información -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-lg bg-light-info text-info rounded-3 me-3">
                            <i data-feather="info" style="width: 24px; height: 24px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Información Importante</h5>
                            <p class="mb-0 text-muted">
                                Esta herramienta te permite crear copias del log principal de Laravel para revisión.
                                El log principal nunca se modifica ni elimina, solo puedes gestionar las copias creadas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de copias de logs -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Copias de Logs Disponibles</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="logsTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre del Archivo</th>
                                    <th>Tamaño</th>
                                    <th>Fecha de Creación</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="logsTableBody">
                                @forelse($backups as $backup)
                                <tr data-file="{{ $backup['name'] }}">
                                    <td>
                                        <i data-feather="file-text" class="me-2 text-primary" style="width: 16px; height: 16px;"></i>
                                        {{ $backup['name'] }}
                                    </td>
                                    <td>{{ $backup['size'] }}</td>
                                    <td>{{ $backup['date'] }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info btn-ver" data-file="{{ $backup['name'] }}" title="Ver contenido">
                                            <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                                        </button>
                                        <a href="{{ route('admin.logs.descargar', $backup['name']) }}" class="btn btn-sm btn-success" title="Descargar">
                                            <i data-feather="download" style="width: 14px; height: 14px;"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger btn-eliminar" data-file="{{ $backup['name'] }}" title="Eliminar">
                                            <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i data-feather="inbox" style="width: 48px; height: 48px;"></i>
                                        <p class="mt-2">No hay copias de logs disponibles. Crea una copia para comenzar.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver contenido del log -->
<div class="modal fade" id="modalVerLog" tabindex="-1" aria-labelledby="modalVerLogLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalVerLogLabel">
                    <i data-feather="file-text" style="width: 18px; height: 18px;" class="me-2"></i>Contenido del Log
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-dark text-light">
                <div class="mb-3">
                    <strong>Archivo:</strong> <span id="logFileName" class="text-info"></span>
                </div>
                <div class="position-relative">
                    <button type="button" class="btn btn-sm btn-outline-light position-absolute top-0 end-0 m-2" id="btnCopiarContenido">
                        <i data-feather="copy" style="width: 14px; height: 14px;" class="me-1"></i> Copiar
                    </button>
                    <pre class="bg-secondary p-3 rounded" style="max-height: 500px; overflow-y: auto;"><code id="logContent" class="text-light"></code></pre>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnDescargarDesdeModal">
                    <i data-feather="download" style="width: 14px; height: 14px;" class="me-1"></i> Descargar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-labelledby="modalConfirmarEliminarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalConfirmarEliminarLabel">
                    <i data-feather="alert-triangle" style="width: 18px; height: 18px;" class="me-2"></i>Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar esta copia del log?</p>
                <p class="text-muted mb-0">
                    <strong>Archivo:</strong> <span id="archivoAEliminar"></span>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">
                    <i data-feather="trash-2" style="width: 14px; height: 14px;" class="me-1"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Configurar token CSRF para todas las peticiones AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let archivoActual = '';

    // Crear copia del log
    $('#btnCopiarLog').click(function(e) {
        e.preventDefault();
        console.log('Botón clickeado');

        const btn = $(this);
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Creando copia...');

        $.ajax({
            url: '{{ route("admin.logs.copiar") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Respuesta recibida:', response);
                if (response.success) {
                    mostrarAlerta('success', response.message);
                    agregarFilaTabla(response.backup);
                } else {
                    mostrarAlerta('danger', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en petición:', xhr, status, error);
                console.error('Respuesta del servidor:', xhr.responseText);

                let mensaje = 'Error al crear la copia del log';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    mensaje = xhr.responseText;
                }

                mostrarAlerta('danger', mensaje);
            },
            complete: function() {
                btn.prop('disabled', false).html('<i data-feather="copy" style="width: 16px; height: 16px;" class="me-2"></i>Crear Copia del Log');
                // Reinicializar Feather Icons
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            }
        });
    });

    // Ver contenido del log
    $(document).on('click', '.btn-ver', function() {
        const fileName = $(this).data('file');

        $.ajax({
            url: '{{ route("admin.logs.ver") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                file: fileName
            },
            beforeSend: function() {
                $('#logContent').html('<div class="text-center"><div class="spinner-border text-light" role="status"><span class="visually-hidden">Cargando...</span></div><p class="mt-2">Cargando contenido...</p></div>');
                $('#modalVerLog').modal('show');
            },
            success: function(response) {
                if (response.success) {
                    $('#logFileName').text(response.filename);
                    $('#logContent').text(response.content);
                    archivoActual = fileName;
                } else {
                    mostrarAlerta('danger', response.message);
                    $('#modalVerLog').modal('hide');
                }
            },
            error: function(xhr) {
                const mensaje = xhr.responseJSON?.message || 'Error al cargar el contenido del log';
                mostrarAlerta('danger', mensaje);
                $('#modalVerLog').modal('hide');
            }
        });
    });

    // Copiar contenido del log al portapapeles
    $('#btnCopiarContenido').click(function() {
        const contenido = $('#logContent').text();
        navigator.clipboard.writeText(contenido).then(function() {
            const btn = $('#btnCopiarContenido');
            const textoOriginal = btn.html();
            btn.html('<i data-feather="check" style="width: 14px; height: 14px;" class="me-1"></i> Copiado');
            // Reinicializar Feather Icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
            setTimeout(function() {
                btn.html(textoOriginal);
                // Reinicializar Feather Icons nuevamente
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            }, 2000);
        });
    });

    // Descargar desde modal
    $('#btnDescargarDesdeModal').click(function() {
        if (archivoActual) {
            window.location.href = '{{ url("admin/logs/descargar") }}/' + archivoActual;
        }
    });

    // Mostrar modal de confirmación para eliminar
    $(document).on('click', '.btn-eliminar', function() {
        archivoActual = $(this).data('file');
        $('#archivoAEliminar').text(archivoActual);
        $('#modalConfirmarEliminar').modal('show');
    });

    // Confirmar eliminación
    $('#btnConfirmarEliminar').click(function() {
        const btn = $(this);
        btn.prop('disabled', true);

        $.ajax({
            url: '{{ route("admin.logs.eliminar") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                file: archivoActual
            },
            success: function(response) {
                if (response.success) {
                    mostrarAlerta('success', response.message);
                    $(`tr[data-file="${archivoActual}"]`).fadeOut(400, function() {
                        $(this).remove();
                        verificarTablaVacia();
                    });
                    $('#modalConfirmarEliminar').modal('hide');
                } else {
                    mostrarAlerta('danger', response.message);
                }
            },
            error: function(xhr) {
                const mensaje = xhr.responseJSON?.message || 'Error al eliminar el archivo';
                mostrarAlerta('danger', mensaje);
            },
            complete: function() {
                btn.prop('disabled', false);
            }
        });
    });

    // Función para mostrar alertas
    function mostrarAlerta(tipo, mensaje) {
        const iconos = {
            success: 'check-circle-fill',
            danger: 'exclamation-circle-fill',
            warning: 'exclamation-triangle-fill',
            info: 'info-circle-fill'
        };

        const alerta = `
            <div class="alert alert-${tipo} alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-${iconos[tipo]} me-2"></i>
                <div>${mensaje}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        $('#alertContainer').html(alerta);

        setTimeout(function() {
            $('.alert').fadeOut(400, function() {
                $(this).remove();
            });
        }, 5000);
    }

    // Función para agregar una nueva fila a la tabla
    function agregarFilaTabla(backup) {
        // Eliminar mensaje de tabla vacía si existe
        $('#logsTableBody tr td[colspan]').parent().remove();

        const nuevaFila = `
            <tr data-file="${backup.name}" style="display: none;">
                <td>
                    <i data-feather="file-text" class="me-2 text-primary" style="width: 16px; height: 16px;"></i>
                    ${backup.name}
                </td>
                <td>${backup.size}</td>
                <td>${backup.date}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-info btn-ver" data-file="${backup.name}" title="Ver contenido">
                        <i data-feather="eye" style="width: 14px; height: 14px;"></i>
                    </button>
                    <a href="{{ url('admin/logs/descargar') }}/${backup.name}" class="btn btn-sm btn-success" title="Descargar">
                        <i data-feather="download" style="width: 14px; height: 14px;"></i>
                    </a>
                    <button class="btn btn-sm btn-danger btn-eliminar" data-file="${backup.name}" title="Eliminar">
                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                    </button>
                </td>
            </tr>
        `;

        $('#logsTableBody').prepend(nuevaFila);
        $(`tr[data-file="${backup.name}"]`).fadeIn(400, function() {
            // Reinicializar Feather Icons para los nuevos elementos
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    }

    // Verificar si la tabla está vacía
    function verificarTablaVacia() {
        if ($('#logsTableBody tr').length === 0) {
            const filaVacia = `
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i data-feather="inbox" style="width: 48px; height: 48px;"></i>
                        <p class="mt-2">No hay copias de logs disponibles. Crea una copia para comenzar.</p>
                    </td>
                </tr>
            `;
            $('#logsTableBody').html(filaVacia);
            // Reinicializar Feather Icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }
    }

    // Inicializar Feather Icons al cargar la página
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});
</script>
@endpush
@endsection

