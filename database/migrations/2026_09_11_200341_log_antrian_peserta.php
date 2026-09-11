<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogAntrianPeserta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_antrian_peserta', function (Blueprint $table) {
            $table->id('log_antrian_id');
            $table->string('log_antrian_code', 50)->unique();
            $table->string('company_mou_code', 50);
            $table->string('mou_peserta_code', 50);
            $table->string('nomor_antrian', 20);
            $table->string('nama_pos_pemeriksaan', 100)->comment('Contoh: Tensi, Radiologi, Lab, Dokter');
            $table->enum('status_antrian', ['Menunggu', 'Dipanggil', 'Sedang Diperiksa', 'Selesai', 'Lewat/Skip'])->default('Dipanggil');
            $table->integer('panggilan_ke')->default(1)->comment('Jumlah berapa kali sudah dipanggil');
            $table->string('operator_user_id', 50)->nullable()->comment('User/Petugas yang memanggil');
            $table->timestamp('waktu_panggil')->useCurrent();
            $table->timestamp('waktu_melayani')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamps();

            // Indexing untuk mempercepat query DataTable / Monitoring
            $table->index('company_mou_code');
            $table->index('mou_peserta_code');
            $table->index('status_antrian');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_antrian_peserta');
    }
}
