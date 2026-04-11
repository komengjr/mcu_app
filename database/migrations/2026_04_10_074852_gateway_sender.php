<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GatewaySender extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gateway_sender', function (Blueprint $table) {
            $table->id('id_gateway_sender');
            $table->string('gateway_sender_code')->unique();
            $table->string('gateway_sender_name');
            $table->string('gateway_sender_no_hp');
            $table->text('gateway_sender_text');
            $table->string('gateway_sender_status');
            $table->string('gateway_sender_cabang');
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
        Schema::dropIfExists('gateway_sender');
    }
}
