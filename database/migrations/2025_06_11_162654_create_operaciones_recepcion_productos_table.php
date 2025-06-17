<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('operaciones_recepcion_productos', function (Blueprint $table) {
            $table->id();

            $table->string('fecha_recepcion', 11)->nullable();
            $table->string('muestra_retencion', 255)->nullable();
            $table->string('producto', 255)->nullable();
            $table->string('proveedor', 255)->nullable();
            $table->string('lote', 50)->nullable();
            $table->string('cantidad_recibida', 20)->nullable();
            $table->string('cantidad_liberada', 20)->nullable();
            $table->string('cantidad_rechazada', 20)->nullable();
            $table->string('cantidad', 10)->nullable();
            $table->string('presentacion', 100)->nullable();
            $table->string('caducidad', 100)->nullable();
             $table->string('olor', 100)->nullable();
            $table->string('color', 100)->nullable();
            $table->string('sabor', 100)->nullable();
            $table->string('apariencia', 100)->nullable();
            $table->text('observaciones')->nullable();
            $table->string('estatus', 50)->nullable();
            $table->string('recibido_netsuite', 50)->nullable();
            $table->string('oc', 50)->nullable();
            $table->string('f_alm_01', 50)->nullable();
            $table->string('factura', 50)->nullable();
            $table->string('certificado_cal_micro', 50)->nullable();
            $table->string('certificado_cal_micro2', 50)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operaciones_recepcion_productos');
    }
};
