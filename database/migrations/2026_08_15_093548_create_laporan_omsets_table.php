<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanOmsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_omsets', function (Blueprint $table) {
            $table->id();

            // Kolom Informasi Transaksi
            $table->date('tanggal')->nullable();
            $table->string('noreg')->nullable();
            $table->string('pasien')->nullable();
            $table->string('hp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('tipe_omset')->nullable();
            $table->date('dob')->nullable();
            $table->string('kel_pelanggan')->nullable();
            $table->string('mou')->nullable();
            $table->string('marketing')->nullable();

            // Kolom Nominal Financial
            $table->decimal('bruto', 15, 2)->default(0);
            $table->decimal('disc', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('pay', 15, 2)->default(0);

            // Kolom Pemeriksaan & Detail Pasien
            $table->integer('jml_test')->default(0);
            $table->text('pemeriksaan')->nullable();
            $table->string('nik')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('location')->nullable();
            $table->string('job')->nullable();
            $table->integer('kedatangan')->default(0);

            // Relasi / Identifikasi Cabang
            $table->string('cabang');

            $table->timestamps();

            // Index gabungan untuk mempercepat pengecekan duplikasi data & kueri pencarian
            $table->index(['cabang', 'tanggal', 'noreg']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_omsets');
    }
}
