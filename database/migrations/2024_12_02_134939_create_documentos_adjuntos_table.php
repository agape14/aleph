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
        Schema::create('documentos_adjuntos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_id')->constrained('solicitudes')->cascadeOnDelete();
            $table->foreignId('progenitor_id')->nullable()->constrained('progenitores')->nullOnDelete();
            $table->enum('tipo_documento', ['boletas_pago', 'declaracion_renta', 'movimientos_migratorios', 'bienes_inmuebles', 'otros']);
            $table->text('ruta_archivo');
            $table->boolean('no_aplica')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_adjuntos');
    }
};
