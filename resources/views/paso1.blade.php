<div id="validacionpaso1">
    @if($textosDinamicos && $textosDinamicos->count() > 0)
        @foreach($textosDinamicos as $texto)
            @if($texto->clave === 'declaracion_jurada')
                <p class="text-justify">
                    {!! $texto->contenido !!}
                </p>
            @elseif($texto->clave === 'evaluacion_beca')
                <p class="text-justify">
                    {!! $texto->contenido !!}
                </p>
            @endif
        @endforeach
    @else
        {{-- Textos por defecto si no hay datos dinámicos --}}
        <p class="text-justify">
            <strong>La solicitud de beca</strong> tiene carácter de declaración jurada y su presentación da inicio a un
            procedimiento de evaluación del estado de necesidad económica de la familia solicitante a fin
            de acceder a una beca para el año lectivo {{ $añoActual }}.
        </p>
        <p class="text-justify">
            El otorgamiento de la beca y el porcentaje de la misma será determinado por el <strong>Colegio</strong>, que
            tiene la atribución de evaluar y verificar la información proporcionada, así como solicitar el
            sustento de la misma. La evaluación es una actividad interna y reservada del Colegio, por lo que
            únicamente los resultados serán comunicados a los padres o tutores.
        </p>
    @endif

    <div class="mb-3">
        <label class="form-label">
            <strong>
                1. Confirmo haber revisado y leído a detalle el
                @if($reglamentoBecas)
                    <a href="{{ $reglamentoBecas->url }}" target="_blank" class="text-primary">
                        {{ $reglamentoBecas->nombre }}
                    </a>:
                @else
                    <a href="{{ asset('files/REGLAMENTO DE BECAS ' . $añoActual . '.pdf') }}" target="_blank" class="text-primary">
                        Reglamento de Becas {{ $añoActual }}
                    </a>:
                @endif
            </strong>
        </label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="reglamento" id="opcionSi" value="Si" data-name="Si has leído el Reglamento de Becas" required>
            <label class="form-check-label" for="opcionSi">
                Sí
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="reglamento" id="opcionNo" value="No">
            <label class="form-check-label" for="opcionNo">
                No
            </label>
        </div>
    </div>
</div>
