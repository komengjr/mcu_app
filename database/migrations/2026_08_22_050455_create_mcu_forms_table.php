<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcuFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcu_forms', function (Blueprint $table) {
            $table->id('id_mcu_form');
            $table->string('form_code')->unique(); // e.g., FORM_RIWAYAT, FORM_FISIK, FORM_SRQ
            $table->string('form_name'); // e.g., Form Pemeriksaan Fisik
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::create('mcu_form_items', function (Blueprint $table) {
            $table->id('id_mcu_form_item');

            $table->unsignedBigInteger('id_mcu_form');
            $table->foreign('id_mcu_form')
                ->references('id_mcu_form')
                ->on('mcu_forms')
                ->onDelete('cascade');

            $table->string('item_label'); // e.g., "Sering Sakit Kepala?", "Tekanan Darah"
            // Tipe Input: text, number, yes_no (Radio), select (Dropdown), textarea
            $table->enum('field_type', ['text', 'number', 'yes_no', 'select', 'textarea']);
            $table->string('unit')->nullable(); // e.g., mmHg, kg, cm
            $table->boolean('is_required')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
        Schema::create('mcu_item_options', function (Blueprint $table) {
            $table->id('id_mcu_item_option');

            $table->unsignedBigInteger('id_mcu_form_item');
            $table->foreign('id_mcu_form_item')
                ->references('id_mcu_form_item')
                ->on('mcu_form_items')
                ->onDelete('cascade');

            $table->string('option_label'); // e.g., "Normal", "Abnormal", "Ringan"
            $table->string('option_value'); // e.g., "normal", "abnormal", "ringan"
            $table->timestamps();
        });
        Schema::create('mcu_registrations', function (Blueprint $table) {
            $table->id('id_mcu_registration');
            $table->string('registration_code')->unique(); // e.g., REG-MCU-202608001

            // Pengikat ke table peserta MCU
            $table->string('mou_peserta_code');
            $table->foreign('mou_peserta_code')
                ->references('mou_peserta_code')
                ->on('company_mou_peserta')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('mcu_date');
            $table->enum('status', ['registered', 'in_progress', 'completed', 'canceled'])->default('registered');
            $table->string('fit_status')->nullable(); // Fit, Fit with Note, Unfit
            $table->text('conclusion_summary')->nullable(); // Catatan resume dari Dokter
            $table->timestamps();
        });
        Schema::create('mcu_results', function (Blueprint $table) {
            $table->id('id_mcu_result');

            $table->unsignedBigInteger('id_mcu_registration');
            $table->foreign('id_mcu_registration')
                ->references('id_mcu_registration')
                ->on('mcu_registrations')
                ->onDelete('cascade');

            $table->unsignedBigInteger('id_mcu_form_item');
            $table->foreign('id_mcu_form_item')
                ->references('id_mcu_form_item')
                ->on('mcu_form_items')
                ->onDelete('cascade');

            $table->text('value')->nullable(); // Menyimpan teks, angka, atau '1'/'0' untuk Yes/No
            $table->foreignId('examiner_id')->nullable()->constrained('users'); // Dokter/Petugas Pemeriksa
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
        Schema::dropIfExists('mcu_forms');
        Schema::dropIfExists('mcu_form_items');
        Schema::dropIfExists('mcu_item_options');
        Schema::dropIfExists('mcu_registrations');
        Schema::dropIfExists('mcu_results');
    }
}
