@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4 mt-4">Configuración del Formulario</h2>
    {{--
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    --}}

    <form action="{{ route('configuracion.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold">Estado</label>
            <select name="valor" class="form-control">
                <option value="activo" {{ $config->valor == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ $config->valor == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Fecha Inicio</label>
            <input type="datetime-local" name="fecha_inicio" class="form-control" value="{{ $config->fecha_inicio }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Fecha Fin</label>
            <input type="datetime-local" name="fecha_fin" class="form-control" value="{{ $config->fecha_fin }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Mensaje</label>
            <textarea id="editor" name="mensaje" class="form-control">{{ $config->mensaje }}</textarea>
            <small class="text-muted">Puedes usar HTML, por ejemplo: &lt;br&gt; para saltos de línea.</small>
        </div>

        <script>
            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
        </script>


        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
