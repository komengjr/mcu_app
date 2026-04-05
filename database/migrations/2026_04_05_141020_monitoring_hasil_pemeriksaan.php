<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MonitoringHasilPemeriksaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_hasil_pemeriksaan', function (Blueprint $table) {
            $table->id('id_monitoring_hasil_pemeriksaan');
            $table->string('monitoring_hasil_pemeriksaan_code');
            $table->string('monitoring_hasil_pasien_code');
            $table->string('master_pemeriksaan_code');
            $table->string('monitoring_hasil_pemeriksaan_status');
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
        Schema::dropIfExists('monitoring_hasil_pemeriksaan');
    }
}
