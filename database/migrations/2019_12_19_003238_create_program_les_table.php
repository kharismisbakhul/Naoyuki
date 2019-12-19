<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramLesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_les', function (Blueprint $table) {
            $table->increments('id_program_les');
            $table->string('nama_program_les');
            $table->string('image');
            $table->string('jumlah_pertemuan');
            $table->string('deskripsi');
            $table->string('cakupan_materi');
            $table->double('biaya');
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
        Schema::dropIfExists('program_les');
    }
}
