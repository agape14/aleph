@extends('layouts.admin')

@section('title', 'Plantilla - Notificación por Email')

@section('content')
<div class="bg-dark-info pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Plantilla: Notificación por Email</h3>
                    <p class="text-white-50">Crea plantillas de email para notificaciones</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.gestor-contenido.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
                    </a>
                    <button class="btn btn-success btn-lg" onclick="guardarPlantilla()">
                        <i class="fas fa-save"></i> Guardar Plantilla
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Configuración de la plantilla -->
    <div class="row mt-6">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Configuración del Email</h5>
                </div>
                <div class="card-body">
                    <form id="formEmail">
                        <div class="mb-3">
                            <label for="tipo_notificacion" class="form-label">Tipo de Notificación</label>
                            <select class="form-select" id="tipo_notificacion" name="tipo_notificacion">
                                <option value="solicitud_recibida">Solicitud Recibida</option>
                                <option value="solicitud_aprobada">Solicitud Aprobada</option>
                                <option value="solicitud_rechazada">Solicitud Rechazada</option>
                                <option value="recordatorio">Recordatorio</option>
                                <option value="personalizada">Personalizada</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="asunto" class="form-label">Asunto del Email</label>
                            <input type="text" class="form-control" id="asunto" name="asunto"
                                   value="Notificación sobre su solicitud de beca" placeholder="Asunto del email">
                        </div>

                        <div class="mb-3">
                            <label for="remitente" class="form-label">Remitente</label>
                            <input type="email" class="form-control" id="remitente" name="remitente"
                                   value="becas@colegio.edu.pe" placeholder="Email del remitente">
                        </div>

                        <div class="mb-3">
                            <label for="nombre_remitente" class="form-label">Nombre del Remitente</label>
                            <input type="text" class="form-control" id="nombre_remitente" name="nombre_remitente"
                                   value="Oficina de Becas" placeholder="Nombre del remitente">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Variables Disponibles</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Puedes usar estas variables en el contenido:</p>
                    <div class="row">
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><code>{nombre_estudiante}</code></li>
                                <li><code>{apellidos_estudiante}</code></li>
                                <li><code>{dni_estudiante}</code></li>
                                <li><code>{codigo_sianet}</code></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><code>{fecha_solicitud}</code></li>
                                <li><code>{estado_solicitud}</code></li>
                                <li><code>{año_lectivo}</code></li>
                                <li><code>{nombre_colegio}</code></li>
                            </ul>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-primary" onclick="insertarVariable('{nombre_estudiante}')">
                        Insertar Variable
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Editor de contenido -->
    <div class="row mt-6">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Contenido del Email</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="contenido" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="contenido" name="contenido" rows="10"
                                  placeholder="Escribe el contenido del email aquí...">Estimado/a {nombre_estudiante},

Hemos recibido su solicitud de beca para el año lectivo {año_lectivo}.

Su solicitud se encuentra en estado: {estado_solicitud}

Le mantendremos informado sobre el proceso de evaluación.

Atentamente,
Oficina de Becas
{nombre_colegio}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="pie_email" class="form-label">Pie de Email</label>
                        <textarea class="form-control" id="pie_email" name="pie_email" rows="3"
                                  placeholder="Pie de email (opcional)">Este es un mensaje automático, por favor no responder a este email.

Para consultas, contactar a: becas@colegio.edu.pe</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vista previa -->
    <div class="row mt-6">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Vista Previa del Email</h5>
                </div>
                <div class="card-body">
                    <div id="vistaPreviaEmail" class="border p-4" style="min-height: 300px;">
                        <!-- La vista previa se generará aquí -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function guardarPlantilla() {
    // Implementar guardado de plantilla
    alert('Función de guardado de plantilla en desarrollo');
}

function insertarVariable(variable) {
    const textarea = document.getElementById('contenido');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const text = textarea.value;
    const before = text.substring(0, start);
    const after = text.substring(end, text.length);

    textarea.value = before + variable + after;
    textarea.focus();
    textarea.setSelectionRange(start + variable.length, start + variable.length);

    actualizarVistaPrevia();
}

function actualizarVistaPrevia() {
    const asunto = document.getElementById('asunto').value;
    const remitente = document.getElementById('remitente').value;
    const nombreRemitente = document.getElementById('nombre_remitente').value;
    const contenido = document.getElementById('contenido').value;
    const pie = document.getElementById('pie_email').value;

    // Reemplazar variables con datos de ejemplo
    const contenidoProcesado = contenido
        .replace(/{nombre_estudiante}/g, 'Juan Carlos')
        .replace(/{apellidos_estudiante}/g, 'Pérez García')
        .replace(/{dni_estudiante}/g, '12345678')
        .replace(/{codigo_sianet}/g, 'SJ2025001')
        .replace(/{fecha_solicitud}/g, new Date().toLocaleDateString('es-PE'))
        .replace(/{estado_solicitud}/g, 'En Revisión')
        .replace(/{año_lectivo}/g, document.getElementById('tipo_notificacion').value === 'solicitud_recibida' ? '2025' : '2025')
        .replace(/{nombre_colegio}/g, 'Colegio San José');

    const vistaPrevia = document.getElementById('vistaPreviaEmail');
    vistaPrevia.innerHTML = `
        <div class="email-preview">
            <div class="email-header border-bottom pb-2 mb-3">
                <strong>De:</strong> ${nombreRemitente} &lt;${remitente}&gt;<br>
                <strong>Asunto:</strong> ${asunto}
            </div>
            <div class="email-content">
                ${contenidoProcesado.replace(/\n/g, '<br>')}
            </div>
            ${pie ? `<div class="email-footer border-top pt-2 mt-3 text-muted small">
                ${pie.replace(/\n/g, '<br>')}
            </div>` : ''}
        </div>
    `;
}

// Actualizar vista previa cuando cambien los campos
document.addEventListener('DOMContentLoaded', function() {
    const campos = ['asunto', 'remitente', 'nombre_remitente', 'contenido', 'pie_email'];
    campos.forEach(campo => {
        document.getElementById(campo).addEventListener('input', actualizarVistaPrevia);
    });

    document.getElementById('tipo_notificacion').addEventListener('change', function() {
        // Cambiar contenido según el tipo de notificación
        const tipo = this.value;
        const contenido = document.getElementById('contenido');

        switch(tipo) {
            case 'solicitud_recibida':
                contenido.value = `Estimado/a {nombre_estudiante},

Hemos recibido su solicitud de beca para el año lectivo {año_lectivo}.

Su solicitud se encuentra en estado: {estado_solicitud}

Le mantendremos informado sobre el proceso de evaluación.

Atentamente,
Oficina de Becas
{nombre_colegio}`;
                break;
            case 'solicitud_aprobada':
                contenido.value = `Estimado/a {nombre_estudiante},

Nos complace informarle que su solicitud de beca ha sido APROBADA.

Detalles de la beca:
- Año lectivo: {año_lectivo}
- Estado: Aprobada
- Porcentaje: Por definir

Próximos pasos:
1. Revisar los términos y condiciones
2. Firmar el compromiso de beca
3. Presentar documentación adicional si es requerida

Atentamente,
Oficina de Becas
{nombre_colegio}`;
                break;
            case 'solicitud_rechazada':
                contenido.value = `Estimado/a {nombre_estudiante},

Lamentamos informarle que su solicitud de beca no ha sido aprobada para el año lectivo {año_lectivo}.

Motivos de la decisión:
- Evaluación de la situación económica
- Documentación presentada
- Criterios establecidos en el reglamento

Puede presentar una nueva solicitud en el próximo período.

Atentamente,
Oficina de Becas
{nombre_colegio}`;
                break;
        }

        actualizarVistaPrevia();
    });

    // Generar vista previa inicial
    actualizarVistaPrevia();
});
</script>
@endsection
