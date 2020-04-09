<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Akademik extends Model
{
    public static function tambahProgram($data, $nama_file)
    {
        $temp = DB::insert('insert into program_les (nama_program_les, image, jumlah_pertemuan, deskripsi, cakupan_materi, biaya) values (?, ?, ?, ?, ?, ?)', [$data->nama, $nama_file ,$data->jumlah_pertemuan, $data->deskripsi, $data->materi, $data->biaya]);
        return $temp;
    }

    public static function getRandomColor() 
    {
        $letters = '0123456789ABCDEF';
        $color = '#';
        for ($i = 0; $i < 6; $i++) {
          $color += $letters[Math.floor(Math.random() * 16)];
        }
        return $color;
    }

    public static function tambahKelas($data)
    {
        $temp = DB::insert('insert into kelas (nama_kelas, id_sensei, color) values (?, ?)', [$data->nama_kelas, $data->nama_sensei, $this->getRandomColor]);

        $dataA = DB::table('kelas')
            ->where(['nama_kelas' => $data->nama_kelas, 'id_sensei' => $data->nama_sensei])
            ->get()->first();

            DB::update('update pendaftaran set status_pendaftaran = ? where id_pendaftaran = ?', [1, intval($data->nama_murid)]);

        $dataB = DB::table('pendaftaran')
            ->join('murid', 'pendaftaran.username', '=', 'murid.username')
            ->where('pendaftaran.id_pendaftaran', $data->nama_murid)
            ->get()->first();

            // Error
        $temp2 = DB::insert('insert into peserta_kelas (username, id_kelas, id_pendaftaran, nilai_evaluasi, status_les) values (?, ?, ?, ?, ?)', [$dataB->username, $dataA->id_kelas, $data->nama_murid, 0, 0]);
        $temp3 = DB::insert('insert into jadwal_kelas (id_kelas, id_hari, id_sesi) values (?, ?, ?)', [$dataA->id_kelas, $data->hariPertemuan, $data->waktuPertemuan]);
        return $temp;
    }
}
