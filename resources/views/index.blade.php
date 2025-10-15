@extends('layouts_page.app')

@section('title', 'Colegio Áleph')

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
        @if (!$mostrarFormulario)
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-1">
                        <div class="card-body text-center text-primary p-4">
                            <p class="mt-3 text-primary text-muted">{!! $titulo_mensaje !!}</p>
                            <hr>
                            <p class="mt-3 ">{!! $mensaje !!}</p>
                            <hr>
                            <p class="small text-primary">{{ $pie_mensaje }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
            <!-- start container -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="title text-center mb-5">
                            <!--<h6 class="mb-0 fw-bold text-primary">Contact Us</h6>-->
                            <h2 class="f-40">SOLICITUD DE BECA PARA EL PERÍODO ACADÉMICO {{ date('Y') + 1 }}</h2>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center ">
                    <div class="col-md-12 mb-4">
                        <div class="text-end mt-3">
                            <label class="me-2">Tiempo restante para enviar el formulario:</label>
                            <span id="tiempoRestante" class="badge bg-primary text-white fs-4"></span>
                            <!-- Botón con Tooltip -->
                            <button type="button" class="btn btn-light btn-sm ms-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Por favor, asegúrate de tener todos los documentos listos antes de comenzar a llenar el formulario.">
                                <i class="mdi mdi-alert text-danger fs-4"></i>
                            </button>
                        </div>
                        <!-- Alerta no invasiva (Bootstrap) -->
                        <div id="alertaTemporal" class="alert alert-warning mt-3 d-none" role="alert">
                            El formulario está a punto de expirar. Por favor, envíalo pronto o refresca la página.
                        </div>
                        <div class="container mt-5">
                            <!-- Indicador de progreso -->
                            <div class="progress mb-4" style="height: 8px;">
                                <div id="progress-bar" class="progress-bar bg-primary" role="progressbar" style="width: 16.66%" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="stepper-wrapper">
                                <div class="stepper-item active" data-step="1">
                                    <div class="step-counter">1</div>
                                    <div class="step-label">Inicio</div>
                                </div>
                                <div class="stepper-item" data-step="2">
                                    <div class="step-counter">2</div>
                                    <div class="step-label">Estudiante</div>
                                </div>
                                <div class="stepper-item" data-step="3">
                                    <div class="step-counter">3</div>
                                    <div class="step-label">Progenitor 1</div>
                                </div>
                                <div class="stepper-item" data-step="4">
                                    <div class="step-counter">4</div>
                                    <div class="step-label">Progenitor 2</div>
                                </div>
                                <div class="stepper-item" data-step="5">
                                    <div class="step-counter">5</div>
                                    <div class="step-label">Situación Económica</div>
                                </div>
                                <div class="stepper-item" data-step="6">
                                    <div class="step-counter">6</div>
                                    <div class="step-label">General</div>
                                </div>
                            </div>

                            <div class="form mt-4">
                                <form  method="POST" action="/setdatos" enctype="multipart/form-data"  class="p-4 border rounded" id="frmSolicitud">
                                <!-- Paso 1: Inicio -->
                                <div class="form-step d-block" data-step="1">
                                    @include('paso1')
                                </div>
                                <!-- Paso 2: Estudiante -->
                                <div class="form-step d-none" data-step="2">
                                    @include('paso2')
                                </div>
                                <!-- Paso 3: Progenitor 1 -->
                                <div class="form-step d-none" data-step="3">
                                    @include('paso3')
                                </div>
                                <!-- Paso 4: Progenitor 2 -->
                                <div class="form-step d-none" data-step="4" id="step-progenitor-2">
                                    <input type="hidden" id="is_insert_progenitor2" name="is_insert_progenitor2" value="0"/>
                                    @include('paso4')
                                </div>
                                <!-- Paso 5: Situación Económica -->
                                <div class="form-step d-none" data-step="5">
                                    @include('paso5')
                                </div>
                                <!-- Paso 6: General -->
                                <div class="form-step d-none" data-step="6">
                                    @include('paso6')
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <button id="prev-btn" class="btn btn-primary" type="button" disabled>← Anterior</button>
                                    <button id="next-btn" class="btn btn-primary" type="button">Siguiente →</button>
                                </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

        <style>
            .stepper-item.completed .step-counter {
                background-color: #28a745 !important;
                color: white !important;
            }
            .stepper-item.completed .step-label {
                color: #28a745 !important;
                font-weight: 500;
            }
            .form-step {
                transition: all 0.3s ease-in-out;
            }
            .progress {
                border-radius: 10px;
                overflow: hidden;
            }
            .progress-bar {
                transition: width 0.6s ease;
            }
            .is-invalid {
                border-color: #dc3545 !important;
                box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
            }
            .stepper-item {
                transition: all 0.3s ease;
            }
            .stepper-item:hover .step-counter {
                transform: scale(1.1);
            }
            .stepper-item.completed {
                cursor: pointer;
            }
            .stepper-item.completed:hover {
                opacity: 0.8;
            }
        </style>
        <script>
            $('input[type="text"]').on('input', function () {
                $(this).val($(this).val().toUpperCase());
            });

            function toggleVisibility(triggerSelector, targetSelector, condition) {
                $(triggerSelector).on('change', function () {
                    const $target = $(targetSelector);
                    const shouldShow = condition($(this));

                    // Mostrar/ocultar el elemento
                    $target.toggleClass('d-none', !shouldShow);

                    // Agregar o eliminar el atributo required en los inputs dentro del target
                    $target.find('input, select, textarea').each(function () {
                        if (shouldShow) {
                            $(this).attr('required', 'required');
                        } else {
                            $(this).removeAttr('required');
                        }
                    });
                });
            }

            function toggleVisibilityByPrefix(prefix, radioYesId, radioNoId, fieldId) {
                toggleVisibility(`#${radioYesId}_${prefix}`, `#${fieldId}_${prefix}`, () => true);
                toggleVisibility(`#${radioNoId}_${prefix}`, `#${fieldId}_${prefix}`, () => false);
            }

            function configureTipoDocumentoChange(prefix) {
                $(`#tipoDocumento_${prefix}`).on('change', function () {
                    const $nroDocumento = $(`#numeroDocumento_${prefix}`);
                    const tipo = $(this).val();

                    $nroDocumento.val('').removeAttr('maxlength minlength pattern placeholder').removeClass('is-invalid');

                    switch (tipo) {
                        case 'DNI':
                            $nroDocumento.attr({
                                maxlength: 8,
                                minlength: 8,
                                pattern: '\\d{8}',
                                placeholder: 'Debe tener 8 dígitos'
                            });
                            break;
                        case 'Pasaporte':
                            $nroDocumento.attr({
                                maxlength: 12,
                                pattern: '[a-zA-Z0-9]{1,12}',
                                placeholder: 'Máximo 12 caracteres alfanuméricos'
                            });
                            break;
                        case 'Carnet de Extranjería':
                            $nroDocumento.attr({
                                maxlength: 9,
                                minlength: 9,
                                pattern: '\\d{9}',
                                placeholder: 'Debe tener 9 dígitos'
                            });
                            break;
                    }
                });

                $(`#numeroDocumento_${prefix}`).on('input', function () {
                    const tipo = $(`#tipoDocumento_${prefix}`).val();
                    const value = $(this).val();
                    const $field = $(this);

                    // Limpiar validación previa
                    $field.removeClass('is-invalid');
                    $field[0].setCustomValidity('');

                    switch (tipo) {
                        case 'DNI':
                            $(this).val(value.replace(/[^0-9]/g, ''));
                            // Validar longitud exacta
                            if (value && value.length !== 8) {
                                $field.addClass('is-invalid');
                                $field[0].setCustomValidity('El DNI debe tener exactamente 8 dígitos');
                            }
                            break;
                        case 'Carnet de Extranjería':
                            $(this).val(value.replace(/[^0-9]/g, ''));
                            // Validar longitud exacta
                            if (value && value.length !== 9) {
                                $field.addClass('is-invalid');
                                $field[0].setCustomValidity('El Carnet de Extranjería debe tener exactamente 9 dígitos');
                            }
                            break;
                        case 'Pasaporte':
                            $(this).val(value.replace(/[^a-zA-Z0-9]/g, ''));
                            // Validar longitud máxima
                            if (value && value.length > 12) {
                                $field.addClass('is-invalid');
                                $field[0].setCustomValidity('El Pasaporte no puede tener más de 12 caracteres');
                            }
                            break;
                    }
                });
            }

            // Configuración para Prog1
            toggleVisibilityByPrefix('Prog1', 'trabajoSi', 'trabajoNo', 'trabajoRemuneradoCampos');
            toggleVisibilityByPrefix('Prog1', 'trabajoNo', 'trabajoSi', 'desempleoCampos');
            toggleVisibilityByPrefix('Prog1', 'bonosSi', 'bonosNo', 'bonosMonto');
            toggleVisibilityByPrefix('Prog1', 'utilidadesSi', 'utilidadesNo', 'utilidadesMonto');
            toggleVisibilityByPrefix('Prog1', 'titularSi', 'titularNo', 'titularCampos');
            toggleVisibilityByPrefix('Prog1', 'inmuebleSi', 'inmuebleNo', 'inmueblesDetalles');
            configureTipoDocumentoChange('Prog1');

            // Configuración para Prog2
            toggleVisibilityByPrefix('Prog2', 'trabajoSi', 'trabajoNo', 'trabajoRemuneradoCampos');
            toggleVisibilityByPrefix('Prog2', 'trabajoNo', 'trabajoSi', 'desempleoCampos');
            toggleVisibilityByPrefix('Prog2', 'bonosSi', 'bonosNo', 'bonosMonto');
            toggleVisibilityByPrefix('Prog2', 'utilidadesSi', 'utilidadesNo', 'utilidadesMonto');
            toggleVisibilityByPrefix('Prog2', 'titularSi', 'titularNo', 'titularCampos');
            toggleVisibilityByPrefix('Prog2', 'inmuebleSi', 'inmuebleNo', 'inmueblesDetalles');
            configureTipoDocumentoChange('Prog2');

            // Validación del año de inicio laboral para Progenitor 1
            document.getElementById('anioLaboral_Prog1').addEventListener('input', function (e) {
                const value = e.target.value;
                const currentYear = new Date().getFullYear();

                if (value.length > 4) {
                    e.target.value = value.slice(0, 4); // Limita a 4 caracteres
                }

                // Validar rango de años (coincide con min/max del HTML)
                if (value && (parseInt(value) < 1960 || parseInt(value) > currentYear)) {
                    e.target.classList.add('is-invalid');
                    e.target.setCustomValidity(`El año debe estar entre 1960 y ${currentYear}`);
                } else {
                    e.target.classList.remove('is-invalid');
                    e.target.setCustomValidity('');
                }
            });

            // Validación del año de inicio laboral para Progenitor 2
            document.getElementById('anioLaboral_Prog2').addEventListener('input', function (e) {
                const value = e.target.value;
                const currentYear = new Date().getFullYear();

                if (value.length > 4) {
                    e.target.value = value.slice(0, 4); // Limita a 4 caracteres
                }

                // Validar rango de años (coincide con min/max del HTML)
                if (value && (parseInt(value) < 1960 || parseInt(value) > currentYear)) {
                    e.target.classList.add('is-invalid');
                    e.target.setCustomValidity(`El año debe estar entre 1960 y ${currentYear}`);
                } else {
                    e.target.classList.remove('is-invalid');
                    e.target.setCustomValidity('');
                }
            });

            // Validación de RUC para Progenitor 1
            document.getElementById('nroRuc_Prog1').addEventListener('input', function (e) {
                const value = e.target.value;

                // Solo permitir números
                e.target.value = value.replace(/[^0-9]/g, '');

                // Validar longitud
                if (value && value.length !== 11) {
                    e.target.classList.add('is-invalid');
                    e.target.setCustomValidity('El RUC debe tener exactamente 11 dígitos');
                } else {
                    e.target.classList.remove('is-invalid');
                    e.target.setCustomValidity('');
                }
            });

            // Validación de RUC para Progenitor 2
            document.getElementById('nroRuc_Prog2').addEventListener('input', function (e) {
                const value = e.target.value;

                // Solo permitir números
                e.target.value = value.replace(/[^0-9]/g, '');

                // Validar longitud
                if (value && value.length !== 11) {
                    e.target.classList.add('is-invalid');
                    e.target.setCustomValidity('El RUC debe tener exactamente 11 dígitos');
                } else {
                    e.target.classList.remove('is-invalid');
                    e.target.setCustomValidity('');
                }
            });

            // Validación de porcentaje de acciones para Progenitor 1
            document.getElementById('acciones_Prog1').addEventListener('input', function (e) {
                const value = parseInt(e.target.value);

                // Solo permitir números
                e.target.value = e.target.value.replace(/[^0-9]/g, '');

                // Validar rango
                if (e.target.value && (value < 1 || value > 100)) {
                    e.target.classList.add('is-invalid');
                    e.target.setCustomValidity('El porcentaje debe estar entre 1 y 100');
                } else {
                    e.target.classList.remove('is-invalid');
                    e.target.setCustomValidity('');
                }
            });

            // Validación de porcentaje de acciones para Progenitor 2
            document.getElementById('acciones_Prog2').addEventListener('input', function (e) {
                const value = parseInt(e.target.value);

                // Solo permitir números
                e.target.value = e.target.value.replace(/[^0-9]/g, '');

                // Validar rango
                if (e.target.value && (value < 1 || value > 100)) {
                    e.target.classList.add('is-invalid');
                    e.target.setCustomValidity('El porcentaje debe estar entre 1 y 100');
                } else {
                    e.target.classList.remove('is-invalid');
                    e.target.setCustomValidity('');
                }
            });

            // Validación de metros cuadrados de vivienda para Progenitor 1
            document.getElementById('metros_Prog1').addEventListener('input', function (e) {
                const value = parseFloat(e.target.value);

                // Solo permitir números y un punto decimal
                e.target.value = e.target.value.replace(/[^0-9.]/g, '');

                // Validar que sea positivo
                if (e.target.value && value <= 0) {
                    e.target.classList.add('is-invalid');
                    e.target.setCustomValidity('Los metros cuadrados deben ser un valor positivo');
                } else {
                    e.target.classList.remove('is-invalid');
                    e.target.setCustomValidity('');
                }
            });

            // Validación de metros cuadrados de vivienda para Progenitor 2
            document.getElementById('metros_Prog2').addEventListener('input', function (e) {
                const value = parseFloat(e.target.value);

                // Solo permitir números y un punto decimal
                e.target.value = e.target.value.replace(/[^0-9.]/g, '');

                // Validar que sea positivo
                if (e.target.value && value <= 0) {
                    e.target.classList.add('is-invalid');
                    e.target.setCustomValidity('Los metros cuadrados deben ser un valor positivo');
                } else {
                    e.target.classList.remove('is-invalid');
                    e.target.setCustomValidity('');
                }
            });

            // Validación de cantidad de inmuebles para Progenitor 1
            document.getElementById('numInmuebles_Prog1').addEventListener('input', function (e) {
                const value = parseInt(e.target.value);

                // Solo permitir números
                e.target.value = e.target.value.replace(/[^0-9]/g, '');

                // Validar rango
                if (e.target.value && (value < 1 || value > 1000)) {
                    e.target.classList.add('is-invalid');
                    e.target.setCustomValidity('La cantidad de inmuebles debe estar entre 1 y 1000');
                } else {
                    e.target.classList.remove('is-invalid');
                    e.target.setCustomValidity('');
                }
            });

            // Validación de cantidad de inmuebles para Progenitor 2
            document.getElementById('numInmuebles_Prog2').addEventListener('input', function (e) {
                const value = parseInt(e.target.value);

                // Solo permitir números
                e.target.value = e.target.value.replace(/[^0-9]/g, '');

                // Validar rango
                if (e.target.value && (value < 1 || value > 1000)) {
                    e.target.classList.add('is-invalid');
                    e.target.setCustomValidity('La cantidad de inmuebles debe estar entre 1 y 1000');
                } else {
                    e.target.classList.remove('is-invalid');
                    e.target.setCustomValidity('');
                }
            });

            // Función para validar campos numéricos positivos
            function validatePositiveNumber(inputId, fieldName) {
                const element = document.getElementById(inputId);
                if (element) {
                    element.addEventListener('input', function (e) {
                        const value = parseFloat(e.target.value);

                        // Solo permitir números y un punto decimal
                        e.target.value = e.target.value.replace(/[^0-9.]/g, '');

                        // Validar que sea positivo
                        if (e.target.value && value < 0) {
                            e.target.classList.add('is-invalid');
                            e.target.setCustomValidity(`${fieldName} debe ser un valor positivo o cero`);
                        } else {
                            e.target.classList.remove('is-invalid');
                            e.target.setCustomValidity('');
                        }
                    });
                }
            }

            // Aplicar validación a todos los campos de ingresos y gastos
            const financialFields = [
                {id: 'remuneracionPlanilla', name: 'Remuneración mensual'},
                {id: 'honorariosProfesionales', name: 'Honorarios profesionales'},
                {id: 'pensionista', name: 'Pensionista / Jubilación'},
                {id: 'rentasInmuebles', name: 'Rentas por alquiler de inmuebles'},
                {id: 'rentasVehiculos', name: 'Rentas por alquiler de vehículos'},
                {id: 'otrosIngresos', name: 'Otros ingresos'},
                {id: 'pagoColegios', name: 'Pago por colegios'},
                {id: 'pagoTalleres', name: 'Pago por talleres'},
                {id: 'pagoUniversidad', name: 'Pago por universidad'},
                {id: 'pagoAlimentacion', name: 'Pago por alimentación'},
                {id: 'pagoAlquiler', name: 'Alquiler departamento/casa'},
                {id: 'pagoCreditoPersonal', name: 'Pago por crédito personal'},
                {id: 'pagoCreditoHipotecario', name: 'Pago por crédito hipotecario'},
                {id: 'pagoCreditoVehicular', name: 'Pago por crédito vehicular'},
                {id: 'pagoServicios', name: 'Pago por servicios'},
                {id: 'pagoMantenimiento', name: 'Pago por mantenimiento'},
                {id: 'pagoApoyoCasa', name: 'Pago por apoyo en casa'},
                {id: 'pagoClubes', name: 'Pago por clubes'},
                {id: 'pagoSeguros', name: 'Pago por seguros'},
                {id: 'pagoApoyoFamiliar', name: 'Pago por apoyo familiar'},
                {id: 'otrosGastos', name: 'Otros gastos'},
                {id: 'ingresos_Prog1', name: 'Ingresos mensuales Progenitor 1'},
                {id: 'ingresos_Prog2', name: 'Ingresos mensuales Progenitor 2'}
            ];

            // Aplicar validaciones a todos los campos financieros
            financialFields.forEach(field => {
                validatePositiveNumber(field.id, field.name);
            });

            // Validación en tiempo real para correos electrónicos
            function validateEmail(inputId, fieldName) {
                const element = document.getElementById(inputId);
                if (element) {
                    element.addEventListener('input', function (e) {
                        const value = e.target.value;
                        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

                        if (value && !emailRegex.test(value)) {
                            e.target.classList.add('is-invalid');
                            e.target.setCustomValidity(`${fieldName} debe tener un formato válido (ejemplo: usuario@dominio.com)`);
                        } else {
                            e.target.classList.remove('is-invalid');
                            e.target.setCustomValidity('');
                        }
                    });
                }
            }

            // Aplicar validación a los correos electrónicos
            validateEmail('correo_Prog1', 'Correo Electrónico del Progenitor 1');
            validateEmail('correo_Prog2', 'Correo Electrónico del Progenitor 2');

            // Validación de número de hijos vs hijos matriculados
            function validateHijos(inputId, matriculadosId, fieldName) {
                const hijosElement = document.getElementById(inputId);
                const matriculadosElement = document.getElementById(matriculadosId);

                if (hijosElement && matriculadosElement) {
                    function validateBoth() {
                        const hijos = parseInt(hijosElement.value) || 0;
                        const matriculados = parseInt(matriculadosElement.value) || 0;

                        if (matriculados > hijos) {
                            matriculadosElement.classList.add('is-invalid');
                            matriculadosElement.setCustomValidity('Los hijos matriculados no pueden ser más que el total de hijos');
                        } else {
                            matriculadosElement.classList.remove('is-invalid');
                            matriculadosElement.setCustomValidity('');
                        }
                    }

                    hijosElement.addEventListener('input', validateBoth);
                    matriculadosElement.addEventListener('input', validateBoth);
                }
            }

            // Aplicar validación a los campos de hijos
            validateHijos('numeroHijos_Prog1', 'hijosMatriculados_Prog1', 'Progenitor 1');
            validateHijos('numeroHijos_Prog2', 'hijosMatriculados_Prog2', 'Progenitor 2');
        </script>

        <script>
            $(document).ready(function() {

                let currentStep = 1;


                function updateSteps() {
                    // Ocultar todos los pasos y divs de validación
                    $('.form-step').addClass('d-none').removeClass('d-block');
                    $('[id^="validacionpaso"]').addClass('d-none').removeClass('d-block');

                    // Mostrar el paso actual y su div de validación
                    $(`.form-step[data-step="${currentStep}"]`).removeClass('d-none').addClass('d-block');
                    $(`#validacionpaso${currentStep}`).removeClass('d-none').addClass('d-block');

                    // Actualizar estado de botones
                    $('#prev-btn').prop('disabled', currentStep === 1);
                    $('#next-btn').text(currentStep === $('.stepper-item').length ? "Solicitar Beca" : "Siguiente →");

                    // Actualizar la barra de progreso
                    const progressPercentage = (currentStep / $('.stepper-item').length) * 100;
                    $('#progress-bar').css('width', progressPercentage + '%').attr('aria-valuenow', progressPercentage);

                    // Actualizar el estado del stepper
                    $('.stepper-item').each(function (index) {
                        const $item = $(this);
                        const $counter = $item.find(".step-counter");
                        const $label = $item.find(".step-label");
                        const stepNumber = index + 1;

                        if (stepNumber === currentStep) {
                            $item.addClass("active");
                            $counter.addClass("bg-primary text-white").removeClass("bg-secondary text-dark");
                            $label.addClass("text-primary");
                        } else if (stepNumber < currentStep) {
                            // Pasos completados
                            $item.removeClass("active").addClass("completed");
                            $counter.addClass("bg-success text-white").removeClass("bg-secondary text-dark bg-primary");
                            $label.addClass("text-success").removeClass("text-primary");
                        } else {
                            // Pasos pendientes
                            $item.removeClass("active completed");
                            $counter.removeClass("bg-primary text-white bg-success").addClass("bg-secondary text-dark");
                            $label.removeClass("text-primary text-success");
                        }
                    });

                    // Auto-enfoque en el primer campo del paso actual
                    setTimeout(() => {
                        focusFirstField(currentStep);
                    }, 100);

                    console.log('currentSteppp',currentStep);
                }

                // Función para enfocar el primer campo del paso actual
                function focusFirstField(step) {
                    const currentStepDiv = $(`.form-step[data-step="${step}"]`);
                    const firstField = currentStepDiv.find('input:not([readonly]):not([type="hidden"]), select, textarea').first();

                    if (firstField.length > 0) {
                        firstField.focus();

                        // Si es un campo de archivo, no hacer focus automático
                        if (firstField.attr('type') === 'file') {
                            const nextField = currentStepDiv.find('input:not([readonly]):not([type="hidden"]):not([type="file"]), select, textarea').first();
                            if (nextField.length > 0) {
                                nextField.focus();
                            }
                        }
                    }
                }

                // Escuchar cambio en los radios de la pregunta 2
                $('input[name="viveConProgenitores"]').change(function () {
                    const selectedValue = $('input[name="viveConProgenitores"]:checked').val();
                    const stepProgenitor2 = $('#step-progenitor-2');
                    const documentosProgenitor2 = $('#documentosProgenitor2');
                    const esInsertaProgenitor2 = $('#is_insert_progenitor2');
                    if (selectedValue === 'uno' || selectedValue === 'tiempo_compartido') {
                        stepProgenitor2.attr('data-skip', 'true');
                        documentosProgenitor2.addClass('d-none');
                        esInsertaProgenitor2.val("0");
                    } else {
                        stepProgenitor2.attr('data-skip', 'false');
                        documentosProgenitor2.removeClass('d-none');
                        esInsertaProgenitor2.val("1");
                    }
                });
                /**/
                // Botón "Siguiente"
                $('#next-btn').click(function () {
                    let nextStep = currentStep + 1;

                    const currentDiv = $(`#validacionpaso${currentStep}`); // Asegúrate de que este ID sea correcto
                    let isValid = true;
                    let errorMessages = [];

                    // Validar campos required
                    currentDiv.find('input[required], select[required], textarea[required]').each(function () {
                        const $field = $(this);
                        const value = $field.val();

                        // Si el campo está vacío
                        if (!value || (typeof value === 'string' && !value.trim())) {
                            isValid = false;
                            const fieldName = $field.attr('data-name') || 'Este campo';
                            errorMessages.push(`- ${fieldName} es obligatorio.`);
                            $field.addClass('is-invalid'); // Marcar campo como inválido
                        } else {
                            $field.removeClass('is-invalid'); // Remover error si ya no está vacío
                        }

                        // Validar formato de correo si es un campo tipo email
                        if ($field.attr('type') === 'email') {
                            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // Expresión regular mejorada para validar email
                            if (!emailRegex.test(value)) {
                                isValid = false;
                                const fieldName = $field.attr('data-name') || 'Correo Electrónico';
                                errorMessages.push(`- ${fieldName} tiene un formato inválido. Debe ser un correo válido (ejemplo: usuario@dominio.com).`);
                                $field.addClass('is-invalid'); // Marcar correo como inválido
                            } else {
                                $field.removeClass('is-invalid'); // Remover error si el formato es correcto
                            }
                        }
                    });

                    // Validar grupos de radios
                    currentDiv.find('input[type="radio"][required]').each(function () {
                        const name = $(this).attr('name'); // Nombre del grupo
                        const isChecked = currentDiv.find(`input[name="${name}"]:checked`).length > 0;

                        if (!isChecked) {
                            isValid = false;
                            const fieldName = $(this).attr('data-name') || 'Una opción';
                            errorMessages.push(`- Seleccionar ${fieldName}.`);
                        }
                    });

                    // Validar checkboxes
                    currentDiv.find('input[type="checkbox"][required]').each(function () {
                        const name = $(this).attr('name'); // Nombre del grupo
                        const isChecked = currentDiv.find(`input[name="${name}"]:checked`).length > 0;

                        if (!isChecked) {
                            isValid = false;
                            const fieldName = $(this).attr('data-name') || 'Al menos una opción';
                            errorMessages.push(`- Seleccionar ${fieldName}.`);
                        }
                    });

                    // Continuamos con la validación de los archivos dentro de currentDiv
                    // Solo validar archivos si no estamos en el paso 6 o si el progenitor correspondiente está visible
                    const isPaso6 = currentDiv.attr('id') === 'validacionpaso6';

                    currentDiv.find('input[type="file"]').each(function () {
                        const $fileInput = $(this);
                        const files = $fileInput[0].files;

                        // Verificar si el campo o su div contenedor tiene la clase d-none
                        const parentDiv = $fileInput.closest('div.row');
                        const progenitorDiv = $fileInput.closest('div[id^="documentosProgenitor"]');

                        // Si estamos en el paso 6, verificar específicamente si el Progenitor 2 está oculto
                        if (isPaso6 && progenitorDiv.attr('id') === 'documentosProgenitor2' && progenitorDiv.hasClass('d-none')) {
                            console.log('Progenitor 2 oculto en paso 6, saltando validación:', $fileInput.attr('id'));
                            return true;
                        }

                        if (parentDiv.hasClass('d-none') || $fileInput.closest('div').hasClass('d-none') || progenitorDiv.hasClass('d-none')) {
                            // Si el campo está oculto (tiene la clase d-none), no validamos los archivos y pasamos al siguiente input
                            console.log('Campo oculto detectado, saltando validación:', $fileInput.attr('id'), 'ProgenitorDiv oculto:', progenitorDiv.hasClass('d-none'));
                            return true;
                        }

                        if (files.length > 0) {
                            const file = files[0];
                            const allowedExtensions = /(\.pdf|\.jpg|\.jpeg)$/i;
                            const maxSize = 5 * 1024 * 1024; // 5 MB

                            // Validar extensión del archivo
                            if (!allowedExtensions.test(file.name)) {
                                isValid = false;
                                const fieldName = $fileInput.attr('data-name') || 'El archivo';
                                errorMessages.push(`- ${fieldName} debe ser un PDF o imagen JPG.`);
                                $fileInput.addClass('is-invalid');
                            } else {
                                $fileInput.removeClass('is-invalid');
                            }

                            // Validar tamaño del archivo
                            if (file.size > maxSize) {
                                isValid = false;
                                const fieldName = $fileInput.attr('data-name') || 'El archivo';
                                errorMessages.push(`- ${fieldName} no debe exceder 5 MB.`);
                                $fileInput.addClass('is-invalid');
                            } else {
                                $fileInput.removeClass('is-invalid');
                            }
                        } else {
                            // Si no hay archivo, obtener el checkbox relacionado
                            const fileInputId = $fileInput.attr('id'); // Obtener el ID del campo de archivo
                            const checkboxId = fileInputId.replace('boletasPago', 'noAplicaBoletasPago') // Reemplaza "boletasPago" por "noAplicaBoletasPago"
                                                        .replace('declaracionJurada', 'noAplicaDeclaracionJurada') // Reemplaza "declaracionJurada" por "noAplicaDeclaracionJurada"
                                                        .replace('certificadoMovimientos', 'noAplicaCertificadoMovimientos') // Reemplaza "certificadoMovimientos" por "noAplicaCertificadoMovimientos"
                                                        .replace('certificadoMovimientoAnioActual', 'noAplicaCertificadoMovimientoAnioActual') // Reemplaza "certificadoMovimientoAnioActual" por "noAplicaCertificadoMovimientoAnioActual"
                                                        .replace('certificadoMovimientoAnioAnterior', 'noAplicaCertificadoMovimientoAnioAnterior') // Reemplaza "certificadoMovimientoAnioAnterior" por "noAplicaCertificadoMovimientoAnioAnterior"
                                                        .replace('constanciaBusquedaRegistros', 'noAplicaConstanciaBusquedaRegistros') // Reemplaza "constanciaBusquedaRegistros" por "noAplicaConstanciaBusquedaRegistros"
                                                        .replace('otrosDocumentos', 'noAplicaOtrosDocumentos'); // Reemplaza "otrosDocumentos" por "noAplicaOtrosDocumentos"
                            const relatedCheckbox = $(`#${checkboxId}`);

                            if (relatedCheckbox.length > 0 && !relatedCheckbox.is(':checked')) {
                                isValid = false;
                                errorMessages.push(`- Marque la opción "No aplica" si no subirá archivo para ${$fileInput.attr('data-name') || 'este campo'}.`);
                            }

                        }
                    });

                    // Log para depuración
                    console.log('Paso actual:', currentStep, 'Validación:', isValid, 'Div actual:', currentDiv);

                    // Mostrar errores con Toastr si hay errores
                    if (!isValid) {
                        // Limpiar clases de error previas
                        currentDiv.find('.is-invalid').removeClass('is-invalid');

                        // Agregar clase de error a los campos problemáticos
                        currentDiv.find('input[required], select[required], textarea[required]').each(function () {
                            const $field = $(this);
                            const value = $field.val();

                            if (!value || (typeof value === 'string' && !value.trim())) {
                                $field.addClass('is-invalid');
                            }
                        });

                        // Scroll suave hacia el primer campo con error
                        const firstErrorField = currentDiv.find('.is-invalid').first();
                        if (firstErrorField.length > 0) {
                            $('html, body').animate({
                                scrollTop: firstErrorField.offset().top - 100
                            }, 500);
                            firstErrorField.focus();
                        }

                        toastr.error(errorMessages.join('<br>'), 'Faltan datos obligatorios', {
                            positionClass: 'toast-bottom-right',
                            closeButton: true,
                            timeOut: 8000,
                        });
                        return;
                    }

                    // Limpiar clases de error si la validación es exitosa
                    currentDiv.find('.is-invalid').removeClass('is-invalid');


                    // Validaciones específicas para cada paso
                    if (currentStep === 1) { // Validación para el paso 1
                        const $reglamentoGroup = $('input[name="reglamento"]');

                        // Verificar si la opción "Sí" está seleccionada
                        if (!$reglamentoGroup.filter('#opcionSi:checked').length) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Debes confirmar que has leído el Reglamento de Becas seleccionando "Sí".',
                                icon: 'error',
                                confirmButtonText: 'Entendido'
                            });
                            return;
                        }

                        // Bloquear el botón "Atrás"
                        $('#prev-btn').attr('disabled', true);
                    }else {
                        $('#prev-btn').attr('disabled', false);
                    }
                    // Validaciones específicas ANTES de ocultar el paso actual
                    if (currentStep === 2) { // Validación para el paso 2
                        const $idestudiante = $('#id_estudiante').val();
                        const selectedOption = $('input[name="viveConProgenitores"]:checked').val();
                        const selectedMotivos = $('input[type="checkbox"]:checked').length; // Contar checkboxes seleccionados

                        if (!$idestudiante) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Debe seleccionar un estudiante, ingrese el tipo y numero de documento para buscar y seleccionarlo.',
                                icon: 'error',
                                confirmButtonText: 'Entendido'
                            });
                            return;
                        }

                        if (!selectedOption) { // Si no hay ninguna opción seleccionada
                            Swal.fire({
                                title: 'Error',
                                text: 'Por favor seleccione una opción en "¿Vive con ambos progenitores?"',
                                icon: 'error',
                                confirmButtonText: 'Entendido'
                            });
                            return;
                        }

                        if (selectedMotivos === 0) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Por favor seleccione al menos un motivo por el que solicita la beca.',
                                icon: 'error',
                                confirmButtonText: 'Entendido'
                            });
                            return;
                        }
                    }

                    if (currentStep === 3) { // Validación para el paso 3 (Progenitor 1)
                        const anioLaboral = $('#anioLaboral_Prog1').val();
                        const currentYear = new Date().getFullYear();

                        if (anioLaboral && (parseInt(anioLaboral) < 1960 || parseInt(anioLaboral) > currentYear)) {
                            $('#anioLaboral_Prog1').addClass('is-invalid');
                            toastr.error(`El año de inicio laboral debe estar entre 1960 y ${currentYear}.`, 'Error de validación', {
                                positionClass: 'toast-bottom-right',
                                closeButton: true,
                                timeOut: 8000,
                            });
                            return;
                        }
                    }

                    if (currentStep === 4) { // Validación para el paso 4 (Progenitor 2)
                        const anioLaboral = $('#anioLaboral_Prog2').val();
                        const currentYear = new Date().getFullYear();

                        if (anioLaboral && (parseInt(anioLaboral) < 1960 || parseInt(anioLaboral) > currentYear)) {
                            $('#anioLaboral_Prog2').addClass('is-invalid');
                            toastr.error(`El año de inicio laboral debe estar entre 1960 y ${currentYear}.`, 'Error de validación', {
                                positionClass: 'toast-bottom-right',
                                closeButton: true,
                                timeOut: 8000,
                            });
                            return;
                        }
                    }

                    // Avanzar al siguiente paso si todo es válido
                    // Solo ocultar el paso actual si NO estamos en el paso 6 (último paso)
                    if (currentStep !== 6) {
                        $(`#validacionpaso${currentStep}`).addClass('d-none');
                        $(`#validacionpaso${nextStep}`).removeClass('d-none');
                    }

                    if (currentStep === 6) {
                        // Validar tamaño de archivos antes de enviar
                        if (!validarTamañoArchivos()) {
                            return; // Detener el envío si los archivos son demasiado grandes
                        }

                        // Recolectar y enviar todos los formularios
                        let formData = new FormData($('#frmSolicitud')[0]);
                        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                        $('#next-btn').prop('disabled', true); // Deshabilitar el botón para evitar múltiples envíos
                        $('#next-btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Registrando Solicitud...'); // Cambiar el contenido del botón a un spinner
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        // Enviar datos con AJAX (o método preferido)
                        $.ajax({
                            url: '/setdatos', // Cambiar por tu endpoint
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                // Mostrar mensaje de éxito
                                Swal.fire({
                                    title: 'Éxito',
                                    text: 'La solicitud de beca se registró correctamente.',
                                    icon: 'success',
                                    confirmButtonText: 'Entendido'
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function (xhr) {
                                let errorMessage = 'Ocurrió un error al registrar la solicitud de beca. Por favor, inténtelo de nuevo.';

                                // Si el servidor devuelve un mensaje de error específico
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = `Error: ${xhr.responseJSON.message}`; // Concatenar el mensaje del servidor
                                } else if (xhr.responseText) {
                                    errorMessage = `Error: ${xhr.responseText}`; // Si no hay respuesta JSON, pero hay texto de error
                                }

                                // Mostrar mensaje de error con Swal
                                Swal.fire({
                                    title: 'Error',
                                    text: errorMessage,
                                    icon: 'error',
                                    confirmButtonText: 'Entendido'
                                }).then(() => {
                                    // Restaurar el botón después de cerrar el modal
                                    $('#next-btn').html('Solicitar Beca'); // Restaurar el texto del botón
                                    $('#next-btn').prop('disabled', false); // Habilitar el botón

                                    // Asegurar que el paso 6 permanezca visible
                                    $('#validacionpaso6').removeClass('d-none').addClass('d-block');

                                    // Enfocar el primer campo del paso 6 para facilitar la corrección
                                    setTimeout(() => {
                                        focusFirstField(6);
                                    }, 100);
                                });

                                // No hacer return aquí para evitar que se ejecute el resto del código
                                return false;
                            }
                        });

                        // Si llegamos aquí, significa que la validación pasó pero aún no se envió
                        // No actualizar el step hasta que se complete el envío
                        return false;
                    }

                    // Saltar el paso 4 si está marcado como omitido
                    if ($(`#step-progenitor-2`).attr('data-skip') === 'true' && nextStep === 4) {
                        nextStep++;
                    }

                    // Actualizar el paso actual si existe el siguiente paso
                    if ($(`.form-step[data-step="${nextStep}"]`).length) {
                        currentStep = nextStep;
                        updateSteps();
                    }
                });

                // Botón "Anterior"
                $('#prev-btn').click(function () {
                    let prevStep = currentStep - 1;

                    // Saltar el paso 4 si está marcado como omitido
                    if ($(`#step-progenitor-2`).attr('data-skip') === 'true' && prevStep === 4) {
                        prevStep--;
                    }

                    // Verificar que el paso anterior exista antes de actualizar
                    if ($(`.form-step[data-step="${prevStep}"]`).length) {
                        // Limpiar errores del paso actual
                        $(`#validacionpaso${currentStep}`).find('.is-invalid').removeClass('is-invalid');

                        // Ocultar paso actual y mostrar paso anterior
                        $(`#validacionpaso${currentStep}`).addClass('d-none');
                        $(`#validacionpaso${prevStep}`).removeClass('d-none');

                        currentStep = prevStep;
                        updateSteps();

                        // Scroll suave hacia arriba del formulario
                        $('html, body').animate({
                            scrollTop: $('.stepper-wrapper').offset().top - 50
                        }, 300);
                    }

                    // Habilitar/deshabilitar el botón de "anterior" según el paso actual
                    if (currentStep === 1) {
                        $('#prev-btn').attr('disabled', true);
                    } else {
                        $('#prev-btn').attr('disabled', false);
                    }
                });

                updateSteps();

                // Hacer los pasos del stepper clickeables para navegación
                $('.stepper-item').on('click', function() {
                    const stepNumber = parseInt($(this).attr('data-step'));

                    // Solo permitir navegación a pasos anteriores completados o al paso actual
                    if (stepNumber <= currentStep || stepNumber === 1) {
                        // Si el paso 4 está marcado para omitirse y estamos tratando de ir al paso 4, saltar al paso 5
                        if (stepNumber === 4 && $('#step-progenitor-2').attr('data-skip') === 'true') {
                            currentStep = 5;
                        } else {
                            currentStep = stepNumber;
                        }

                        // Limpiar errores del paso actual
                        $(`#validacionpaso${currentStep}`).find('.is-invalid').removeClass('is-invalid');

                        // Actualizar la vista usando la función centralizada
                        updateSteps();

                        // Scroll suave hacia el stepper
                        $('html, body').animate({
                            scrollTop: $('.stepper-wrapper').offset().top - 50
                        }, 300);
                    }
                });

                $('#buscarEstudiante').on('click', function() {
                    const tipoDocumento = $('#tipoDocumento').val();
                    const numeroDocumento = $('#nroDocumento').val();

                    if (!tipoDocumento) {
                        //alert('Por favor, ingrese un número de documento.');
                        Swal.fire({
                            title: 'Error',
                            text: 'Por favor, seleccione un tipo de documento.',
                            icon: 'danger',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#3085d6',
                            background: '#fff',
                            timer: 4000 // Si deseas que desaparezca después de 4 segundos
                        });
                        return;
                    }

                    if (!numeroDocumento) {
                        //alert('Por favor, ingrese un número de documento.');
                        Swal.fire({
                            title: 'Error',
                            text: 'Por favor, ingrese un número de documento.',
                            icon: 'danger',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#3085d6',
                            background: '#fff',
                            timer: 4000 // Si deseas que desaparezca después de 4 segundos
                        });
                        return;
                    }

                    // Realizar la solicitud AJAX
                    $.ajax({
                        url: "{{ route('estudiantes.buscar') }}",
                        type: "GET",
                        data: { tipoDocumento: tipoDocumento ,nroDocumento: numeroDocumento },
                        success: function(response) {
                            if (response.success) {
                                $('#id_estudiante').val(response.data.id);
                                $('#nombres').val(response.data.nombres);
                                $('#apellidos').val(response.data.apellidos);
                                $('#codigo_sianet').val(response.data.codigo_sianet);
                                toastr.success('Se obtuvieron los datos del estudiante, correctamente.', 'Éxito', {
                                    positionClass: 'toast-bottom-right',
                                    closeButton: true,
                                    timeOut: 5000,
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: response.message,
                                    icon: 'danger',
                                    confirmButtonText: 'Aceptar',
                                    confirmButtonColor: '#3085d6',
                                    background: '#fff',
                                    timer: 4000 // Si deseas que desaparezca después de 4 segundos
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                    title: 'Error',
                                    text: 'Error al buscar el estudiante. Verifique el número de documento.',
                                    icon: 'danger',
                                    confirmButtonText: 'Aceptar',
                                    confirmButtonColor: '#3085d6',
                                    background: '#fff',
                                    timer: 4000 // Si deseas que desaparezca después de 4 segundos
                                });
                        }
                    });
                });

            // Selecciona todos los inputs numéricos relacionados con ingresos
                const ingresosFields = [
                    '#remuneracionPlanilla',
                    '#honorariosProfesionales',
                    '#pensionista',
                    '#rentasInmuebles',
                    '#rentasVehiculos',
                    '#otrosIngresos'
                ];

                const gastosFields = [
                    '#pagoColegios',
                    '#pagoTalleres',
                    '#pagoUniversidad',
                    '#pagoAlimentacion',
                    '#pagoAlquiler',
                    '#pagoCreditoPersonal',
                    '#pagoCreditoHipotecario',
                    '#pagoCreditoVehicular',
                    '#pagoServicios',
                    '#pagoMantenimiento',
                    '#pagoApoyoCasa',
                    '#pagoClubes',
                    '#pagoSeguros',
                    '#pagoApoyoFamiliar',
                    '#otrosGastos',
                ];

                // Escucha el evento 'input' en cada campo de ingresos
                $(ingresosFields.join(',')).on('input', function () {
                    let totalIngresos = 0;
                    // Recorre cada campo de ingresos y suma sus valores
                    ingresosFields.forEach(field => {
                        const value = parseFloat($(field).val()) || 0; // Si el valor es NaN, usa 0
                        totalIngresos += value;
                    });
                    // Actualiza el campo totalIngresos
                    $('#totalIngresos').val(totalIngresos.toFixed(2)); // Redondea a 2 decimales
                });

                // Escucha el evento 'input' en cada campo de gastos
                $(gastosFields.join(',')).on('input', function () {
                    let totalGastos = 0;
                    // Recorre cada campo de gastos y suma sus valores
                    gastosFields.forEach(field => {
                        const value = parseFloat($(field).val()) || 0; // Si el valor es NaN, usa 0
                        totalGastos += value;
                    });
                    // Actualiza el campo totalGastos
                    $('#totalGastos').val(totalGastos.toFixed(2)); // Redondea a 2 decimales
                });




                // Variables pasadas desde Blade
                const formTimeout = {{ $formTimeout }}; // Tiempo total en segundos
                const formAlertTime = {{ $formAlertTime }}; // Tiempo de alerta en segundos

                // Almacena el tiempo inicial (timestamp en milisegundos)
                const inicioTiempo = Date.now();
                let tiempoRestante = formTimeout; // Inicializa el tiempo restante

                // Actualiza el tiempo restante cada segundo
                const actualizarTiempo = setInterval(() => {
                    // Calcula el tiempo transcurrido desde el inicio
                    const tiempoTranscurrido = Math.floor((Date.now() - inicioTiempo) / 1000);

                    // Calcula el tiempo restante
                    tiempoRestante = formTimeout - tiempoTranscurrido;

                    // Muestra el tiempo restante en formato hh:mm:ss
                    const horas = Math.floor(tiempoRestante / 3600); // Total de horas
                    const minutos = Math.floor((tiempoRestante % 3600) / 60); // Minutos restantes después de las horas
                    const segundos = tiempoRestante % 60; // Segundos restantes

                    $('#tiempoRestante').text(
                        `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`
                    );

                    // Si el tiempo alcanza el tiempo de alerta, muestra la alerta de Bootstrap
                    if (tiempoRestante === formAlertTime) {
                        $('#alertaTemporal').removeClass('d-none');
                    }

                    // Si el tiempo se agota, limpia el intervalo y muestra la alerta de SweetAlert2
                    if (tiempoRestante <= 0) {
                        clearInterval(actualizarTiempo);
                        Swal.fire({
                            title: '¡Tiempo agotado!',
                            text: 'El tiempo para enviar el formulario ha expirado. Por favor, refresca la página.',
                            icon: 'error',
                            confirmButtonText: 'Entendido',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then(() => {
                            location.reload(); // Recarga la página
                        });
                    }
                }, 1000);

                // Función para validar el tamaño de los archivos
                function validarTamañoArchivos() {
                    const maxFileSize = 5 * 1024 * 1024; // 5MB por archivo
                    const maxTotalSize = 100 * 1024 * 1024; // 100MB total
                    let totalSize = 0;
                    let archivosGrandes = [];

                    // Obtener todos los inputs de archivo
                    const fileInputs = document.querySelectorAll('input[type="file"]');

                    for (let input of fileInputs) {
                        if (input.files && input.files.length > 0) {
                            for (let file of input.files) {
                                totalSize += file.size;

                                // Verificar tamaño individual
                                if (file.size > maxFileSize) {
                                    archivosGrandes.push({
                                        nombre: file.name,
                                        tamaño: (file.size / (1024 * 1024)).toFixed(2) + ' MB',
                                        campo: input.getAttribute('data-name') || input.name
                                    });
                                }
                            }
                        }
                    }

                    // Verificar tamaño total
                    if (totalSize > maxTotalSize) {
                        Swal.fire({
                            title: '¡Formulario Demasiado Grande!',
                            html: `
                                <div class="text-start">
                                    <p>El tamaño total de los archivos (${(totalSize / (1024 * 1024)).toFixed(2)} MB) excede el límite permitido (100 MB).</p>
                                    <p><strong>Recomendaciones:</strong></p>
                                    <ul>
                                        <li>Comprime los archivos PDF antes de subirlos</li>
                                        <li>Usa imágenes JPG en lugar de PNG</li>
                                        <li>Sube menos archivos a la vez</li>
                                    </ul>
                                </div>
                            `,
                            icon: 'warning',
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#d33'
                        });
                        return false;
                    }

                    // Verificar archivos individuales grandes
                    if (archivosGrandes.length > 0) {
                        let mensaje = 'Los siguientes archivos exceden el límite de 5MB:\n\n';
                        archivosGrandes.forEach(archivo => {
                            mensaje += `• ${archivo.nombre} (${archivo.tamaño}) - ${archivo.campo}\n`;
                        });
                        mensaje += '\nPor favor, comprime estos archivos antes de subirlos.';

                        Swal.fire({
                            title: '¡Archivos Demasiado Grandes!',
                            text: mensaje,
                            icon: 'warning',
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#d33'
                        });
                        return false;
                    }

                    return true;
                }
            });
        </script>
        <!-- end container -->
        @endif
    </section>
    <!-- end section -->
@endsection
