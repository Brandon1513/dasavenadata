<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('importaciones', function (Blueprint $table) {
            $table->enum('estatus', ['pendiente', 'aceptado', 'rechazado'])->default('pendiente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('importaciones', function (Blueprint $table) {
            //
        });
    }
};
