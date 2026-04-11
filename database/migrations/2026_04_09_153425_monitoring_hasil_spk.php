<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MonitoringHasilSpk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_hasil_spk', function (Blueprint $table) {
            $table->id('id_monitoring_hasil_spk');
            $table->string('monitoring_hasil_spk_code')->unique();
            $table->string('monitoring_hasil_spk_name');
            $table->string('monitoring_hasil_spk_date');
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
        Schema::dropIfExists('monitoring_hasil_spk');
    }
}
