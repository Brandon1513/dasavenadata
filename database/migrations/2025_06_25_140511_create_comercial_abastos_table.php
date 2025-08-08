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
   Schema::create('comercial_abastos', function (Blueprint $table) {
    $table->id();
    $table->string('Año', 4)->nullable();
    $table->string('Mes', 15)->nullable();
    $table->string('Semana', 10)->nullable();
    $table->string('Idcliente', 50)->nullable();
    $table->string('Cliente', 100)->nullable();
    $table->string('Codigo', 50)->nullable();
    $table->string('numerodetienda', 50)->nullable();
    $table->string('Nombredetienda', 100)->nullable();
    $table->string('SKU', 50)->nullable();
    $table->string('Itemid', 50)->nullable();
    $table->string('Unitcost', 20)->nullable();
    $table->string('UnitRetail', 20)->nullable();
    $table->text('ClusterTienda')->nullable();
    $table->text('UnidadesAnaquel')->nullable();
    $table->text('UnidadesExSecu')->nullable();

    // Agrupamos campos tipo Qty o Sales como text
    $table->text('AAV13POSQty')->nullable();
    $table->text('AAV13POSSales')->nullable();
    $table->text('AAV11POSQty')->nullable();
    $table->text('AAV11POSSales')->nullable();
    $table->text('AAV10POSQty')->nullable();
    $table->text('AAV10POSSales')->nullable();
    $table->text('AAV9POSQty')->nullable();
    $table->text('AAV9POSSales')->nullable();
    // ... continúa agrupando los demás campos similares a estos como text

    // Campos con nombres como NF7DOH, NF7DTCAD, etc.
    $table->text('NF7DOH')->nullable();
    $table->text('NF7DTCAD')->nullable();
    $table->text('NF7DITCAD')->nullable();
    $table->text('NF7DIT')->nullable();
    $table->text('NF3DIT')->nullable();
    $table->text('NF3DOH')->nullable();
    $table->text('DDOH')->nullable();

    // Campos de pronóstico
    $table->text('PromedioSemanal')->nullable();
    $table->text('Promediosemana1$')->nullable();
    $table->text('PromFcstVta')->nullable();
    $table->text('PromFcstVta2')->nullable();

    // Otros
    $table->text('Inventario0pzs')->nullable();
    $table->text('InventarioNegativo')->nullable();

    // Fecha Laravel
    $table->timestamps();
});

}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comercial_abastos');
    }
};
