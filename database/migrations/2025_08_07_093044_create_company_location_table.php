<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_location', function (Blueprint $table) {
            $table->id('id_company_location');
            $table->string('company_location_code')->unique();
            $table->string('master_company_code');
            $table->string('company_location_name');
            $table->string('company_location_alamat');
            $table->string('company_location_status');
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
        Schema::dropIfExists('company_location');
    }
}
