@extends('layouts.app')

@section('title', 'Página Principal')

@section('content')

      <!-- home section -->
      <section class="home bg-light" id="home">
        <!-- start container -->
        <div class="container">
            <!-- start row -->
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="images/aleph-icon-rbg.png" alt="" class="img-fluid mb-4 smallphone-image">
                    <h1>Educación innovadora</h1>
                    <h3 >para las soluciones del mañana.</h3>
                    <!--<p class="mt-4 text-muted">Nuestra metodología educativa está alineada con las neurociencias y los últimos estudios sobre el aprendizaje efectivo y significativo.</p>
                    <button class="btn bg-gradiant mt-4" href="#contact">Ver mas</button>-->
                    <a class="btn bg-gradiant mt-4" href="#contact">Ver más</a>
                </div>



                <div class="col-lg-5 offset-md-1 ">
                    <img src="images/img-aleph.jpeg" alt="" class="img-fluid">
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->

        <div class="background-line"></div>
    </section>
    <!-- end home section -->

    <!-- contact section -->
    <section class="section contact overflow-hidden" id="contact">
        <!-- start container -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="title text-center mb-5">
                        <!--<h6 class="mb-0 fw-bold text-primary">Contact Us</h6>-->
                        <h2 class="f-40">SOLICITUD DE BECA PARA EL PERÍODO ACADÉMICO 2025!</h2>
                    </div>
                </div>
            </div>

            <div class="row align-items-center ">
                <div class="col-md-12 mb-4">
                    <div class="container mt-5">
                        <div class="stepper-wrapper">
                            <div class="stepper-item active">
                                <div class="step-counter">1</div>
                                <div class="step-label">Inicio</div>
                            </div>
                            <div class="stepper-item">
                                <div class="step-counter">2</div>
                                <div class="step-label">Estudiante</div>
                            </div>
                            <div class="stepper-item">
                                <div class="step-counter">3</div>
                                <div class="step-label">Progenitor 1</div>
                            </div>
                            <div class="stepper-item">
                                <div class="step-counter">4</div>
                                <div class="step-label">Progenitor 2</div>
                            </div>
                            <div class="stepper-item">
                                <div class="step-counter">5</div>
                                <div class="step-label">Situación Económica</div>
                            </div>
                            <div class="stepper-item">
                                <div class="step-counter">6</div>
                                <div class="step-label">General</div>
                            </div>
                        </div>

                        <div class="form mt-4">
                            <!-- Example Form -->
                            <div class="form-step d-block">
                                <form class="p-4 border rounded">
                                    <p class="text-justify">
                                        <strong>La solicitud de beca</strong> tiene carácter de declaración jurada y su presentación da inicio a un
                                        procedimiento de evaluación del estado de necesidad económica de la familia solicitante a fin
                                        de acceder a una beca para el año lectivo 2025.
                                    </p>
                                    <p class="text-justify">
                                        El otorgamiento de la beca y el porcentaje de la misma será determinado por el <strong>Colegio</strong>, que
                                        tiene la atribución de evaluar y verificar la información proporcionada, así como solicitar el
                                        sustento de la misma. La evaluación es una actividad interna y reservada del Colegio, por lo que
                                        únicamente los resultados serán comunicados a los padres o tutores.
                                    </p>
                                    <ul class="list-group list-group-flush mb-4">
                                        <li class="list-group-item"><strong>1.</strong> Solicitud de beca para el período académico 2025</li>
                                        <li class="list-group-item"><strong>2.</strong> Año lectivo 2025</li>
                                        <li class="list-group-item"><strong>3.</strong> Reglamento de Becas 2025</li>
                                    </ul>
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <strong>
                                                1. Confirmo haber revisado y leído a detalle el
                                                <a href="{{ asset('files/Revisión Formulario Beca 2025.pdf') }}" target="_blank" class="text-primary">
                                                    Reglamento de Becas 2025
                                                </a>:
                                            </strong>
                                        </label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="reglamento" id="opcionSi" value="Si" required>
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
                                </form>
                            </div>

                            <div class="form-step d-none">
                                <!-- Paso 2: Message -->
                                <form id="estudianteForm " class="p-4 border rounded">
                                    <!-- Sección de Identificación -->
                                    <h4 class="mt-4">Información del Estudiante</h4>
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
                                            <label for="nroDocumento" class="form-label"><strong>Número de Documento</strong></label>
                                            <input type="text" id="nroDocumento" class="form-control" placeholder="Ingrese el número de documento" required>
                                            <div class="invalid-feedback">
                                                El número de documento no es válido para el tipo seleccionado.
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <!-- Datos del Estudiante -->
                                    <h5 class="mt-4">Datos del Estudiante</h5>
                                    <div class="mb-3">
                                        <label for="nombres" class="form-label">Nombres</label>
                                        <input type="text" id="nombres" class="form-control" placeholder="Nombres del estudiante" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellidos" class="form-label">Apellidos</label>
                                        <input type="text" id="apellidos" class="form-control" placeholder="Apellidos del estudiante" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="codigoBCP" class="form-label">Código Sianet Estudiante</label>
                                        <input type="text" id="codigoBCP" class="form-control" placeholder="Código Sianet del estudiante" maxlength="15" required>
                                    </div>
                                    <hr>

                                    <!-- Pregunta 2 -->
                                    <h5 class="mt-4">2. ¿Vive con ambos progenitores?</h5>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="viveConProgenitores" id="ambosProgenitores" value="ambos" required>
                                            <label class="form-check-label" for="ambosProgenitores">
                                                Sí (habilitar Progenitor 1 y Progenitor 2)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="viveConProgenitores" id="unProgenitor" value="uno">
                                            <label class="form-check-label" for="unProgenitor">
                                                Sólo con 1 progenitor (habilitar solo Progenitor 1)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="viveConProgenitores" id="tiempoCompartido" value="compartido">
                                            <label class="form-check-label" for="tiempoCompartido">
                                                Tiempo compartido con ambos progenitores (habilitar solo Progenitor 1)
                                            </label>
                                        </div>
                                    </div>
                                    <hr>

                                    <!-- Pregunta 3 -->
                                    <h5 class="mt-4">3. Marque los motivos por los que usted solicita la beca</h5>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="motivoEconomico" value="economico">
                                            <label class="form-check-label" for="motivoEconomico">Económico</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="motivoSalud" value="salud">
                                            <label class="form-check-label" for="motivoSalud">Salud</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="motivoHijosMatriculados" value="hijosMatriculados">
                                            <label class="form-check-label" for="motivoHijosMatriculados">De 2 a más hijos matriculados en la institución educativa</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="motivoEducativasEspeciales" value="educativasEspeciales">
                                            <label class="form-check-label" for="motivoEducativasEspeciales">Necesidades educativas especiales</label>
                                        </div>
                                    </div>
                                    <hr>

                                    <!-- Pregunta 4 -->
                                    <h5 class="mt-4">4. Cuéntanos las razones por las que han seleccionado los motivos en el ítem anterior</h5>
                                    <div class="mb-3">
                                        <label for="razones" class="form-label">Razones</label>
                                        <textarea id="razones" class="form-control" rows="4" placeholder="Explique las razones aquí"></textarea>
                                    </div>
                                </form>


                            </div>
                            <div class="form-step d-none">
                                <!-- Paso 3:  -->
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

                            </div>
                            <div class="form-step d-none">
                                <!-- Paso 4:  -->
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
                            </div>
                            <div class="form-step  d-none">
                                <!-- Paso 5-->
                                <form id="ingresosGastosForm" class="p-4 border rounded">
                                    <h3>Ingresos y Gastos Mensuales</h3>

                                    <!-- Sección de INGRESOS -->
                                    <h4 class="mt-4">INGRESOS</h4>
                                    <div class="row mb-3">
                                        <label for="remuneracionPlanilla" class="col-sm-6 col-form-label">Remuneración mensual - planilla</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="remuneracionPlanilla" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="honorarios" class="col-sm-6 col-form-label">Honorarios profesionales</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="honorarios" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pensionista" class="col-sm-6 col-form-label">Pensionista / Jubilación</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="pensionista" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="rentasInmuebles" class="col-sm-6 col-form-label">Rentas por alquiler de inmuebles</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="rentasInmuebles" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="rentasVehiculos" class="col-sm-6 col-form-label">Rentas por alquiler de vehículos</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="rentasVehiculos" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="otrosIngresos" class="col-sm-6 col-form-label">Otros ingresos <span class="text-muted">(detallar)</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="otrosIngresos" class="form-control" placeholder="Detalle otros ingresos">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="totalIngresos" class="col-sm-6 col-form-label"><strong>TOTAL DE INGRESOS MENSUALES</strong></label>
                                        <div class="col-sm-6">
                                            <input type="number" id="totalIngresos" class="form-control" placeholder="S/ 0.00" disabled>
                                        </div>
                                    </div>

                                    <!-- Sección de GASTOS -->
                                    <h4 class="mt-4">GASTOS TOTALES</h4>
                                    <div class="row mb-3">
                                        <label for="numHijos" class="col-sm-6 col-form-label">Número de hijos</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="numHijos" class="form-control" placeholder="Número de hijos">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pagoColegios" class="col-sm-6 col-form-label">Pago por colegios</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="pagoColegios" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pagoTalleres" class="col-sm-6 col-form-label">Pago por talleres</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="pagoTalleres" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pagoUniversidad" class="col-sm-6 col-form-label">Pago por universidad/ estudios diversos</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="pagoUniversidad" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pagoAlimentacion" class="col-sm-6 col-form-label">Pago por alimentación familiar</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="pagoAlimentacion" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pagoAlquiler" class="col-sm-6 col-form-label">Alquiler departamento/casa</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="pagoAlquiler" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pagoCreditoPersonal" class="col-sm-6 col-form-label">Pago por crédito personal</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="pagoCreditoPersonal" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pagoCreditoHipotecario" class="col-sm-6 col-form-label">Pago por crédito hipotecario</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="pagoCreditoHipotecario" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pagoCreditoVehicular" class="col-sm-6 col-form-label">Pago por crédito vehicular</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="pagoCreditoVehicular" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pagoServicios" class="col-sm-6 col-form-label">Pago total por servicio de agua, luz, teléfono, internet</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="pagoServicios" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pagoMantenimiento" class="col-sm-6 col-form-label">Pago por servicio de mantenimiento</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="pagoMantenimiento" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pagoApoyoCasa" class="col-sm-6 col-form-label">Pago total persona de apoyo en casa</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="pagoApoyoCasa" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pagoClubes" class="col-sm-6 col-form-label">Pago por asociación en clubes</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="pagoClubes" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pagoSeguros" class="col-sm-6 col-form-label">Pago por seguros de salud</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="pagoSeguros" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pagoApoyoFamiliar" class="col-sm-6 col-form-label">Pago por apoyo familiar</label>
                                        <div class="col-sm-6">
                                            <input type="number" id="pagoApoyoFamiliar" class="form-control" placeholder="S/ 0.00">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="otrosGastos" class="col-sm-6 col-form-label">Otros gastos <span class="text-muted">(detallar)</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="otrosGastos" class="form-control" placeholder="Detalle otros gastos">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="totalGastos" class="col-sm-6 col-form-label"><strong>TOTAL DE GASTOS MENSUALES</strong></label>
                                        <div class="col-sm-6">
                                            <input type="number" id="totalGastos" class="form-control" placeholder="S/ 0.00" disabled>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="form-step">
                                <form id="documentosForm" class="p-4 border rounded">
                                    <h3>General</h3>

                                    <h4 class="mt-4">Progenitor 1</h4>
                                    <div class="row mb-3">
                                        <label for="boletasPagoProgenitor1" class="col-sm-6 col-form-label">1. Copia de las boletas de pago o recibo por honorarios de ambos progenitores o del tutor, correspondiente a los 3 meses anteriores al mes de presentación de la solicitud</label>
                                        <div class="col-sm-6">
                                            <input type="file" id="boletasPagoProgenitor1" class="form-control" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="noAplicaBoletasPagoProgenitor1">
                                                <label class="form-check-label" for="noAplicaBoletasPagoProgenitor1">
                                                    No aplica
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="declaracionJuradaProgenitor1" class="col-sm-6 col-form-label">2. Copia de la declaración Jurada anual del impuesto a la renta correspondiente al año inmediato anterior, de ambos progenitores y del tutor si fuera el caso</label>
                                        <div class="col-sm-6">
                                            <input type="file" id="declaracionJuradaProgenitor1" class="form-control" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="noAplicaDeclaracionJuradaProgenitor1">
                                                <label class="form-check-label" for="noAplicaDeclaracionJuradaProgenitor1">
                                                    No aplica
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="certificadoMovimientosProgenitor1" class="col-sm-6 col-form-label">3. Certificado de movimientos migratorios de ambos progenitores, correspondientes al 2023 y 2024</label>
                                        <div class="col-sm-6">
                                            <input type="file" id="certificadoMovimientosProgenitor1" class="form-control" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="noAplicaCertificadoMovimientosProgenitor1">
                                                <label class="form-check-label" for="noAplicaCertificadoMovimientosProgenitor1">
                                                    No aplica
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="constanciaBusquedaRegistrosProgenitor1" class="col-sm-6 col-form-label">4. Constancia expedida por los Registros Públicos del resultado de la búsqueda de bienes muebles e inmuebles con el nombre de cada uno de los progenitores y/o tutor</label>
                                        <div class="col-sm-6">
                                            <input type="file" id="constanciaBusquedaRegistrosProgenitor1" class="form-control" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="noAplicaConstanciaBusquedaRegistrosProgenitor1">
                                                <label class="form-check-label" for="noAplicaConstanciaBusquedaRegistrosProgenitor1">
                                                    No aplica
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="otrosDocumentosProgenitor1" class="col-sm-6 col-form-label">5. Cualquier otro documento que consideren relevante para sustentar la necesidad económica</label>
                                        <div class="col-sm-6">
                                            <input type="file" id="otrosDocumentosProgenitor1" class="form-control" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="noAplicaOtrosDocumentosProgenitor1">
                                                <label class="form-check-label" for="noAplicaOtrosDocumentosProgenitor1">
                                                    No aplica
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="mt-4">Progenitor 2</h4>
                                    <div class="row mb-3">
                                        <label for="boletasPagoProgenitor2" class="col-sm-6 col-form-label">1. Copia de las boletas de pago o recibo por honorarios de ambos progenitores o del tutor, correspondiente a los 3 meses anteriores al mes de presentación de la solicitud</label>
                                        <div class="col-sm-6">
                                            <input type="file" id="boletasPagoProgenitor2" class="form-control" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="noAplicaBoletasPagoProgenitor2">
                                                <label class="form-check-label" for="noAplicaBoletasPagoProgenitor2">
                                                    No aplica
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="declaracionJuradaProgenitor2" class="col-sm-6 col-form-label">2. Copia de la declaración Jurada anual del impuesto a la renta correspondiente al año inmediato anterior, de ambos progenitores y del tutor si fuera el caso</label>
                                        <div class="col-sm-6">
                                            <input type="file" id="declaracionJuradaProgenitor2" class="form-control" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="noAplicaDeclaracionJuradaProgenitor2">
                                                <label class="form-check-label" for="noAplicaDeclaracionJuradaProgenitor2">
                                                    No aplica
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="certificadoMovimientosProgenitor2" class="col-sm-6 col-form-label">3. Certificado de movimientos migratorios de ambos progenitores, correspondientes al 2023 y 2024</label>
                                        <div class="col-sm-6">
                                            <input type="file" id="certificadoMovimientosProgenitor2" class="form-control" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="noAplicaCertificadoMovimientosProgenitor2">
                                                <label class="form-check-label" for="noAplicaCertificadoMovimientosProgenitor2">
                                                    No aplica
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="constanciaBusquedaRegistrosProgenitor2" class="col-sm-6 col-form-label">4. Constancia expedida por los Registros Públicos del resultado de la búsqueda de bienes muebles e inmuebles con el nombre de cada uno de los progenitores y/o tutor</label>
                                        <div class="col-sm-6">
                                            <input type="file" id="constanciaBusquedaRegistrosProgenitor2" class="form-control" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="noAplicaConstanciaBusquedaRegistrosProgenitor2">
                                                <label class="form-check-label" for="noAplicaConstanciaBusquedaRegistrosProgenitor2">
                                                    No aplica
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="otrosDocumentosProgenitor2" class="col-sm-6 col-form-label">5. Cualquier otro documento que consideren relevante para sustentar la necesidad económica</label>
                                        <div class="col-sm-6">
                                            <input type="file" id="otrosDocumentosProgenitor2" class="form-control" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="noAplicaOtrosDocumentosProgenitor2">
                                                <label class="form-check-label" for="noAplicaOtrosDocumentosProgenitor2">
                                                    No aplica
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button id="prev-btn" class="btn btn-secondary" type="button" disabled>← Anterior</button>
                                <button id="next-btn" class="btn btn-primary" type="button">Siguiente →</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <script>
            document.addEventListener("DOMContentLoaded", function () {
                 // Selecciona todos los inputs de tipo texto
                const textInputs = document.querySelectorAll('input[type="text"]');

                textInputs.forEach(input => {
                    input.addEventListener("input", function () {
                        // Convierte el valor del input a mayúsculas
                        this.value = this.value.toUpperCase();
                    });
                });
                const stepperItems = document.querySelectorAll(".stepper-item");
                const formSteps = document.querySelectorAll(".form-step");
                const prevBtn = document.getElementById("prev-btn");
                const nextBtn = document.getElementById("next-btn");
                let currentStep = 0;

                function updateStepper() {
                    stepperItems.forEach((item, index) => {
                        const counter = item.querySelector(".step-counter");
                        const label = item.querySelector(".step-label");

                        if (index === currentStep) {
                            item.classList.add("active");
                            counter.classList.add("bg-primary", "text-white");
                            counter.classList.remove("bg-secondary", "text-dark");
                            label.classList.add("text-primary");
                        } else {
                            item.classList.remove("active");
                            counter.classList.remove("bg-primary", "text-white");
                            counter.classList.add("bg-secondary", "text-dark");
                            label.classList.remove("text-primary");
                        }
                    });

                    formSteps.forEach((step, index) => {
                        if (index === currentStep) {
                            step.classList.add("d-block");
                            step.classList.remove("d-none");
                        } else {
                            step.classList.add("d-none");
                            step.classList.remove("d-block");
                        }
                    });

                    prevBtn.disabled = currentStep === 0;
                    nextBtn.textContent = currentStep === stepperItems.length - 1 ? "Solicitar Beca" : "Siguiente";
                }

                prevBtn.addEventListener("click", () => {
                    if (currentStep > 0) {
                        currentStep--;
                        updateStepper();
                    }
                });

                nextBtn.addEventListener("click", () => {
                    const currentForm = formSteps[currentStep].querySelector("form"); // Seleccionar el formulario actual

                    if (currentForm) {
                        if (!currentForm.checkValidity()) {
                            currentForm.reportValidity(); // Muestra los mensajes de validación del navegador
                            return; // Detiene el avance al siguiente paso
                        }

                        // Validación manual para el grupo de radio "reglamento" solo si existe
                        const reglamentoRadio = currentForm.querySelector('input[name="reglamento"]:checked');
                        const reglamentoGroupExists = currentForm.querySelector('input[name="reglamento"]');

                        if (reglamentoGroupExists && !reglamentoRadio) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Por favor confirma si has leído el Reglamento de Becas 2025.',
                                icon: 'error',
                                confirmButtonText: 'Entendido',
                            });
                            return; // Detiene el avance si no está seleccionado
                        }

                        // Validación manual para los checkboxes en el formulario actual
                        const checkboxes = currentForm.querySelectorAll('input[type="checkbox"]'); // Seleccionar checkboxes solo en el formulario actual
                        if (checkboxes.length > 0) { // Solo validar si hay checkboxes
                            const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                            if (!isChecked) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Debe seleccionar al menos un motivo.',
                                    icon: 'error',
                                    confirmButtonText: 'Entendido',
                                });
                                return; // Detiene la acción si no se seleccionó ninguna
                            }
                        }
                    }

                    if (currentStep < stepperItems.length - 1) {
                        currentStep++;
                        updateStepper();
                    } else {
                        // Lógica para enviar el formulario y mostrar alerta moderna
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Se realizó el registro de solicitud de beca correctamente.',
                            icon: 'success',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#3085d6',
                            background: '#fff',
                            timer: 4000 // Si deseas que desaparezca después de 4 segundos
                        }).then(() => {
                            // Regresar al primer paso (Step 1)
                            currentStep = 0;
                            updateStepper();
                        });
                    }
                });


                updateStepper();



                const trabajoSi = document.getElementById("trabajoSi");
                const trabajoNo = document.getElementById("trabajoNo");
                const trabajoRemuneradoCampos = document.getElementById("trabajoRemuneradoCampos");
                const desempleoCampos = document.getElementById("desempleoCampos");

                const bonosSi = document.getElementById("bonosSi");
                const bonosNo = document.getElementById("bonosNo");
                const bonosMonto = document.getElementById("bonosMonto");

                const utilidadesSi = document.getElementById("utilidadesSi");
                const utilidadesNo = document.getElementById("utilidadesNo");
                const utilidadesMonto = document.getElementById("utilidadesMonto");

                // Mostrar/ocultar secciones dependiendo de trabajo remunerado
                trabajoSi.addEventListener("change", function () {
                    trabajoRemuneradoCampos.classList.remove("d-none");
                    desempleoCampos.classList.add("d-none");
                });

                trabajoNo.addEventListener("change", function () {
                    trabajoRemuneradoCampos.classList.add("d-none");
                    desempleoCampos.classList.remove("d-none");
                });

                // Mostrar/ocultar monto de bonos
                bonosSi.addEventListener("change", function () {
                    if (bonosSi.checked) {
                        bonosMonto.classList.remove("d-none");
                    }
                });

                bonosNo.addEventListener("change", function () {
                    if (bonosNo.checked) {
                        bonosMonto.classList.add("d-none");
                    }
                });

                utilidadesSi.addEventListener("change", function () {
                    if (utilidadesSi.checked) {
                        utilidadesMonto.classList.remove("d-none"); // Mostrar el campo
                    }
                });

                utilidadesNo.addEventListener("change", function () {
                    if (utilidadesNo.checked) {
                        utilidadesMonto.classList.add("d-none"); // Ocultar el campo
                    }
                });


                const titularSi = document.getElementById("titularSi");
                const titularNo = document.getElementById("titularNo");
                const titularCampos = document.getElementById("titularCampos");

                titularSi.addEventListener("change", function () {
                    if (titularSi.checked) titularCampos.classList.remove("d-none");
                });

                titularNo.addEventListener("change", function () {
                    if (titularNo.checked) titularCampos.classList.add("d-none");
                });

                // Más de un inmueble
                const inmuebleSi = document.getElementById("inmuebleSi");
                const inmuebleNo = document.getElementById("inmuebleNo");
                const inmueblesDetalles = document.getElementById("inmueblesDetalles");

                inmuebleSi.addEventListener("change", function () {
                    if (inmuebleSi.checked) inmueblesDetalles.classList.remove("d-none");
                });

                inmuebleNo.addEventListener("change", function () {
                    if (inmuebleNo.checked) inmueblesDetalles.classList.add("d-none");
                });





                const tipoDocumento = document.getElementById("tipoDocumento");
                const nroDocumento = document.getElementById("nroDocumento");

                tipoDocumento.addEventListener("change", function () {
                    // Restablece el estado y elimina restricciones previas
                    nroDocumento.setCustomValidity("");
                    nroDocumento.value = ""; // Limpia el campo
                    nroDocumento.removeAttribute("maxlength");
                    nroDocumento.removeAttribute("minlength");
                    nroDocumento.removeAttribute("pattern");

                    // Aplica las restricciones en base al tipo de documento seleccionado
                    switch (tipoDocumento.value) {
                        case "DNI":
                            nroDocumento.setAttribute("maxlength", "8");
                            nroDocumento.setAttribute("minlength", "8");
                            nroDocumento.setAttribute("pattern", "\\d{8}"); // Solo 8 dígitos
                            nroDocumento.placeholder = "Debe tener 8 dígitos";
                            break;
                        case "Pasaporte":
                            nroDocumento.setAttribute("maxlength", "12");
                            nroDocumento.setAttribute("pattern", "[a-zA-Z0-9]{1,12}"); // Alfanumérico
                            nroDocumento.placeholder = "Máximo 12 caracteres alfanuméricos";
                            break;
                        case "Carnet de Extranjería":
                            nroDocumento.setAttribute("maxlength", "9");
                            nroDocumento.setAttribute("minlength", "9");
                            nroDocumento.setAttribute("pattern", "\\d{9}"); // Solo 9 dígitos
                            nroDocumento.placeholder = "Debe tener 9 dígitos";
                            break;
                    }
                });

                nroDocumento.addEventListener("input", function () {
                    const tipo = tipoDocumento.value;

                    // Validación dinámica
                    switch (tipo) {
                        case "DNI":
                        case "Carnet de Extranjería":
                            // Permitir solo números
                            nroDocumento.value = nroDocumento.value.replace(/[^0-9]/g, "");
                            break;
                        case "Pasaporte":
                            // Permitir solo caracteres alfanuméricos
                            nroDocumento.value = nroDocumento.value.replace(/[^a-zA-Z0-9]/g, "");
                            break;
                    }

                    const minLength = nroDocumento.getAttribute("minlength");
                    const maxLength = nroDocumento.getAttribute("maxlength");
                    const valueLength = nroDocumento.value.length;

                    // Validación dinámica del campo
                    if ((minLength && valueLength < minLength) || (maxLength && valueLength > maxLength)) {
                        nroDocumento.setCustomValidity("La cantidad de caracteres no es válida para el tipo de documento seleccionado.");
                    } else {
                        nroDocumento.setCustomValidity("");
                    }
                });

            });
        </script>

        <!-- end container -->
    </section>
    <!-- end section -->
@endsection
