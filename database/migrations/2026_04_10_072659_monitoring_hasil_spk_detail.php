<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MonitoringHasilSpkDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_hasil_spk_detail', function (Blueprint $table) {
            $table->id('id_monitoring_hasil_spk_det');
            $table->string('monitoring_hasil_spk_det_code')->unique();
            $table->string('monitoring_hasil_spk_code');
            $table->string('monitoring_hasil_pasien_code');
            $table->longText('monitoring_hasil_spk_det_ttd');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitoring_hasil_spk_detail');
    }
}
