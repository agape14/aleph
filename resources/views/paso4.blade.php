
<div id="validacionpaso4">
    <!-- Información del progenitor -->
    <h4 class="mt-4">Información del Progenitor 2</h4>
    <div class="row g-3 mb-3">
        <div class="col-lg-6 col-12">
            <label for="tipoDocumento_Prog2" class="form-label"><strong>Tipo de Documento</strong></label>
            <select id="tipoDocumento_Prog2" name="tipoDocumento_Prog2" class="form-select"  data-name="Tipo de Documento" required>
                <option value="" selected disabled>Seleccione un tipo de documento</option>
                <option value="DNI">DNI</option>
                <option value="Pasaporte">Pasaporte</option>
                <option value="Carnet de Extranjería">Carnet de Extranjería</option>
            </select>
        </div>
        <div class="col-lg-6 col-12">
            <label for="numeroDocumento_Prog2" class="form-label"><strong>Número de Documento</strong></label>
            <div class="input-group">
                <input type="text" id="numeroDocumento_Prog2"  name="numeroDocumento_Prog2" class="form-control" placeholder="Ingrese el número de documento" required data-name="Número de Documento">
            </div>
            <div class="invalid-feedback">
                El número de documento no es válido para el tipo seleccionado.
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label for="nombres_Prog2" class="form-label">Nombres</label>
        <input type="text" id="nombres_Prog2" name="nombres_Prog2" class="form-control" placeholder="Nombres del progenitor" required data-name="Nombres del progenitor">
    </div>
    <div class="mb-3">
        <label for="apellidos_Prog2" class="form-label">Apellidos</label>
        <input type="text" id="apellidos_Prog2" name="apellidos_Prog2" class="form-control" placeholder="Apellidos del progenitor"  required data-name="Apellidos del progenitor">
    </div>
    <div class="mb-3">
        <label for="correo_Prog2" class="form-label">Correo Electrónico</label>
        <input type="email" id="correo_Prog2" name="correo_Prog2" class="form-control" placeholder="Correo Electrónico del progenitor" required data-name="Correo Electrónico del progenitor">
    </div>
    <hr>

    <!-- Número de hijos -->
    <div class="row g-3 mb-3">
        <div class="col-lg-6 col-12">
            <label for="numeroHijos_Prog2" class="form-label"><strong>Número de Hijos</strong></label>
            <input type="number" id="numeroHijos_Prog2" name="numeroHijos_Prog2" class="form-control" placeholder="Ingrese el número de hijos" min="0" required data-name="Número de Hijos">
        </div>
        <div class="col-lg-6 col-12">
            <label for="hijosMatriculados_Prog2" class="form-label"><strong>Número de hijos matriculados en la institución</strong></label>
            <input type="number" id="hijosMatriculados_Prog2" name="hijosMatriculados_Prog2" class="form-control" placeholder="Ingrese el número de hijos matriculados" min="0" required data-name="Número de Hijos matriculados">
        </div>
    </div>
    <hr>

    <!-- Formación académica -->
    <h5 class="mt-4">Formación Académica</h5>
    <div class="mb-3">
        <select id="formacionAcademica_Prog2" name="formacionAcademica_Prog2" class="form-select" required data-name="Formación Académica">
            <option value="" selected disabled>Seleccione su nivel de formación</option>
            <option value="tecnica">Formación Superior Técnica</option>
            <option value="universitaria">Formación Superior Universitaria</option>
            <option value="bachillerato">Bachillerato</option>
            <option value="titulado">Titulado</option>
            <option value="maestria">Maestría / Doctorado</option>
        </select>
    </div>
    <hr>

    <!-- Ocupación laboral -->
    <h5 class="mt-4">Ocupación Laboral e Ingresos</h5>

    <!-- ¿Tiene trabajo remunerado? -->
    <div class="mb-3">
        <label class="form-label"><strong>Actualmente, ¿se encuentra desempeñando un trabajo remunerado?</strong></label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="trabajoRemunerado_Prog2" id="trabajoSi_Prog2" value="si" required data-name="Ocupación Laboral e Ingresos">
            <label class="form-check-label" for="trabajoSi_Prog2">Sí</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="trabajoRemunerado_Prog2" id="trabajoNo_Prog2" value="no">
            <label class="form-check-label" for="trabajoNo_Prog2">No</label>
        </div>
    </div>

    <!-- Campos para "No tiene trabajo remunerado" -->
    <div id="desempleoCampos_Prog2" class="d-none">
        <div class="mb-3">
            <label for="tiempoDesempleo_Prog2" class="form-label"><strong>Tiempo de desempleo (en meses)</strong></label>
            <input type="number" id="tiempoDesempleo_Prog2" name="tiempoDesempleo_Prog2" class="form-control" placeholder="Ingrese el tiempo en meses" min="0" maxlength="10" data-name="Tiempo de desempleo (en meses)">
        </div>
    </div>

    <!-- Campos para "Sí tiene trabajo remunerado" -->
    <div id="trabajoRemuneradoCampos_Prog2" class="d-none">
        <div class="mb-3">
            <label class="form-label"><strong>¿Se encuentra en planilla?</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="planilla_Prog2" id="planillaSi_Prog2" value="si" data-name="Se encuentra en planilla">
                <label class="form-check-label" for="planillaSi_Prog2">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="planilla_Prog2" id="planillaNo_Prog2" value="no">
                <label class="form-check-label" for="planillaNo_Prog2">No</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>¿Emite recibo por honorarios?</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="honorarios_Prog2" id="honorariosSi_Prog2" value="si" data-name="Emite recibo por honorarios">
                <label class="form-check-label" for="honorariosSi_Prog2">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="honorarios_Prog2" id="honorariosNo_Prog2" value="no">
                <label class="form-check-label" for="honorariosNo_Prog2">No</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>Tipo de sueldo</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipoSueldo_Prog2" id="sueldoFijo_Prog2" value="fijo" data-name="Tipo de sueldo">
                <label class="form-check-label" for="sueldoFijo_Prog2">Fijo</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipoSueldo_Prog2" id="sueldoVariable_Prog2" value="variable" >
                <label class="form-check-label" for="sueldoVariable_Prog2">Variable</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="cargo_Prog2" class="form-label"><strong>Cargo que desempeña</strong></label>
            <input type="text" id="cargo_Prog2" name="cargo_Prog2" class="form-control" placeholder="Ingrese su cargo"  data-name="Cargo que desempeña" maxlength="250">
        </div>
        <div class="mb-3">
            <label for="anioLaboral_Prog2" class="form-label"><strong>Desde qué año labora ahí</strong></label>
            <input type="number" id="anioLaboral_Prog2" name="anioLaboral_Prog2" class="form-control" placeholder="Ingrese el año" min="1960" max="2099" data-name="Año labora">
        </div>
        <div class="mb-3">
            <label for="lugarTrabajo_Prog2" class="form-label"><strong>Lugar de trabajo</strong></label>
            <input type="text" id="lugarTrabajo_Prog2" name="lugarTrabajo_Prog2" class="form-control" placeholder="Ingrese el lugar de trabajo" data-name="Lugar de trabajo" maxlength="250">
        </div>
        <div class="mb-3">
            <label for="ingresos_Prog2" class="form-label"><strong>Remuneración o ingresos brutos mensuales (S/)</strong></label>
            <input type="number" id="ingresos_Prog2" name="ingresos_Prog2" class="form-control" placeholder="Ingrese el monto en soles" min="0" data-name="Remuneración o ingresos brutos mensuales">
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>¿Durante el año percibe bonos?</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="bonos_Prog2" id="bonosSi_Prog2" value="si" data-name="Percibe bonos">
                <label class="form-check-label" for="bonosSi_Prog2">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="bonos_Prog2" id="bonosNo_Prog2" value="no">
                <label class="form-check-label" for="bonosNo_Prog2">No</label>
            </div>
        </div>
        <div class="mb-3 d-none" id="bonosMonto_Prog2">
            <label for="montoBonos_Prog2" class="form-label"><strong>Monto aproximado de bonos (S/)</strong></label>
            <select id="montoBonos_Prog2" name="montoBonos_Prog2" class="form-select" data-name="Monto de bono">
                <option value="" selected disabled>Seleccione un rango</option>
                <option value="5000-10000">De S/5,000 a S/10,000</option>
                <option value="10000-15000">De S/10,000 a S/15,000</option>
                <option value="15000-mas">De S/15,000 a más</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>¿Durante el año percibe utilidades?</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="utilidades_Prog2" id="utilidadesSi_Prog2" value="si" data-name="Percibe utilidades">
                <label class="form-check-label" for="utilidades_Prog2">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="utilidades_Prog2" id="utilidadesNo_Prog2" value="no">
                <label class="form-check-label" for="utilidades_Prog2">No</label>
            </div>
        </div>
        <div class="mb-3 d-none" id="utilidadesMonto_Prog2">
            <label for="montoUtilidades_Prog2" class="form-label"><strong>Monto aproximado de utilidades (S/)</strong></label>
            <select id="montoUtilidades_Prog2" name="montoUtilidades_Prog2" class="form-select" data-name="Monto utilidades">
                <option value="" selected disabled>Seleccione un rango</option>
                <option value="5000-10000">De S/5,000 a S/10,000</option>
                <option value="10000-15000">De S/10,000 a S/15,000</option>
                <option value="15000-mas">De S/15,000 a más</option>
            </select>
        </div>
    </div>

    <!-- Información de vivienda -->
    <hr>
    <!-- Es titular o accionista de alguna empresa -->
    <div class="mb-3">
        <label class="form-label"><strong>¿Es titular o accionista de alguna empresa?</strong></label>
        <div class="form-check">
            <input type="radio" id="titularSi_Prog2" name="titularEmpresa_Prog2" class="form-check-input" value="Si" required data-name="Es titular o accionista de alguna empresa">
            <label class="form-check-label" for="titularSi_Prog2">Sí</label>
        </div>
        <div class="form-check">
            <input type="radio" id="titularNo_Prog2" name="titularEmpresa_Prog2" class="form-check-input" value="No">
            <label class="form-check-label" for="titularNo_Prog2">No</label>
        </div>
    </div>
    <div id="titularCampos_Prog2" class="d-none">
        <div class="mb-3">
            <label for="acciones_Prog2" class="form-label">Indique el % de acciones o participación:</label>
            <input type="number" id="acciones_Prog2" name="acciones_Prog2" class="form-control" placeholder="Ingrese el porcentaje" data-name="Porcentaje de acciones o participación" min="1" max="100" step="1">
        </div>
        <div class="mb-3">
            <label for="razonSocial_Prog2" class="form-label">Precisar Razón Social:</label>
            <input type="text" id="razonSocial_Prog2" name="razonSocial_Prog2" class="form-control" placeholder="Razón Social" data-name="Razón Social" maxlength="250">
        </div>
        <div class="mb-3">
            <label for="nroRuc_Prog2" class="form-label">Precisar Nro de RUC:</label>
            <input type="text" id="nroRuc_Prog2" name="nroRuc_Prog2" class="form-control"  placeholder="Número de RUC" data-name="Número de RUC" maxlength="11" minlength="11" pattern="\d{11}" >
        </div>
    </div>

    <!-- Información sobre su vivienda -->
    <div class="mb-3">
        <label class="form-label"><strong>Información sobre su vivienda</strong></label>
        <div class="form-check">
            <input type="radio" id="viviendaPropia_Prog2" name="tipoVivienda_Prog2" class="form-check-input" value="Propia" required data-name="Información sobre su vivienda">
            <label class="form-check-label" for="viviendaPropia_Prog2">Propia</label>
        </div>
        <div class="form-check">
            <input type="radio" id="viviendaAlquilada_Prog2" name="tipoVivienda_Prog2" class="form-check-input" value="Alquilada">
            <label class="form-check-label" for="viviendaAlquilada_Prog2">Alquilada</label>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">¿Cuenta con crédito hipotecario vigente?</label>
        <div class="form-check">
            <input type="radio" id="creditoSi_Prog2" name="creditoHipotecario_Prog2" class="form-check-input" value="Si" data-name="Crédito hipotecario vigente" required>
            <label class="form-check-label" for="creditoSi_Prog2">Sí</label>
        </div>
        <div class="form-check">
            <input type="radio" id="creditoNo_Prog2" name="creditoHipotecario_Prog2" class="form-check-input" value="No">
            <label class="form-check-label" for="creditoNo_Prog2">No</label>
        </div>
    </div>
    <div id="viviendaDetalles_Prog2">
        <div class="mb-3">
            <label for="direccion_Prog2" class="form-label">Especifique dirección:</label>
            <input type="text" id="direccion_Prog2" name="direccion_Prog2" class="form-control" placeholder="Ingrese la dirección" required data-name="Dirección" maxlength="250">
        </div>
        <div class="mb-3">
            <label for="metros_Prog2" class="form-label">Indicar m<sup>2</sup> aproximados:</label>
            <input type="number" id="metros_Prog2" name="metros_Prog2" class="form-control" placeholder="Metros cuadrados" required data-name="Metros cuadrados" maxlength="20">
        </div>
    </div>

    <!-- Es propietario o copropietario de más de un inmueble -->
    <div class="mb-3">
        <label class="form-label"><strong>¿Es propietario o copropietario de más de un inmueble?</strong></label>
        <div class="form-check">
            <input type="radio" id="inmuebleSi_Prog2" name="masInmuebles_Prog2" class="form-check-input" value="Si" data-name="Propietario o Copropietario">
            <label class="form-check-label" for="inmuebleSi_Prog2">Sí</label>
        </div>
        <div class="form-check">
            <input type="radio" id="inmuebleNo_Prog2" name="masInmuebles_Prog2" class="form-check-input" value="No">
            <label class="form-check-label" for="inmuebleNo_Prog2">No</label>
        </div>
    </div>
    <div id="inmueblesDetalles_Prog2" class="d-none">
        <label for="numInmuebles_Prog2" class="form-label">N° de inmuebles:</label>
        <input type="number" id="numInmuebles_Prog2" name="numInmuebles_Prog2" class="form-control" placeholder="Ingrese el número de inmuebles" data-name="Número de inmuebles" min="1" max="1000" step="1">
    </div>
</div>
