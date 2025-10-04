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
        Schema::create('roles_contenido', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // 'gestor_textos', 'gestor_documentos', 'administrador_contenido'
            $table->string('descripcion');
            $table->json('permisos'); // ['textos.create', 'textos.edit', 'documentos.create', etc.]
            $table->boolean('activo')->default(false);
            $table->string('token_activacion')->unique()->nullable();
            $table->timestamp('fecha_activacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_contenido');
    }
};
