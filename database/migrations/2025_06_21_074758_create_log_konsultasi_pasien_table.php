<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogKonsultasiPasienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_konsultasi_pasien', function (Blueprint $table) {
            $table->id('id_konsultasi_pasien');
            $table->string('mou_peserta_code');
            $table->string('log_konsultasi_status');
            $table->text('log_konsultasi_deskripsi')->nullable();
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
        Schema::dropIfExists('log_konsultasi_pasien');
    }
}
