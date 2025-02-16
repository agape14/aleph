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
        Schema::create('backups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Para saber quién hizo el backup
            $table->string('file_path')->nullable(); // Ruta del archivo de backup
            $table->enum('status', ['success', 'failed'])->default('success'); // Estado del backup
            $table->text('error_message')->nullable(); // Para registrar errores si falla
            $table->timestamps(); // created_at y updated_at automáticamente

            // Clave foránea para enlazar con la tabla users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backups');
    }
};
