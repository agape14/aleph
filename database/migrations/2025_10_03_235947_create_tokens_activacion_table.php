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
        Schema::create('tokens_activacion', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->string('tipo'); // 'rol_contenido', 'funcionalidad', 'modulo'
            $table->string('nombre');
            $table->text('descripcion');
            $table->json('configuracion')->nullable(); // Configuración específica del token
            $table->boolean('activo')->default(false);
            $table->timestamp('fecha_expiracion')->nullable();
            $table->integer('usos_maximos')->nullable();
            $table->integer('usos_actuales')->default(0);
            $table->foreignId('usuario_creador')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens_activacion');
    }
};
