<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogKehadiranPasienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_kehadiran_pasien', function (Blueprint $table) {
            $table->id('id_log_kehadiran_pasien');
            $table->string('mou_peserta_code');
            $table->string('log_kehadiran_pasien_lokasi');
            $table->longText('log_kehadiran_pasien_sign');
            $table->string('log_kehadiran_pasien_status');
            $table->text('log_kehadiran_pasien_token');
            $table->timestamp('log_kehadiran_pasien_time');
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
        Schema::dropIfExists('log_kehadiran_pasien');
    }
}
