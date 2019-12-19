<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sub_menu', function (Blueprint $table) {
            $table->bigIncrements('id_sub_menu');
            $table->string('judul', 50);
            $table->string('url', 50);
            $table->string('ikon', 50);
            $table->unsignedInteger('id_menu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_sub_menu');
    }
}
