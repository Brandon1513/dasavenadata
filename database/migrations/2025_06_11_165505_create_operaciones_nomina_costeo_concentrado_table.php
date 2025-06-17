<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('operaciones_nomina_costeo_concentrado', function (Blueprint $table) {
            $table->id();

            $table->string('anio', 10)->nullable();
            $table->string('mes', 10)->nullable();
            $table->string('area', 50)->nullable();
            $table->string('monto', 100)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operaciones_nomina_costeo_concentrado');
    }
};
