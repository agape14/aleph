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
            // Eliminar las claves foráneas existentes si ya están definidas
            $table->dropForeign(['solicitud_id']);
            $table->dropForeign(['estudiante_id']);

            // Modificar las columnas para que sean nullable
            $table->unsignedBigInteger('solicitud_id')->nullable()->change();
            $table->unsignedBigInteger('estudiante_id')->nullable()->change();

            // Añadir las claves foráneas con `nullOnDelete`
            $table->foreign('solicitud_id')->references('id')->on('solicitudes')->nullOnDelete();
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progenitores', function (Blueprint $table) {
            // Eliminar las claves foráneas
            $table->dropForeign(['solicitud_id']);
            $table->dropForeign(['estudiante_id']);

            // Revertir las columnas a no nullable
            $table->unsignedBigInteger('solicitud_id')->nullable(false)->change();
            $table->unsignedBigInteger('estudiante_id')->nullable(false)->change();

            // Restaurar las claves foráneas originales
            $table->foreign('solicitud_id')->references('id')->on('solicitudes');
            $table->foreign('estudiante_id')->references('id')->on('estudiantes');
        });
    }
};
