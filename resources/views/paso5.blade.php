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
