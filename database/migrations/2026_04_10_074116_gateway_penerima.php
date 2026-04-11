<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GatewayPenerima extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gateway_penerima', function (Blueprint $table) {
            $table->id('id_gateway_penerima');
            $table->string('gateway_penerima_code')->unique();
            $table->string('gateway_penerima_name');
            $table->string('gateway_penerima_no_hp');
            $table->string('gateway_penerima_jk');
            $table->string('gateway_penerima_cabang');
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
        Schema::dropIfExists('gateway_penerima');
    }
}
