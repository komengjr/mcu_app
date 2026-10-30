<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MarketingSettingKpiTarget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_setting_kpi_target', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_id')->constrained('marketing_setting_kpi')->onDelete('cascade');
            $table->unsignedTinyInteger('bulan'); // 1 - 12
            $table->year('tahun');
            $table->decimal('target_standar', 15, 2)->default(0);
            $table->timestamps();

            // Mencegah duplikasi setting target untuk indikator yang sama pada bulan & tahun yang sama
            $table->unique(['kpi_id', 'bulan', 'tahun'], 'kpi_target_bulan_tahun_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketing_setting_kpi_target');
    }
}
