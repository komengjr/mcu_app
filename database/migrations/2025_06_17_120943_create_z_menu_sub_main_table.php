<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZMenuSubMainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('z_menu_sub_main', function (Blueprint $table) {
             $table->id('id_menu_sub_main');
            $table->string('menu_main_sub_code')->unique();
            $table->string('menu_sub_code');
            $table->string('menu_main_sub_name');
            $table->string('menu_main_sub_link');
            $table->string('menu_main_sub_icon')->nullable();
            $table->string('menu_main_sub_status');
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
        Schema::dropIfExists('z_menu_sub_main');
    }
}
