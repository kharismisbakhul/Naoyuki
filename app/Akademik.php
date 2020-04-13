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

    public static function tambahKelas($data, $color)
    {
        $temp = DB::insert('insert into kelas (nama_kelas, id_sensei, color) values (?, ?, ?)', [$data->nama_kelas, $data->nama_sensei, $color]);

        $dataA = DB::table('kelas')
            ->where(['nama_kelas' => $data->nama_kelas, 'id_sensei' => $data->nama_sensei])
            ->get()->first();

            $sensei = DB::table('sensei')
            ->where(['id_sensei' => $data->nama_sensei])
            ->get()->first();

            DB::table('pendaftaran')->whereIn('id_pendaftaran', $data->murid)->update(['status_pendaftaran' => 1]);
            
            DB::table('jadwal_kosong')
            ->where('id_sesi', $data->waktuPertemuan1)
            ->where('id_hari', $data->hariPertemuan1)
            ->where('username', $sensei->username)
            ->update(array('status_kosong' => 1));

            DB::table('jadwal_kosong')
            ->where('id_sesi', $data->waktuPertemuan2)
            ->where('id_hari', $data->hariPertemuan2)
            ->where('username', $sensei->username)
            ->update(array('status_kosong' => 1));

        $dataB = DB::table('pendaftaran')
            ->join('murid', 'pendaftaran.username', '=', 'murid.username')
            ->whereIn('pendaftaran.id_pendaftaran', $data->murid)
            ->get();

        for ($i=0; $i < count($dataB); $i++) { 
            # code...
            DB::insert('insert into peserta_kelas (username, id_kelas, id_pendaftaran, nilai_evaluasi, status_les) values (?, ?, ?, ?, ?)', [$dataB[$i]->username, $dataA->id_kelas, $dataB[$i]->id_pendaftaran, 0, 0]);

            DB::table('jadwal_kosong')
            ->where('id_sesi', $data->waktuPertemuan1)
            ->where('id_hari', $data->hariPertemuan1)
            ->where('username', $dataB[$i]->username)
            ->update(array('status_kosong' => 1));

            DB::table('jadwal_kosong')
            ->where('id_sesi', $data->waktuPertemuan2)
            ->where('id_hari', $data->hariPertemuan2)
            ->where('username', $dataB[$i]->username)
            ->update(array('status_kosong' => 1));
        }

        // Jadwal 1
        DB::insert('insert into jadwal_kelas (id_kelas, id_hari, id_sesi) values (?, ?, ?)', [$dataA->id_kelas, $data->hariPertemuan1, $data->waktuPertemuan1]);
        
        // Jadwal 2
        DB::insert('insert into jadwal_kelas (id_kelas, id_hari, id_sesi) values (?, ?, ?)', [$dataA->id_kelas, $data->hariPertemuan2, $data->waktuPertemuan2]);

        return $temp;
    }
}
