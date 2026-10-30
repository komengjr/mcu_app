<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MarketingAksesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tabel 1: Multi Akses Cabang untuk Manager/Atasan
        Schema::create('marketing_akses_cabang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marketing_staff_id')->constrained('marketing_staff')->onDelete('cascade');
            $table->string('kode_cabang');
            $table->timestamps();
        });

        // Tabel 2: Aturan Hierarki Penilaian (Atasan vs Bawahan)
        Schema::create('marketing_hierarki_penilaian', function (Blueprint $table) {
            $table->id();
            $table->string('jabatan_penilai'); // Contoh: Direktur, Kepala Cabang, Manager, Supervisor
            $table->string('jabatan_dinilai'); // Contoh: Kepala Cabang, Manager, Supervisor, Marketing Staff
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
        Schema::dropIfExists('marketing_hierarki_penilaian');
        Schema::dropIfExists('marketing_akses_cabang');
    }
}
