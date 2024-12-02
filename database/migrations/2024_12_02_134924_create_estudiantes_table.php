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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 15);
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('codigo_bcp', 50);
            $table->enum('vive_con', ['ambos', 'uno', 'tiempo_compartido']);
            $table->json('motivos_beca');
            $table->text('razones_motivos')->nullable();
            $table->timestamps();

            $table->foreignId('solicitud_id')->constrained('solicitudes')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
