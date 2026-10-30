<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingPenilaianTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Tabel Header Penilaian Bulanan Staf
        Schema::create('marketing_penilaian_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marketing_staff_id')->constrained('marketing_staff')->onDelete('cascade');
            $table->unsignedTinyInteger('bulan'); // 1 - 12
            $table->year('tahun');
            $table->decimal('total_skor_akhir', 5, 2)->default(0); // Nilai akhir dalam persen (0 - 100+)
            $table->enum('predikat', ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'])->nullable();
            $table->text('catatan_evaluasi')->nullable();
            $table->enum('status', ['Draft', 'Final'])->default('Draft');
            $table->timestamps();

            // Mencegah duplikasi penilaian staf di bulan dan tahun yang sama
            $table->unique(['marketing_staff_id', 'bulan', 'tahun'], 'penilaian_staff_bulan_tahun_unique');
        });

        // 2. Tabel Detail Nilai per Poin KPI
        Schema::create('marketing_penilaian_staff_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_staff_id')->constrained('marketing_penilaian_staff')->onDelete('cascade');
            $table->foreignId('kpi_id')->nullable()->constrained('marketing_setting_kpi')->onDelete('set null');

            $table->string('nama_indikator', 150);
            $table->enum('tipe_penilaian', ['Manual', 'Otomatis']);
            $table->decimal('target_standar', 15, 2)->default(0);
            $table->decimal('pencapaian_real', 15, 2)->default(0);
            $table->string('satuan', 50);
            $table->decimal('bobot_persen', 5, 2)->default(0);
            $table->decimal('persentase_capaian', 8, 2)->default(0); // (Real / Target) * 100
            $table->decimal('skor_terbobot', 8, 2)->default(0); // (Persentase Capaian * Bobot) / 100
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
        Schema::dropIfExists('marketing_penilaian_staff_detail');
        Schema::dropIfExists('marketing_penilaian_staff');
    }
}
