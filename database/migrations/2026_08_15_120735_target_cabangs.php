<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TargetCabangs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target_cabangs', function (Blueprint $table) {
            $table->id();
            $table->string('master_cabang_code'); // Nama/Kode Cabang
            $table->integer('tahun');             // Misal: 2025, 2026
            $table->integer('bulan');             // 1 s/d 12 (Januari s/d Desember)
            $table->decimal('target', 15, 2)->default(0); // Nominal target spesifik bulan tersebut
            $table->timestamps();

            // Kunci Unik: 1 Cabang hanya punya 1 Target per Bulan dalam Tahun tersebut
            $table->unique(['master_cabang_code', 'tahun', 'bulan']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('target_cabangs');
    }
}
