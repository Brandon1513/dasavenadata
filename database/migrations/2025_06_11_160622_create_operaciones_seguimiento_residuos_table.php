<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('operaciones_seguimiento_residuos', function (Blueprint $table) {
            $table->id();

            $table->string('fecha', 11)->nullable();
            $table->decimal('cantidad_kg', 10, 2)->nullable();
            $table->string('receta_producida', 255)->nullable();
            $table->string('cantidad_recetas_producidas', 255)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operaciones_seguimiento_residuos');
    }
};
