<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta_kelas', function (Blueprint $table) {
            $table->increments('id_peserta_kelas');
            $table->string('username', 20);
            $table->UnsignedInteger('id_kelas');
            $table->integer('status_pendaftaran');
            $table->double('nilai_evaluasi');
            $table->integer('status_les');
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
        Schema::dropIfExists('peserta_kelas');
    }
}
