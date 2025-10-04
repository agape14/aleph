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
        Schema::create('versiones_textos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('texto_dinamico_id')->constrained('textos_dinamicos')->cascadeOnDelete();
            $table->string('version');
            $table->text('contenido_anterior');
            $table->text('contenido_nuevo');
            $table->string('motivo_cambio')->nullable();
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('versiones_textos');
    }
};
