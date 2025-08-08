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
    Schema::create('comercial_sellin', function (Blueprint $table) {
        $table->id();

        $table->string('estado_sat', 20)->nullable();
        $table->string('uuid', 100)->nullable();
        $table->string('serie', 20)->nullable();
        $table->string('folio', 20)->nullable();
        $table->string('fecha', 20)->nullable();
        $table->string('mes', 20)->nullable();
        $table->string('anio', 20)->nullable();
        $table->string('nombre_emisor', 100)->nullable();
        $table->string('rfc_emisor', 30)->nullable();
        $table->string('nombre_receptor', 100)->nullable();
        $table->string('rfc_receptor', 30)->nullable();
        $table->string('clave_prod_serv', 20)->nullable();
        $table->string('no_identificacion', 20)->nullable();
        $table->string('descripcion', 100)->nullable();
        $table->string('producto', 40)->nullable();
        $table->string('unidad', 20)->nullable();
        $table->string('clave_unidad', 20)->nullable();
        $table->string('unidades', 20)->nullable();
        $table->string('cantidad', 20)->nullable();
        $table->string('precio_unitario', 20)->nullable();
        $table->string('importe', 20)->nullable();
        $table->string('descuento', 20)->nullable();
        $table->string('tipocambio', 20)->nullable();
        $table->string('moneda', 20)->nullable();
        $table->string('version', 20)->nullable();
        $table->string('client', 20)->nullable();
        $table->string('canal', 20)->nullable();
        $table->string('gramaje', 20)->nullable();
        $table->string('clave', 20)->nullable();
        $table->string('kilos', 20)->nullable();
        $table->string('categoria', 20)->nullable();
        $table->string('semana', 20)->nullable();
        $table->string('semana_da', 20)->nullable();
        $table->string('week_w', 20)->nullable();
        $table->string('cte', 20)->nullable();
        $table->string('sku', 30)->nullable();
        $table->string('folio_netsuite', 30)->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comercial_sellin');
    }
};
