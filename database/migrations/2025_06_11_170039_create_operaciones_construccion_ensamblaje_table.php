<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('operaciones_construccion_ensamblaje', function (Blueprint $table) {
            $table->id();

            $table->string('num_doc', 50)->nullable();
            $table->string('anio_fecha', 11)->nullable();
            $table->string('fecha', 11)->nullable();
            $table->string('articulo', 100)->nullable();
            $table->string('nota', 100)->nullable();
            $table->string('importe', 20)->nullable();
            $table->string('tipo', 100)->nullable();
            $table->string('unidades', 50)->nullable();
            $table->integer('cantidad')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operaciones_construccion_ensamblaje');
    }
};
