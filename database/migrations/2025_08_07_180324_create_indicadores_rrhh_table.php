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
        Schema::create('indicadores_rrhh', function (Blueprint $table) {
            $table->id();
            $table->year('anio')->nullable();
            $table->string('mes', 20)->nullable();
            $table->decimal('rotacion_general', 10, 4)->nullable();
            $table->decimal('rotacion_mayor_3m', 10, 4)->nullable();
            $table->decimal('rotacion_menor_3m', 10, 4)->nullable();
            $table->decimal('porcentaje_cumplimiento', 5, 2)->nullable();
            $table->integer('accidentes_trabajo')->nullable();
            $table->decimal('indice', 5, 2)->nullable();
            $table->integer('plantilla')->nullable();
            $table->decimal('lesiones_internas_no_incapacidad', 5, 2)->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicadores_rrhh');
    }
};
