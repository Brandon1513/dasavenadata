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
    Schema::create('comercial_ventas_sellout', function (Blueprint $table) {
        $table->id();

        $table->string('año', 10)->nullable();
        $table->string('Q', 10)->nullable();
        $table->string('mes', 15)->nullable();
        $table->string('semana', 10)->nullable();
        $table->string('cliente', 100);
        $table->string('Canal', 100)->nullable();
        $table->string('idtienda', 50)->nullable();
        $table->string('Nombre', 100)->nullable();
        $table->string('sku', 100)->nullable();
        $table->string('PZ', 50)->nullable();
        $table->string('Monto', 50)->nullable();
        $table->string('inventario', 50)->nullable();
        $table->string('transito', 50)->nullable();
        $table->string('validos', 50)->nullable();
        $table->string('semanaPB', 20)->nullable();
        $table->string('Clavepb', 50)->nullable();
        $table->string('clavecte', 50)->nullable();
        $table->string('dia', 10)->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comercial_ventas_sellout');
    }
};
