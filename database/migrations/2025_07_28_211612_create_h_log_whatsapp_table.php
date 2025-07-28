<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHLogWhatsappTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h_log_whatsapp', function (Blueprint $table) {
            $table->id('id_h_log_whatsapp');
            $table->string('h_log_whatsapp_code')->unique();
            $table->string('h_log_whatsapp_userid');
            $table->string('h_log_whatsapp_number');
            $table->string('h_log_whatsapp_name');
            $table->longText('h_log_whatsapp_text');
            $table->string('h_log_whatsapp_status');
            $table->string('h_log_whatsapp_cabang');
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
        Schema::dropIfExists('h_log_whatsapp');
    }
}
