<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalKosongSenseiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_kosong_sensei', function (Blueprint $table) {
            $table->increments('id_jadwal_kosong');
            $table->time('jam');
            $table->date('hari');
            $table->date('bulan');
            $table->date('tahun');
            $table->UnsignedInteger('id_sensei');
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
        Schema::dropIfExists('jadwal_kosong_sensei');
    }
}
