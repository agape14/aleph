<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configuraciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('valor')->default('activo'); // activo o inactivo
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_fin')->nullable();
            $table->text('mensaje')->nullable(); // Nuevo campo para mensaje
            $table->timestamps();
        });

        // Insertar el primer registro
        DB::table('configuraciones')->insert([
            'nombre' => 'registro_solicitud',
            'valor' => 'activo',
            'fecha_inicio' => Carbon::create(2025, 1, 1, 0, 0, 0),
            'fecha_fin' => Carbon::create(2025, 2, 28, 23, 59, 59),
            'mensaje' => "Estimadas familias <br>

            De acuerdo con los comunicados enviados durante el mes de enero y febrero ha finalizado el proceso de solicitud de becas 2025.<br>

            Muchas gracias por su atención.<br><br>



            Atte.<br>

            Dirección de administración y finanzas.",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('configuraciones');
    }
};
