<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MonitoringHasilPasien extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_hasil_pasien', function (Blueprint $table) {
            $table->id('id_monitoring_hasil_pasien');
            $table->string('monitoring_hasil_pasien_code')->unique();
            $table->string('monitoring_hasil_pasien_nama');
            $table->string('monitoring_hasil_pasien_nik')->nullable();
            $table->string('monitoring_hasil_pasien_tgl_lahir');
            $table->string('monitoring_hasil_pasien_jk');
            $table->string('monitoring_hasil_pasien_reg')->nullable();
            $table->dateTime('monitoring_hasil_pasien_tgl_periksa')->nullable();
            $table->dateTime('monitoring_hasil_pasien_tgl_selesai')->nullable();
            $table->string('monitoring_hasil_pasien_type');
            $table->text('monitoring_hasil_pasien_file')->nullable();
            $table->string('monitoring_hasil_pasien_cabang');
            $table->string('monitoring_hasil_pasien_user');
            $table->string('monitoring_hasil_pasien_status');
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
        Schema::dropIfExists('monitoring_hasil_pasien');
    }
}
