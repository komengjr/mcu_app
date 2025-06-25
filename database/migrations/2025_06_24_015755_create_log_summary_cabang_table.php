<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogSummaryCabangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_summary_cabang', function (Blueprint $table) {
            $table->id('id_summary_cabang');
            $table->string('summary_cabang_code')->unique();
            $table->string('company_mou_code');
            $table->string('master_cabang_code');
            $table->string('summary_cabang_pesentasi')->nullable();
            $table->string('summary_cabang_pesentasi_date')->nullable();
            $table->text('summary_cabang_pesentasi_r')->nullable();
            $table->string('summary_cabang_executive')->nullable();
            $table->string('summary_cabang_executive_date')->nullable();
            $table->text('summary_cabang_executive_r')->nullable();
            $table->string('summary_cabang_ht')->nullable();
            $table->string('summary_cabang_ht_date')->nullable();
            $table->text('summary_cabang_ht_r')->nullable();
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
        Schema::dropIfExists('log_summary_cabang');
    }
}
