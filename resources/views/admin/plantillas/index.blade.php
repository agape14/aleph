@extends('layouts.admin')

@section('title', 'Plantillas de Documentos - Gestor de Contenido')

@section('content')
<div class="bg-dark-info pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Plantillas de Documentos</h3>
                    <p class="text-white-50">Genera documentos personalizados para el sistema de becas</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.gestor-contenido.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de plantillas -->
    <div class="row mt-6">
        @foreach($plantillas as $plantilla)
        <div class="col-xl-4 col-lg-6 col-md-6 col-12 mt-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-shape icon-lg bg-{{ $plantilla['color'] }} text-white rounded-2 me-3">
                            <i class="{{ $plantilla['icono'] }} fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ $plantilla['nombre'] }}</h5>
                            <p class="text-muted mb-0">{{ $plantilla['descripcion'] }}</p>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.plantillas.show', $plantilla['id']) }}"
                           class="btn btn-{{ $plantilla['color'] }} btn-sm flex-fill">
                            <i class="fas fa-edit"></i> Crear
                        </a>
                        <button class="btn btn-outline-{{ $plantilla['color'] }} btn-sm"
                                onclick="mostrarEjemplo('{{ $plantilla['id'] }}')">
                            <i class="fas fa-eye"></i> Ver Ejemplo
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Plantillas guardadas -->
    <div class="row mt-6">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Plantillas Guardadas</h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">No hay plantillas guardadas</h6>
                        <p class="text-muted">Las plantillas que crees se guardarán aquí para uso futuro.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de ejemplo -->
<div class="modal fade" id="modalEjemplo" tabindex="-1" aria-labelledby="modalEjemploLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEjemploLabel">Ejemplo de Plantilla</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="contenidoEjemplo">
                    <!-- El contenido del ejemplo se cargará aquí -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="crearDesdeEjemplo()">Crear desde Ejemplo</button>
            </div>
        </div>
    </div>
</div>

<script>
function mostrarEjemplo(plantillaId) {
    const ejemplos = {
        'reglamento-becas': `
            <h4>REGLAMENTO DE BECAS 2025</h4>
            <h5>COLEGIO SAN JOSÉ</h5>

            <h6>CAPÍTULO I - DISPOSICIONES GENERALES</h6>
            <p><strong>Artículo 1°.-</strong> El presente reglamento tiene por objeto establecer las normas y procedimientos para el otorgamiento de becas académicas en el Colegio San José.</p>

            <h6>CAPÍTULO II - TIPOS DE BECAS</h6>
            <p><strong>Artículo 2°.-</strong> Se establecen los siguientes tipos de becas:</p>
            <ul>
                <li>Beca por Excelencia Académica</li>
                <li>Beca por Necesidad Económica</li>
                <li>Beca Deportiva</li>
                <li>Beca Cultural</li>
            </ul>

            <h6>CAPÍTULO III - REQUISITOS</h6>
            <p><strong>Artículo 3°.-</strong> Los requisitos para postular a una beca son:</p>
            <ol>
                <li>Ser estudiante regular del colegio</li>
                <li>Presentar documentación completa</li>
                <li>Cumplir con los criterios establecidos</li>
            </ol>
        `,
        'formulario-solicitud': `
            <h4>SOLICITUD DE BECA ACADÉMICA</h4>
            <h5>Año Lectivo 2025</h5>

            <div class="border p-3">
                <h6>DATOS DEL ESTUDIANTE</h6>
                <div class="row">
                    <div class="col-md-6">
                        <label>Nombres:</label>
                        <input type="text" class="form-control" disabled>
                    </div>
                    <div class="col-md-6">
                        <label>Apellidos:</label>
                        <input type="text" class="form-control" disabled>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>DNI:</label>
                        <input type="text" class="form-control" disabled>
                    </div>
                    <div class="col-md-6">
                        <label>Código SIANET:</label>
                        <input type="text" class="form-control" disabled>
                    </div>
                </div>
            </div>
        `,
        'notificacion-email': `
            <div class="email-preview">
                <div class="email-header border-bottom pb-2 mb-3">
                    <strong>De:</strong> Oficina de Becas &lt;becas@colegio.edu.pe&gt;<br>
                    <strong>Asunto:</strong> Notificación sobre su solicitud de beca
                </div>
                <div class="email-content">
                    <p>Estimado/a Juan Carlos,</p>
                    <p>Hemos recibido su solicitud de beca para el año lectivo 2025.</p>
                    <p>Su solicitud se encuentra en estado: En Revisión</p>
                    <p>Le mantendremos informado sobre el proceso de evaluación.</p>
                    <p>Atentamente,<br>Oficina de Becas<br>Colegio San José</p>
                </div>
            </div>
        `
    };

    document.getElementById('contenidoEjemplo').innerHTML = ejemplos[plantillaId] || '<p>Ejemplo no disponible</p>';
    document.getElementById('modalEjemploLabel').textContent = 'Ejemplo: ' + plantillaId.replace('-', ' ').toUpperCase();

    const modal = new bootstrap.Modal(document.getElementById('modalEjemplo'));
    modal.show();
}

function crearDesdeEjemplo() {
    // Redirigir a la plantilla correspondiente
    const plantillaId = document.getElementById('modalEjemploLabel').textContent.split(': ')[1].toLowerCase().replace(' ', '-');
    window.location.href = `/admin/plantillas/${plantillaId}`;
}
</script>
@endsection
