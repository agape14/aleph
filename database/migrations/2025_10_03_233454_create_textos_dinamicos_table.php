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
        Schema::create('textos_dinamicos', function (Blueprint $table) {
            $table->id();
            $table->string('clave')->unique(); // 'declaracion_jurada', 'evaluacion_beca', etc.
            $table->string('titulo');
            $table->text('contenido');
            $table->string('seccion')->default('formulario'); // 'formulario', 'paso1', 'paso2', etc.
            $table->boolean('activo')->default(true);
            $table->integer('orden')->default(0);
            $table->year('año_lectivo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('textos_dinamicos');
    }
};
