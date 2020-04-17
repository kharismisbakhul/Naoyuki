<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Murid extends Model
{
    protected $table = 'murid';
    protected $primaryKey = 'username';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['username', 'nama_lengkap', 'email', 'no_hp', 'asal_sekolah', 'alamat'];

    public function user()
    {
        return $this->belongsTo('App\User', 'username', 'username');
    }
    public function peserta_kelas(){
        return $this->hasMany('App\Peserta_Kelas', 'username', 'username');
    }
    public function pendaftaran(){
        return $this->hasMany('App\Pendaftaran', 'username', 'username');
    }

    public static function daftar($data)
    {
        date_default_timezone_set("Asia/Jakarta");
        DB::insert('insert into pendaftaran (username, id_program_les, status_pendaftaran, tanggal_mulai, tanggal_pendaftaran, waktu_pendaftaran) values (?, ?, ?, ?, ?, ?)', [session('username'), $data->program, 0, $data->waktuMulai, date('Y-m-d'), date('h:i:s')]);

        $temp = DB::table('pendaftaran')
            ->where(['pendaftaran.username' => session('username'), 'pendaftaran.id_program_les' => $data->program,'pendaftaran.tanggal_mulai' => $data->waktuMulai, 'status_pendaftaran' => 0])
            ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
            ->join('murid', 'pendaftaran.username', '=', 'murid.username')
            ->get()->first();
        return $temp;
    }
    public static function bayar($id, $nama_file)
    {
        DB::update('update pendaftaran set status_pendaftaran = ?, bukti_pendaftaran = ? where id_pendaftaran = ?', [2, $nama_file, intval($id)]);
    }
    // public static function getProgramTerdaftar($id)
    // {
    //     $program_les = DB::table('pendaftaran')->where(['id_pendaftaran' => $id])
    //         ->join('program_les', 'pendaftaran.id_program_les', '=', 'program_les.id_program_les')
    //         ->join('murid', 'pendaftaran.username', '=', 'murid.username')
    //         ->get()->first();
    //     Header('Content-type: appliaction/json');
    //     echo json_encode($program_les);
    // }
}
