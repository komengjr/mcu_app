<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MessageWaMcu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_wa_mcu', function (Blueprint $table) {
            $table->id('id_message_wa_mcu');
            $table->string('message_wa_mcu_code')->unique();
            $table->string('message_wa_mcu_token');
            $table->string('message_wa_mcu_cabang');
            $table->string('message_wa_mcu_number');
            $table->string('message_wa_mcu_name');
            $table->string('message_wa_mcu_type');
            $table->longText('message_wa_mcu_text');
            $table->longText('message_wa_mcu_file');
            $table->string('message_wa_mcu_status');
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
        Schema::dropIfExists('message_wa_mcu');
    }
}
