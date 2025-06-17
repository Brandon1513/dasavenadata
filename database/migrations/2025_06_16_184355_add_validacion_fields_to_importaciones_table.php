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
        Schema::table('importaciones', function (Blueprint $table) {
            $table->timestamp('validado_en')->nullable()->after('estatus');
            $table->unsignedBigInteger('validado_por')->nullable()->after('validado_en');

            $table->foreign('validado_por')->references('id')->on('users')->nullOnDelete();
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
