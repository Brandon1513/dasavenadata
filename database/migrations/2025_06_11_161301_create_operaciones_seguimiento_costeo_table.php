<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('operaciones_seguimiento_costeo', function (Blueprint $table) {
            $table->id();

            $table->string('semana', 30)->nullable();
            $table->string('dia_sem', 30)->nullable();
            $table->string('fecha', 30)->nullable();
            $table->string('linea', 30)->nullable();
            $table->string('presentacion', 30)->nullable();
            $table->string('turno', 30)->nullable();
            $table->integer('unidades_producidas')->nullable();
            $table->string('porcentaje_de_part', 30)->nullable();
            $table->double('gramaje')->nullable();
            $table->double('kg')->nullable();
            $table->integer('num_de_personas_mezclado')->nullable();
            $table->integer('num_de_personas_horneado')->nullable();
            $table->integer('num_de_personas_formado')->nullable();
            $table->integer('num_de_personas_empaque')->nullable();
            $table->double('costeo_num_de_personas_mezclado')->nullable();
            $table->double('costeo_num_de_personas_horneado')->nullable();
            $table->double('costeo_num_de_personas_formado')->nullable();
            $table->double('costeo_num_de_personas_empaque')->nullable();
            $table->double('total_personal')->nullable();
            $table->decimal('$_mezclado', 15, 2)->nullable();
            $table->decimal('$_horneado', 15, 2)->nullable();
            $table->decimal('$_formado', 15, 2)->nullable();
            $table->decimal('$_empaque', 15, 2)->nullable();
            $table->decimal('costo_nomina', 15, 2)->nullable();
            $table->double('kg_por_persona')->nullable();
            $table->double('costo_nomina_kg')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operaciones_seguimiento_costeo');
    }
};
