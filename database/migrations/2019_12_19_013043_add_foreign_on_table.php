<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignOnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->foreign('id_status_user')->references('id_status_user')->on('status_user');
        });

        Schema::table('notifikasi', function (Blueprint $table) {
            $table->foreign('id_kategori_notifikasi')->references('id_kategori_notifikasi')->on('kategori_notifikasi');
            $table->foreign('username')->references('username')->on('user');
        });

        Schema::table('user_access_menu', function (Blueprint $table) {
            $table->foreign('id_status_user')->references('id_status_user')->on('status_user');
            $table->foreign('id_menu')->references('id_menu')->on('user_menu');
        });

        Schema::table('user_sub_menu', function (Blueprint $table) {
            $table->foreign('id_menu')->references('id_menu')->on('user_menu');
        });

        Schema::table('jadwal_kosong_murid', function (Blueprint $table) {
            $table->foreign('username')->references('username')->on('murid');
        });

        Schema::table('peserta_kelas', function (Blueprint $table) {
            $table->foreign('username')->references('username')->on('murid');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
        });

        Schema::table('kelas', function (Blueprint $table) {
            $table->foreign('id_program_les')->references('id_program_les')->on('program_les');
            $table->foreign('id_sensei')->references('id_sensei')->on('sensei');
        });

        Schema::table('jadwal_kosong_sensei', function (Blueprint $table) {
            $table->foreign('id_sensei')->references('id_sensei')->on('sensei');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropForeign('user_id_status_user_foreign');
        });
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->dropForeign('notifikasi_id_kategori_notifikasi_foreign');
            $table->dropForeign('notifikasi_username_foreign');
        });
        Schema::table('user_access_menu', function (Blueprint $table) {
            $table->dropForeign('user_access_menu_id_status_user_foreign');
            $table->dropForeign('user_access_menu_id_menu_foreign');
        });
        Schema::table('user_sub_menu', function (Blueprint $table) {
            $table->dropForeign('user_sub_menu_id_menu_foreign');
        });
        Schema::table('jadwal_kosong_murid', function (Blueprint $table) {
            $table->dropForeign('jadwal_kosong_murid_username_foreign');
        });
        Schema::table('peserta_kelas', function (Blueprint $table) {
            $table->dropForeign('peserta_kelas_username_foreign');
            $table->dropForeign('peserta_kelas_id_kelas_foreign');
        });
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropForeign('kelas_id_sensei_foreign');
            $table->dropForeign('kelas_id_program_les_foreign');
        });
        Schema::table('jadwal_kosong_sensei', function (Blueprint $table) {
            $table->dropForeign('jadwal_kosong_sensei_id_sensei_foreign');
        });
    }
}
