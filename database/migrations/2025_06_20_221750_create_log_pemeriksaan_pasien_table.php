<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogPemeriksaanPasienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_pemeriksaan_pasien', function (Blueprint $table) {
            $table->id('id_log_pemeriksaan_pasien');
            $table->string('mou_peserta_code');
            $table->string('master_pemeriksaan_code');
            $table->string('log_pemeriksaan_status');
            $table->text('log_pemeriksaan_deskripsi')->nullable();
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
        Schema::dropIfExists('log_pemeriksaan_pasien');
    }
}
