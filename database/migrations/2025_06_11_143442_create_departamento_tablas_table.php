<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('departamento_tablas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departamento_id')->constrained()->onDelete('cascade');
            $table->string('tabla'); // nombre de la tabla permitida
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departamento_tablas');
    }
};

