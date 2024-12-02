<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('progenitores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_id')->constrained('solicitudes')->cascadeOnDelete();
            $table->foreignId('estudiante_id')->nullable()->constrained('estudiantes')->nullOnDelete();
            $table->enum('tipo', ['progenitor1', 'progenitor2']);
            $table->string('dni', 15);
            $table->string('nombres');
            $table->string('apellidos');
            $table->tinyInteger('numero_hijos');
            $table->tinyInteger('hijos_matriculados');
            $table->enum('formacion_academica', ['tecnica', 'universitaria', 'bachillerato', 'titulado', 'maestria', 'doctorado']);
            $table->boolean('trabaja');
            $table->string('tiempo_desempleo')->nullable();
            $table->boolean('sueldo_fijo')->nullable();
            $table->boolean('sueldo_variable')->nullable();
            $table->string('cargo')->nullable();
            $table->year('anio_inicio_laboral')->nullable();
            $table->string('lugar_trabajo')->nullable();
            $table->decimal('ingresos_mensuales', 10, 2)->nullable();
            $table->boolean('recibe_bonos')->nullable();
            $table->enum('monto_bonos', ['5000-10000', '10000-15000', '15000-mas'])->nullable();
            $table->boolean('recibe_utilidades')->nullable();
            $table->enum('monto_utilidades', ['5000-10000', '10000-15000', '15000-mas'])->nullable();
            $table->boolean('titular_empresa')->nullable();
            $table->decimal('porcentaje_acciones', 5, 2)->nullable();
            $table->string('razon_social')->nullable();
            $table->string('numero_ruc', 15)->nullable();
            $table->enum('vivienda_tipo', ['propia', 'alquilada'])->nullable();
            $table->boolean('credito_hipotecario')->nullable();
            $table->text('direccion_vivienda')->nullable();
            $table->decimal('m2_vivienda', 5, 2)->nullable();
            $table->tinyInteger('cantidad_inmuebles')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progenitores');
    }
};
