<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalKosongMuridTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_kosong_murid', function (Blueprint $table) {
            $table->increments('id_jadwal_kosong');
            $table->time('jam');
            $table->date('hari');
            $table->date('bulan');
            $table->date('tahun');
            $table->string('username', 20);
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
        Schema::dropIfExists('jadwal_kosong_murid');
    }
}
