<div id="validacionpaso5">
    <h3>Ingresos y Gastos Mensuales</h3>

    <!-- Sección de INGRESOS -->
    <h4 class="mt-4">INGRESOS</h4>
    <div class="row mb-3">
        <label for="remuneracionPlanilla" class="col-sm-6 col-form-label">Remuneración mensual - planilla</label>
        <div class="col-sm-6">
            <input type="number" id="remuneracionPlanilla" name="remuneracionPlanilla" class="form-control" placeholder="S/ 0.00" data-name="Remuneración mensual" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="honorariosProfesionales" class="col-sm-6 col-form-label">Honorarios profesionales</label>
        <div class="col-sm-6">
            <input type="number" id="honorariosProfesionales" name="honorariosProfesionales" class="form-control" placeholder="S/ 0.00" data-name="Honorarios profesionales" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="pensionista" class="col-sm-6 col-form-label">Pensionista / Jubilación</label>
        <div class="col-sm-6">
            <input type="number" id="pensionista" name="pensionista" class="form-control" placeholder="S/ 0.00" data-name="Pensionista / Jubilación" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="rentasInmuebles" class="col-sm-6 col-form-label">Rentas por alquiler de inmuebles</label>
        <div class="col-sm-6">
            <input type="number" id="rentasInmuebles" name="rentasInmuebles" class="form-control" placeholder="S/ 0.00" data-name="Rentas por alquiler de inmuebles" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="rentasVehiculos" class="col-sm-6 col-form-label">Rentas por alquiler de vehículos</label>
        <div class="col-sm-6">
            <input type="number" id="rentasVehiculos" name="rentasVehiculos" class="form-control" placeholder="S/ 0.00" data-name="entas por alquiler de vehículos" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="otrosIngresos" class="col-sm-6 col-form-label">Otros ingresos <span class="text-muted">(Ingresar monto y detallar debajo)</span></label>
        <div class="col-sm-6">
            <input type="number" id="otrosIngresos" name="otrosIngresos" class="form-control" placeholder="Ingrese el monto" data-name="Otros ingresos" step="1" min="0" required>
            <textarea id="detalleOtrosIngresos" name="detalleOtrosIngresos" class="form-control mt-2" placeholder="Detalle otros ingresos" rows="2" required></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <label for="totalIngresos" class="col-sm-6 col-form-label"><strong>TOTAL DE INGRESOS MENSUALES</strong></label>
        <div class="col-sm-6">
            <input type="number" id="totalIngresos" name="totalIngresos" class="form-control" placeholder="S/ 0.00" readonly data-name="TOTAL DE INGRESOS" required>
        </div>
    </div>

    <!-- Sección de GASTOS -->
    <h4 class="mt-4">GASTOS TOTALES</h4>
    <div class="row mb-3">
        <label for="numHijos" class="col-sm-6 col-form-label">Número de hijos</label>
        <div class="col-sm-6">
            <input type="number" id="numHijos" name="numHijos" class="form-control" placeholder="Número de hijos" data-name="Número de hijos" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="pagoColegios" class="col-sm-6 col-form-label">Pago por colegios</label>
        <div class="col-sm-6">
            <input type="number" id="pagoColegios" name="pagoColegios" class="form-control" placeholder="S/ 0.00" data-name="Pago por colegios" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="pagoTalleres" class="col-sm-6 col-form-label">Pago por talleres</label>
        <div class="col-sm-6">
            <input type="number" id="pagoTalleres" name="pagoTalleres" class="form-control" placeholder="S/ 0.00" data-name="Pago por talleres" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="pagoUniversidad" class="col-sm-6 col-form-label">Pago por universidad/ estudios diversos</label>
        <div class="col-sm-6">
            <input type="number" id="pagoUniversidad" name="pagoUniversidad" class="form-control" placeholder="S/ 0.00" data-name="Pago por universidad" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="pagoAlimentacion" class="col-sm-6 col-form-label">Pago por alimentación familiar</label>
        <div class="col-sm-6">
            <input type="number" id="pagoAlimentacion" name="pagoAlimentacion" class="form-control" placeholder="S/ 0.00" required data-name="Pago Alimentacion">
        </div>
    </div>
    <div class="row mb-3">
        <label for="pagoAlquiler" class="col-sm-6 col-form-label">Alquiler departamento/casa</label>
        <div class="col-sm-6">
            <input type="number" id="pagoAlquiler" name="pagoAlquiler" class="form-control" placeholder="S/ 0.00" required data-name="Pago Alquiler">
        </div>
    </div>
    <div class="row mb-3">
        <label for="pagoCreditoPersonal" class="col-sm-6 col-form-label">Pago por crédito personal</label>
        <div class="col-sm-6">
            <input type="number" id="pagoCreditoPersonal" name="pagoCreditoPersonal" class="form-control" placeholder="S/ 0.00" required data-name="Pago Credito Personal">
        </div>
    </div>
    <div class="row mb-3">
        <label for="pagoCreditoHipotecario" class="col-sm-6 col-form-label">Pago por crédito hipotecario</label>
        <div class="col-sm-6">
            <input type="number" id="pagoCreditoHipotecario" name="pagoCreditoHipotecario" class="form-control" placeholder="S/ 0.00" required data-name="Pago Credito Hipotecario">
        </div>
    </div>
    <div class="row mb-3">
        <label for="pagoCreditoVehicular" class="col-sm-6 col-form-label">Pago por crédito vehicular</label>
        <div class="col-sm-6">
            <input type="number" id="pagoCreditoVehicular" name="pagoCreditoVehicular" class="form-control" placeholder="S/ 0.00" required data-name="Pago Credito Vehicular">
        </div>
    </div>
    <div class="row mb-3">
        <label for="pagoServicios" class="col-sm-6 col-form-label">Pago total por servicio de agua, luz, teléfono, internet</label>
        <div class="col-sm-6">
            <input type="number" id="pagoServicios" name="pagoServicios" class="form-control" placeholder="S/ 0.00" required data-name="Pago Servicios">
        </div>
    </div>
    <div class="row mb-3">
        <label for="pagoMantenimiento" class="col-sm-6 col-form-label">Pago por servicio de mantenimiento</label>
        <div class="col-sm-6">
            <input type="number" id="pagoMantenimiento" name="pagoMantenimiento" class="form-control" placeholder="S/ 0.00" required data-name="Pago Mantenimiento">
        </div>
    </div>
    <div class="row mb-3">
        <label for="pagoApoyoCasa" class="col-sm-6 col-form-label">Pago total persona de apoyo en casa</label>
        <div class="col-sm-6">
            <input type="number" id="pagoApoyoCasa" name="pagoApoyoCasa" class="form-control" placeholder="S/ 0.00" required data-name="Pago ApoyoCasa">
        </div>
    </div>
    <div class="row mb-3">
        <label for="pagoClubes" class="col-sm-6 col-form-label">Pago por asociación en clubes</label>
        <div class="col-sm-6">
            <input type="number" id="pagoClubes" name="pagoClubes" class="form-control" placeholder="S/ 0.00" required data-name="Pago Clubes">
        </div>
    </div>
    <div class="row mb-3">
        <label for="pagoSeguros" class="col-sm-6 col-form-label">Pago por seguros de salud</label>
        <div class="col-sm-6">
            <input type="number" id="pagoSeguros" name="pagoSeguros" class="form-control" placeholder="S/ 0.00" required data-name="Pago Seguros">
        </div>
    </div>
    <div class="row mb-3">
        <label for="pagoApoyoFamiliar" class="col-sm-6 col-form-label">Pago por apoyo familiar</label>
        <div class="col-sm-6">
            <input type="number" id="pagoApoyoFamiliar" name="pagoApoyoFamiliar" class="form-control" placeholder="S/ 0.00" required data-name="Pago Apoyo Familiar">
        </div>
    </div>
    <div class="row mb-3">
        <label for="otrosGastos" class="col-sm-6 col-form-label">Otros gastos <span class="text-muted">(Ingresar monto y detallar debajo)</span></label>
        <div class="col-sm-6">
            <input type="number" id="otrosGastos" name="otrosGastos" class="form-control" placeholder="Ingrese el monto" data-name="Otros gastos" step="1" min="0" required>
            <textarea id="detalleOtrosGastos" name="detalleOtrosGastos" class="form-control mt-2" placeholder="Detalle otros gastos" rows="2" required></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <label for="totalGastos" class="col-sm-6 col-form-label"><strong>TOTAL DE GASTOS MENSUALES</strong></label>
        <div class="col-sm-6">
            <input type="number" id="totalGastos" name="totalGastos" class="form-control" placeholder="S/ 0.00" readonly>
        </div>
    </div>
</div>
