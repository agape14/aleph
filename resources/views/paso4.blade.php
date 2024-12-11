<form id="progenitor2Form" class="p-4 border rounded">
    <!-- Información del progenitor -->
    <h4 class="mt-4">Información del Progenitor 2</h4>
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
            <label for="prog2numeroDocumento" class="form-label"><strong>Número de Documento</strong></label>
            <input type="text" id="prog2numeroDocumento" class="form-control" placeholder="Ingrese el número de documento" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="nombres" class="form-label">Nombres</label>
        <input type="text" id="prog2nombres" class="form-control" placeholder="Nombres del progenitor" readonly>
    </div>
    <div class="mb-3">
        <label for="apellidos" class="form-label">Apellidos</label>
        <input type="text" id="prog2apellidos" class="form-control" placeholder="Apellidos del progenitor" readonly>
    </div>
    <hr>

    <!-- Número de hijos -->
    <div class="row g-3 mb-3">
        <div class="col-lg-6 col-12">
            <label for="prog2numeroHijos" class="form-label"><strong>Número de Hijos</strong></label>
            <input type="number" id="prog2numeroHijos" class="form-control" placeholder="Ingrese el número de hijos" min="0" required>
        </div>
        <div class="col-lg-6 col-12">
            <label for="prog2hijosMatriculados" class="form-label"><strong>Número de hijos matriculados en la institución</strong></label>
            <input type="number" id="prog2hijosMatriculados" class="form-control" placeholder="Ingrese el número de hijos matriculados" min="0" required>
        </div>
    </div>
    <hr>

    <!-- Formación académica -->
    <h5 class="mt-4">Formación Académica</h5>
    <div class="mb-3">
        <select id="prog2formacionAcademica" class="form-select" required>
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
            <input class="form-check-input" type="radio" name="prog2trabajoRemunerado" id="trabajoSi" value="si" required>
            <label class="form-check-label" for="trabajoSi">Sí</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="prog2trabajoRemunerado" id="trabajoNo" value="no">
            <label class="form-check-label" for="trabajoNo">No</label>
        </div>
    </div>

    <!-- Campos para "No tiene trabajo remunerado" -->
    <div id="desempleoCampos" class="d-none">
        <div class="mb-3">
            <label for="prog2tiempoDesempleo" class="form-label"><strong>Tiempo de desempleo (en meses)</strong></label>
            <input type="number" id="prog2tiempoDesempleo" class="form-control" placeholder="Ingrese el tiempo en meses" min="0">
        </div>
    </div>

    <!-- Campos para "Sí tiene trabajo remunerado" -->
    <div id="trabajoRemuneradoCampos" class="d-none">
        <div class="mb-3">
            <label class="form-label"><strong>¿Se encuentra en planilla?</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="prog2planilla" id="prog2planillaSi" value="si">
                <label class="form-check-label" for="prog2planillaSi">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="prog2planilla" id="prog2planillaNo" value="no">
                <label class="form-check-label" for="prog2planillaNo">No</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>¿Emite recibo por honorarios?</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="prog2honorarios" id="prog2honorariosSi" value="si">
                <label class="form-check-label" for="prog2honorariosSi">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="prog2honorarios" id="prog2honorariosNo" value="no">
                <label class="form-check-label" for="prog2honorariosNo">No</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>Tipo de sueldo</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="prog2tipoSueldo" id="prog2sueldoFijo" value="fijo">
                <label class="form-check-label" for="prog2sueldoFijo">Fijo</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="prog2tipoSueldo" id="prog2sueldoVariable" value="variable">
                <label class="form-check-label" for="prog2sueldoVariable">Variable</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="prog2cargo" class="form-label"><strong>Cargo que desempeña</strong></label>
            <input type="text" id="prog2cargo" class="form-control" placeholder="Ingrese su cargo">
        </div>
        <div class="mb-3">
            <label for="prog2anioLaboral" class="form-label"><strong>Desde qué año labora ahí</strong></label>
            <input type="number" id="prog2anioLaboral" class="form-control" placeholder="Ingrese el año" min="1900" max="2099">
        </div>
        <div class="mb-3">
            <label for="prog2lugarTrabajo" class="form-label"><strong>Lugar de trabajo</strong></label>
            <input type="text" id="prog2lugarTrabajo" class="form-control" placeholder="Ingrese el lugar de trabajo">
        </div>
        <div class="mb-3">
            <label for="prog2ingresos" class="form-label"><strong>Remuneración o ingresos brutos mensuales (S/)</strong></label>
            <input type="number" id="prog2ingresos" class="form-control" placeholder="Ingrese el monto en soles" min="0">
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>¿Durante el año percibe bonos?</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="prog2bonos" id="prog2bonosSi" value="si">
                <label class="form-check-label" for="prog2bonosSi">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="prog2bonos" id="prog2bonosNo" value="no">
                <label class="form-check-label" for="prog2bonosNo">No</label>
            </div>
        </div>
        <div class="mb-3 d-none" id="bonosMonto">
            <label for="prog2montoBonos" class="form-label"><strong>Monto aproximado de bonos (S/)</strong></label>
            <select id="prog2montoBonos" class="form-select">
                <option value="" selected disabled>Seleccione un rango</option>
                <option value="5000-10000">De S/5,000 a S/10,000</option>
                <option value="10000-15000">De S/10,000 a S/15,000</option>
                <option value="15000-mas">De S/15,000 a más</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>¿Durante el año percibe utilidades?</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="prog2utilidades" id="prog2utilidadesSi" value="si">
                <label class="form-check-label" for="prog2utilidadesSi">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="prog2utilidades" id="prog2utilidadesNo" value="no">
                <label class="form-check-label" for="prog2utilidadesNo">No</label>
            </div>
        </div>
        <div class="mb-3 d-none" id="utilidadesMonto">
            <label for="prog2montoUtilidades" class="form-label"><strong>Monto aproximado de utilidades (S/)</strong></label>
            <select id="prog2montoUtilidades" class="form-select">
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
                <input class="form-check-input" type="radio" name="prog2planilla" id="prog2planillaSi" value="si">
                <label class="form-check-label" for="prog2planillaSi">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="prog2planilla" id="prog2planillaNo" value="no">
                <label class="form-check-label" for="prog2planillaNo">No</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>¿Emite recibo por honorarios?</strong></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="prog2honorarios" id="prog2honorariosSi" value="si">
                <label class="form-check-label" for="prog2honorariosSi">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="prog2honorarios" id="prog2honorariosNo" value="no">
                <label class="form-check-label" for="prog2honorariosNo">No</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="prog2cargo" class="form-label"><strong>Cargo que desempeña</strong></label>
            <input type="text" id="prog2cargo" class="form-control" placeholder="Ingrese su cargo">
        </div>
        <div class="mb-3">
            <label for="prog2anioLaboral" class="form-label"><strong>Desde qué año labora ahí</strong></label>
            <input type="number" id="prog2anioLaboral" class="form-control" placeholder="Ingrese el año" min="1900" max="2099">
        </div>
        <div class="mb-3">
            <label for="prog2lugarTrabajo" class="form-label"><strong>Lugar de trabajo</strong></label>
            <input type="text" id="prog2lugarTrabajo" class="form-control" placeholder="Ingrese el lugar de trabajo">
        </div>
        <div class="mb-3">
            <label for="prog2ingresos" class="form-label"><strong>Remuneración o ingresos brutos mensuales (S/)</strong></label>
            <input type="number" id="prog2ingresos" class="form-control" placeholder="Ingrese el monto en soles" min="0">
        </div>
    </div>

    <!-- Información de vivienda -->
    <hr>
    <!-- Es titular o accionista de alguna empresa -->
    <div class="mb-3">
        <label class="form-label"><strong>¿Es titular o accionista de alguna empresa?</strong></label>
        <div class="form-check">
            <input type="radio" id="prog2titularSi" name="prog2titularEmpresa" class="form-check-input" value="Si" required>
            <label class="form-check-label" for="prog2titularSi">Sí</label>
        </div>
        <div class="form-check">
            <input type="radio" id="prog2titularNo" name="prog2titularEmpresa" class="form-check-input" value="No">
            <label class="form-check-label" for="prog2titularNo">No</label>
        </div>
    </div>
    <div id="titularCampos" class="d-none">
        <div class="mb-3">
            <label for="prog2acciones" class="form-label">Indique el % de acciones o participación:</label>
            <input type="number" id="prog2acciones" class="form-control" placeholder="Ingrese el porcentaje">
        </div>
        <div class="mb-3">
            <label for="prog2razonSocial" class="form-label">Precisar Razón Social:</label>
            <input type="text" id="prog2razonSocial" class="form-control" placeholder="Razón Social">
        </div>
        <div class="mb-3">
            <label for="prog2nroRuc" class="form-label">Precisar Nro de RUC:</label>
            <input type="text" id="prog2nroRuc" class="form-control" placeholder="Número de RUC">
        </div>
    </div>

    <!-- Información sobre su vivienda -->
    <div class="mb-3">
        <label class="form-label"><strong>Información sobre su vivienda</strong></label>
        <div class="form-check">
            <input type="radio" id="prog2viviendaPropia" name="prog2tipoVivienda" class="form-check-input" value="Propia" required>
            <label class="form-check-label" for="prog2viviendaPropia">Propia</label>
        </div>
        <div class="form-check">
            <input type="radio" id="prog2viviendaAlquilada" name="prog2tipoVivienda" class="form-check-input" value="Alquilada">
            <label class="form-check-label" for="prog2viviendaAlquilada">Alquilada</label>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">¿Cuenta con crédito hipotecario vigente?</label>
        <div class="form-check">
            <input type="radio" id="prog2creditoSi" name="prog2creditoHipotecario" class="form-check-input" value="Si">
            <label class="form-check-label" for="prog2creditoSi">Sí</label>
        </div>
        <div class="form-check">
            <input type="radio" id="prog2creditoNo" name="prog2creditoHipotecario" class="form-check-input" value="No">
            <label class="form-check-label" for="prog2creditoNo">No</label>
        </div>
    </div>
    <div id="viviendaDetalles">
        <div class="mb-3">
            <label for="prog2direccion" class="form-label">Especifique dirección:</label>
            <input type="text" id="prog2direccion" class="form-control" placeholder="Ingrese la dirección">
        </div>
        <div class="mb-3">
            <label for="prog2metros" class="form-label">Indicar m<sup>2</sup> aproximados:</label>
            <input type="number" id="prog2metros" class="form-control" placeholder="Metros cuadrados">
        </div>
    </div>

    <!-- Es propietario o copropietario de más de un inmueble -->
    <div class="mb-3">
        <label class="form-label"><strong>¿Es propietario o copropietario de más de un inmueble?</strong></label>
        <div class="form-check">
            <input type="radio" id="prog2inmuebleSi" name="prog2masInmuebles" class="form-check-input" value="Si">
            <label class="form-check-label" for="prog2inmuebleSi">Sí</label>
        </div>
        <div class="form-check">
            <input type="radio" id="prog2inmuebleNo" name="prog2masInmuebles" class="form-check-input" value="No">
            <label class="form-check-label" for="prog2inmuebleNo">No</label>
        </div>
    </div>
    <div id="inmueblesDetalles" class="d-none">
        <label for="prog2numInmuebles" class="form-label">N° de inmuebles:</label>
        <input type="number" id="prog2numInmuebles" class="form-control" placeholder="Ingrese el número de inmuebles">
    </div>
</form>
