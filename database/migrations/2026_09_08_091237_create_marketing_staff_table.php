<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_cabang', function (Blueprint $table) {
            $table->id(); // id biasa (BigInteger Auto Increment)
            $table->string('kode_cabang', 50)->unique();
            $table->string('nama_cabang', 100);
            $table->string('entitas', 100)->nullable();
            $table->string('kota', 100)->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
        Schema::create('marketing_staff', function (Blueprint $table) {
            $table->id();

            // Foreign key terhubung ke marketing_cabang
            $table->string('kode_cabang', 50)->nullable();
            $table->foreign('kode_cabang')
                ->references('kode_cabang')
                ->on('marketing_cabang')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->string('nik', 20)->unique();
            $table->string('nama_lengkap', 100);
            $table->string('email', 100)->unique();
            $table->string('no_telepon', 15)->nullable();

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

            $table->date('tanggal_masuk');

            // Data Rekening
            $table->string('nama_bank', 50)->nullable();
            $table->string('nomor_rekening', 30)->nullable();
            $table->string('nama_pemilik_rekening', 100)->nullable();

            $table->enum('status_aktif', ['Aktif', 'Nonaktif'])->default('Aktif');
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
        Schema::dropIfExists('marketing_cabang');
        Schema::dropIfExists('marketing_staff');
    }
}
