<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orden_venta', function (Blueprint $table) {
            $table->id();
            $table->string('num_oc')->nullable();
            $table->string('num_venta')->nullable();
            $table->date('fecha')->nullable();
            $table->date('fecha_venc_oc')->nullable();
            $table->date('fecha_envio')->nullable();
            $table->string('cliente')->nullable();
            $table->string('articulo')->nullable();
            $table->integer('suma_cantidad')->nullable();
            $table->integer('suma_cant_enviada')->nullable();
            $table->integer('suma_cant_no_enviada')->nullable();
            $table->integer('suma_cant_perdida')->nullable();
            $table->integer('suma_fila_afectada')->nullable();
            $table->string('estado')->nullable();
            $table->string('motivo_venta_perdida')->nullable();
            $table->date('fecha_cerrada')->nullable();
            $table->float('suma_importe_bruto', 15, 2)->nullable();
            $table->date('fecha_entrega_cliente')->nullable();
            $table->date('fecha_funcion')->nullable();
            $table->string('categoria')->nullable();
            $table->string('sku')->nullable();
            $table->date('fecha_de_estatus')->nullable();
            $table->integer('suma_enviada_con_devolucion')->nullable();
            $table->integer('suma_no_enviada_con_devolucion')->nullable();
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orden_venta');
    }
};

