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
    public static function tambahKelas($data)
    {
        $temp = DB::insert('insert into kelas (nama_kelas, id_sensei) values (?, ?)', [$data->nama_kelas, $data->nama_sensei]);

        $dataA = DB::table('kelas')
            ->where(['nama_kelas' => $data->nama_kelas, 'id_sensei' => $data->nama_sensei])
            ->get()->first();

            // Error
        $temp2 = DB::insert('insert into peserta_kelas (username, id_kelas, id_pendaftaran, nilai_evaluasi, status_les) values (?, ?, ?, ?, ?)', [$data->nama_murid, $dataA->id_kelas, 1, 0, 0]);
        return $temp;
    }
}
