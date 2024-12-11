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
            $table->string('tipo_documento', 80)->nullable();
            $table->string('nro_documento', 15)->nullable();
            $table->string('apepaterno')->nullable();
            $table->string('apematerno')->nullable();
            $table->string('nombres')->nullable();
            $table->string('codigo_sianet')->nullable();
            $table->enum('vive_con', ['ambos', 'uno', 'tiempo_compartido'])->nullable();
            $table->json('motivos_beca')->nullable();
            $table->text('razones_motivos')->nullable();
            $table->timestamps();
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
