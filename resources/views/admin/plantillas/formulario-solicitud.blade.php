@extends('layouts.admin')

@section('title', 'Plantilla - Formulario de Solicitud')

@section('content')
<div class="bg-dark-info pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Plantilla: Formulario de Solicitud</h3>
                    <p class="text-white-50">Genera formularios de solicitud personalizados</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.gestor-contenido.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
                    </a>
                    <button class="btn btn-success btn-lg" onclick="generarFormulario()">
                        <i class="fas fa-file-alt"></i> Generar Formulario
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Configuración del formulario -->
    <div class="row mt-6">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Configuración Básica</h5>
                </div>
                <div class="card-body">
                    <form id="formFormulario">
                        <div class="mb-3">
                            <label for="titulo_formulario" class="form-label">Título del Formulario</label>
                            <input type="text" class="form-control" id="titulo_formulario" name="titulo_formulario"
                                   value="Solicitud de Beca Académica" placeholder="Título del formulario">
                        </div>

                        <div class="mb-3">
                            <label for="año_lectivo" class="form-label">Año Lectivo</label>
                            <input type="number" class="form-control" id="año_lectivo" name="año_lectivo"
                                   value="{{ date('Y') + 1 }}" min="{{ date('Y') }}" max="{{ date('Y') + 5 }}">
                        </div>

                        <div class="mb-3">
                            <label for="instrucciones" class="form-label">Instrucciones Generales</label>
                            <textarea class="form-control" id="instrucciones" name="instrucciones" rows="4"
                                      placeholder="Instrucciones para llenar el formulario">Complete todos los campos requeridos. Los documentos deben estar en formato PDF, JPG o PNG. El tamaño máximo por archivo es 5MB.</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_limite" class="form-label">Fecha Límite de Entrega</label>
                            <input type="date" class="form-control" id="fecha_limite" name="fecha_limite"
                                   value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Campos del Formulario</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Secciones Incluidas</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="seccion_estudiante" checked>
                            <label class="form-check-label" for="seccion_estudiante">
                                Datos del Estudiante
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="seccion_progenitores" checked>
                            <label class="form-check-label" for="seccion_progenitores">
                                Datos de los Progenitores
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="seccion_economica" checked>
                            <label class="form-check-label" for="seccion_economica">
                                Situación Económica
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="seccion_documentos" checked>
                            <label class="form-check-label" for="seccion_documentos">
                                Documentos Adjuntos
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Campos Adicionales</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="campo_emergencia">
                            <label class="form-check-label" for="campo_emergencia">
                                Contacto de Emergencia
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="campo_medico">
                            <label class="form-check-label" for="campo_medico">
                                Información Médica
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="campo_transporte">
                            <label class="form-check-label" for="campo_transporte">
                                Información de Transporte
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vista previa del formulario -->
    <div class="row mt-6">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Vista Previa del Formulario</h5>
                </div>
                <div class="card-body">
                    <div id="vistaPreviaFormulario" class="border p-4" style="min-height: 500px;">
                        <!-- La vista previa se generará aquí -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function generarFormulario() {
    // Implementar generación del formulario
    alert('Función de generación de formulario en desarrollo');
}

function actualizarVistaPrevia() {
    const titulo = document.getElementById('titulo_formulario').value;
    const año = document.getElementById('año_lectivo').value;
    const instrucciones = document.getElementById('instrucciones').value;
    const fechaLimite = document.getElementById('fecha_limite').value;

    const vistaPrevia = document.getElementById('vistaPreviaFormulario');
    vistaPrevia.innerHTML = `
        <div class="text-center mb-4">
            <h2>${titulo}</h2>
            <h4>Año Lectivo ${año}</h4>
        </div>

        <div class="alert alert-info">
            <h5>Instrucciones:</h5>
            <p>${instrucciones}</p>
            <p><strong>Fecha límite de entrega:</strong> ${fechaLimite}</p>
        </div>

        <form>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nombres del Estudiante</label>
                        <input type="text" class="form-control" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Apellidos del Estudiante</label>
                        <input type="text" class="form-control" disabled>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">DNI del Estudiante</label>
                        <input type="text" class="form-control" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Código SIANET</label>
                        <input type="text" class="form-control" disabled>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="button" class="btn btn-primary" disabled>Enviar Solicitud</button>
            </div>
        </form>
    `;
}

// Actualizar vista previa cuando cambien los campos
document.addEventListener('DOMContentLoaded', function() {
    const campos = ['titulo_formulario', 'año_lectivo', 'instrucciones', 'fecha_limite'];
    campos.forEach(campo => {
        document.getElementById(campo).addEventListener('input', actualizarVistaPrevia);
    });

    // Generar vista previa inicial
    actualizarVistaPrevia();
});
</script>
@endsection
