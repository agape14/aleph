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
        Schema::create('documentos_sistema', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo'); // 'reglamento', 'formulario', 'guia', etc.
            $table->string('ruta_archivo');
            $table->string('nombre_archivo_original');
            $table->string('mime_type');
            $table->bigInteger('tamaño_archivo');
            $table->text('descripcion')->nullable();
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
        Schema::dropIfExists('documentos_sistema');
    }
};
