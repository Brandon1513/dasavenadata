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
        Schema::create('validador_tablas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('validador_id')->constrained('users');
            $table->foreignId('departamento_id')->constrained('departamentos');
            $table->string('tabla'); // ejemplo: 'archivos_operaciones', 'reportes_comercial', etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validador_tablas');
    }
};
