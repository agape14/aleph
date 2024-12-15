<div id="validacionpaso2">
    <!-- Sección de Identificación -->
    <h4 class="mt-4">Información del Estudiante</h4>
    <div class="row g-3 mb-3">
        <div class="col-lg-6 col-12">
            <label for="tipoDocumento" class="form-label"><strong>Tipo de Documento</strong></label>
            <select id="tipoDocumento" class="form-select" required data-name="Tipo de Documento">
                <option value="" selected disabled>Seleccione un tipo de documento</option>
                <option value="DNI">DNI</option>
                <option value="Pasaporte">Pasaporte</option>
                <option value="Carnet de Extranjería">Carnet de Extranjería</option>
            </select>
        </div>
        <div class="col-lg-6 col-12">
            <label for="nroDocumento" class="form-label"><strong>Número de Documento</strong></label>
            <div class="input-group">
                <input type="text" id="nroDocumento" class="form-control" placeholder="Ingrese el número de documento" data-name="Número de Documento" required>
                <button type="button" id="buscarEstudiante" class="btn btn-primary">Buscar</button>
            </div>
            <div class="invalid-feedback">
                El número de documento no es válido para el tipo seleccionado.
            </div>
        </div>
    </div>
    <hr>

    <!-- Datos del Estudiante -->
    <h5 class="mt-4">Datos del Estudiante</h5>
    <div class="mb-3">
        <input type="hidden" id="id_estudiante" name="id_estudiante" required data-name="Datos del Estudiante">
        <label for="nombres" class="form-label">Nombres</label>
        <input type="text" id="nombres" class="form-control" placeholder="Nombres del estudiante" readonly>
    </div>
    <div class="mb-3">
        <label for="apellidos" class="form-label">Apellidos</label>
        <input type="text" id="apellidos" class="form-control" placeholder="Apellidos del estudiante" readonly>
    </div>
    <div class="mb-3">
        <label for="codigo_sianet" class="form-label">Código Estudiante Sianet</label>
        <input type="text" id="codigo_sianet" name="codigo_sianet"  class="form-control" placeholder="Código Sianet del estudiante" readonly>
    </div>
    <hr>

    <!-- Pregunta 2 -->
    <h5 class="mt-4">2. ¿Vive con ambos progenitores?</h5>
    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="viveConProgenitores" id="ambosProgenitores" value="ambos" required data-name="Vive con Progenitores">
            <label class="form-check-label" for="ambosProgenitores">
                Sí
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="viveConProgenitores" id="unProgenitor" value="uno">
            <label class="form-check-label" for="unProgenitor">
                Sólo con 1 progenitor
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="viveConProgenitores" id="tiempoCompartido" value="compartido">
            <label class="form-check-label" for="tiempoCompartido">
                Tiempo compartido con ambos progenitores
            </label>
        </div>
    </div>
    <hr>

    <!-- Pregunta 3 -->
    <h5 class="mt-4">3. Marque los motivos por los que usted solicita la beca</h5>
    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="motivoEconomico" name="motivosBeca[]" value="economico" required data-name="Motivos para solicitar la beca">
            <label class="form-check-label" for="motivoEconomico">Económico</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="motivoSalud" name="motivosBeca[]" value="salud">
            <label class="form-check-label" for="motivoSalud">Salud</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="motivoHijosMatriculados" name="motivosBeca[]" value="hijosMatriculados">
            <label class="form-check-label" for="motivoHijosMatriculados">De 2 a más hijos matriculados en la institución educativa</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="motivoEducativasEspeciales" name="motivosBeca[]" value="educativasEspeciales">
            <label class="form-check-label" for="motivoEducativasEspeciales">Necesidades educativas especiales</label>
        </div>
    </div>
    <hr>

    <!-- Pregunta 4 -->
    <h5 class="mt-4">4. Cuéntanos las razones por las que han seleccionado los motivos en el ítem anterior</h5>
    <div class="mb-3">
        <label for="razones" class="form-label">Razones</label>
        <textarea id="razones" name="razones"  class="form-control" rows="4" placeholder="Explique las razones aquí" required data-name="Razones por las que han seleccionado los motivos"></textarea>
    </div>
</div>
