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
    Schema::create('comercial_channel_sellin', function (Blueprint $table) {
        $table->id();

        $table->text('semana')->nullable();
        $table->text('aop')->nullable();
        $table->text('sop')->nullable();
        $table->text('aa')->nullable();
        $table->text('cliente')->nullable();
        $table->text('categoria')->nullable();
        $table->text('semana_cal')->nullable();
        $table->text('anio')->nullable();
        $table->text('aop_dinero')->nullable();
        $table->text('sop_dinero')->nullable();
        $table->text('aa_dinero')->nullable();
        $table->text('month_aop')->nullable();
        $table->text('mounth_sop')->nullable();
        $table->text('month_aop_dinero')->nullable();
        $table->text('mounth_sop_dinero')->nullable();
        $table->text('precio_aa')->nullable();
        $table->text('week')->nullable();
        $table->text('cte')->nullable();
        $table->text('precio')->nullable();
        $table->text('cod_pp')->nullable();
        $table->text('mes')->nullable();
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
        Schema::dropIfExists('comercial_channel_sellin');
    }
};
