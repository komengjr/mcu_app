<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingSettingKpiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_setting_kpi', function (Blueprint $table) {
            $table->id();
            $table->enum('jabatan', [
                'Direktur Marketing',
                'Kepala Cabang',
                'Manager Marketing',
                'Supervisor Marketing',
                'Marketing Dokter',
                'Marketing Perusahaan',
                'Marketing Komunikasi',
                'Marketing Rujukan'
            ]);
            $table->string('nama_indikator', 150);
            $table->enum('tipe_penilaian', ['Manual', 'Otomatis'])->default('Manual');
            $table->string('sumber_data_otomatis', 100)->nullable(); // e.g: 'pencapaian_omset', 'jumlah_kunjungan', 'jumlah_klien_baru'
            $table->decimal('target_standar', 15, 2)->default(0);
            $table->string('satuan', 50)->nullable(); // e.g: 'Rupiah', 'Persen', 'Dokter', 'Kunjungan'
            $table->decimal('bobot_persen', 5, 2)->default(0); // Total bobot per jabatan idealnya 100%
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
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
        Schema::dropIfExists('marketing_setting_kpi');
    }
}
