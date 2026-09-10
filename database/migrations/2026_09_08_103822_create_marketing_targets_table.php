<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_targets', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel marketing_staff
            $table->foreignId('marketing_staff_id')->constrained('marketing_staff')->onDelete('cascade');

            // Periode Target Bulanan
            $table->unsignedTinyInteger('bulan'); // 1 sampai 12
            $table->year('tahun'); // contoh: 2026

            // Parameter Target & Insentif per Bulan tersebut
            $table->decimal('target_omset', 15, 2)->default(0);
            $table->decimal('persentase_komisi', 5, 2)->default(0); // Bisa dioverride per bulan jika ada promo
            $table->enum('tier_insentif', ['Tier 1', 'Tier 2', 'Tier 3'])->default('Tier 1');

            // Status pencapaian (opsional untuk penilaian nantinya)
            $table->enum('status_pencapaian', ['Belum Tercapai', 'Tercapai', 'Bonus Max'])->default('Belum Tercapai');

            $table->timestamps();

            // Mencegah duplikat target pada staff di bulan & tahun yang sama
            $table->unique(['marketing_staff_id', 'bulan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketing_targets');
    }
}
