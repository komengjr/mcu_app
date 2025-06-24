<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogPengirimanPasienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_pengiriman_pasien', function (Blueprint $table) {
            $table->id('id_pengiriman_pasien');
            $table->string('mou_peserta_code');
            $table->string('log_pengiriman_status');
            $table->timestamp('log_pengiriman_date');
            $table->text('log_pengiriman_deskripsi')->nullable();
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
        Schema::dropIfExists('log_pengiriman_pasien');
    }
}
