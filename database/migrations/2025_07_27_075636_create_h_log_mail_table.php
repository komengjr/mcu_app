<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHLogMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h_log_mail', function (Blueprint $table) {
            $table->id('id_h_log_mail');
            $table->string('h_log_mail_code')->unique();
            $table->string('h_log_mail_address');
            $table->string('h_log_mail_userid');
            $table->string('h_log_mail_subject');
            $table->string('h_log_mail_name');
            $table->longText('h_log_mail_messages');
            $table->integer('h_log_mail_status');
            $table->string('h_log_mail_cabang');
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
        Schema::dropIfExists('h_log_mail');
    }
}
