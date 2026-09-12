<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogPemanggilanPos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_pemanggilan_pos', function (Blueprint $table) {
            $table->id('id_log_pemanggilan');
            $table->string('log_pemanggilan_code', 50)->unique();

            // Relasi ke induk nomor antrian peserta
            $table->unsignedBigInteger('log_antrian_id');
            $table->string('log_antrian_code', 50);
            $table->string('nomor_antrian', 20); // Mengambil dari log_antrian_peserta agar tetap konsisten

            $table->string('company_mou_code', 50);
            $table->string('mou_peserta_code', 50);

            // Kode pos pemeriksaan (dari master_pemeriksaan_code atau 'REGISTRASI')
            $table->string('master_pemeriksaan_code', 100);

            // Status pemanggilan khusus untuk pos ini
            $table->enum('status_antrian', ['Menunggu', 'Dipanggil', 'Sedang Diperiksa', 'Selesai', 'Lewat/Skip'])->default('Menunggu');
            $table->integer('panggilan_ke')->default(0);

            $table->string('operator_user_id', 50)->nullable();
            $table->timestamp('waktu_panggil')->nullable();
            $table->timestamp('waktu_melayani')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('log_antrian_id')->references('log_antrian_id')->on('log_antrian_peserta')->onDelete('cascade');

            // Indexing
            $table->index(['log_antrian_id', 'master_pemeriksaan_code']);
            $table->index(['company_mou_code', 'master_pemeriksaan_code', 'status_antrian'], 'idx_log_pos_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_pemanggilan_pos');
    }
}
