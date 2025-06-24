<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogLokasiPasienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_lokasi_pasien', function (Blueprint $table) {
            $table->id('id_log_lokasi_pasien');
            $table->string('mou_peserta_code');
            $table->string('lokasi_cabang');
            $table->string('log_lokasi_status');
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
        Schema::dropIfExists('log_lokasi_pasien');
    }
}
