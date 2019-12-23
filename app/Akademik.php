<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Akademik extends Model
{
    public static function tambahProgram($data)
    {
        $temp = DB::insert('insert into program_les (nama_program_les, jumlah_pertemuan, deskripsi, cakupan_materi, biaya) values (?, ?, ?, ?, ?)', [$data->nama, $data->jumlah_pertemuan, $data->deskripsi, $data->materi, $data->biaya]);
        return $temp;
    }
    public static function tambahKelas($data)
    {
        $temp = DB::insert('insert into kelas (nama_kelas, id_sensei, id_program_les) values (?, ?, ?)', [$data->nama_kelas, $data->nama_sensei, $data->nama_program]);

        $dataA = DB::table('kelas')
            ->where(['nama_kelas' => $data->nama_kelas, 'id_program_les' => $data->nama_program, 'id_sensei' => $data->nama_sensei])
            ->get()->first();

        $temp2 = DB::insert('insert into peserta_kelas (username, id_kelas, status_pendaftaran, nilai_evaluasi, status_les) values (?, ?, ?, ?, ?)', [$data->nama_murid, $dataA->id_kelas, 1, 0, 0]);
        return $temp;
    }
}
