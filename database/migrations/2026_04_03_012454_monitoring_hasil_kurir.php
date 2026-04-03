<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MonitoringHasilKurir extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_hasil_kurir', function (Blueprint $table) {
            $table->id('id_monitoring_hasil_kurir');
            $table->string('monitoring_hasil_kurir_code')->unique();
            $table->string('monitoring_hasil_pasien_code');
            $table->string('monitoring_hasil_kurir_name');
            $table->dateTime('monitoring_hasil_kurir_date');
            $table->text('monitoring_hasil_kurir_sign');
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
        Schema::dropIfExists('monitoring_hasil_kurir');
    }
}
