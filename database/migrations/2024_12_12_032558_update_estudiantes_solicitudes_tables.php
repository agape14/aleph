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
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropColumn('vive_con');
            $table->dropColumn('motivos_beca');
            $table->dropColumn('razones_motivos');
        });

        Schema::table('solicitudes', function (Blueprint $table) {
            $table->enum('vive_con', ['ambos', 'uno', 'tiempo_compartido'])->nullable()->after('id');
            $table->json('motivos_beca')->nullable()->after('vive_con');
            $table->text('razones_motivos')->nullable()->after('motivos_beca');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir los cambios, en caso de ser necesario
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->dropColumn('vive_con');
            $table->dropColumn('motivos_beca');
            $table->dropColumn('razones_motivos');
        });

        Schema::table('estudiantes', function (Blueprint $table) {
            $table->enum('vive_con', ['ambos', 'uno', 'tiempo_compartido'])->nullable();
            $table->json('motivos_beca')->nullable();
            $table->text('razones_motivos')->nullable();
        });
    }
};
