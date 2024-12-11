
<form id="progenitor1Form" class="p-4 border rounded">
    <!-- Información del progenitor -->
    <h4 class="mt-4">Información del Progenitor 1</h4>
    <div class="row g-3 mb-3">
        <div class="col-lg-6 col-12">
            <label for="tipoDocumento" class="form-label"><strong>Tipo de Documento</strong></label>
            <select id="tipoDocumento" class="form-select" required>
                <option value="" selected disabled>Seleccione un tipo de documento</option>
                <option value="DNI">DNI</option>
                <option value="Pasaporte">Pasaporte</option>
                <option value="Carnet de Extranjería">Carnet de Extranjería</option>
            </select>
        </div>
        <div class="col-lg-6 col-12">
            <label for="numeroDocumento" class="form-label"><strong>Número de Documento</strong></label>
            <input type="text" id="numeroDocumento" class="form-control" placeholder="Ingrese el número de documento" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="nombres" class="form-label">Nombres</label>
        <input type="text" id="nombres" class="form-control" placeholder="Nombres del progenitor" readonly>
    </div>
    <div class="mb-3">
        <label for="apellidos" class="form-label">Apellidos</label>
        <input type="text" id="apellidos" class="form-control" placeholder="Apellidos del progenitor" readonly>
    </div>
    <hr>

    <!-- Número de hijos -->
    <div class="row g-3 mb-3">
        <div class="col-lg-6 col-12">
            <label for="numeroHijos" class="form-label"><strong>Número de Hijos</strong></label>
            <input type="number" id="numeroHijos" class="form-control" placeholder="Ingrese el número de hijos" min="0" required>
        </div>
        <div class="col-lg-6 col-12">
            <label for="hijosMatriculados" class="form-label"><strong>Número de hijos matriculados en la institución</strong></label>
            <input type="number" id="hijosMatriculados" class="form-control" placeholder="Ingrese el número de hijos matriculados" min="0" required>
        </div>
    </div>
    <hr>

    <!-- Formación académica -->
    <h5 class="mt-4">Formación Académica</h5>
    <div class="mb-3">
        <select id="formacionAcademica" class="form-select" required>
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
            <input class="form-check-input" type="radio" name="trabajoRemunerado" id="trabajoSi" value="si" required>
            <label class="form-check-label" for="trabajoSi">Sí</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="trabajoRemunerado" id="trabajoNo" value="no">
            <label class="form-check-label" for="trabajoNo">No</label>
        </div>
    </div>

    <!-- Campos para "No tiene trabajo remunerado" -->
    <div id="desempleoCampos" class="d-none">
        <div class="mb-3">
            <label for="tiempoDesempleo" class="form-label"><strong>Tiempo de desempleo (en meses)</strong></label>
            <input type="number" id="tiempoDesempleo" class="form-control" placeholder="Ingrese el tiempo en meses" min="0">
        </div>
    </div>

    <!-- Campos para "Sí tiene trabajo remunerado" -->
    <div id="trabajoRemuneradoCampos" class="d-none">
        <div class="mb-3">
            <label class="form-label"><strong>¿Se encuentra en planilla?</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="planilla" id="planillaSi" value="si">
                <label class="form-check-label" for="planillaSi">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="planilla" id="planillaNo" value="no">
                <label class="form-check-label" for="planillaNo">No</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>¿Emite recibo por honorarios?</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="honorarios" id="honorariosSi" value="si">
                <label class="form-check-label" for="honorariosSi">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="honorarios" id="honorariosNo" value="no">
                <label class="form-check-label" for="honorariosNo">No</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>Tipo de sueldo</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipoSueldo" id="sueldoFijo" value="fijo">
                <label class="form-check-label" for="sueldoFijo">Fijo</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipoSueldo" id="sueldoVariable" value="variable">
                <label class="form-check-label" for="sueldoVariable">Variable</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="cargo" class="form-label"><strong>Cargo que desempeña</strong></label>
            <input type="text" id="cargo" class="form-control" placeholder="Ingrese su cargo">
        </div>
        <div class="mb-3">
            <label for="anioLaboral" class="form-label"><strong>Desde qué año labora ahí</strong></label>
            <input type="number" id="anioLaboral" class="form-control" placeholder="Ingrese el año" min="1900" max="2099">
        </div>
        <div class="mb-3">
            <label for="lugarTrabajo" class="form-label"><strong>Lugar de trabajo</strong></label>
            <input type="text" id="lugarTrabajo" class="form-control" placeholder="Ingrese el lugar de trabajo">
        </div>
        <div class="mb-3">
            <label for="ingresos" class="form-label"><strong>Remuneración o ingresos brutos mensuales (S/)</strong></label>
            <input type="number" id="ingresos" class="form-control" placeholder="Ingrese el monto en soles" min="0">
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>¿Durante el año percibe bonos?</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="bonos" id="bonosSi" value="si">
                <label class="form-check-label" for="bonosSi">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="bonos" id="bonosNo" value="no">
                <label class="form-check-label" for="bonosNo">No</label>
            </div>
        </div>
        <div class="mb-3 d-none" id="bonosMonto">
            <label for="montoBonos" class="form-label"><strong>Monto aproximado de bonos (S/)</strong></label>
            <select id="montoBonos" class="form-select">
                <option value="" selected disabled>Seleccione un rango</option>
                <option value="5000-10000">De S/5,000 a S/10,000</option>
                <option value="10000-15000">De S/10,000 a S/15,000</option>
                <option value="15000-mas">De S/15,000 a más</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>¿Durante el año percibe utilidades?</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="utilidades" id="utilidadesSi" value="si">
                <label class="form-check-label" for="utilidadesSi">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="utilidades" id="utilidadesNo" value="no">
                <label class="form-check-label" for="utilidadesNo">No</label>
            </div>
        </div>
        <div class="mb-3 d-none" id="utilidadesMonto">
            <label for="montoUtilidades" class="form-label"><strong>Monto aproximado de utilidades (S/)</strong></label>
            <select id="montoUtilidades" class="form-select">
                <option value="" selected disabled>Seleccione un rango</option>
                <option value="5000-10000">De S/5,000 a S/10,000</option>
                <option value="10000-15000">De S/10,000 a S/15,000</option>
                <option value="15000-mas">De S/15,000 a más</option>
            </select>
        </div>
    </div>


    <!-- Campos habilitados si tiene trabajo remunerado -->
    <div id="trabajoRemuneradoCampos" class="d-none">
        <div class="mb-3">
            <label class="form-label"><strong>¿Se encuentra en planilla?</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="planilla" id="planillaSi" value="si">
                <label class="form-check-label" for="planillaSi">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="planilla" id="planillaNo" value="no">
                <label class="form-check-label" for="planillaNo">No</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>¿Emite recibo por honorarios?</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="honorarios" id="honorariosSi" value="si">
                <label class="form-check-label" for="honorariosSi">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="honorarios" id="honorariosNo" value="no">
                <label class="form-check-label" for="honorariosNo">No</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="cargo" class="form-label"><strong>Cargo que desempeña</strong></label>
            <input type="text" id="cargo" class="form-control" placeholder="Ingrese su cargo">
        </div>
        <div class="mb-3">
            <label for="anioLaboral" class="form-label"><strong>Desde qué año labora ahí</strong></label>
            <input type="number" id="anioLaboral" class="form-control" placeholder="Ingrese el año" min="1900" max="2099">
        </div>
        <div class="mb-3">
            <label for="lugarTrabajo" class="form-label"><strong>Lugar de trabajo</strong></label>
            <input type="text" id="lugarTrabajo" class="form-control" placeholder="Ingrese el lugar de trabajo">
        </div>
        <div class="mb-3">
            <label for="ingresos" class="form-label"><strong>Remuneración o ingresos brutos mensuales (S/)</strong></label>
            <input type="number" id="ingresos" class="form-control" placeholder="Ingrese el monto en soles" min="0">
        </div>
    </div>

    <!-- Información de vivienda -->
    <hr>
    <!-- Es titular o accionista de alguna empresa -->
    <div class="mb-3">
        <label class="form-label"><strong>¿Es titular o accionista de alguna empresa?</strong></label>
        <div class="form-check">
            <input type="radio" id="titularSi" name="titularEmpresa" class="form-check-input" value="Si" required>
            <label class="form-check-label" for="titularSi">Sí</label>
        </div>
        <div class="form-check">
            <input type="radio" id="titularNo" name="titularEmpresa" class="form-check-input" value="No">
            <label class="form-check-label" for="titularNo">No</label>
        </div>
    </div>
    <div id="titularCampos" class="d-none">
        <div class="mb-3">
            <label for="acciones" class="form-label">Indique el % de acciones o participación:</label>
            <input type="number" id="acciones" class="form-control" placeholder="Ingrese el porcentaje">
        </div>
        <div class="mb-3">
            <label for="razonSocial" class="form-label">Precisar Razón Social:</label>
            <input type="text" id="razonSocial" class="form-control" placeholder="Razón Social">
        </div>
        <div class="mb-3">
            <label for="nroRuc" class="form-label">Precisar Nro de RUC:</label>
            <input type="text" id="nroRuc" class="form-control" placeholder="Número de RUC">
        </div>
    </div>

    <!-- Información sobre su vivienda -->
    <div class="mb-3">
        <label class="form-label"><strong>Información sobre su vivienda</strong></label>
        <div class="form-check">
            <input type="radio" id="viviendaPropia" name="tipoVivienda" class="form-check-input" value="Propia" required>
            <label class="form-check-label" for="viviendaPropia">Propia</label>
        </div>
        <div class="form-check">
            <input type="radio" id="viviendaAlquilada" name="tipoVivienda" class="form-check-input" value="Alquilada">
            <label class="form-check-label" for="viviendaAlquilada">Alquilada</label>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">¿Cuenta con crédito hipotecario vigente?</label>
        <div class="form-check">
            <input type="radio" id="creditoSi" name="creditoHipotecario" class="form-check-input" value="Si">
            <label class="form-check-label" for="creditoSi">Sí</label>
        </div>
        <div class="form-check">
            <input type="radio" id="creditoNo" name="creditoHipotecario" class="form-check-input" value="No">
            <label class="form-check-label" for="creditoNo">No</label>
        </div>
    </div>
    <div id="viviendaDetalles">
        <div class="mb-3">
            <label for="direccion" class="form-label">Especifique dirección:</label>
            <input type="text" id="direccion" class="form-control" placeholder="Ingrese la dirección">
        </div>
        <div class="mb-3">
            <label for="metros" class="form-label">Indicar m<sup>2</sup> aproximados:</label>
            <input type="number" id="metros" class="form-control" placeholder="Metros cuadrados">
        </div>
    </div>

    <!-- Es propietario o copropietario de más de un inmueble -->
    <div class="mb-3">
        <label class="form-label"><strong>¿Es propietario o copropietario de más de un inmueble?</strong></label>
        <div class="form-check">
            <input type="radio" id="inmuebleSi" name="masInmuebles" class="form-check-input" value="Si">
            <label class="form-check-label" for="inmuebleSi">Sí</label>
        </div>
        <div class="form-check">
            <input type="radio" id="inmuebleNo" name="masInmuebles" class="form-check-input" value="No">
            <label class="form-check-label" for="inmuebleNo">No</label>
        </div>
    </div>
    <div id="inmueblesDetalles" class="d-none">
        <label for="numInmuebles" class="form-label">N° de inmuebles:</label>
        <input type="number" id="numInmuebles" class="form-control" placeholder="Ingrese el número de inmuebles">
    </div>
</form>
