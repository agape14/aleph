<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('configuraciones', function (Blueprint $table) {
            $table->string('titulo_mensaje')->default('ATENCIÓN')->after('mensaje');
            $table->string('pie_mensaje')->default('Si tienes alguna duda, comunícate con la administración.')->after('titulo_mensaje');
        });
        // Actualizar registros existentes con los valores por defecto
        DB::table('configuraciones')->update([
            'titulo_mensaje' => 'ATENCIÓN',
            'pie_mensaje' => 'Si tienes alguna duda, comunícate con la administración.',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configuraciones', function (Blueprint $table) {
            $table->dropColumn(['titulo_mensaje', 'pie_mensaje']);
        });
    }
};
