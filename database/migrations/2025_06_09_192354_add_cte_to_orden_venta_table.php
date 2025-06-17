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
        $table->string('cte')->nullable()->after('cliente');
    });
}

public function down()
{
    Schema::table('orden_venta', function (Blueprint $table) {
        $table->dropColumn('cte');
    });
}

};
