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
        Schema::table('progenitores', function (Blueprint $table) {
            $table->string('correo_electronico', 255)->nullable()->after('apellidos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {


        Schema::table('progenitores', function (Blueprint $table) {
            $table->dropColumn('correo_electronico');
        });
    }
};
