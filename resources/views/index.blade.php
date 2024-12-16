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
                            <form class="p-4 border rounded" id="frmSolicitud">
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

            $nroDocumento.val('').removeAttr('maxlength minlength pattern placeholder');

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

            switch (tipo) {
                case 'DNI':
                case 'Carnet de Extranjería':
                    $(this).val(value.replace(/[^0-9]/g, ''));
                    break;
                case 'Pasaporte':
                    $(this).val(value.replace(/[^a-zA-Z0-9]/g, ''));
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

</script>

<script>
    $(document).ready(function() {

        let currentStep = 1;


        function updateSteps() {
            $('.form-step').addClass('d-none').removeClass('d-block');
            $(`.form-step[data-step="${currentStep}"]`).removeClass('d-none').addClass('d-block');

            // Actualizar estado de botones
            $('#prev-btn').prop('disabled', currentStep === 1);
            $('#next-btn').text(currentStep === $('.stepper-item').length ? "Solicitar Beca" : "Siguiente →");

            // Actualizar el estado del stepper
            $('.stepper-item').each(function (index) {
                const $item = $(this);
                const $counter = $item.find(".step-counter");
                const $label = $item.find(".step-label");

                if (index + 1 === currentStep) {
                    $item.addClass("active");
                    $counter.addClass("bg-primary text-white").removeClass("bg-secondary text-dark");
                    $label.addClass("text-primary");
                } else {
                    $item.removeClass("active");
                    $counter.removeClass("bg-primary text-white").addClass("bg-secondary text-dark");
                    $label.removeClass("text-primary");
                }
            });
            console.log('currentSteppp',currentStep);
        }

        // Escuchar cambio en los radios de la pregunta 2
        $('input[name="viveConProgenitores"]').change(function () {
            const selectedValue = $('input[name="viveConProgenitores"]:checked').val();
            const stepProgenitor2 = $('#step-progenitor-2');
            const documentosProgenitor2 = $('#documentosProgenitor2');
            const esInsertaProgenitor2 = $('#is_insert_progenitor2');
            if (selectedValue === 'uno' || selectedValue === 'compartido') {
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
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expresión regular para validar email
                    if (!emailRegex.test(value)) {
                        isValid = false;
                        const fieldName = $field.attr('data-name') || 'Correo Electrónico';
                        errorMessages.push(`- ${fieldName} tiene un formato inválido.`);
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

            currentDiv.find('input[type="file"]').each(function () {
                const $fileInput = $(this);
                const files = $fileInput[0].files;

                // Verificar si el div contenedor tiene la clase d-none
                const parentDiv = $fileInput.closest('div[id^="documentosProgenitor"]'); // Encuentra el div padre
                if (parentDiv.hasClass('d-none')) {
                    // Si el div está oculto (tiene la clase d-none), no validamos los archivos y pasamos al siguiente input
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
                toastr.error(errorMessages.join('<br>'), 'Faltan datos obligatorios', {
                    positionClass: 'toast-bottom-right',
                    closeButton: true,
                    timeOut: 5000,
                });
                return;
            }

            // Avanzar al siguiente paso si todo es válido
            $(`#validacionpaso${currentStep}`).addClass('d-none');
            $(`#validacionpaso${nextStep}`).removeClass('d-none');
            // Validaciones específicas para cada paso
            if (currentStep === 1) { // Validación para el paso 1


                /*const $reglamentoGroup = $('input[name="reglamento"]');
                if ($reglamentoGroup.length && !$reglamentoGroup.filter(':checked').length) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Por favor confirma si has leído el Reglamento de Becas 2025.',
                        icon: 'error',
                        confirmButtonText: 'Entendido'
                    });
                    return;
                }*/
                $('#prev-btn').attr('disabled', true);
            }else {
                $('#prev-btn').attr('disabled', false);
            }

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

            if (currentStep === 6) {
                // Recolectar y enviar todos los formularios
                let formData = new FormData($('#frmSolicitud')[0]);
                $('#next-btn').prop('disabled', true); // Deshabilitar el botón para evitar múltiples envíos
                $('#next-btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Registrand Solicitud...'); // Cambiar el contenido del botón a un spinner
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
                        // Eliminar el icono de loading y habilitar el botón
                        $('#next-btn').html('Siguiente'); // Restaurar el texto del botón
                        $('#next-btn').prop('disabled', false); // Habilitar el botón
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
                        });
                        $('#next-btn').html('Siguiente'); // Restaurar el texto del botón
                        $('#next-btn').prop('disabled', false); // Habilitar el botón
                    }
                });
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

            if ($(`.form-step[data-step="${prevStep}"]`).length) {
                currentStep = prevStep;
                updateSteps();
            }

            // Habilitar/deshabilitar el botón de "anterior" según el paso actual
            if (currentStep === 1) {
                $('#prev-btn').attr('disabled', true);
            } else {
                $('#prev-btn').attr('disabled', false);
            }
        });

        updateSteps();

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
    });
</script>
        <!-- end container -->
    </section>
    <!-- end section -->
@endsection
