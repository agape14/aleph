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
        Schema::create('logs_contenido', function (Blueprint $table) {
            $table->id();
            $table->string('tabla_afectada'); // 'textos_dinamicos', 'documentos_sistema'
            $table->unsignedBigInteger('registro_id');
            $table->string('accion'); // 'created', 'updated', 'deleted'
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            $table->string('campo_modificado')->nullable();
            $table->text('valor_anterior')->nullable();
            $table->text('valor_nuevo')->nullable();
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_contenido');
    }
};
