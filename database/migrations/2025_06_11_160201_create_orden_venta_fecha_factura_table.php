<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orden_venta_fecha_factura', function (Blueprint $table) {
            $table->id();

            $table->string('num_oc', 30)->nullable();
            $table->string('num_factura', 30)->nullable();
            $table->string('fecha_factura', 30)->nullable();
            $table->string('fecha_vencimiento', 30)->nullable();
            $table->string('fecha_envio', 30)->nullable();
            $table->string('cliente', 80)->nullable();
            $table->string('articulo', 80)->nullable();
            $table->string('suma_cantidad', 30)->nullable();
            $table->string('suma_cant_enviada', 30)->nullable();
            $table->string('suma_cant_facturada', 30)->nullable();
            $table->string('estado', 30)->nullable();
            $table->string('fecha_cerrada', 30)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orden_venta_fecha_factura');
    }
};
