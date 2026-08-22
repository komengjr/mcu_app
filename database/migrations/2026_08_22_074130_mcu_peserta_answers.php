<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class McuPesertaAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcu_peserta_answers', function (Blueprint $table) {
            $table->id('id_mcu_answer');
            $table->string('mou_peserta_code'); // Tipe disesuaikan ke string
            $table->unsignedBigInteger('id_mcu_form');
            $table->json('answers_data');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();

            // Foreign Key mengacu pada mou_peserta_code
            $table->foreign('mou_peserta_code')
                ->references('mou_peserta_code')
                ->on('company_mou_peserta')
                ->onDelete('cascade');

            $table->foreign('id_mcu_form')
                ->references('id_mcu_form')
                ->on('mcu_forms')
                ->onDelete('cascade');

            // Unique Key menggunakan mou_peserta_code dan id_mcu_form
            $table->unique(['mou_peserta_code', 'id_mcu_form']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mcu_peserta_answers');
    }
}
