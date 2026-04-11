<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GatewayLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gateway_log', function (Blueprint $table) {
            $table->id('id_gateway_log');
            $table->string('gateway_log_code')->unique();
            $table->string('gateway_log_cabang');
            $table->string('gateway_jadwal_code');
            $table->string('gateway_log_date');
            $table->string('gateway_log_time');
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
        Schema::dropIfExists('gateway_log');
    }
}
