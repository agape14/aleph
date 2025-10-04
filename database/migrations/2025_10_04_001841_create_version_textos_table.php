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
        Schema::create('version_textos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('texto_dinamico_id')->constrained('textos_dinamicos')->onDelete('cascade');
            $table->integer('version');
            $table->text('contenido_anterior');
            $table->text('contenido_nuevo');
            $table->string('motivo_cambio')->nullable();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['texto_dinamico_id', 'version']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('version_textos');
    }
};
