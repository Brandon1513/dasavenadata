<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('operaciones_seguimiento_costeo_concentrado', function (Blueprint $table) {
            $table->id();

            $table->string('linea', 30)->nullable();
            $table->string('sku', 30)->nullable();
            $table->string('kg_matutino', 30)->nullable();
            $table->string('kg_nocturno', 30)->nullable();
            $table->string('kg_total', 30)->nullable();
            $table->string('nomina_matutino', 30)->nullable();
            $table->string('nomina_nocturno', 30)->nullable();
            $table->string('nomina_total', 30)->nullable();
            $table->string('personal_matutino', 30)->nullable();
            $table->string('personal_nocturno', 30)->nullable();
            $table->string('personal_total', 30)->nullable();
            $table->string('kgpersona_matutino', 30)->nullable();
            $table->string('kgpersona_nocturno', 30)->nullable();
            $table->string('kgpersona_total', 30)->nullable();
            $table->string('costokg_matutino', 30)->nullable();
            $table->string('costokg_nocturno', 30)->nullable();
            $table->string('costokg_total', 30)->nullable();
            $table->string('costo_porcentual', 30)->nullable();
            $table->string('costo_alimylog', 30)->nullable();
            $table->string('costo_calidad', 30)->nullable();
            $table->string('costo_compras', 30)->nullable();
            $table->string('costo_mantenimiento', 30)->nullable();
            $table->string('costo_lavado', 30)->nullable();
            $table->string('costo_otros', 30)->nullable();
            $table->string('costo_cvooperaciones', 30)->nullable();
            $table->string('horas_matutino', 30)->nullable();
            $table->string('horas_vespertino', 30)->nullable();
            $table->string('horas_total', 30)->nullable();
            $table->string('anio', 30)->nullable();
            $table->string('mes', 30)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operaciones_seguimiento_costeo_concentrado');
    }
};
