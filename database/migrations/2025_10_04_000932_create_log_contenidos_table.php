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
        Schema::create('log_contenidos', function (Blueprint $table) {
            $table->id();
            $table->string('accion'); // 'created', 'updated', 'deleted'
            $table->string('tabla_afectada'); // 'textos_dinamicos', 'documentos_sistema'
            $table->unsignedBigInteger('registro_id');
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->string('ip_address')->nullable();
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            $table->string('campo_modificado')->nullable();
            $table->text('motivo_cambio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_contenidos');
    }
};
