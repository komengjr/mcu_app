<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyMouTokenAbsensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_mou_peserta_token_absensi', function (Blueprint $table) {
            $table->id('id_token_absensi');
            $table->string('company_mou_token_code')->unique();
            $table->string('company_mou_code');
            $table->string('company_mou_token_link');
            $table->string('company_mou_token_status');
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
        Schema::dropIfExists('company_mou_peserta_token_absensi');
    }
}
