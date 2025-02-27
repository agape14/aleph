@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4 mt-4">Configuración del Formulario</h2>

    <form action="{{ route('configuracion.update') }}" method="POST">
        @csrf
        <style>
            /* Aumentar tamaño del switch */
            .switch-lg {
                width: 2.5rem;
                height: 1.1rem;
            }

            .switch-lg:checked {
                background-color: #0d6efd !important;
            }

            .form-check-input {
                transform: scale(1.5); /* Agranda el interruptor */
            }
        </style>
        <div class="mb-3">
            <label class="form-label fw-bold d-block">Estado</label>
            <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input me-2 switch-lg" type="checkbox" id="estadoSwitch"
                    {{ old('valor', $config->valor) == 'activo' ? 'checked' : '' }}>
                <label class="form-check-label fw-bold" id="estadoLabel">
                    {{ old('valor', $config->valor) == 'activo' ? 'Activo' : 'Inactivo' }}
                </label>
            </div>
            <input type="hidden" id="estadoHidden" name="valor" value="{{ old('valor', $config->valor) }}">
        </div>

        {{-- Fecha Inicio --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Fecha Inicio</label>
            <input type="datetime-local" name="fecha_inicio" class="form-control" value="{{ $config->fecha_inicio }}">
        </div>

        {{-- Fecha Fin --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Fecha Fin</label>
            <input type="datetime-local" name="fecha_fin" class="form-control" value="{{ $config->fecha_fin }}">
        </div>

        {{-- Título del Mensaje --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Título del Mensaje</label>
            <input type="text" name="titulo_mensaje" class="form-control" value="{{ $config->titulo_mensaje }}">
        </div>

        {{-- Mensaje con CKEditor --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Mensaje</label>
            <textarea id="editor" name="mensaje" class="form-control">{!! $config->mensaje !!}</textarea>
            <small class="text-muted">Puedes usar HTML, por ejemplo: &lt;br&gt; para saltos de línea.</small>
        </div>

        {{-- Pie del Mensaje --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Pie del Mensaje</label>
            <input type="text" name="pie_mensaje" class="form-control" value="{{ $config->pie_mensaje }}">
        </div>

        <script>
            // Inicializar CKEditor
            ClassicEditor.create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });

            // Control del Switch de Estado
            document.getElementById('estadoSwitch').addEventListener('change', function() {
                let estadoLabel = document.getElementById('estadoLabel');
                let estadoHidden = document.getElementById('estadoHidden');

                if (this.checked) {
                    estadoLabel.textContent = 'Activo';
                    estadoHidden.value = 'activo';
                } else {
                    estadoLabel.textContent = 'Inactivo';
                    estadoHidden.value = 'inactivo';
                }
            });
        </script>

        {{-- Botón Guardar --}}
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
