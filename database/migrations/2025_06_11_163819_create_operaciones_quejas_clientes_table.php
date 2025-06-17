<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('operaciones_quejas_clientes', function (Blueprint $table) {
            $table->id();

            $table->string('folio_queja', 50)->nullable();
            $table->string('mes', 20)->nullable();
            $table->string('fecha_queja', 11)->nullable();
            $table->string('nombre_cliente', 255)->nullable();
            $table->text('descripcion_queja')->nullable();
            $table->string('tipo', 100)->nullable();
            $table->string('clase_desviacion', 100)->nullable();
            $table->string('sku', 50)->nullable();
            $table->string('lote', 50)->nullable();
            $table->string('fecha_produccion', 11)->nullable();
            $table->string('punto_venta', 100)->nullable();
            $table->string('medio_comunicacion', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('domicilio', 255)->nullable();
            $table->string('correo_electronico', 255)->nullable();
            $table->text('correccion_inmediata')->nullable();
            $table->string('ac', 11)->nullable();
            $table->string('num_ac', 11)->nullable();
            $table->integer('dias_fabricacion_queja')->nullable();
            $table->string('contacto_mkt', 255)->nullable();
            $table->string('fecha_contacto_mkt', 11)->nullable();
            $table->string('correo_calidad', 255)->nullable();
            $table->string('fecha_contacto_cal', 11)->nullable();
            $table->text('respuesta_cliente')->nullable();
            $table->string('fecha_respuesta', 11)->nullable();
            $table->string('correo_directo', 255)->nullable();
            $table->string('fecha_correo', 11)->nullable();
            $table->tinyInteger('reposicion_solicitada')->nullable();
            $table->tinyInteger('fecha_reposicion')->nullable();
            $table->tinyInteger('paqueteria')->nullable();
            $table->string('numero_guia', 50)->nullable();
            $table->text('observaciones')->nullable();
            $table->decimal('producto_reposicion', 10, 2)->nullable();
            $table->decimal('costo_reposicion', 10, 2)->nullable();
            $table->decimal('costo_guia', 10, 2)->nullable();
            $table->string('solicitud_producto_produccion', 255)->nullable();
            $table->string('fecha_solicitud_producto_produccion', 11)->nullable();
            $table->tinyInteger('entrega_produccion_ecommerce')->nullable();
            $table->tinyInteger('fecha_entrega_produccion_ecommerce')->nullable();
            $table->string('folio_salida_dasavena', 50)->nullable();
            $table->tinyInteger('reposicion_armada')->nullable();
            $table->string('fecha_armado_reposicion', 11)->nullable();
            $table->tinyInteger('reposicion_entregada_coord_logistica')->nullable();
            $table->tinyInteger('fecha_entrega_coord_logistica')->nullable();
            $table->tinyInteger('envio_reposicion_paqueteria')->nullable();
            $table->tinyInteger('fecha_envio_reposicion_paqueteria')->nullable();
            $table->tinyInteger('reposicion_entregada_cliente')->nullable();
            $table->string('mes_produccion', 4)->nullable();
            $table->string('anio_produccion', 4)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operaciones_quejas_clientes');
    }
};
