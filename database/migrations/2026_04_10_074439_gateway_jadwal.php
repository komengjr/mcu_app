<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GatewayJadwal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gateway_jadwal', function (Blueprint $table) {
            $table->id('id_gateway_jadwal');
            $table->string('gateway_jadwal_code')->unique();
            $table->date('gateway_jadwal_date');
            $table->time('gateway_jadwal_time');
            $table->string('gateway_jadwal_type');
            $table->text('gateway_jadwal_pesan');
            $table->string('gateway_jadwal_cabang');
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
        Schema::dropIfExists('gateway_jadwal');
    }
}
