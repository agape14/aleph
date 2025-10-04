@extends('layouts.admin')

@section('title', 'Plantilla - Reglamento de Becas')

@section('content')
<div class="bg-dark-info pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-2 mb-lg-0">
                    <h3 class="mb-0 text-white">Plantilla: Reglamento de Becas</h3>
                    <p class="text-white-50">Genera el reglamento de becas dinámicamente</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.gestor-contenido.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
                    </a>
                    <button class="btn btn-success btn-lg" onclick="generarPDF()">
                        <i class="fas fa-file-pdf"></i> Generar PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de configuración -->
    <div class="row mt-6">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Configuración del Reglamento</h5>
                </div>
                <div class="card-body">
                    <form id="formReglamento">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="año_lectivo" class="form-label">Año Lectivo</label>
                                    <input type="number" class="form-control" id="año_lectivo" name="año_lectivo"
                                           value="{{ date('Y') + 1 }}" min="{{ date('Y') }}" max="{{ date('Y') + 5 }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fecha_aprobacion" class="form-label">Fecha de Aprobación</label>
                                    <input type="date" class="form-control" id="fecha_aprobacion" name="fecha_aprobacion"
                                           value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="director" class="form-label">Director del Colegio</label>
                                    <input type="text" class="form-control" id="director" name="director"
                                           value="Dr. Juan Pérez" placeholder="Nombre del Director">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="colegio" class="form-label">Nombre del Colegio</label>
                                    <input type="text" class="form-control" id="colegio" name="colegio"
                                           value="Colegio San José" placeholder="Nombre del Colegio">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="porcentaje_maximo" class="form-label">Porcentaje Máximo de Beca</label>
                            <input type="number" class="form-control" id="porcentaje_maximo" name="porcentaje_maximo"
                                   value="100" min="1" max="100" step="1">
                        </div>

                        <div class="mb-3">
                            <label for="fecha_limite" class="form-label">Fecha Límite de Postulación</label>
                            <input type="date" class="form-control" id="fecha_limite" name="fecha_limite"
                                   value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Vista Previa</h5>
                </div>
                <div class="card-body">
                    <div id="vistaPrevia" class="border p-3" style="height: 400px; overflow-y: auto;">
                        <!-- La vista previa se generará aquí -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido del reglamento -->
    <div class="row mt-6">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Contenido del Reglamento</h5>
                </div>
                <div class="card-body">
                    <div id="contenidoReglamento">
                        <!-- El contenido se generará dinámicamente -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function generarPDF() {
    // Implementar generación de PDF
    alert('Función de generación de PDF en desarrollo');
}

function actualizarVistaPrevia() {
    const año = document.getElementById('año_lectivo').value;
    const director = document.getElementById('director').value;
    const colegio = document.getElementById('colegio').value;
    const porcentaje = document.getElementById('porcentaje_maximo').value;
    const fechaLimite = document.getElementById('fecha_limite').value;

    const vistaPrevia = document.getElementById('vistaPrevia');
    vistaPrevia.innerHTML = `
        <h4>REGLAMENTO DE BECAS ${año}</h4>
        <p><strong>Colegio:</strong> ${colegio}</p>
        <p><strong>Director:</strong> ${director}</p>
        <p><strong>Porcentaje máximo:</strong> ${porcentaje}%</p>
        <p><strong>Fecha límite:</strong> ${fechaLimite}</p>
    `;
}

// Actualizar vista previa cuando cambien los campos
document.addEventListener('DOMContentLoaded', function() {
    const campos = ['año_lectivo', 'director', 'colegio', 'porcentaje_maximo', 'fecha_limite'];
    campos.forEach(campo => {
        document.getElementById(campo).addEventListener('input', actualizarVistaPrevia);
    });

    // Generar vista previa inicial
    actualizarVistaPrevia();
});
</script>
@endsection
