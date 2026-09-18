<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class McuPemeriksaanParameters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcu_pemeriksaan_parameters', function (Blueprint $table) {
            $table->id('id_parameter');
            $table->string('kategori'); // e.g., 'JANTUNG', 'ABDOMEN', 'LOW BACK PAIN', 'CTS'
            $table->string('nama_parameter'); // e.g., 'Laseque', 'JVP', 'Nyeri Tekan'
            $table->string('key_parameter')->unique(); // e.g., 'lbp_laseque', 'jantung_jvp'
            $table->enum('input_type', ['boolean', 'select', 'text'])->default('boolean');
            $table->json('options')->nullable(); // Simpan opsi pilihan jika input_type = select, contoh: ["negatif", "positif"]
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
        Schema::create('mcu_pemeriksaan_fisik', function (Blueprint $table) {
            $table->id('id_pemeriksaan_fisik');
            $table->string('mou_peserta_code');
            $table->foreign('mou_peserta_code')
                ->references('mou_peserta_code')
                ->on('company_mou_peserta')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('no_reg')->unique();
            $table->date('tgl_pemeriksaan');
            $table->string('dokter_pemeriksa');
            $table->text('kesimpulan')->nullable();
            $table->timestamps();
        });
        Schema::create('mcu_pemeriksaan_fisik_details', function (Blueprint $table) {
            $table->id('id_pemeriksaan_detail');

            $table->unsignedBigInteger('id_pemeriksaan_fisik');
            $table->foreign('id_pemeriksaan_fisik')
                ->references('id_pemeriksaan_fisik')
                ->on('mcu_pemeriksaan_fisik')
                ->onDelete('cascade');

            $table->unsignedBigInteger('id_parameter');
            $table->foreign('id_parameter')
                ->references('id_parameter')
                ->on('mcu_pemeriksaan_parameters')
                ->onDelete('cascade');

            $table->string('nilai_value')->nullable(); // Menampung nilai utama (misal: 'NORMAL', 'ABNORMAL', 'SANGAT TINGGI')
            $table->text('keterangan')->nullable();   // Menampung free text catatan/detail saat hasil tidak normal
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
        Schema::dropIfExists('mcu_pemeriksaan_parameters');
        Schema::dropIfExists('mcu_pemeriksaan_fisik');
        Schema::dropIfExists('mcu_pemeriksaan_fisik_details');
    }
}
