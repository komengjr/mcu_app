<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyMouAgreementUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_mou_agreement_user', function (Blueprint $table) {
            $table->id('id_mou_agreement_user');
            $table->string('mou_agreement_user_code')->unique();
            $table->string('mou_peserta_code');
            $table->string('master_pemeriksaan_code');
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
        Schema::dropIfExists('company_mou_agreement_user');
    }
}
