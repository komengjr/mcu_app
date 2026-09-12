<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CompanyMouPemeriksaanDoc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_mou_pemeriksaan_doc', function (Blueprint $table) {
            $table->id('id_pemeriksaan_doc');
            $table->string('mou_peserta_code')->unique();
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->integer('rr_nafas')->nullable();
            $table->decimal('suhu', 4, 2)->nullable();
            $table->string('tensi')->nullable();
            $table->integer('nadi_hr')->nullable();
            $table->integer('spo2')->nullable();

            // Field Tambahan Sesuai Form & Controller
            $table->text('catatan_dokter')->nullable();
            $table->string('kesimpulan')->nullable(); // Menampung: Fit, Fit with Note, Temporary Unfit, Unfit

            $table->string('pemeriksa')->nullable();
            $table->string('dokter_penginput')->nullable();
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
        Schema::dropIfExists('company_mou_pemeriksaan_doc');
    }
}
