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
        Schema::table('progenitores', function (Blueprint $table) {
            $table->string('certificado_movimiento_anio_actual', 255)->nullable()->after('cantidad_inmuebles');
            $table->string('certificado_movimiento_anio_anterior', 255)->nullable()->after('certificado_movimiento_anio_actual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progenitores', function (Blueprint $table) {
            $table->dropColumn(['certificado_movimiento_anio_actual', 'certificado_movimiento_anio_anterior']);
        });
    }
};
