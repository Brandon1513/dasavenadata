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
    Schema::create('comercial_channel_sellout', function (Blueprint $table) {
        $table->id();

        $table->text('semana_wk')->nullable();
        $table->text('aop_si_2022')->nullable();
        $table->text('sop_fcst_si_2022_pzs')->nullable();
        $table->text('si_2021')->nullable();
        $table->text('cliente')->nullable();
        $table->text('categoria')->nullable();
        $table->text('semana')->nullable();
        $table->text('clave')->nullable();
        $table->text('semana_bien')->nullable();
        $table->text('venta_so')->nullable();
        $table->text('anio')->nullable();
        $table->text('mes')->nullable();
        $table->text('q')->nullable();
        $table->text('aop_dinero')->nullable();
        $table->text('sop_dinero')->nullable();
        $table->text('aa_dinero')->nullable();
        $table->text('mount_pz')->nullable();
        $table->text('mount_dinero')->nullable();
        $table->text('cte')->nullable();
        $table->text('precio')->nullable();
        $table->text('producto')->nullable();
        $table->text('baseline_aop')->nullable();
        $table->text('baseline_aop_dinero')->nullable();
        $table->text('baseline_sop')->nullable();
        $table->text('baseline_sop_dinero')->nullable();
        $table->text('promo_en_precio')->nullable();
        $table->text('servicio')->nullable();
        $table->text('degustacion')->nullable();
        $table->text('alcances')->nullable();
        $table->text('innovacion')->nullable();
        $table->text('exhib_adicional')->nullable();
        $table->text('eficiencias_cpfr')->nullable();
        $table->text('mkt_act')->nullable();
        $table->text('otros')->nullable();
        $table->text('comentarios')->nullable();
        $table->text('venta_real_pz')->nullable();
        $table->text('venta_real_dinero')->nullable();
        $table->text('total_bb_aop')->nullable();
        $table->text('total_bb_aop_dinero')->nullable();
        $table->text('promo_dinero')->nullable();
        $table->text('servicio_dinero')->nullable();
        $table->text('desgustaciones_dinero')->nullable();
        $table->text('alcances_dinero')->nullable();
        $table->text('innovacio_dinero')->nullable();
        $table->text('exhib_adicional_dinero')->nullable();
        $table->text('eficiencias_cpfr_dinero')->nullable();
        $table->text('mkt_act_dinero')->nullable();
        $table->text('otros_dinero')->nullable();
        $table->text('promo_en_precio_v2')->nullable();
        $table->text('servicio_v2')->nullable();
        $table->text('degustacion_v2')->nullable();
        $table->text('alcances_v2')->nullable();
        $table->text('innovacion_v2')->nullable();
        $table->text('exhib_adicional_v2')->nullable();
        $table->text('eficiencias_cpfr_v2')->nullable();
        $table->text('mkt_act_v2')->nullable();
        $table->text('otros_v2')->nullable();
        $table->text('total_bb_aop_v2')->nullable();
        $table->text('total_bb_aop_dinero_v2')->nullable();
        $table->text('promo_dinero_v2')->nullable();
        $table->text('servicio_dinero_v2')->nullable();
        $table->text('desgustaciones_dinero_v2')->nullable();
        $table->text('alcances_dinero_v2')->nullable();
        $table->text('innovacio_dinero_v2')->nullable();
        $table->text('exhib_adicional_dinero_v2')->nullable();
        $table->text('eficiencias_cpfr_dinero_v2')->nullable();
        $table->text('mkt_act_dinero_v2')->nullable();
        $table->text('otros_dinero_v2')->nullable();
        $table->text('sku')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comercial_channel_sellout');
    }
};
