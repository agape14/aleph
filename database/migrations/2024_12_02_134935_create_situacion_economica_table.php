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
        Schema::create('situacion_economica', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_id')->constrained('solicitudes')->cascadeOnDelete();
            $table->decimal('ingresos_planilla', 10, 2)->default(0);
            $table->decimal('ingresos_honorarios', 10, 2)->default(0);
            $table->decimal('ingresos_pension', 10, 2)->default(0);
            $table->decimal('ingresos_alquiler', 10, 2)->default(0);
            $table->decimal('ingresos_vehiculos', 10, 2)->default(0);
            $table->decimal('otros_ingresos', 10, 2)->default(0);
            $table->decimal('total_ingresos', 10, 2)->default(0);
            $table->decimal('gastos_colegios', 10, 2)->default(0);
            $table->decimal('gastos_talleres', 10, 2)->default(0);
            $table->decimal('gastos_universidad', 10, 2)->default(0);
            $table->decimal('gastos_alimentacion', 10, 2)->default(0);
            $table->decimal('otros_gastos', 10, 2)->default(0);
            $table->decimal('total_gastos', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('situacion_economica');
    }
};
