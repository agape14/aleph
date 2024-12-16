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
        Schema::table('situacion_economica', function (Blueprint $table) {
            // Verificar y agregar columnas faltantes basadas en el formulario
            if (!Schema::hasColumn('situacion_economica', 'detalle_otros_ingresos')) {
                $table->text('detalle_otros_ingresos')->nullable()->after('otros_ingresos');
            }
            if (!Schema::hasColumn('situacion_economica', 'detalle_otros_gastos')) {
                $table->text('detalle_otros_gastos')->nullable()->after('otros_gastos');
            }
            if (!Schema::hasColumn('situacion_economica', 'num_hijos')) {
                $table->unsignedInteger('num_hijos')->default(0)->after('total_ingresos');
            }
            if (!Schema::hasColumn('situacion_economica', 'gastos_alquiler')) {
                $table->decimal('gastos_alquiler', 10, 2)->default(0.00)->after('gastos_alimentacion');
            }
            if (!Schema::hasColumn('situacion_economica', 'gastos_credito_personal')) {
                $table->decimal('gastos_credito_personal', 10, 2)->default(0.00)->after('gastos_alquiler');
            }
            if (!Schema::hasColumn('situacion_economica', 'gastos_credito_hipotecario')) {
                $table->decimal('gastos_credito_hipotecario', 10, 2)->default(0.00)->after('gastos_credito_personal');
            }
            if (!Schema::hasColumn('situacion_economica', 'gastos_credito_vehicular')) {
                $table->decimal('gastos_credito_vehicular', 10, 2)->default(0.00)->after('gastos_credito_hipotecario');
            }
            if (!Schema::hasColumn('situacion_economica', 'gastos_servicios')) {
                $table->decimal('gastos_servicios', 10, 2)->default(0.00)->after('gastos_credito_vehicular');
            }
            if (!Schema::hasColumn('situacion_economica', 'gastos_mantenimiento')) {
                $table->decimal('gastos_mantenimiento', 10, 2)->default(0.00)->after('gastos_servicios');
            }
            if (!Schema::hasColumn('situacion_economica', 'gastos_apoyo_casa')) {
                $table->decimal('gastos_apoyo_casa', 10, 2)->default(0.00)->after('gastos_mantenimiento');
            }
            if (!Schema::hasColumn('situacion_economica', 'gastos_clubes')) {
                $table->decimal('gastos_clubes', 10, 2)->default(0.00)->after('gastos_apoyo_casa');
            }
            if (!Schema::hasColumn('situacion_economica', 'gastos_seguros')) {
                $table->decimal('gastos_seguros', 10, 2)->default(0.00)->after('gastos_clubes');
            }
            if (!Schema::hasColumn('situacion_economica', 'gastos_apoyo_familiar')) {
                $table->decimal('gastos_apoyo_familiar', 10, 2)->default(0.00)->after('gastos_seguros');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('situacion_economica', function (Blueprint $table) {
            // Eliminar las columnas agregadas si es necesario
            $table->dropColumn([
                'detalle_otros_ingresos',
                'detalle_otros_gastos',
                'num_hijos',
                'gastos_alquiler',
                'gastos_credito_personal',
                'gastos_credito_hipotecario',
                'gastos_credito_vehicular',
                'gastos_servicios',
                'gastos_mantenimiento',
                'gastos_apoyo_casa',
                'gastos_clubes',
                'gastos_seguros',
                'gastos_apoyo_familiar',
            ]);
        });
    }
};
