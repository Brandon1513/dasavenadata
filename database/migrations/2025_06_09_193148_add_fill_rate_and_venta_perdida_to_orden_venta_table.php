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
    Schema::table('orden_venta', function (Blueprint $table) {
        $table->string('suma_fill_rate', 50)->nullable()->after('articulo');
        $table->string('suma_venta_perdida', 50)->nullable()->after('articulo');
    });
}

public function down()
{
    Schema::table('orden_venta', function (Blueprint $table) {
        $table->dropColumn('suma_fill_rate');
        $table->dropColumn('suma_venta_perdida');
    });
}

};
